<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManifestHeader;
use Config;
use Storage;
use MongoDB\BSON\UTCDateTime;

class DeliveryScheduleController extends Controller
{
    public function index()
    {
        return view('delivery_schedule/index');
    }

    public function index_spo()
    {
        return view('delivery_schedule/index_spc');
    }
    public function createDummyFile()
    {
        foreach(ManifestHeader::get() as $mf){
           $filenm = explode("#", $mf->file_nm);
          \File::copy(storage_path('template_dummy/dummymf.pdf'), storage_path('MF_TEST/'.strtoupper($mf->mf_type).'/'.$filenm[0]));
          \File::copy(storage_path('template_dummy/dummymf.pdf'), storage_path('MF_TEST/'.strtoupper($mf->mf_type).'-KANBAN/'.$filenm[1]));
        }
        return true;
    }
    public function zipMF(Request $request)
    {
        // dd(\Storage::disk('mf_directory')->path("/"));
        // Storage::disk('mf_directory')->put('file.txt', 'Contents');
        $zip = new \ZipArchive();
        $fileName = "DHARMA_POLIMETAL_MI_MFPDF_".date("d-m-Y").".zip";
        // try{
             if ($zip->open(storage_path('temp_zip/MI-'.md5($request->ip().time().$fileName)).'.tmp', \ZipArchive::CREATE) == TRUE)
            
            {

                foreach ($request->download_doc as $k){
                    $filenm = explode("#", $k);
                      // dd($filenm);
                    // dd(scandir("D:/MI_TEST/MI/"));
                 // "D:\\\\MANIFEST\\".$mf_type."\\PRD-".$mf_type."\\"
                    $file = Storage::disk('mf_directory')->path("/").$filenm[0];
                    $relativeName = basename($file);
                    // dd($filenm[0])
                    $zip->addFile($file, $filenm[0]);

                    $file = Storage::disk('mf_kanban_directory')->path("/").$filenm[1];
                    $relativeName = basename($file);
                    $zip->addFile($file, $filenm[1]);
                }
                $zip->close();

                  return response()->download(storage_path('temp_zip/MI-'.md5($request->ip().time().$fileName)).'.tmp', $fileName)->deleteFileAfterSend(true);
            }
        // } catch(\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $e)
        // {
        //     return redirect()->back()->with(['message_fail' => 'File Tidak Ditemukan.']);
        // }

      
    }

    public function zipMFSP(Request $request)
    {

        $zip = new \ZipArchive();
        $fileName = "DHARMA_POLIMETAL_SO_MFPDF_".date("d-m-Y").".zip";
        try{
             if ($zip->open(storage_path('temp_zip/SO-'.md5($request->ip().time().$fileName)).'.tmp', \ZipArchive::CREATE) == TRUE)
            
            {
                
                foreach ($request->download_doc as $k){
                    $filenm = explode("#", $k);
                      // dd($filenm);
                 // "D:\\\\MANIFEST\\".$mf_type."\\PRD-".$mf_type."\\"
                    $file = Storage::disk('so_directory')->path("/").$filenm[0];
                    $relativeName = basename($file);
                    // dd($filenm[0])
                    $zip->addFile($file, $filenm[0]);

                    $file = Storage::disk('so_kanban_directory')->path("/").$filenm[1];
                    $relativeName = basename($file);
                    $zip->addFile($file, $filenm[1]);
                }
                $zip->close();

                  return response()->download(storage_path('temp_zip/SO-'.md5($request->ip().time().$fileName)).'.tmp', $fileName)->deleteFileAfterSend(true);
            }
        } catch(\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $e)
        {
            return redirect()->back()->with(['message_fail' => 'File Tidak Ditemukan.']);
        }

      
    }

   

