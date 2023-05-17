<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManifestHeader;
use App\Models\Vendor;
use Config;
use Storage;
use MongoDB\BSON\UTCDateTime;

class DeliveryScheduleController extends Controller
{
    public function index()
    {
        $vendor = Vendor::all();
        return view('delivery_schedule/index')->with(['list_vendor' => $vendor]);
    }

    public function index_spo()
    {
       $vendor = Vendor::all();
        return view('delivery_schedule/index_spc')->with(['list_vendor' => $vendor]);
    }
    public function createDummyFile()
    {
        foreach(ManifestHeader::get() as $mf){
           $filenm = explode("#", $mf->file_nm);
          \File::copy(storage_path('template_dummy/dummymf.pdf'), storage_path('MF_TEST/'.strtoupper($mf->mf_type).'/'.@$filenm[0]));
          \File::copy(storage_path('template_dummy/dummymf.pdf'), storage_path('MF_TEST/'.strtoupper($mf->mf_type).'-KANBAN/'.@$filenm[1]));
        }
        return true;
    }
    public function zipMF(Request $request)
    {
        if(!extension_loaded('zip'))
        {
            return redirect()->back()->with(['message_fail' => 'Zip extension not enabled or not installed on server, please contact the IT team.']);
        }
        if(empty($request->download_doc))
        {
            return redirect()->back()->with(['message_fail' => 'Belum ada data yang dipilih.']);
        }
        // dd(\Storage::disk('mf_directory')->path("/"));
        // Storage::disk('mf_directory')->put('file.txt', 'Contents');
        $zip = new \ZipArchive();
        $fileName = "DHARMA_POLIMETAL_MI_MFPDF_".date("d-m-Y").".zip";
        $zipnm = md5($request->ip().time().$fileName);
        try{
             if ($zip->open(storage_path('temp_zip/MI-'.$zipnm.'.tmp'), \ZipArchive::CREATE) == TRUE)
            
            {
               
                foreach ($request->download_doc as $k){
                    $filenm = explode("#", $k);
                      // dd($filenm);
                    // dd(scandir("D:/MI_TEST/MI/"));
                 // "D:\\\\MANIFEST\\".$mf_type."\\PRD-".$mf_type."\\"
                    $file = Storage::disk('mf_directory')->path("").$filenm[0];
                    $file_qas = Storage::disk('mf_qas_directory')->path("").$filenm[0];
                    $relativeName = basename($file);
                    // dd(file_get_contents( $file));
                    if(file_exists($file))
                    {
                        $zip->addFile($file, "01 Manifest/".$filenm[0]);
                    } else{
                         $zip->addFile($file_qas, "01 Manifest/".$filenm[0]);
                    }

                    $file = Storage::disk('mf_kanban_directory')->path("").$filenm[1];
                    $file_qas = Storage::disk('mf_qas_kanban_directory')->path("").$filenm[1];
                    $relativeName = basename($file);

                    if(file_exists($file))
                    {
                        $zip->addFile($file, "02 Kanban/".$filenm[1]);
                    } else{
                         $zip->addFile($file_qas, "02 Kanban/".$filenm[1]);
                    }
                }
                $zip->close();
                  ///SET DOWNLOAD FLAG
                foreach($request->id_mf as $mf)
                {
                     ManifestHeader::where('manifest',$mf)->update(['downloaded' => date('Y-m-d H:i:s')]);
                }
                ///DOWNLOADING
                  return response()->download(storage_path('temp_zip/MI-'.$zipnm.'.tmp'), $fileName)->deleteFileAfterSend(true);
            }
        }  catch(\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $e)
        {
            // return $e;
            return redirect()->back()->with(['message_fail' => 'File Not Found.']);
        } catch(\InvalidArgumentException $e)
        {
            return redirect()->back()->with(['message_fail' => 'PO Directory filesystem driver has not been set in  application, please contact the IT team.']);
        } catch(\Exception $e)
        {
            return redirect()->back()->with(['message_fail' => 'File Not Found, maybe PO Directory in filesystem config not been set in applicaton or directory not been mount on server, please contact IT Team']);
        }

      
    }

