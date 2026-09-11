<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\masterData\Asset;
use Carbon\Carbon;
use App\Models\scheduleKunjungan;
use App\Models\Maintenance;
use App\Models\RescheduleLog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\masterData\Proses;
use App\Models\MaintenanceSetting;

class ActionMTController extends Controller
{
    public function index(){
     

        
        $twoMonthsAgo = Carbon::now()->subMonths(2);

        $idUser = auth()->user();
        $count = 0;
        $countTotal = 0;
        $assetsOld = [];
        $assetsRecent = [];
        $scheduleKunjungans = [];


    
        if($idUser->role == "Admin"){
              
            $countTotal = Asset::count();
         
            // Count assets with 'Maintenance Segera' status (today or past due)
            $count = Asset::with('scheduleKunjungans')
                ->get()
                ->filter(function($asset) {
                    if ($asset->scheduleKunjungans && $asset->scheduleKunjungans->waktu_kunjungan) {
                        $waktuKunjungan = Carbon::parse($asset->scheduleKunjungans->waktu_kunjungan);
                        return $waktuKunjungan->isToday() || $waktuKunjungan->isPast();
                    }
                    return false;
                })
                ->count();

           
                $assetsRecent = Asset::with([
                    'part',
                    'vendor',
                    'scheduleKunjungans',
                    'maintenances' => function($q) {
                        $q->latest()->limit(1);
                    }
                ])
                ->get()
                ->sortBy(function($asset) {
                    if ($asset->scheduleKunjungans && $asset->scheduleKunjungans->waktu_kunjungan) {
                        $waktu = Carbon::parse($asset->scheduleKunjungans->waktu_kunjungan);
                        if ($waktu->isToday() || $waktu->isPast()) {
                            return '0_' . $waktu->format('Y-m-d');
                        }
                        return '1_' . $waktu->format('Y-m-d');
                    }
                    return '2_9999-12-31';
                })
                ->values();


            
          
            
        }
        elseif($idUser->role == "vendor"){
            $user = auth()->user();
          
            $countTotal = Asset::where('vendor_id', $user->foreign_id)->count();

            
    
            
            
            // Count assets with 'Maintenance Segera' status for this vendor
            // Count assets with 'Maintenance Segera' status (today or past due)
            $count = Asset::with('scheduleKunjungans')
                ->where('vendor_id', $user->foreign_id)
                ->get()
                ->filter(function($asset) {
                    if ($asset->scheduleKunjungans && $asset->scheduleKunjungans->waktu_kunjungan) {
                        $waktuKunjungan = Carbon::parse($asset->scheduleKunjungans->waktu_kunjungan);
                        return $waktuKunjungan->isToday() || $waktuKunjungan->isPast();
                    }
                    return false;
                })
                ->count();
        
          
            $assetsRecent = Asset::with([
                'part',
                'vendor',
                'scheduleKunjungans',
                'maintenances' => function($q) {
                    $q->latest()->limit(1);
                }
            ])->where('vendor_id', $user->foreign_id)
            ->get()
            ->sortBy(function($asset) {
                if ($asset->scheduleKunjungans && $asset->scheduleKunjungans->waktu_kunjungan) {
                    $waktu = Carbon::parse($asset->scheduleKunjungans->waktu_kunjungan);
                    if ($waktu->isToday() || $waktu->isPast()) {
                        return '0_' . $waktu->format('Y-m-d');
                    }
                    return '1_' . $waktu->format('Y-m-d');
                }
                return '2_9999-12-31';
            })
            ->values();
        }

        //belum diwhare lagi untuk masing" vendor
       


   

       return view('maintenance.index', compact('count', 'countTotal', 'assetsRecent', 'idUser', 'scheduleKunjungans'));
    }

