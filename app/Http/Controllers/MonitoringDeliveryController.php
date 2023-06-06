<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManifestHeader;
use App\Models\Vendor;
use App\Models\ManifestDetail;

class MonitoringDeliveryController extends Controller
{
    public function index()
    {
        $vendor = Vendor::all();
        return view('monitoring_delivery/index')->with(['list_vendor' => $vendor]);
    }
    
    public function detail_material($manifest = null)
    {
        return view('monitoring_delivery/detail_material')->with(['manifest' => $manifest]);
    }

    public function detail_kanban($manifest = null)
    {
        return view('monitoring_delivery/detail_kanban')->with(['manifest' => $manifest]);
    }

    public function getDelivery(Request $request)
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
                $data = $mf->get();
            }else{
           

             $mf =   ManifestHeader::where('id_vendor', auth()->user()->foreign_id);

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
                $data = $mf->get();
            }else{

                $mf =  ManifestHeader::where('mf_type','like','%');

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
          
            ->editColumn('manifest', function ($data) {
                
               return  $data->manifest;
            })
            ->editColumn('delivery_date', function ($data) {
                
                return  date('Y-m-d',strtotime($data->delivery_date));
            })
            ->editColumn('po_num', function ($data) {
                
                return  $data->po_num;
            })
            ->editColumn('id_vendor', function ($data) {
                
                return $data->id_vendor;
            })
            ->addColumn('in_kanban', function ($data) {
                
                return ManifestDetail::where('manifest', $data->manifest)->where('scan_date','<>','0000-00-00')->groupBy('manifest')->count('scan_date');
            })
            ->addColumn('recieved_kanban', function ($data) {
                
                return ManifestDetail::where('manifest', $data->manifest)->where('issued_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
            })
            ->editColumn('sent', function ($data) {
                
                return $data->sent;
            }) ->editColumn('downloaded', function ($data) {
                
                return $data->downloaded;
            }) ->editColumn('scan_stat', function ($data) {

                if($data->stat == "P")
                {
                     if ($data->manifestDetails->sum('qty_pack') == $data->manifestDetails->sum('qty_in')) {
                        $scan_stat = "<small><span class=\"badge bg-success\">Done</span></small>";
                    } else {
                        $scan_stat = "<small><span class=\"badge bg-primary\">On Progress</span></small>";
                    }
                } elseif($data->stat == "H")
                {

                 $scan_stat = "<small><span class=\"badge bg-danger\">Outstanding</span></small>";

                }elseif ($data->stat  == "D"){
                    $scan_stat = "<small><span class=\"badge bg-success\">Done</span></small>";
                } else {
                    $scan_stat = "<small><span class=\"badge bg-warning text-dark\">Waiting</span></small>";
                }
                return $scan_stat;
            })
            ->editColumn('active', function ($data) {
                
                return $data->active;
            })
            ->editColumn('nm_vendor', function ($data) {
                
                return @$data->vendors->nm_vendor;
            })
            ->editColumn('material', function ($data) {
                $md = $data->manifestDetails()->first();
                return @$md->material;
            })
            ->editColumn('material_desc', function ($data) {
                
                return @$data->manifestDetails()->first()->material_desc;
            })
            ->editColumn('qty_tot', function ($data) {
                
                return $data->manifestDetails->sum('qty_pack');
            })
            ->editColumn('receive_stat', function ($data) {
                $kanban_in = ManifestDetail::where('manifest', $data->manifest)->where('issued_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
                $tot_kanban = $data->manifestDetails->count('kanban');
                  if ($tot_kanban == $kanban_in) {
                        $receive_stat = "<small><span class=\"badge bg-success\">" . $kanban_in . "/" . $tot_kanban . "</span></small>";
                    } else {
                        $receive_stat = "<small><span class=\"badge bg-warning text-dark\">" . $kanban_in . "/" . $tot_kanban . "</span></small>";
                    }
                return $receive_stat;
            })
            ->editColumn('kanban_stat', function ($data) {
                $kanban_received = ManifestDetail::where('manifest', $data->manifest)->where('issued_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
                 $tot_kanban = $data->manifestDetails->count('kanban');
                 if(!empty($data->qty_scan_outstanding)){
                  if ($data->manifestDetails->count('kanban') == $kanban_received) {
                        $receive_stat = "<small><span class=\"badge bg-success\">" . $kanban_received . "/" . $tot_kanban . "</span></small>";
                    } else {
                        $receive_stat = "<small><span class=\"badge bg-warning text-dark\">" . $kanban_received . "/" . $tot_kanban . "</span></small>";
                    }
                } else{
                      $receive_stat = "<small><span class=\"badge bg-warning text-dark\">" . 0 . "/" . $tot_kanban . "</span></small>";
                }
                return $receive_stat;
            })
            ->editColumn('active_stat', function ($data) {
               if ($data->active == 'O') {
                     $active_stat = "<small><span class=\"badge bg-warning text-dark\">Open</span></small>";
                } else {
                    $active_stat = "<small><span class=\"badge bg-success\">Closed</span></small>";
                }
                return $active_stat;
            })
            ->editColumn('tot_qty_in', function ($data) {
                
                return $data->manifestDetails->sum('qty_in');
            })
            ->editColumn('tot_kanban', function ($data) {
                
                return $data->manifestDetails->count('kanban');
            })
            ->editColumn('button', function ($data) {
                
                return view('monitoring_delivery/buttons')->with(['data' => $data]);
            })
            ->rawColumns(['scan_stat','kanban_stat','active_stat','kanban_stat','receive_stat','button'])
            ->make(true);
    }

    public function getMaterialDetail(Request $request)
    {
       
        $data = ManifestDetail::where('manifest',$request->manifest)->orderBy('delivery_date','DESC')->get();
      
       return \DataTables::of($data)
          
            
            ->editColumn('manifest', function ($data) {
                
               return  $data->manifest;
            })
            ->editColumn('delivery_date', function ($data) {
                
                return  date('Y-m-d',strtotime($data->manifestHeaders->delivery_date));
            })
            ->editColumn('po_num', function ($data) {
                
                return  $data->manifestHeaders->po_num;
            })
            ->editColumn('item', function ($data) {
                
                return  $data->item;
            })
            ->editColumn('id_vendor', function ($data) {
                
                return $data->manifestHeaders->id_vendor;
            })
            ->editColumn('nm_vendor', function ($data) {
                
                return @$data->manifestHeaders->vendors->nm_vendor;
            })
            ->editColumn('material', function ($data) {
                
                return @$data->material;
            })
            ->editColumn('material_desc', function ($data) {
                
                return @$data->material_desc;
            })

            ->editColumn('qty', function ($data){
                // $mf = ManifestHeader::where('manifest', $data->manifest)->first();
                $tot_qty = $data->qty_pack;
                $qty_in =  $data->qty_in;
                if ($tot_qty == $qty_in) {
                    $qty_stat = "<small><span class=\"badge bg-green\">" . $qty_in . "/" . $tot_qty . "</span></small>";
                } else {
                    $qty_stat = "<small><span class=\"badge bg-orange\">" . $qty_in . "/" . $tot_qty . "</span></small>";
                }

                return $qty_stat;
            })
            ->editColumn('scan_stat', function ($data) {

                if($data->stat == "P")
                {
                    $stat = ManifestDetail::where('manifest', $data->manifest);
                     if ($stat->sum('qty_pack') == $stat->sum('qty_in')) {
                        $scan_stat = "<small><span class=\"badge bg-success\">Done</span></small>";
                    } else {
                        $scan_stat = "<small><span class=\"badge bg-primary\">On Progress</span></small>";
                    }
                } elseif($data->stat == "H")
                {

                 $scan_stat = "<small><span class=\"badge bg-danger\">Outstanding</span></small>";

                }elseif ($data->stat  == "D"){
                    $scan_stat = "<small><span class=\"badge bg-success\">Done</span></small>";
                } else {
                    $scan_stat = "<small><span class=\"badge bg-warning text-dark\">Waiting</span></small>";
                }
                return $scan_stat;
            })
             ->editColumn('receive_stat', function ($data) {
                $rec_kanban = ManifestDetail::where('manifest', $data->manifest)->where('issued_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
                $tot_kanban = ManifestDetail::where('manifest',$data->manifest)->count('kanban');
                if ($rec_kanban >= 1) {
                    $kanban_received = $rec_kanban;
                } else {
                    $kanban_received = "0";
                }
                  if ($tot_kanban == $kanban_received) {
                        $receive_stat = "<small><span class=\"badge bg-green\">" . $kanban_received . "/" . $tot_kanban . "</span></small>";
                    } else {
                        $receive_stat = "<small><span class=\"badge bg-warning text-dark\">" . $kanban_received . "/" . $tot_kanban . "</span></small>";
                    }
                return $receive_stat;
            })
            ->editColumn('kanban_stat', function ($data) {
                $k_in = ManifestDetail::where('manifest', $data->manifest)->where('scan_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
                 $tot_kanban = ManifestDetail::where('manifest',$data->manifest)->count('kanban');
                if ($k_in >= 1) {
                    $kanban_in = $k_in;
                } else {
                    $kanban_in = "0";
                }
                  if ($tot_kanban == $kanban_in) {
                        $receive_stat = "<small><span class=\"badge bg-green\">" . $kanban_in . "/" . $tot_kanban . "</span></small>";
                    } else {
                        $receive_stat = "<small><span class=\"badge bg-warning text-dark\">" . $kanban_in . "/" . $tot_kanban . "</span></small>";
                    }
                return $receive_stat;
            })

            ->addColumn('recieved_kanban', function ($data) {
                
                return ManifestDetail::where('manifest', $data->manifest)->where('issued_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
            })
            ->addColumn('uom', function ($data) {
                
                return "PCE";
            })
            ->addColumn('qty', function ($data) {
                
                // return ManifestDetail::where('manifest', $data->manifest)->sum('qty_pack');
               return $data->qty_pack;;
            })
            ->rawColumns(['scan_stat','kanban_stat','qty','active_stat','kanban_stat','receive_stat'])
            ->make(true);
    }

    public function getKanbanDetail(Request $request)
    {
       
        $data = ManifestDetail::where('manifest',$request->manifest)->orderBy('delivery_date','DESC')->get();
      
       return \DataTables::of($data)
          
            
            ->editColumn('kanban', function ($data) {
                
               return  $data->kanban;
            })
            ->editColumn('arrival_date_time', function ($data) {
                
                return  date('Y-m-d H:i:s',strtotime($data->arrival_date));
            })
            ->editColumn('material', function ($data) {
                
                return @$data->material;
            })
            ->editColumn('material_desc', function ($data) {
                
                return @$data->material_desc;
            })
            ->editColumn('scan_stat', function ($data) {

                if($data->stat == "P")
                {
                    $stat = ManifestDetail::where('manifest', $data->manifest);
                     if ($stat->sum('qty_pack') == $stat->sum('qty_in')) {
                        $scan_stat = "<small><span class=\"badge bg-success\">Done</span></small>";
                    } else {
                        $scan_stat = "<small><span class=\"badge bg-primary\">On Progress</span></small>";
                    }
                } elseif($data->stat == "H")
                {

                 $scan_stat = "<small><span class=\"badge bg-danger\">Outstanding</span></small>";

                }elseif ($data->stat  == "D"){
                    $scan_stat = "<small><span class=\"badge bg-success\">Done</span></small>";
                } else {
                    $scan_stat = "<small><span class=\"badge bg-warning text-dark\">Waiting</span></small>";
                }
                return $scan_stat;
            })
            ->editColumn('receive_stat', function ($data) {
                $rec_kanban = ManifestDetail::where('manifest', $data->manifest)->where('issued_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
                $tot_kanban = ManifestDetail::where('manifest',$data->manifest)->count('kanban');
                if ($rec_kanban >= 1) {
                    $kanban_received = $rec_kanban;
                } else {
                    $kanban_received = "0";
                }
                  if ($tot_kanban == $kanban_received) {
                          $receive_stat = "<small><span class=\"badge bg-success\">Done</span></small>";
                    } else {
                         $receive_stat = "<small><span class=\"badge bg-warning text-dark\">Waiting</span></small>";
                    }
                return $receive_stat;
            })
            ->editColumn('kanban_stat', function ($data) {
                $k_in = ManifestDetail::where('manifest', $data->manifest)->where('scan_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
                 $tot_kanban = ManifestDetail::where('manifest',$data->manifest)->count('kanban');
                if(!empty($data->qty_scan_outstanding)){
                    if ($k_in >= 1) {
                        $kanban_in = $k_in;
                    } else {
                        $kanban_in = "0";
                    }
                      if ($tot_kanban == $kanban_in) {
                            $receive_stat = "<small><span class=\"badge bg-green\">" . $kanban_in . "/" . $tot_kanban . "</span></small>";
                        } else {
                            $receive_stat = "<small><span class=\"badge bg-warning text-dark\">" . $kanban_in . "/" . $tot_kanban . "</span></small>";
                        }
                } else{
                    $receive_stat = "<small><span class=\"badge bg-warning text-dark\">" . 0 . "/" . $tot_kanban . "</span></small>";
                }
                return $receive_stat;
            })
             ->editColumn('active_stat', function ($data) {
               if ($data->active == 'O') {
                     $active_stat = "<small><span class=\"badge bg-warning text-dark\">Open</span></small>";
                } else {
                    $active_stat = "<small><span class=\"badge bg-success\">Closed</span></small>";
                }
                return $active_stat;
            })

            ->addColumn('recieved_kanban', function ($data) {
                
                return ManifestDetail::where('manifest', $data->manifest)->where('issued_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
            })
            ->addColumn('uom', function ($data) {
                
                return "PCE";
            })
            ->addColumn('qty', function ($data) {
                
                // return ManifestDetail::where('manifest', $data->manifest)->sum('qty_pack');
                return $data->qty_pack;
            })
            ->rawColumns(['scan_stat','kanban_stat','active_stat','kanban_stat','receive_stat'])
            ->make(true);
    }
    
}