    public function zipMFSP(Request $request)
    {
        if(!extension_loaded('zip'))
        {
            return redirect()->back()->with(['message_fail' => 'Zip extension not enabled or not installed on server, please contact the IT team.']);
        }
        if(empty($request->download_doc))
        {
            return redirect()->back()->with(['message_fail' => 'Belum ada data yang dipilih.']);
        }

        $zip = new \ZipArchive();
        $fileName = "DHARMA_POLIMETAL_SO_MFPDF_".date("d-m-Y").".zip";
        $zipnm = md5($request->ip().time().$fileName);
        try{


             if ($zip->open(storage_path('temp_zip/SO-'.$zipnm.'.tmp'), \ZipArchive::CREATE) == TRUE)
            
            {
                
                foreach ($request->download_doc as $k){
                    $filenm = explode("#", $k);
                      // dd($filenm);
                 // "D:\\\\MANIFEST\\".$mf_type."\\PRD-".$mf_type."\\"
                    $file = Storage::disk('so_directory')->path("").$filenm[0];
                    $file_qas = Storage::disk('so_qas_directory')->path("").$filenm[0];
                    $relativeName = basename($file);
                    // dd($filenm[0])
                    // dd(file_get_contents( $file));
                    if(file_exists($file))
                    {
                        $zip->addFile($file, "01 Manifest/".$filenm[0]);
                    } else{
                         $zip->addFile($file_qas, "01 Manifest/".$filenm[0]);
                    }

                    $file = Storage::disk('so_kanban_directory')->path("").$filenm[1];
                    $file_qas = Storage::disk('so_qas_kanban_directory')->path("").$filenm[1];
                    $relativeName = basename($file);
                    if(file_exists($file))
                    {
                        $zip->addFile($file, "02 Kanban/".$filenm[1]);
                    } else{
                         $zip->addFile($file_qas,"02 Kanban/". $filenm[1]);
                    }    
                }
                $zip->close();
                ///SET DOWNLOAD FLAG
                foreach($request->id_mf as $mf)
                {
                    ManifestHeader::where('manifest',$mf)->update(['downloaded' => date('Y-m-d H:i:s')]);
                }
                ///DOWNLOADING
                  return response()->download(storage_path('temp_zip/SO-'.$zipnm.'.tmp'), $fileName)->deleteFileAfterSend(true);
            }
        }  catch(\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $e)
        {
            // return $e;
            return redirect()->back()->with(['message_fail' => 'File Not Found.']);
        } catch(\InvalidArgumentException $e)
        {
            return redirect()->back()->with(['message_fail' => 'PO Directory filesystem driver has not been set in  application, please contact the IT team.']);
        } catch(\Exception $e)
        {
            return redirect()->back()->with(['message_fail' => 'File Not Found, maybe PO Directory in filesystem config not been set in applicaton or directory not been mount on server, please contact IT Team']);
        }

      
    }

   

