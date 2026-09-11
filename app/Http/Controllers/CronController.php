<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\scheduleKunjungan;
use App\Models\MaintenanceSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CronController extends Controller
{
    public function updateAssetStatus()
    {
        \Log::info('=== Cron Job Started ===', ['timestamp' => now()]);
        
        try {
            $today = Carbon::now('Asia/Jakarta')->startOfDay();
            $tomorrow = Carbon::now('Asia/Jakarta')->addDay()->startOfDay();
            $tomorrowEnd = Carbon::now('Asia/Jakarta')->addDay()->endOfDay();
            
            \Log::info('Date range', [
                'today' => $today->toDateString(),
                'tomorrow' => $tomorrow->toDateString()
            ]);
            
            // H-1: Kirim reminder Email (cek semua schedule besok tanpa filter status)
            $reminderSchedules = scheduleKunjungan::all()
                ->filter(function($schedule) use ($tomorrow) {
                    return Carbon::parse($schedule->waktu_kunjungan)->isSameDay($tomorrow);
                });
            
            \Log::info('Reminder schedules found', ['count' => $reminderSchedules->count()]);
            
            // Load relationships
            $reminderSchedules->load(['asset.vendor', 'asset.part']);
            
            $debugInfo = [];
            $reminderSent = 0;
            foreach ($reminderSchedules as $schedule) {
                $vendorData = $schedule->asset->vendor ?? null;
                $debug = [
                    'asset_id' => $schedule->asset_id,
                    'has_asset' => !is_null($schedule->asset),
                    'has_vendor' => !is_null($vendorData),
                    'vendor_id' => $vendorData->id_vendor ?? 'N/A',
                    'vendor_name' => $vendorData->nm_vendor ?? 'N/A',
                    'vendor_fields' => $vendorData ? array_keys($vendorData->toArray()) : [],
                    'status' => $schedule->status ?? 'no status',
                ];
                
                // Skip jika sudah selesai atau telat
                if (isset($schedule->status) && in_array($schedule->status, ['selesai', 'telat'])) {
                    $debug['skipped'] = 'status selesai/telat';
                    $debugInfo[] = $debug;
                    continue;
                }
                
                // Cari email dari vendor
                $vendorEmail = null;
                if ($vendorData) {
                    // Coba ambil dari field vend_email di vendor
                    $vendorEmail = $vendorData->vend_email ?? null;
                    
                    // Jika tidak ada, coba cari dari user vendor
                    if (!$vendorEmail && $vendorData->id_vendor) {
                        $vendorUser = \App\Models\MasterUser::where('foreign_id', $vendorData->id_vendor)
                            ->where('is_vendor', true)
                            ->first();
                        $vendorEmail = $vendorUser->email ?? null;
                    }
                    $debug['vendor_email'] = $vendorEmail ?? 'not found';
                }
                
                if ($schedule->asset && $vendorEmail) {
                    try {
                        $this->sendEmailReminder($schedule, $vendorEmail);
                        $debug['sent'] = true;
                        $debug['email_to'] = $vendorEmail;
                        $reminderSent++;
                    } catch (\Exception $e) {
                        $debug['sent'] = false;
                        $debug['reason'] = 'email error: ' . $e->getMessage();
                        \Log::error('Email send failed: ' . $e->getMessage());
                    }
                } else {
                    $debug['sent'] = false;
                    $debug['reason'] = $schedule->asset ? 'missing email' : 'missing asset';
                }
                $debugInfo[] = $debug;
            }
            
            // H: Update status jadi "telat" jika belum maintenance
            $overdueSchedules = scheduleKunjungan::all()
                ->filter(function($schedule) use ($today) {
                    return Carbon::parse($schedule->waktu_kunjungan)->lt($today);
                });
            
            \Log::info('Overdue schedules found', ['count' => $overdueSchedules->count()]);
            
            $overdueCount = 0;
            foreach ($overdueSchedules as $overdue) {
                // Skip jika sudah selesai atau telat
                if (!isset($overdue->status) || !in_array($overdue->status, ['selesai', 'telat'])) {
                    $overdue->update(['status' => 'telat']);
                    $overdueCount++;
                    \Log::info('Status updated to telat', ['asset_id' => $overdue->asset_id]);
                }
            }
            
            \Log::info('=== Cron Job Completed ===', [
                'reminder_sent' => $reminderSent,
                'overdue_updated' => $overdueCount,
                'timestamp' => now()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => "Reminder sent: {$reminderSent}, Status updated to telat: {$overdueCount}",
                'reminder_sent' => $reminderSent,
                'overdue_updated' => $overdueCount,
                'debug_info' => $debugInfo,
                'timestamp' => now()
            ]);
        } catch (\Exception $e) {
            \Log::error('=== Cron Job Failed ===', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'timestamp' => now()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    private function sendEmailReminder($schedule, $vendorEmail)
    {
        $vendorName = $schedule->asset->vendor->nm_vendor ?? 'Vendor';
        $assetNo = $schedule->asset->no_assets ?? 'N/A';
        $partName = $schedule->asset->part->part_name ?? 'N/A';
        $date = Carbon::parse($schedule->waktu_kunjungan)->format('d-m-Y');
        
        \Log::info('Sending email reminder', [
            'to' => $vendorEmail,
            'vendor' => $vendorName,
            'asset' => $assetNo,
            'date' => $date
        ]);
        
        Mail::send([], [], function ($message) use ($vendorEmail, $vendorName, $assetNo, $partName, $date) {
            $message->to($vendorEmail)
                ->subject('🔔 Reminder: Jadwal Maintenance Besok')
                ->setBody("
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset='UTF-8'>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
                            .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
                            .header h1 { margin: 0; font-size: 24px; }
                            .content { padding: 30px; }
                            .info-box { background: #f8f9fa; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
                            .info-box strong { color: #667eea; }
                            .details { background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; margin: 20px 0; }
                            .details table { width: 100%; border-collapse: collapse; }
                            .details td { padding: 10px; border-bottom: 1px solid #f0f0f0; }
                            .details td:first-child { font-weight: bold; color: #555; width: 40%; }
                            .footer { background: #f8f9fa; padding: 20px; text-align: center; color: #666; font-size: 12px; }
                            .button { display: inline-block; background: #667eea; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h1>🔔 Reminder Maintenance</h1>
                                <p style='margin: 10px 0 0 0; font-size: 14px;'>eProcurement System</p>
                            </div>
                            <div class='content'>
                                <p>Kepada Yth. <strong>{$vendorName}</strong>,</p>
                                
                                <div class='info-box'>
                                    <strong>⏰ Pengingat:</strong> Besok (<strong>{$date}</strong>) ada jadwal maintenance yang perlu dilakukan.
                                </div>
                                
                                <div class='details'>
                                    <h3 style='margin-top: 0; color: #667eea;'>Detail Asset</h3>
                                    <table>
                                        <tr>
                                            <td>📦 Asset No</td>
                                            <td><strong>{$assetNo}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>🔧 Part Name</td>
                                            <td><strong>{$partName}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>📅 Tanggal</td>
                                            <td><strong>{$date}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <p style='color: #666; line-height: 1.6;'>
                                    Mohon untuk melakukan maintenance sesuai jadwal yang telah ditentukan. 
                                    Pastikan semua prosedur maintenance dilakukan dengan baik dan dokumentasikan hasilnya.
                                </p>
                                
                                <p style='margin-top: 30px;'>
                                    Terima kasih atas kerjasamanya.<br>
                                    <strong>Tim eProcurement</strong>
                                </p>
                            </div>
                            <div class='footer'>
                                <p>Email ini dikirim secara otomatis oleh sistem eProcurement.</p>
                                <p>© 2026 PT Dharma Polimetal. All rights reserved.</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ", 'text/html');
        });
        
        \Log::info('Email sent successfully to: ' . $vendorEmail);
    }
    
    /**
     * Auto-create next maintenance schedule based on moving type
     * Called when maintenance is completed
     */
    public function autoScheduleNextMaintenance($assetId, $movingType)
    {
        try {
            \Log::info('Auto scheduling next maintenance', [
                'asset_id' => $assetId,
                'moving_type' => $movingType
            ]);

            // Get interval based on moving type
            $intervalMonths = MaintenanceSetting::getIntervalByMovingType($movingType);
            
            // Calculate next maintenance date
            $nextMaintenanceDate = Carbon::now('Asia/Jakarta')->addMonths($intervalMonths);
            
            // Check if schedule already exists
            $existingSchedule = scheduleKunjungan::where('asset_id', $assetId)->first();
            
            if ($existingSchedule) {
                // Update existing schedule
                $existingSchedule->waktu_kunjungan = $nextMaintenanceDate;
                $existingSchedule->moving_type = $movingType;
                $existingSchedule->status = null; // Reset status
                $existingSchedule->save();
                
                \Log::info('Updated existing schedule', [
                    'asset_id' => $assetId,
                    'next_date' => $nextMaintenanceDate->toDateTimeString()
                ]);
            } else {
                // Create new schedule
                scheduleKunjungan::create([
                    'asset_id' => $assetId,
                    'waktu_kunjungan' => $nextMaintenanceDate,
                    'moving_type' => $movingType,
                    'idUser' => null, // System generated
                ]);
                
                \Log::info('Created new schedule', [
                    'asset_id' => $assetId,
                    'next_date' => $nextMaintenanceDate->toDateTimeString()
                ]);
            }
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to auto schedule next maintenance', [
                'asset_id' => $assetId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
