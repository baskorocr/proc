@extends('layouts.main')
@section('title',"Dashboard ISO")
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css"/>
<style type="text/css">
    div.table-responsive > div.dataTables_wrapper > div.row
        {
            overflow:auto !important;
        }
        div.dataTables_wrapper div.dt-row{
    min-height:300px;
}
</style>
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard ISO Document</h1>
      <nav>
        <ol class="breadcrumb">
          {{-- <li class="breadcrumb-item"><a href="index.html">DOC ISO</a></li> --}}
          <li class="breadcrumb-item active">Dashboard ISO</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        <div class="col-md-3">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $regis->where('stat', 'V')->count() }}</h3>
              <p>Valid Document</p>
            </div>
            <div class="icon">
              <i class="far fa-file"></i>
            </div>
            <a href="{{route('detail-iso-dashboard',['stat' => 'V'])}}" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>


        </div> 


        <div class="col-md-3">
          <div class="small-box bg-orange">
            <div class="inner">
              <h3>{{ $regis->where('stat', 'N')->count() }}</h3>
              <p>Renewed Document</p>
            </div>
            <div class="icon">
              <i class="far fa-file"></i>
            </div>
            <a href="{{route('detail-iso-dashboard',['stat' => 'N'])}}" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-md-3">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $regis->where('stat', 'E')->count() }}</h3>
              <p>Expired Document</p>
            </div>
            <div class="icon">
              <i class="far fa-file"></i>
            </div>
            <a href="{{route('detail-iso-dashboard',['stat' => 'E'])}}" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
          </div>

          <div class="col-md-3">
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>{{ $regis->count() }}</h3>
              <p>Total Document</p>
            </div>
            <div class="icon">
              <i class="far fa-file"></i>
            </div>
            <a href="#" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
          </div>


        </div>
      </div>
      {{-- <div class="row">
      <div class="flex-parent jc-center">
          <div style="float:left"; >
            <table>
                <tr>
                    <th id="table" >
                    <div style="background-color:#5cb85c;  height:150px" class="card info-card revenue-card">
                      <div class="card-body">
                        <h5 style="color:white" class="card-title">Valid Document</h5>
                          <div class="ps-3"><i style="position: absolute;top: auto;bottom: 5px;right: 5px;z-index: 0;font-size: 90px;color: rgba(0, 0, 0, 0.15);" class="far fa-file"></i>
                            <h6 style="color:white">{{ $regis->where('stat', 'V')->count() }}</h6>
                          </div>
                           <a href="{{route('detail-iso-dashboard',['stat' => 'V'])}}" style="color:white; ">More Info <i class="fas fa-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                    </th>
                </tr>
            </table>
            </div>
            <div style="float:left; margin-left:10px;" >
            <table>
            <tr> 
              <th id="table" >
                  <div style="background-color:Orange;  height:150px"  class="card info-card sales-card">
                    <div class="card-body">
                      <h5 style ="color:white"class="card-title">Renewed Document</h5>
                      <div class="d-flex align-items-center">
                        <div class="ps-3"><i style="position: absolute;top: auto;bottom: 5px;right: 5px;z-index: 0;font-size: 90px;color: rgba(0, 0, 0, 0.15);" class="far fa-file"></i>
                        <h6 style="color:white">{{ $regis->where('stat', 'N')->count() }}</h6>

                        </div>

                      </div>
                 
                       <a href="{{route('detail-iso-dashboard',['stat' => 'N'])}}" style="color:white; ">More Info <i class="fas fa-arrow-right"></i></a>
                    </div>
                  </div>
              </th>
            </tr>
            </table>
            </div>
            <div style="float:left; margin-left:10px" >
            <table>
            <tr> 
              <th id="table" >
                    <div style="background-color:Salmon;  height:150px"class="card info-card revenue-card">
                      <div class="card-body">
                        <h5 style="color:white"class="card-title">Expired Document</h5>
                          <div class="ps-3"><i style="position: absolute;top: auto;bottom: 5px;right: 5px;z-index: 0;font-size: 90px;color: rgba(0, 0, 0, 0.15);" class="far fa-file"></i>
                          <h6 style="color:white">{{ $regis->where('stat', 'E')->count() }}</h6>
                          </div>
                           <a href="{{route('detail-iso-dashboard',['stat' => 'E'])}}" style="color:white; ">More Info <i class="fas fa-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
               </th>
            </tr>
            </table>
            </div>
            <div style="float:left; margin-left:10px" >
            <table>
            <tr> 
               <th id="table" >
                  <div style="background-color:MediumBlue;  height:150px "class="card info-card sales-card">
                      <div class="card-body">
                        <h5 style="color:white" class="card-title">Total Document</h5>
                        <div class="d-flex align-items-center">
                          <div class="ps-3"><i style="position: absolute;top: auto;bottom: 5px;right: 5px;z-index: 0;font-size: 90px;color: rgba(0, 0, 0, 0.15);" class="far fa-file"></i>
                          <h6 style="color:white">{{ $regis->count() }}</h6>
                          </div>
                          
                        </div>
                         <a href="#" style="color:white; ">More Info <i class="fas fa-arrow-right"></i></a>
                      </div>
                    </div>
                </th>
            </tr>
            </table>
            </div> --}}
          {{-- </div> --}}
        <div class="table-responsive">
       <table id="iso"  class="table table-striped table-bordered"   style="width:1260px">
                  <thead>
                    <tr>
                    {{-- <th style="min-width: 100px;">Action</th> --}}
                        <th style="min-width: 70px; max-width: 70px;">Vendor Code</th>
                        <th style="min-width: 200px;">Vendor Name</th>
                        <th style="min-width: 100px;">Material Supply</th>
                        <th style="min-width: 30px;">Simplikasi</th>
                        <th style="max-width: 80px;">ISO Cert Num</th>
                        <th style="max-width: 80px;" >Expire Date</th>
                        <th style="max-width: 80px;" >Expired Status</th>
                        <th style="max-width: 100px;" >Doc Process</th>
                        <th style="min-width: 10000px;" >ISO Cert Date</th>
                        <th style="min-width: 100px;" >Certified</th>
                        <th style="min-width: 100px;" >ISO Type</th>
                        <th style="min-width: 30px;" >File</th>
                        <th style="min-width: 100px;" >Last change</th>
                        <th style="min-width: 100px;" >Entry Date</th>
                        <th style="min-width: 100px;" >Remark</th>
                        {{-- <th style="min-width: 100px;" >Doc Number</th>
                        <th style="min-width: 100px;" >Ref Number</th> --}}
                    </tr>
                  </thead>   
                  <tbody>
                    @foreach($regis as $item)
                    <?php 
                 
                    $date_full = $item->exp_date;

                    ?>
                      <tr>
                    {{--   <td>
                         <div class="dropdown">
                            <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Choose
                            </a>

  


 
                            <ul class="dropdown-menu">
                              <li> <a href="{{route('doc-iso.view',['id' => $item->_id])}}" class="dropdown-item"><i class='fas fa-eye'></i> View</a></li>
                              <li><a href="{{route('doc-iso.renew',['id' => $item->_id])}}" class="dropdown-item"> <i class='fas fa-copy'></i> Renew</a></li>
                              <li> <a href="{{route('doc-iso.change',['id' => $item->_id])}}" class="dropdown-item"> <i class='fas fa-edit'></i> Change</a></li>
                              <li> <a href="{{route('approve-iso',['id' => $item->id])}}" class="dropdown-item"> <i class='fas fa-check'></i> Approval</a></li>
                              <li><a href='{{route('delete-iso',['id' => $item->_id,'trn_id' => $item->trn_id,'doc_year' => $item->doc_year])}}' class="dropdown-item" data-toggle='tooltip' onclick="return confirm('All reference data will be deleted. \n Are you sure want to delete this data [{{$item->trn_id}}]?')"> <i class='fas fa-trash'></i> Delete</a></li>
                            </ul>
                          </div>
                          </td>  --}}
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
                        <td>{{date('d-m-Y', strtotime($date_full))}}</td>
                        {{-- <td>{!! strtotime($date_full) < strtotime(date('Y-m-d')) ? '<span class="badge bg-danger">Expired</span>' : '<span class="badge bg-success">Valid</span>' !!}</td> --}}
                        <td><span class="badge bg-{{@$item->transaction->color}}">{{@$item->transaction->trn_name}}</span></td>
                        <td>{!!$doc_proccess!!} </td>
                        <td>{{ date('d-m-Y', strtotime($item->cert_date)) }}</td>
                        <td>{{ $item->cert_name}}</td>
                        <td>{{$item->iso_type_name}}</td>
                        <td><a href="{{asset('files/regis_iso/'.$item->doc_path)}}" class="btn btn-flat text-primary" target="_blank" data-toggle='tooltip' title='click to preview' >
                                <i class="fa fa-file"></i>
                            </a></td>
                        
                        
           <td>{{date('Y-m-d H:i:s',strtotime(!empty($item->updated_at)?$item->updated_at:$item->ch_date))}}</td>
          <td>{{date('Y-m-d H:i:s',strtotime(!empty($item->created_at)?$item->created_at:$item->cr_date))}}</td>
                        <td>{{$item->remark}}</td>
                        {{-- <td>{{$item->trn_id}} - {{$item->doc_year}}</td>
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

                        ?>    --}}
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
  var table = $('#iso').DataTable({
     
      responsive: true,
     
      rowReorder:{dataSrc: 0, snapX: true, enable: true},
       columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 1, targets: 2 },
            { responsivePriority: 1, targets: 3 },
            { responsivePriority: 1, targets: 4 },
            { responsivePriority: 1, targets: 5 },
            { responsivePriority: 1, targets: 6 },
            { responsivePriority: 1, targets: 7 },
        ]
      
   
  })
var originaldocumentwidth = $(document).width();
var newdocumentwidth = $(document).width();
var zoomratio = originaldocumentwidth / newdocumentwidth;

function updateZoom() {
    newdocumentwidth = $(document).width();
    zoomratio = originaldocumentwidth / newdocumentwidth;
    
    // $('#originaldocumentwidth').html(originaldocumentwidth);
    $('#iso').css("width", newdocumentwidth-150+'px');
    console.log(zoomratio);
}
$(window).resize(function() {
    updateZoom();
});
updateZoom();

</script>
@endsection