    public function getDeliveryMf(Request $request)
    {
         $vendor_list =array_filter(preg_split('/\r\n|\r|\n/',$request->vendor_list));

        $manifest = array_filter(preg_split('/\r\n|\r|\n/',$request->manifest));
       if(auth()->user()->role == 'vendor')
       {
            if(!empty($request->dt_start) && !empty($request->dt_end))
            {
                $sYear = date("Y",strtotime($request->dt_start));
                $sMonth = date("m",strtotime($request->dt_start));
                $sDay = date("d",strtotime($request->dt_start));

                $eYear = date("Y",strtotime($request->dt_end));
                $eMonth = date("m",strtotime($request->dt_end));
                $eDay = date("d",strtotime($request->dt_end));
                 $mf = ManifestHeader::where('id_vendor', auth()->user()->foreign_id)->whereBetween(
                             'delivery_date', array(
                                 \Carbon\Carbon::createFromDate($sYear, $sMonth, $sDay),
                                  \Carbon\Carbon::createFromDate($eYear, $eMonth, $eDay)
                             ));
                if(count($manifest) > 0)
                {
                    $mf->whereIn('manifest', $manifest);
                }
                 if ((count($vendor_list)>0)) {
                    $mf->whereIn('id_vendor', $vendor_list);
                } elseif((count($vendor_list)==0) AND $request->vendor_select != null){
                    $mf->whereIn('id_vendor',[$request->vendor_select]);
                }
                $data = $mf->where('mf_type','MI')->get();
            }else{
             // $data = ManifestHeader::where('id_vendor', auth()->user()->foreign_id)->where('mf_type','MI')->get();

             $mf =   ManifestHeader::where('id_vendor', auth()->user()->foreign_id)->where('mf_type','MI');

              if(count($manifest) > 0)
                {
                    $mf->whereIn('manifest', $manifest);
                }
                if ((count($vendor_list)>0)) {
                    $mf->whereIn('id_vendor', $vendor_list);
                } elseif((count($vendor_list)==0) AND $request->vendor_select != null){
                    $mf->whereIn('id_vendor',[$request->vendor_select]);
                }

             $data = $mf->get();

            }
       } else {
              // dd($request->dt_end);
           if(!empty($request->dt_start) && !empty($request->dt_end))
            { 

                $sYear = date("Y",strtotime($request->dt_start));
                $sMonth = date("m",strtotime($request->dt_start));
                $sDay = date("d",strtotime($request->dt_start));

                $eYear = date("Y",strtotime($request->dt_end));
                $eMonth = date("m",strtotime($request->dt_end));
                $eDay = date("d",strtotime($request->dt_end));

                 $mf = ManifestHeader::whereBetween(
                         'delivery_date', array(
                             \Carbon\Carbon::createFromDate($sYear, $sMonth, $sDay),
                              \Carbon\Carbon::createFromDate($eYear, $eMonth, $eDay)
                         ));
               if(count($manifest) > 0)
                {
                    $mf->whereIn('manifest', $manifest);
                }
                if ((count($vendor_list)>0)) {
                    $mf->whereIn('id_vendor', $vendor_list);
                } elseif((count($vendor_list)==0) AND $request->vendor_select != null){
                    $mf->whereIn('id_vendor',[$request->vendor_select]);
                }
                $data = $mf->where('mf_type','MI')->get();
            }else{


             $mf =  ManifestHeader::where('mf_type','MI');

              if(count($manifest) > 0)
                {
                    $mf->whereIn('manifest', $manifest);
                }
                if ((count($vendor_list)>0)) {
                    $mf->whereIn('id_vendor', $vendor_list);
                } elseif((count($vendor_list)==0) AND $request->vendor_select != null){
                    $mf->whereIn('id_vendor',[$request->vendor_select]);
                }

             $data = $mf->get();

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
       
            if(@$data->vendors->user->status_user == "A")
            {
                $s = " <i title='User Active' class='fas fa-check-circle text-success'></i> ";
            } else{
                $s="<i title='User Non Active' class='fas fa-exclamation-circle text-warning'></i>";
            }
            
               return empty($data->vendors->user) ? "-":$data->vendors->user->username." ".$s;
            })

            ->addColumn('download_check', function ($data) {
               return '<input type="checkbox" data-filenm="'.$data->file_nm.'"  class="checked" id="'.$data->manifest.'" onclick="selectedDwn(\'#'.$data->manifest.'\')"  name="downloadchk[]" value="'.$data->manifest.'">';
            })
            ->addColumn('mail_stat', function ($data) {
               if((!empty($data->sent) || ($data->sent != '0000-00-00 00:00:00')) AND isset($data->sent))
               {
                return "<small><i class='fas fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fas fa-exclamation-circle' style='color: red;'></i></small>";
            
            }) 
            ->addColumn('downloaded', function ($data) {
               if((!empty($data->downloaded) || ($data->downloaded != '0000-00-00 00:00:00')) AND isset($data->downloaded))
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
            ->rawColumns(['download_check','mail_stat','vendor_email','downloaded','file_stat','active'])
            ->make(true);
    }

    public function getDeliverySPC(Request $request)
    {
         $vendor_list =array_filter(preg_split('/\r\n|\r|\n/',$request->vendor_list));

        $manifest = array_filter(preg_split('/\r\n|\r|\n/',$request->manifest));
       if(auth()->user()->role == 'vendor')
       {
            if(!empty($request->dt_start) && !empty($request->dt_end))
            {
                $sYear = date("Y",strtotime($request->dt_start));
                $sMonth = date("m",strtotime($request->dt_start));
                $sDay = date("d",strtotime($request->dt_start));

                $eYear = date("Y",strtotime($request->dt_end));
                $eMonth = date("m",strtotime($request->dt_end));
                $eDay = date("d",strtotime($request->dt_end));
                 $mf = ManifestHeader::where('id_vendor', auth()->user()->foreign_id)->whereBetween(
                             'delivery_date', array(
                                 \Carbon\Carbon::createFromDate($sYear, $sMonth, $sDay),
                                  \Carbon\Carbon::createFromDate($eYear, $eMonth, $eDay)
                             ));
                if(count($manifest) > 0)
                {
                    $mf->whereIn('manifest', $manifest);
                }
                 if ((count($vendor_list)>0)) {
                    $mf->whereIn('id_vendor', $vendor_list);
                } elseif((count($vendor_list)==0) AND $request->vendor_select != null){
                    $mf->whereIn('id_vendor',[$request->vendor_select]);
                }
                $data = $mf->where('mf_type','SO')->get();
            }else{
              
             $mf =   ManifestHeader::where('id_vendor', auth()->user()->foreign_id)->where('mf_type','SO');

              if(count($manifest) > 0)
                {
                    $mf->whereIn('manifest', $manifest);
                }
                if ((count($vendor_list)>0)) {
                    $mf->whereIn('id_vendor', $vendor_list);
                } elseif((count($vendor_list)==0) AND $request->vendor_select != null){
                    $mf->whereIn('id_vendor',[$request->vendor_select]);
                }

             $data = $mf->get();

            }
       } else {
              // dd($request->dt_end);
           if(!empty($request->dt_start) && !empty($request->dt_end))
            { 

                $sYear = date("Y",strtotime($request->dt_start));
                $sMonth = date("m",strtotime($request->dt_start));
                $sDay = date("d",strtotime($request->dt_start));

                $eYear = date("Y",strtotime($request->dt_end));
                $eMonth = date("m",strtotime($request->dt_end));
                $eDay = date("d",strtotime($request->dt_end));

                 $mf = ManifestHeader::whereBetween(
                         'delivery_date', array(
                             \Carbon\Carbon::createFromDate($sYear, $sMonth, $sDay),
                              \Carbon\Carbon::createFromDate($eYear, $eMonth, $eDay)
                         ));
               if(count($manifest) > 0)
                {
                    $mf->whereIn('manifest', $manifest);
                }
                if ((count($vendor_list)>0)) {
                    $mf->whereIn('id_vendor', $vendor_list);
                } elseif((count($vendor_list)==0) AND $request->vendor_select != null){
                    $mf->whereIn('id_vendor',[$request->vendor_select]);
                }
                $data = $mf->where('mf_type','SO')->get();
            }else{
               
             $mf =   ManifestHeader::where('mf_type','SO');

              if(count($manifest) > 0)
                {
                    $mf->whereIn('manifest', $manifest);
                }
                if ((count($vendor_list)>0)) {
                    $mf->whereIn('id_vendor', $vendor_list);
                } elseif((count($vendor_list)==0) AND $request->vendor_select != null){
                    $mf->whereIn('id_vendor',[$request->vendor_select]);
                }

             $data = $mf->get();

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
       
            if(@$data->vendors->user->status_user == "A")
            {
                $s = " <i title='Pengguna Aktif' class='fas fa-check-circle text-success'></i> ";
            } else{
                $s="<i title='Pengguna Non-aktif' class='fas fa-exclamation-circle text-warning'></i> ";
            }
            
               return empty($data->vendors->user) ? "-":$data->vendors->user->username." ".$s;
            })

            ->addColumn('download_check', function ($data) {
                 return '<input type="checkbox" data-filenm="'.$data->file_nm.'"  class="checked" id="'.$data->manifest.'" onclick="selectedDwn(\'#'.$data->manifest.'\')"  name="downloadchk[]" value="'.$data->manifest.'">';
            })
            ->addColumn('mail_stat', function ($data) {
             if((!empty($data->sent) || ($data->sent != '0000-00-00 00:00:00')) AND isset($data->sent))
               {
                return "<small><i class='fas fa-check-circle' style='color: green;'></i></small>";
               } 
                 return "<small><i class='fas fa-exclamation-circle' style='color: red;'></i></small>";
            
            }) 
            ->addColumn('downloaded', function ($data) {
              if((!empty($data->downloaded) || ($data->downloaded != '0000-00-00 00:00:00')) AND isset($data->downloaded))
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
            ->rawColumns(['download_check','vendor_email','mail_stat','downloaded','file_stat','active'])
            ->make(true);
    }
}