    public function kunjungan(Request $request)
{
 
    $validator = Validator::make($request->all(), [
        'asset_id' => 'required',
        'waktu_kunjungan' => 'required|date',
        'moving_type' => 'required|in:slow_moving,standar_moving,fast_moving',
    ]);

    if ($validator->fails()) {
        dd($validator->errors()); // 👈 Lihat error validasi di sini
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Lanjut kalau validasi lolos
    try {
        $scheduleKunjungan = new ScheduleKunjungan();
        $scheduleKunjungan->asset_id = $request->asset_id;
        $scheduleKunjungan->waktu_kunjungan = $request->waktu_kunjungan; // Fix nama field
        $scheduleKunjungan->moving_type = $request->moving_type;
        $scheduleKunjungan->idUser = auth()->user()->id;
        $scheduleKunjungan->save();

        return redirect()->back()->with('success', 'Jadwal berhasil disimpan!');
    } catch (\Throwable $th) {
        return redirect()->back()->withErrors($th->getMessage());
    }
}

public function KunjunganDestroy(Request $request)
{
 
    $scheduleKunjungan = ScheduleKunjungan::where('asset_id',$request->id)->first();
  
    $scheduleKunjungan->delete();
    return redirect()->back()->with('success', 'Jadwal berhasil dihapus!');
}
public function reschedule (Request $request)
{
    try {
        \Log::info('Reschedule Request Data', $request->all());
        
        $validator = Validator::make($request->all(), [
            'new_waktu_kunjungan' => 'required|date',
            'moving_type' => 'required|in:slow_moving,standar_moving,fast_moving',
        ]);

        if ($validator->fails()) {
            \Log::error('Reschedule Validation Failed', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kunjungan = null;
        $oldDate = null;
        $assetId = null;

        if ($request->kunjungan_id) {
            // Reschedule existing schedule
            \Log::info('Reschedule existing schedule', ['kunjungan_id' => $request->kunjungan_id]);
            $kunjungan = scheduleKunjungan::find($request->kunjungan_id);
            
            if (!$kunjungan) {
                \Log::error('Schedule not found', ['kunjungan_id' => $request->kunjungan_id]);
                return redirect()->back()->withErrors(['error' => 'Schedule tidak ditemukan']);
            }
            
            $oldDate = $kunjungan->waktu_kunjungan;
            $assetId = $kunjungan->asset_id;
            
            // Update existing schedule
            $kunjungan->waktu_kunjungan = $request->new_waktu_kunjungan;
            $kunjungan->moving_type = $request->moving_type;
            $kunjungan->status = null; // Reset status
            $kunjungan->save();
            \Log::info('Schedule updated', ['id' => $kunjungan->id]);
            
        } else {
            // Create new schedule (first time scheduling)
            \Log::info('Create new schedule', ['asset_id' => $request->asset_id]);
            $assetId = $request->asset_id;
            
            // Check if schedule already exists for this asset
            $existingSchedule = scheduleKunjungan::where('asset_id', $assetId)->first();
            
            if ($existingSchedule) {
                // Update existing instead of creating duplicate
                \Log::info('Existing schedule found, updating', ['id' => $existingSchedule->id]);
                $oldDate = $existingSchedule->waktu_kunjungan;
                $existingSchedule->waktu_kunjungan = $request->new_waktu_kunjungan;
                $existingSchedule->moving_type = $request->moving_type;
                $existingSchedule->status = null;
                $existingSchedule->save();
                $kunjungan = $existingSchedule;
            } else {
                // Create new schedule
                \Log::info('Creating new schedule');
                $kunjungan = scheduleKunjungan::create([
                    'asset_id' => $assetId,
                    'idUser' => auth()->user()->id,
                    'waktu_kunjungan' => $request->new_waktu_kunjungan,
                    'moving_type' => $request->moving_type,
                ]);
                \Log::info('New schedule created', ['id' => $kunjungan->id]);
            }
        }

        // Simpan log reschedule
        \Log::info('Creating reschedule log', ['asset_id' => $assetId]);
        $asset = Asset::where('no_assets', $assetId)->first();
        
        if (!$asset) {
            \Log::warning('Asset not found for reschedule log', ['asset_id' => $assetId]);
        }
        
        RescheduleLog::create([
            'asset_id' => $assetId,
            'vendor_id' => $asset ? $asset->vendor_id : null,
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->nm_user ?? auth()->user()->name ?? '-',
            'old_date' => $oldDate instanceof \Carbon\Carbon ? $oldDate->format('Y-m-d H:i:s') : (string) ($oldDate ?? 'Belum Dijadwalkan'),
            'new_date' => (string) $request->new_waktu_kunjungan,
        ]);
        
        \Log::info('Reschedule log created successfully');

        return redirect()->back()->with('success', 'Jadwal berhasil direschedule!');
        
    } catch (\Exception $e) {
        \Log::error('Reschedule Exception', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    }
}

public function riwayatReschedule(Request $request)
{
    $query = RescheduleLog::with(['asset.part', 'vendor'])
        ->orderBy('created_at', 'desc');

    if ($request->has('vendor_id') && !empty($request->vendor_id)) {
        $query->where('vendor_id', $request->vendor_id);
    }

    $logs = $query->get();
    $vendors = \App\Models\Vendor::orderBy('nm_vendor')->get();

    return view('maintenance.riwayat_reschedule', compact('logs', 'vendors'));
}

public function uploadMaintenance(Request $request)
{
    try {
        \Log::info('Upload Maintenance Request', $request->all());
        
        $validator = Validator::make($request->all(), [
            'asset_id' => 'required',
            'vendor_id' => 'required',
            'maintenance_file' => 'required|file|mimes:pdf|max:10240',
            'description' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            \Log::error('Validation Failed', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->status == 0){
            $asset = Asset::where('no_assets', $request->asset_id)->first();
            
            \Log::info('Asset Found', ['asset' => $asset ? $asset->no_assets : 'null']);
            
            if(!$asset) {
                return redirect()->back()->withErrors(['error' => 'Asset tidak ditemukan']);
            }
            
            $scheduleKunjungan = ScheduleKunjungan::where('asset_id', $asset->no_assets)->first();
    
            if ($request->hasFile('maintenance_file')) {
                $file = $request->file('maintenance_file');
                $fileName = 'maintenance_' . $asset->no_assets . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                $filePath = $file->storeAs('maintenance', $fileName, 'public');
                \Log::info('File Stored', ['path' => $filePath, 'fileName' => $fileName]);
                
                $maintenance = new Maintenance();
                $maintenance->asset_no = $asset->no_assets;
                $maintenance->vendor_id = $request->vendor_id;
                $maintenance->nama_file = $fileName;
                $maintenance->deskripsi = $request->description;
                $maintenance->status = 0;
                $maintenance->save();
                
                \Log::info('Maintenance Saved', ['id' => $maintenance->_id]);
    
                if($scheduleKunjungan) {
                    $scheduleKunjungan->update(['waktu_kunjungan' => null]);
                    \Log::info('Schedule Updated');
                }
    
                return redirect()->back()->with('success', 'File maintenance berhasil diupload dan data tersimpan untuk Asset: ' . $asset->no_assets);
            }
        }
        elseif($request->status == 1){
           $maintenance = Maintenance::where('asset_no', $request->asset_id)
            ->latest()
            ->first();
   
            if($maintenance) {
                $maintenance->status = 0;
                $maintenance->deskripsi = $request->description;
                $maintenance->save();
                return redirect()->back()->with('success', 'Maintenance berhasil diupdate');
            }
        }
      
        return redirect()->back()->withErrors(['maintenance_file' => 'File tidak ditemukan']);
        
    } catch (\Exception $e) {
        \Log::error('Upload Maintenance Error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    }
}

public function verification()
{
    // Ambil data maintenance dengan status 0 beserta relasi asset.part dan vendor
    $maintenances = Maintenance::with(['asset.part', 'vendor'])
        ->where('status', 0)
        ->get();
   
    return view('maintenance.verification', compact('maintenances'));
}

public function approveMaintenance($id)
{
    try {
        $maintenance = Maintenance::find($id);
        
        if (!$maintenance) {
            return redirect()->back()->with('error', 'Data maintenance tidak ditemukan');
        }

        $asset = Asset::where('no_assets', $maintenance->asset_no)->first();
        
        // Get existing schedule to get moving_type
        $schedule = ScheduleKunjungan::where('asset_id', $maintenance->asset_no)->first();
        $movingType = $schedule && $schedule->moving_type ? $schedule->moving_type : 'standar_moving';
        
        // Get interval based on moving type
        $addMonths = MaintenanceSetting::getIntervalByMovingType($movingType);

        // Calculate next maintenance date (keep in Asia/Jakarta timezone)
        $target = Carbon::now('Asia/Jakarta')
            ->addMonthsNoOverflow($addMonths)
            ->format('Y-m-d H:i:s');
        
        $maintenance->status = 2;
        $maintenance->deskripsi = "All done";
        $maintenance->save();

        // Update atau create schedule dengan moving_type
        if ($schedule) {
            $schedule->waktu_kunjungan = $target;
            $schedule->moving_type = $movingType;
            $schedule->status = null; // Reset status
            $schedule->save();
        } else {
            ScheduleKunjungan::create([
                'asset_id' => $maintenance->asset_no,
                'idUser' => auth()->user()->id,
                'waktu_kunjungan' => $target,
                'moving_type' => $movingType,
            ]);
        }
        
        \Log::info('Maintenance approved and next schedule updated', [
            'asset_id' => $maintenance->asset_no,
            'moving_type' => $movingType,
            'interval_months' => $addMonths,
            'next_maintenance' => $target
        ]);
        
        return redirect()->back()->with('success', 'Maintenance berhasil disetujui untuk Asset: ' . $maintenance->asset_no);
        
    } catch (\Exception $e) {
        \Log::error('Approve maintenance failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

public function rejectMaintenance(Request $request, $id)
{
   
    $validator = Validator::make($request->all(), [
        'reject_reason' => 'required|string|max:500'
    ]);

   
    try {
        $maintenance = Maintenance::find($id);
        
        if (!$maintenance) {
            return redirect()->back()->withErrors(['error' => 'Data maintenance tidak ditemukan']);
        }
        
        $maintenance->status = 1; // Status rejected
        $maintenance->alasan_reject = $request->reject_reason;
        $maintenance->save();

        // Restore jadwal kunjungan agar vendor bisa upload ulang
        $scheduleKunjungan = scheduleKunjungan::where('asset_id', $maintenance->asset_no)->first();
        if($scheduleKunjungan) {
            $scheduleKunjungan->waktu_kunjungan = Carbon::now()->format('d-m-Y');
            $scheduleKunjungan->save();
        }
        
        return redirect()->back()->with('success', 'Maintenance berhasil ditolak untuk Asset: ' . $maintenance->asset_no);
        
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    }
}

public function riwayat()
{
    $query = Maintenance::with(['asset.part', 'vendor'])
        ->orderBy('created_at', 'desc');

    // Vendor hanya lihat miliknya
    if (auth()->user()->role === 'vendor') {
        $query->where('vendor_id', auth()->user()->foreign_id);
    }

    $maintenances = $query->get();

    return view('maintenance.riwayat', compact('maintenances'));
}

public function export()
{
    $idUser = auth()->user();
    
    // Get assets based on user role
    if($idUser->role == "Admin"){
        $assets = Asset::with(['part', 'vendor', 'scheduleKunjungans'])->get();
    } elseif($idUser->role == "vendor"){
        $assets = Asset::with(['part', 'vendor', 'scheduleKunjungans'])
            ->where('vendor_id', $idUser->foreign_id)
            ->get();
    } else {
        $assets = collect();
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Header
    $sheet->setCellValue('A1', '#');
    $sheet->setCellValue('B1', 'Asset No');
    $sheet->setCellValue('C1', 'Vendor');
    $sheet->setCellValue('D1', 'Part');
    $sheet->setCellValue('E1', 'Dies');
    $sheet->setCellValue('F1', 'Process');
    $sheet->setCellValue('G1', 'Quantity');
    $sheet->setCellValue('H1', 'Next Maintenance');
    $sheet->setCellValue('I1', 'Status');
    
    // Data
    $row = 2;
    foreach ($assets as $index => $asset) {
        // Get process names
        $prosesNames = [];
        if(is_array($asset->proses_id)) {
            foreach($asset->proses_id as $pid) {
                $p = Proses::find($pid);
                if($p) $prosesNames[] = $p->proses_name;
            }
        } elseif($asset->proses_id) {
            $p = Proses::find($asset->proses_id);
            if($p) $prosesNames[] = $p->proses_name;
        }
        $prosesName = !empty($prosesNames) ? implode(', ', $prosesNames) : '-';
        
        // Determine status
        $status = 'Belum Dijadwalkan';
        if($asset->scheduleKunjungans && $asset->scheduleKunjungans->waktu_kunjungan) {
            $waktuKunjungan = Carbon::parse($asset->scheduleKunjungans->waktu_kunjungan);
            if($waktuKunjungan->isToday() || $waktuKunjungan->isPast()) {
                $status = 'Maintenance Segera';
            } else {
                $status = 'Terjadwal';
            }
        }
        
        $sheet->setCellValue('A' . $row, $index + 1);
        $sheet->setCellValue('B' . $row, $asset->no_assets ?? '-');
        $sheet->setCellValue('C' . $row, optional($asset->vendor)->nm_vendor ?? '-');
        $sheet->setCellValue('D' . $row, optional($asset->part)->part_name ?? '-');
        $sheet->setCellValue('E' . $row, (!empty($asset->dies) && $asset->dies !== 'nan') ? $asset->dies : '-');
        $sheet->setCellValue('F' . $row, $prosesName);
        $sheet->setCellValue('G' . $row, $asset->jumlah ?? '-');
        $sheet->setCellValue('H' . $row, optional($asset->scheduleKunjungans)->waktu_kunjungan ?? '-');
        $sheet->setCellValue('I' . $row, $status);
        $row++;
    }
    
    $writer = new Xlsx($spreadsheet);
    $filename = 'maintenance_assets_' . date('YmdHis') . '.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit;
}

}