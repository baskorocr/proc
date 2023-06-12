@extends('layouts.main')
@section('title',"Detail Material ".$manifest)
@section('content')
<style type="text/css">
div.table-responsive > div.dataTables_wrapper > div.row
{
    overflow:auto !important;
}
/*div.dataTables_wrapper div.dt-row{
    min-height:50vh;
}*/
</style>
<main id="main" class="main">
    <div class="pagetitle">
       <h1>Detail Material <br> <small class="text-muted">{{$manifest}}</small></h1>
        <nav>
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
                {{-- <li class="breadcrumb-item"><a href="{{route('monitoring.delivery')}}">Monitoring Delivery</a></li> --}}
                <li class="breadcrumb-item active">Detail Material</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table  class="table table-bordered table-striped table-sm" id="detail-material">
                                    <thead>
                                        <th>Manifest</th>
                                        <th>Delivery Date</th>
                                        <th>PO Number</th>
                                        <th>Vendor</th>
                                        <th>Itm</th>
                                        <th>Material</th>
                                        <th>Material Descr.</th>
                                        <th>UoM</th>
                                        <th>Qty</th>
                                        <th>Kanban</th>
                                        <th>GR Stat</th>
                                        
                                    </thead>
                                    <tbody>
                    <?php $grouping = []; ?>
                    @foreach($detail_material as $dm)
                     @if(!in_array(@$dm->material,$grouping))
                        <?php 
                             $k_in = \App\Models\ManifestDetail::where('manifest', $dm->manifest)->where('material',$dm->material)->whereNotNull('scan_date')->count('scan_date');
                             $tot_kanban = \App\Models\ManifestDetail::where('manifest',$dm->manifest)->where('material',$dm->material)->count('kanban');
                            if ($k_in >= 1) {
                                $kanban_in = $k_in;
                            } else {
                                $kanban_in = "0";
                            }
                            if ($tot_kanban == $kanban_in) {
                                $kanban_stat = "<small><span class=\"badge bg-green\">" . $kanban_in . "/" . $tot_kanban . "</span></small>";
                            } else {
                                $kanban_stat = "<small><span class=\"badge bg-warning text-dark\">" . $kanban_in . "/" . $tot_kanban . "</span></small>";
                            }

                            $rec_kanban = \App\Models\ManifestDetail::where('manifest', $dm->manifest)->where('material',$dm->material)->whereNotNull('issued_date')->count('issued_date');
                            if ($rec_kanban >= 1) {
                                $kanban_received = $rec_kanban;
                            } else {
                                $kanban_received = "0";
                            }
                              if ($tot_kanban != $kanban_received) {
                                    $receive_stat = "<small><span class=\"badge bg-green\">" . $kanban_received . "/" . $tot_kanban . "</span></small>";
                                } else {
                                    $receive_stat = "<small><span class=\"badge bg-warning text-dark\">" . $kanban_received . "/" . $tot_kanban . "</span></small>";
                                }
                           
                                $qty_tot =  \App\Models\ManifestDetail::where('manifest', $dm->manifest)->where('material',$dm->material)->sum('qty_pack');
                                $tot_qty_in =  \App\Models\ManifestDetail::where('manifest', $dm->manifest)->where('material',$dm->material)->sum('qty_in');
                                $tot_qty = $qty_tot;
                                if ($tot_qty_in >= 1) {
                                    $qty_in = $tot_qty_in;
                                } else {
                                    $qty_in = "0";
                                }

                                if ($tot_qty == $qty_in) {
                                    $qty_stat = "<small><span class=\"badge bg-green\">" . $qty_in . "/" . $qty_tot  . "</span></small>";
                                } else {
                                    $qty_stat = "<small><span class=\"badge bg-warning text-dark\">" . $qty_in . "/" . $qty_tot  . "</span></small>";
                                }
                              
                        ?>
                                            <tr>
                                                <td>{{$dm->manifest}}</td>
                                                <td>{{date('Y-m-d',strtotime(@$dm->manifestHeaders->delivery_date))}}</td>
                                                <td>{{@$dm->manifestHeaders->po_num}}</td>
                                                <td>{{@$dm->manifestHeaders->vendors->nm_vendor}}</td>
                                                <td>{{$dm->item}}</td>
                                                <td>{{@$dm->material}}</td>
                                                <td>{{@$dm->material_desc}}</td>
                                                <td>PCE</td>
                                                <td>{!!$qty_stat!!}</td>
                                                <td>{!!$kanban_stat!!}</td>
                                                <td>{!!$receive_stat!!}</td>
                                            </tr>
                                            <?php $grouping[] = @$dm->material;?>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @endsection
    @section('javascript')
    <script>
         $('#detail-material').DataTable({order: [[4, 'asc']]});
    </script>
{{--     <script>
    $('#detail-material').DataTable({
    "order": [[ 1, "DESC" ]],
    processing: true,
    serverSide: true,
    autoWidth:false,
    "language": {
    "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
    },
    ajax: "{{ route('api.monitoring.delivery.detail.datatables',['manifest' => $manifest])}}",
    columns: [
    {
    data: 'manifest',
    name: 'manifest'
    },{
    data: 'delivery_date',
    name: 'delivery_date'
    },
    {
    data: 'po_num',
    name: 'po_num'
    },{
    data: 'nm_vendor',
    name: 'nm_vendor'
    },{
    data: 'item',
    name: 'item'
    },
    {
    data: 'material',
    name: 'material'
    },
    {
    data: 'material_desc',
    name: 'material_desc'
    },
    {
    data: 'uom',
    name: 'uom'
    },
    {
    data: 'qty',
    name: 'qty'
    },
    {
    data: 'kanban_stat',
    name: 'kanban_stat'
    },
    {
    data: 'receive_stat',
    name: 'receive_stat'
    },
    ]
    });
    
    </script> --}}
    @endsection