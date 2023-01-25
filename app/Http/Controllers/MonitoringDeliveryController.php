<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManifestHeader;
use App\Models\ManifestDetail;

class MonitoringDeliveryController extends Controller
{
    public function index()
    {
        return view('monitoring_delivery/index');
    }
    
    public function detail_material($manifest)
    {
        return view('monitoring_delivery/detail_material')->with(['manifest' => $manifest]);
    }

    public function detail_kanban($manifest)
    {
        return view('monitoring_delivery/detail_kanban')->with(['manifest' => $manifest]);
    }

    public function getDelivery(Request $request)
    {
       if(auth()->user()->role == 'vendor')
       {
             $data = ManifestHeader::where('id_vendor', auth()->user()->foreign_id)->orderBy('delivery_date','DESC')->get();
       } else {
            $data = ManifestHeader::orderBy('delivery_date','DESC')->get();
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
                        $scan_stat = "<small><h4><span class=\"badge bg-green\">Done</span></h4></small>";
                    } else {
                        $scan_stat = "<small><h4><span class=\"badge bg-blue\">On Progress</span></h4></small>";
                    }
                } elseif($data->stat == "H")
                {

                 $scan_stat = "<small><h4><span class=\"badge bg-red\">Outstanding</span></h4></small>";

                }elseif ($data->stat  == "D"){
                    $scan_stat = "<small><h4><span class=\"badge bg-green\">Done</span></h4></small>";
                } else {
                    $scan_stat = "<small><h4><span class=\"badge bg-orange\">Waiting</span></h4></small>";
                }
                return $scan_stat;
            })
            ->editColumn('active', function ($data) {
                
                return $data->active;
            })
            ->editColumn('nm_vendor', function ($data) {
                
                return $data->vendors->nm_vendor;
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
                        $receive_stat = "<small><h4><span class=\"badge bg-green\">" . $kanban_in . "/" . $tot_kanban . "</span></h4></small>";
                    } else {
                        $receive_stat = "<small><h4><span class=\"badge bg-orange\">" . $kanban_in . "/" . $tot_kanban . "</span></h4></small>";
                    }
                return $receive_stat;
            })
            ->editColumn('kanban_stat', function ($data) {
                $kanban_received = ManifestDetail::where('manifest', $data->manifest)->where('issued_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
                 $tot_kanban = $data->manifestDetails->count('kanban');
                  if ($data->manifestDetails->count('kanban') == $kanban_received) {
                        $receive_stat = "<small><h4><span class=\"badge bg-green\">" . $kanban_received . "/" . $tot_kanban . "</span></h4></small>";
                    } else {
                        $receive_stat = "<small><h4><span class=\"badge bg-orange\">" . $kanban_received . "/" . $tot_kanban . "</span></h4></small>";
                    }
                return $receive_stat;
            })
            ->editColumn('active_stat', function ($data) {
               if ($data->active == 'O') {
                     $active_stat = "<small><h4><span class=\"badge bg-orange\">Open</span></h4></small>";
                } else {
                    $active_stat = "<small><h4><span class=\"badge bg-green\">Closed</span></h4></small>";
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
                
                return $data->manifestHeaders->vendors->nm_vendor;
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
                        $scan_stat = "<small><h4><span class=\"badge bg-green\">Done</span></h4></small>";
                    } else {
                        $scan_stat = "<small><h4><span class=\"badge bg-blue\">On Progress</span></h4></small>";
                    }
                } elseif($data->stat == "H")
                {

                 $scan_stat = "<small><h4><span class=\"badge bg-red\">Outstanding</span></h4></small>";

                }elseif ($data->stat  == "D"){
                    $scan_stat = "<small><h4><span class=\"badge bg-green\">Done</span></h4></small>";
                } else {
                    $scan_stat = "<small><h4><span class=\"badge bg-orange\">Waiting</span></h4></small>";
                }
                return $scan_stat;
            })
             ->editColumn('receive_stat', function ($data) {
                $kanban_in = ManifestDetail::where('manifest', $data->manifest)->where('issued_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
                $tot_kanban = ManifestDetail::where('manifest',$data->manifest)->count('kanban');
                  if ($tot_kanban == $kanban_in) {
                        $receive_stat = "<small><h4><span class=\"badge bg-green\">" . $kanban_in . "/" . $tot_kanban . "</span></h4></small>";
                    } else {
                        $receive_stat = "<small><h4><span class=\"badge bg-orange\">" . $kanban_in . "/" . $tot_kanban . "</span></h4></small>";
                    }
                return $receive_stat;
            })
            ->editColumn('kanban_stat', function ($data) {
                $kanban_received = ManifestDetail::where('manifest', $data->manifest)->where('issued_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
                 $tot_kanban = ManifestDetail::where('manifest',$data->manifest)->count('kanban');
                  if ($data->count('kanban') == $kanban_received) {
                        $receive_stat = "<small><h4><span class=\"badge bg-green\">" . $kanban_received . "/" . $tot_kanban . "</span></h4></small>";
                    } else {
                        $receive_stat = "<small><h4><span class=\"badge bg-orange\">" . $kanban_received . "/" . $tot_kanban . "</span></h4></small>";
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
            ->rawColumns(['scan_stat','kanban_stat','active_stat','kanban_stat','receive_stat'])
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
                        $scan_stat = "<small><h4><span class=\"badge bg-green\">Done</span></h4></small>";
                    } else {
                        $scan_stat = "<small><h4><span class=\"badge bg-blue\">On Progress</span></h4></small>";
                    }
                } elseif($data->stat == "H")
                {

                 $scan_stat = "<small><h4><span class=\"badge bg-red\">Outstanding</span></h4></small>";

                }elseif ($data->stat  == "D"){
                    $scan_stat = "<small><h4><span class=\"badge bg-green\">Done</span></h4></small>";
                } else {
                    $scan_stat = "<small><h4><span class=\"badge bg-orange\">Waiting</span></h4></small>";
                }
                return $scan_stat;
            })
             ->editColumn('receive_stat', function ($data) {
                $kanban_in = ManifestDetail::where('manifest', $data->manifest)->where('issued_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
                $tot_kanban = ManifestDetail::where('manifest',$data->manifest)->count('kanban');
                  if ($tot_kanban == $kanban_in) {
                        $receive_stat = "<small><h4><span class=\"badge bg-green\">" . $kanban_in . "/" . $tot_kanban . "</span></h4></small>";
                    } else {
                        $receive_stat = "<small><h4><span class=\"badge bg-orange\">" . $kanban_in . "/" . $tot_kanban . "</span></h4></small>";
                    }
                return $receive_stat;
            })
            ->editColumn('kanban_stat', function ($data) {
                $kanban_received = ManifestDetail::where('manifest', $data->manifest)->where('issued_date','<>','0000-00-00')->groupBy('manifest')->count('issued_date');
                 $tot_kanban = ManifestDetail::where('manifest',$data->manifest)->count('kanban');
                  if ($data->count('kanban') == $kanban_received) {
                        $receive_stat = "<small><h4><span class=\"badge bg-green\">" . $kanban_received . "/" . $tot_kanban . "</span></h4></small>";
                    } else {
                        $receive_stat = "<small><h4><span class=\"badge bg-orange\">" . $kanban_received . "/" . $tot_kanban . "</span></h4></small>";
                    }
                return $receive_stat;
            })
             ->editColumn('active_stat', function ($data) {
               if ($data->active == 'O') {
                     $active_stat = "<small><h4><span class=\"badge bg-orange\">Open</span></h4></small>";
                } else {
                    $active_stat = "<small><h4><span class=\"badge bg-green\">Closed</span></h4></small>";
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
