@extends('layouts.main')
@section('title',"Dashboard ISO Document (".$stat_type.")")
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css"/>
<style type="text/css">
div.table-responsive > div.dataTables_wrapper > div.row
{
    overflow:auto !important;
}
div.dataTables_wrapper div.dt-row{
    min-height:70vh;
}
</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard ISO Report ({{$stat_type}})</h1>
        <nav>
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="index.html">DOC ISO</a></li> --}}
                <li class="breadcrumb-item active">Dashboard ISO</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->
        <section class="section dashboard">
            <div class="table-responsive" style="min-height:500px">
                <table id="iso"  class="table table-striped table-bordered table-sm"   style="width:100%">
                    <thead>
                        <tr>
                            @if($stat_type == 'Valid' || $stat_type="Renewed" || $stat_type="Expired")
                            <th style="max-width: 10px;"></th>
                            <th style="max-width: 30px;">Action</th>
                            @endif
                            <th style="max-width: 70px;">Vendor Code</th>
                            <th style="max-width: 160px;">Vendor Name</th>
                            <th style="max-width: 80px;">Material Supply</th>
                            <th style="max-width: 30px;">Simplikasi</th>
                            <th style="max-width: 80px;">ISO Cert Num</th>
                            <th style="max-width: 80px;" >ISO Cert Date</th>
                            <th style="max-width: 80px;" >Expire Date</th>
                            <th style="max-width: 80px;" >Expired Status</th>
                            <th style="max-width: 80px" >Doc Process</th>
                            <th style="min-width: 10000px;" >Certified</th>
                            <th style="min-width: 100px;" >ISO Type</th>
                            <th style="min-width: 30px;" >File</th>
                            <th style="min-width: 100px;" >Last change</th>
                            <th style="min-width: 100px;" >Entry Date</th>
                            <th style="min-width: 100px;" >Remark</th>
                            <th style="min-width: 100px;" >unixtime</th>
                            {{--  <th style="min-width: 100px;" >Doc Number</th>
                            <th style="min-width: 100px;" >Ref Number</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($regis as $item)
                        <?php
                        
                        $date_full = $item->exp_date;
                        ?>
                        <tr>
                            @if($stat_type == 'Valid' || $stat_type="Renewed" || $stat_type="Expired")
                            
                            <td></td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Choose
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li> <a href="{{route('doc-iso.view',['id' => $item->_id])}}" class="dropdown-item"><i class='fas fa-eye'></i> View</a></li>
                                        {{-- @dd(\IsoHelper::get_number_range_data($item->ref_doc, $item->ref_doc_year)) --}}
                                        @if((empty($item->ref_doc) AND empty($item->ref_doc_year)))
                                            <li><a href="{{route('doc-iso.renew',['id' => $item->_id])}}" class="dropdown-item"> <i class='fas fa-copy'></i> Renew</a></li>
                                        @endif
                                        @if(($item->stat != 'A' AND $item->stat != 'E') )
                                             <li> <a href="{{route('doc-iso.change',['id' => $item->_id])}}" class="dropdown-item"> <i class='fas fa-edit'></i> Change</a></li>
                                        @endif
                                        @if(auth()->user()->role != "vendor")
                                            @if(($item->stat != 'A' AND $item->stat != 'E'))
                                                <li> <a href="{{route('approve-iso',['id' => $item->id])}}" class="dropdown-item"> <i class='fas fa-check'></i> Approval</a></li>
                                                <li><a href='{{route('delete-iso',['id' => $item->_id,'trn_id' => $item->trn_id,'doc_year' => $item->doc_year])}}' class="dropdown-item" data-toggle='tooltip' onclick="return confirm('All reference data will be deleted. \n Are you sure want to delete this data [{{$item->trn_id}}]?')"> <i class='fas fa-trash'></i> Delete</a></li>
                                            @endif
                                        @endif
                                        
                                    </ul>
                          
                           {{-- <ul class="dropdown-menu">
                              <li> <a href="{{route('doc-iso.view',['id' => $item->_id])}}" class="dropdown-item"><i class='fas fa-eye'></i> View</a></li>
                              @if ($item->trn_type == 'R' OR $item->trn_type == 'I')
                              <li><a href="{{route('doc-iso.renew',['id' => $item->_id])}}" class="dropdown-item"> <i class='fas fa-copy'></i> Renew</a></li>
                              @endif
                              @if( ($item->stat != 'N' AND $item->stat != 'E' ) AND $item->trn_type != 'R' AND $item->trn_type != 'I')
                              <li> <a href="{{route('doc-iso.change',['id' => $item->_id])}}" class="dropdown-item"> <i class='fas fa-edit'></i> Change</a></li>
                              @endif
                              @if(auth()->user()->role != "vendor")
                              @if(( $item->stat != 'N' AND $item->stat != 'E') AND $item->trn_type != 'R' AND $item->trn_type != 'I' )
                              <li> <a href="{{route('approve-iso',['id' => $item->id])}}" class="dropdown-item"> <i class='fas fa-check'></i> Approval</a></li>
                              <li><a href='{{route('delete-iso',['id' => $item->_id,'trn_id' => $item->trn_id,'doc_year' => $item->doc_year])}}' class="dropdown-item" data-toggle='tooltip' onclick="return confirm('All reference data will be deleted. \n Are you sure want to delete this data [{{$item->trn_id}}]?')"> <i class='fas fa-trash'></i> Delete</a></li>
                              @endif
                              @endif
                            </ul>  --}}
                          </div>
                        </td>
                      @endif
                           <?php if ($item->simply == "X") {
                              $simplify = '<center><i class="fa fa-check"></i></center>';
                            }else{
                              $simplify = '';
                            }
                            $count = count(IsoHelper::get_transaction_type_id($item->trn_type));
                            $trans = IsoHelper::get_transaction_type_id_first($item->trn_type);
                             if ($count == 1) {
                                $color = 'badge bg-'.$trans->color;
                                $doc_proccess = '<span class="'.$color.'">'.@$trans->trn_name.'</span>';
                            } else {
                                $doc_proccess = '<span class="badge bg-primary">'.@$trans->trn_name.'</span>';
                            }

                            ?>
                        <td>{{ @$item->vendor->id_vendor }} </td>
                        <td>{{ @$item->vendor->nm_vendor }}</td>
                        <td>{{ $item->mat_supply }}</td>
                        <td>{!! $simplify !!}</td>
                        <td>{{ $item->cert_num }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->cert_date)) }}</td>
                         <td>{{date('d-m-Y', strtotime($date_full))}}</td>
                          <td><span class="badge bg-{{@$item->transaction->color}}">{{@$item->transaction->trn_name}}</span></td>
                        <td>{!!$doc_proccess!!} </td>
                        <td>{{ $item->cert_name}}</td>
                        <td>{{$item->iso_type_name}}</td>
                        <td><a href="{{asset('files/regis_iso/'.$item->doc_path)}}" class="btn btn-flat text-primary" target="_blank" data-toggle='tooltip' title='click to preview' >
                                <i class="fa fa-file"></i>
                            </a></td>
                        
                        
           <td>{{date('Y-m-d H:i:s',strtotime(!empty($item->updated_at)?$item->updated_at:$item->ch_date))}}</td>
          <td>{{date('Y-m-d H:i:s',strtotime(!empty($item->created_at)?$item->created_at:$item->cr_date))}}</td>
                        <td>{{$item->remark}}</td>
                        <td>{{strtotime($item->cert_date)}}</td>
                       {{--  <td>{{$item->trn_id}} - {{$item->doc_year}}</td>
                         <?php
                            if ( $item->ref_doc == '0000000000') {
                                echo "<td></td>";
                            }  else {
                            ?>
                                <td>
                                    <a href="{{route('doc-iso.view',['id' => $item->_id])}}" 
                                        target="_blank">
                                        <?php echo $item->ref_doc."-".$item->ref_doc_year ?>
                                    </a> 
                                </td>
                        <?php    
                            }

                        ?>   --}} 
                      </tr>
                    @endforeach
                  </tbody>    
                </table>

             </div>
             </div>
    </section>



  </main><!-- End #main -->
@endsection
@section('javascript')
<script data-require="datatables-responsive@*" data-semver="2.1.0" src="//cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
<script type="text/javascript">
  $('#iso').DataTable({
      order: [[7, 'desc']],
         "autoWidth": false,
        responsive:true,

        'columnDefs': [
            { 'orderData':[17], 'targets': [1] },
            {
                'targets': [17],
                'visible': false,
                'searchable': false
            },
        ],
      
   
  })
  var originaldocumentwidth = $(document).width();
var newdocumentwidth = $(document).width();
var zoomratio = originaldocumentwidth / newdocumentwidth;

// function updateZoom() {
//     newdocumentwidth = $(document).width();
//     zoomratio = originaldocumentwidth / newdocumentwidth;
    
//     // $('#originaldocumentwidth').html(originaldocumentwidth);
//     $('#iso').css("width", newdocumentwidth-150+'px');
//     console.log(zoomratio);
// }
// $(window).resize(function() {
//     updateZoom();
// });
</script>
@endsection