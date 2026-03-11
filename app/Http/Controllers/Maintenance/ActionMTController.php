<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\masterData\Asset;
use Carbon\Carbon;
use App\Models\scheduleKunjungan;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\masterData\Proses;

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
                        $q->latest()->limit(1); // ambil hanya maintenance terbaru
                    }
                ])
                ->get()
                ->sortBy(function($asset) {
                    if ($asset->scheduleKunjungans && $asset->scheduleKunjungans->count() > 0) {
                        return $asset->scheduleKunjungans
                            ->whereBetween('waktu_kunjungan', [Carbon::now(), Carbon::now()->addDays(7)])
                            ->min('waktu_kunjungan') ?? now()->addYears(100);
                    }
                    return now()->addYears(100);
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
                    $q->latest()->limit(1); // ambil hanya maintenance terbaru
                }
            ])->where('vendor_id', $user->foreign_id)
            ->get()
            ->sortBy(function($asset) {
                if ($asset->scheduleKunjungans && $asset->scheduleKunjungans->count() > 0) {
                    return $asset->scheduleKunjungans
                        ->whereBetween('waktu_kunjungan', [Carbon::now(), Carbon::now()->addDays(7)])
                        ->min('waktu_kunjungan') ?? now()->addYears(100);
                }
                return now()->addYears(100);
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
   
    $validator = Validator::make($request->all(), [
        'kunjungan_id' => 'required',
        'new_waktu_kunjungan' => 'required|date',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $kunjungan = scheduleKunjungan::find($request->kunjungan_id);
    $kunjungan->waktu_kunjungan = $request->new_waktu_kunjungan;
    $kunjungan->save();

    return redirect()->back()->with('success', 'Jadwal berhasil direschedule!');
}

public function uploadMaintenance(Request $request)
{
    try {
        \Log::info('Upload Maintenance Request', $request->all());
        
        $validator = Validator::make($request->all(), [
            'asset_id' => 'required',
            'vendor_id' => 'required',
            'maintenance_file' => 'required|file|mimes:png,pdf|max:10240',
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
        $scheduleKunjungan = ScheduleKunjungan::where('asset_id', $maintenance->asset_no)->first();

        $target = Carbon::now('Asia/Jakarta')
        ->addMonthsNoOverflow(2)
        ->timezone('UTC')
        ->format('d-m-Y');

        
        if (!$maintenance) {
            return redirect()->back()->withErrors(['error' => 'Data maintenance tidak ditemukan']);
        }
        
        $maintenance->status = 2; // Status approved
        $maintenance->deskripsi =  "All done";
        $maintenance->save();

        $scheduleKunjungan->waktu_kunjungan = $target;
        $scheduleKunjungan->save();

        
        
        return redirect()->back()->with('success', 'Maintenance berhasil disetujui untuk Asset: ' . $maintenance->asset_no);
        
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
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
        
        $maintenance->status = null; // Status rejected
        $maintenance->deskripsi = $request->reject_reason;
        $maintenance->save();
        
        return redirect()->back()->with('success', 'Maintenance berhasil ditolak untuk Asset: ' . $maintenance->asset_no);
        
    } catch (\Exception $e) {
        dd($e);
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    }
}

public function riwayat()
{
    $maintenances = Maintenance::with(['asset.part', 'vendor'])
        ->orderBy('created_at', 'desc')
        ->get();

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