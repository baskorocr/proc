@extends('layouts.main')
@section('title',"Detail Kanban ".$manifest)
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Detail Kanban <br> <small class="text-muted">{{$manifest}}</small></h1>
        <nav>
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
                {{-- <li class="breadcrumb-item"><a href="{{route('monitoring.delivery')}}">Monitoring Delivery</a></li> --}}
                <li class="breadcrumb-item active">Detail Kanban</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table  class="table table-bordered table-striped table-sm" id="detail-kanban">
                                    <thead>
                                        <th>Kanban</th>
                                        <th>Arrival Date & Time</th>
                                        <th>Material</th>
                                        <th>Material Descr.</th>
                                        <th>UoM</th>
                                        <th>Qty</th>
                                        <th>Scan Stat</th>
                                        <th>GR Stat</th>
                                        <th>Kanban Stat</th>
                                        
                                    </thead>
                                    <tbody>
            <?php
             $data = \App\Models\ManifestDetail::where('manifest',$manifest)->orderBy('delivery_date','DESC')->get();
             ?>
             @foreach($data as $data)
             <?php
             if(!empty($data->arrival_date))
                {
                    $arrival_date =   date('D, d.m.Y',strtotime($data->arrival_date))." ". date('H:i',strtotime($data->arrival_time));
                } else {
                    $arrival_date="-";
                }

                 if($data->arrival_date != null){
                    $scan_stat = "<small><span class=\"badge bg-success\">Done</span></small>";
                 } else {
                    $scan_stat = "<small><span class=\"badge bg-warning text-dark\">Waiting</span></small>";
                 }

                if (!empty($data->issued_date)) {
                      $receive_stat = "<small><span class=\"badge bg-success\">Done</span></small>";
                } else {
                     $receive_stat = "<small><span class=\"badge bg-warning text-dark\">Waiting</span></small>";
                }

                //  $k_in = \App\Models\ManifestDetail::where('manifest', $data->manifest)->whereNotNull('scan_date')->groupBy('manifest')->count('scan_date');
                //  $tot_kanban = \App\Models\ManifestDetail::where('manifest',$data->manifest)->count('kanban');
                // if(!empty($data->qty_scan_outstanding)){
                //     if ($k_in >= 1) {
                //         $kanban_in = $k_in;
                //     } else {
                //         $kanban_in = "0";
                //     }
                //       if ($tot_kanban == $kanban_in) {
                //             $kanban_stat = "<small><span class=\"badge bg-green\">" . $kanban_in . "/" . $tot_kanban . "</span></small>";
                //         } else {
                //             $kanban_stat = "<small><span class=\"badge bg-warning text-dark\">" . $kanban_in . "/" . $tot_kanban . "</span></small>";
                //         }
                // } else{
                //     $kanban_stat = "<small><span class=\"badge bg-warning text-dark\">" . 0 . "/" . $tot_kanban . "</span></small>";
                // }

                 if ($data->active == 'A') {
                     $active_stat = "<small><span class=\"badge bg-warning text-dark\">Open</span></small>";
                } else {
                    $active_stat = "<small><span class=\"badge bg-success\">Closed</span></small>";
                }
             ?>

                                         <tr>
                                            <td>{{$data->kanban}}</td>
                                            <td>{{ $arrival_date }}</td>
                                            <td>{{@$data->material}}</td>
                                            <td>{{@$data->material_desc}}</td>
                                            <td>{{"PCE"}}</td>
                                            <td>{{$data->qty_pack}}</td>
                                            <td>{!!$scan_stat!!}</td>
                                            <td>{!!$receive_stat!!}</td>
                                            <td>{!!$active_stat!!}</td>
                                        </tr>

            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        @endsection
        @section('javascript')
        <script>
        $('#detail-kanban').DataTable({ "order": [[ 0, "ASC" ]],});
        
        </script>
        @endsection