    public function getDeliveryMf($start=null,$end=null,$manifest=null)
    {
       if(auth()->user()->role == 'vendor')
       {
            if(!empty($start) && !empty($end))
            {
                $sYear = date("Y",strtotime($start));
                $sMonth = date("m",strtotime($start));
                $sDay = date("d",strtotime($start));

                $eYear = date("Y",strtotime($end));
                $eMonth = date("m",strtotime($end));
                $eDay = date("d",strtotime($end));
                 $mf = ManifestHeader::where('id_vendor', auth()->user()->foreign_id)->whereBetween(
                             'delivery_date', array(
                                 \Carbon\Carbon::createFromDate($sYear, $sMonth, $sDay),
                                  \Carbon\Carbon::createFromDate($eYear, $eMonth, $eDay)
                             ));
                    
                if(!empty($manifest))
                {
                    $mf->where('manifest', $manifest);
                }
                $data = $mf->where('mf_type','MI')->get();
            }else{
             $data = ManifestHeader::where('id_vendor', auth()->user()->foreign_id)->where('mf_type','MI')->get();

            }
       } else {
              // dd($start);
           if(!empty($start) && !empty($end))
            { 

                $sYear = date("Y",strtotime($start));
                $sMonth = date("m",strtotime($start));
                $sDay = date("d",strtotime($start));

                $eYear = date("Y",strtotime($end));
                $eMonth = date("m",strtotime($end));
                $eDay = date("d",strtotime($end));

                 $mf = ManifestHeader::whereBetween(
                         'delivery_date', array(
                             \Carbon\Carbon::createFromDate($sYear, $sMonth, $sDay),
                              \Carbon\Carbon::createFromDate($eYear, $eMonth, $eDay)
                         ));
                if(!empty($manifest))
                {
                    $mf->where('manifest', $manifest);
                }
                $data = $mf->where('mf_type','MI')->get();
            }else{
             $data = ManifestHeader::where('mf_type','MI')->get();

            }
       }
 
       return \DataTables::of($data)
          
            ->editColumn('delivery_date', function ($data) {
                
               return  date('Y-m-d',strtotime($data->delivery_date));
            }) 
            ->addColumn('vendor_name', function ($data) {
               return empty($data->vendors) ? "-":$data->vendors->nm_vendor;
            })
            ->addColumn('vendor_email', function ($data) {
               return empty($data->vendors->user) ? "-":$data->vendors->user->username;
            })

            ->addColumn('download_check', function ($data) {
               return '<input type="checkbox" data-filenm="'.$data->file_nm.'"  class="checked" id="'.$data->manifest.'" onclick="selectedDwn(\'#'.$data->manifest.'\')"  name="downloadchk[]" value="'.$data->manifest.'">';
            })
            ->addColumn('mail_stat', function ($data) {
               if(!empty($data->sent) || ($data->sent != '0000-00-00 00:00:00'))
               {
                return "<small><i class='fas fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fas fa-exclamation-circle' style='color: red;'></i></small>";
            
            }) 
            ->addColumn('downloaded', function ($data) {
               if(!empty($data->downloaded) || ($data->downloaded != '0000-00-00 00:00:00'))
               {
                return "<small><i class='fas fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fas fa-exclamation-circle' style='color: red;'></i></small>";
            
            })
             ->addColumn('file_stat', function ($data) {
               if(!empty($data->file_nm))
               {
                return "<small><i class='fas fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fas fa-exclamation-circle' style='color: red;'></i></small>";
            
            }) 
             ->addColumn('active', function ($data) {
               if($data->active == "A")
               {
                return "<small><i class='fas fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fas fa-exclamation-circle' style='color: red;'></i></small>";
            
            })
            ->rawColumns(['download_check','mail_stat','downloaded','file_stat','active'])
            ->make(true);
    }

    public function getDeliverySPC($start=null,$end=null,$manifest=null)
    {
        if(auth()->user()->role == 'vendor')
       {
            if(!empty($start) && !empty($end))
            {
                $sYear = date("Y",strtotime($start));
                $sMonth = date("m",strtotime($start));
                $sDay = date("d",strtotime($start));

                $eYear = date("Y",strtotime($end));
                $eMonth = date("m",strtotime($end));
                $eDay = date("d",strtotime($end));
                 $mf = ManifestHeader::where('id_vendor', auth()->user()->foreign_id)->whereBetween(
                             'delivery_date', array(
                                 \Carbon\Carbon::createFromDate($sYear, $sMonth, $sDay),
                                  \Carbon\Carbon::createFromDate($eYear, $eMonth, $eDay)
                             ));
                if(!empty($manifest))
                {
                    $mf->where('manifest', $manifest);
                }    
                 $data =$mf->where('mf_type','SO')->get();
            }else{
             $data = ManifestHeader::where('id_vendor', auth()->user()->foreign_id)->where('mf_type','SO')->get();

            }
       } else {
              // dd($start);
           if(!empty($start) && !empty($end))
            { 

                $sYear = date("Y",strtotime($start));
                $sMonth = date("m",strtotime($start));
                $sDay = date("d",strtotime($start));

                $eYear = date("Y",strtotime($end));
                $eMonth = date("m",strtotime($end));
                $eDay = date("d",strtotime($end));

                 $mf = ManifestHeader::whereBetween(
                         'delivery_date', array(
                             \Carbon\Carbon::createFromDate($sYear, $sMonth, $sDay),
                              \Carbon\Carbon::createFromDate($eYear, $eMonth, $eDay)
                         ));
                if(!empty($manifest))
                {
                    $mf->where('manifest', $manifest);
                }    
                 $data =$mf->where('mf_type','SO')->get();
            }else{
             $data = ManifestHeader::where('mf_type','SO')->get();

            }
       }
       return \DataTables::of($data)
          
            ->editColumn('delivery_date', function ($data) {
                
               return  date('Y-m-d',strtotime($data->delivery_date));
            }) 
            ->addColumn('vendor_name', function ($data) {
               return empty($data->vendors) ? "-":$data->vendors->nm_vendor;
            })
            ->addColumn('vendor_email', function ($data) {
               return empty($data->vendors->user) ? "-":$data->vendors->user->username;
            })

            ->addColumn('download_check', function ($data) {
                 return '<input type="checkbox" data-filenm="'.$data->file_nm.'"  class="checked" id="'.$data->manifest.'" onclick="selectedDwn(\'#'.$data->manifest.'\')"  name="downloadchk[]" value="'.$data->manifest.'">';
            })
            ->addColumn('mail_stat', function ($data) {
               if(!empty($data->sent) || ($data->sent != '0000-00-00 00:00:00'))
               {
                return "<small><i class='fas fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fas fa-exclamation-circle' style='color: red;'></i></small>";
            
            }) 
            ->addColumn('downloaded', function ($data) {
               if(!empty($data->downloaded) || ($data->downloaded != '0000-00-00 00:00:00'))
               {
                return "<small><i class='fas fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fas fa-exclamation-circle' style='color: red;'></i></small>";
            
            })
             ->addColumn('file_stat', function ($data) {
               if(!empty($data->file_nm))
               {
                return "<small><i class='fas fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fas fa-exclamation-circle' style='color: red;'></i></small>";
            
            }) 
             ->addColumn('active', function ($data) {
               if($data->active == "A")
               {
                return "<small><i class='fas fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fas fa-exclamation-circle' style='color: red;'></i></small>";
            
            })
            ->rawColumns(['download_check','mail_stat','downloaded','file_stat','active'])
            ->make(true);
    }
}
