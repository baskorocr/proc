@extends('layouts.main')
@section('title',"Form Input Page")
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css"/>
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Document ISO Report</h1>
    <nav>
      <ol class="breadcrumb">
        {{-- <li class="breadcrumb-item"><a href="index.html">DOC ISO</a></li> --}}
        <li class="breadcrumb-item active">Report ISO</li>
      </ol>
    </nav>
  </div>


  <section class="section dashboard">
    <div class="row">
      <div class="col-md-2">
        <div class="small-box bg-blue">
          <div class="inner">
            <h3>{{ $regis->where('trn_type', 'S')->count() }}</h3>
            <p>Submitted Document</p>
          </div>
          <div class="icon">
            <i class="far fa-file"></i>
          </div>
          <a href="{{route('detail-iso-report',['stat' => 'S'])}}" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <div class="col-md-2">
        <div class="small-box bg-orange">
          <div class="inner">
            <h3>{{ $regis->where('trn_type', 'C')->count() }}</h3>
            <p>Rejected Document</p>
          </div>
          <div class="icon">
            <i class="far fa-file"></i>
          </div>
          <a href="{{route('detail-iso-report',['stat' => 'C'])}}" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <div class="col-md-2">
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{ $regis->where('trn_type', 'U')->count() }}</h3>
            <p>Updated Document</p>
          </div>
          <div class="icon">
            <i class="far fa-file"></i>
          </div>
          <a href="{{route('detail-iso-report',['stat' => 'U'])}}" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <div class="col-md-2">
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ $regis->where('trn_type', 'I')->count() }}</h3>
            <p>Approved Document</p>
          </div>
          <div class="icon">
            <i class="far fa-file"></i>
          </div>
          <a href="{{route('detail-iso-report',['stat' => 'I'])}}" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      
      <div class="col-md-2">
        <div class="small-box bg-orange">
          <div class="inner">
            <h3>{{ $regis->where('stat', 'E')->count() }}</h3>
            <p>Notified Document</p>
          </div>
          <div class="icon">
            <i class="far fa-file"></i>
          </div>
          <a href="{{route('detail-iso-dashboard',['stat' => 'E'])}}" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <div class="col-md-2">
        <div class="small-box bg-navy">
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
    {{-- <div class="row">
      <div class="flex-parent jc-center">
        <div style="float:left"; >
          <table>
            <tr>
              <th id="table" >
                <div style="background-color:MediumBlue; width:153px"  class="card info-card sales-card">
                  <div class="card-body">
                    <h5 style="color:white" class="card-title">Submitted Document </h5>
                    <div class= ax"ps-3"><i style="position: absolute;top: auto;bottom: 5px;right: 5px;z-index: 0;font-size: 90px;color: rgba(0, 0, 0, 0.15);" class="far fa-file"></i>
                      <h6 style="color:white">{{ $regis->where('trn_type', 'S')->count() }}</h6>
                    </div>
                    <a href="{{route('detail-iso-report',['stat' => 'S'])}}" style="color:white; ">More Info <i class="fas fa-arrow-right"></i></a>
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
                <div style="background-color:Salmon; width:153px"   class="card info-card sales-card">
                  <div class="card-body">
                    <h5 style ="color:white"class="card-title">Rejected Document</h5>
                    <div class="ps-3">
                      <i style="position: absolute;top: auto;bottom: 5px;right: 5px;z-index: 0;font-size: 90px;color: rgba(0, 0, 0, 0.15);" class="far fa-file"></i>
                      <h6 style="color:white">{{ $regis->where('trn_type', 'C')->count() }}</h6>
                    </div>
                    <a href="{{route('detail-iso-report',['stat' => 'C'])}}" style="color:white; ">More Info <i class="fas fa-arrow-right"></i></a>
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
                <div style="background-color:Orange; width:153px" class="card info-card revenue-card">
                  <div class="card-body">
                    <h5 style="color:white"class="card-title">Updated Document</h5>
                    <div class="ps-3">
                      <i style="position: absolute;top: auto;bottom: 5px;right: 5px;z-index: 0;font-size: 90px;color: rgba(0, 0, 0, 0.15);" class="far fa-file"></i>
                      <h6 style ="color:white">{{ $regis->where('trn_type', 'U')->count() }}</h6>
                    </div>
                    <a href="{{route('detail-iso-report',['stat' => 'U'])}}" style="color:white; ">More Info <i class="fas fa-arrow-right"></i></a>
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
                <div class="col">
                  <div style="background-color:#5cb85c;  width:153px" class="card info-card sales-card">
                    <div class="card-body">
                      <h5 style="color:white" class="card-title">Approved Document</h5>
                      <div class="d-flex align-items-center">
                        <div class="ps-3">
                          <i style="position: absolute;top: auto;bottom: 5px;right: 5px;z-index: 0;font-size: 90px;color: rgba(0, 0, 0, 0.15);" class="far fa-file"></i>
                          <h6 style="color:white">{{ $regis->where('trn_type', 'R')->count() }}</h6>
                        </div>
                      </div>
                      <a href="{{route('detail-iso-report',['stat' => 'R'])}}" style="color:white; ">More Info <i class="fas fa-arrow-right"></i></a>
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
                <div class="col">
                  <div style="background-color:Orange; width:153px" class="card info-card revenue-card">
                    <div class="card-body">
                      <h5 style="color:white"class="card-title">Notified Document</h5>
                      <div class="ps-3"><i style="position: absolute;top: auto;bottom: 5px;right: 5px;z-index: 0;font-size: 90px;color: rgba(0, 0, 0, 0.15);" class="far fa-file"></i>
                        <h6 style="color:white">{{ $regis->where('trn_type', 'I')->count() }}</h6>
                      </div>
                      <a href="{{route('detail-iso-report',['stat' => 'I'])}}" style="color:white; ">More Info <i class="fas fa-arrow-right"></i></a>
                    </div>
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
              <div class="col-3">
                <div style="background-color:MidnightBlue; width:153px;"class="card info-card revenue-card">
                  <div class="card-body">
                    <h5 style="color:white"class="card-title">Total Document</h5><i style="position: absolute;top: auto;bottom: 5px;right: 5px;z-index: 0;font-size: 90px;color: rgba(0, 0, 0, 0.15);" class="far fa-file"></i>
                    <div class="ps-3">
                      <h6 style ="color:white">{{ $regis->count() }}</h6>
                    </div>
                    <a href="#" style="color:white; ">More Info <i class="fas fa-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </th>
        </tr>
      </table>
    </div> --}}
  </section>
  <div class="table-responsive">
    <table id="iso"  class="table table-striped table-bordered display nowrap " data-striping="false" data-toggle-column="last" data-paging="true" data-sorting="true" data-filtering="true" style="width:100%">
      <thead>
        <tr>
          <th>#</th>
          <th>Action</th>
          <th style="min-width: 60px;">Vendor Code</th>
          <th style="min-width: 200px;">Vendor Name</th>
          <th style="min-width: 100px;">Material Supply</th>
          <th style="min-width: 30px;">Simplikasi</th>
          <th style="min-width: 100px;">ISO Cert Num</th>
          <th style="min-width: 100px;" >Expire Date</th>
          <th style="min-width: 100px;" >Expired Status</th>
          <th style="min-width: 100px;" >Doc Process</th>
          <th style="min-width: 10000px;" >ISO Cert Date</th>
          <th style="min-width: 100px;" >Certified</th>
          <th style="min-width: 100px;" >ISO Type</th>
          <th style="min-width: 30px;" >File</th>
          <th style="min-width: 100px;" >Last change</th>
          <th style="min-width: 100px;" >Entry Date</th>
          <th style="min-width: 100px;" >Remark</th>
          <th style="min-width: 100px;" >Doc Number</th>
          <th style="min-width: 100px;" >Ref Number</th>
        </tr>
      </thead>
      <tbody>
        @foreach($regis as $item)
        <?php
        
        $date_full = $item->exp_date;
        ?>
        <tr>
          <td>
          </td>
          <td>
            <div class="dropdown">
              <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Choose
              </a>
              
              
              <ul class="dropdown-menu">
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
              </ul>
               {{-- <ul class="dropdown-menu">
                <li> <a href="{{route('doc-iso.view',['id' => $item->_id])}}" class="dropdown-item"><i class='fas fa-eye'></i> View</a></li>
               
                <li><a href="{{route('doc-iso.renew',['id' => $item->_id])}}" class="dropdown-item"> <i class='fas fa-copy'></i> Renew</a></li>
               
                
                <li> <a href="{{route('doc-iso.change',['id' => $item->_id])}}" class="dropdown-item"> <i class='fas fa-edit'></i> Change</a></li>
                
              
                <li> <a href="{{route('approve-iso',['id' => $item->id])}}" class="dropdown-item"> <i class='fas fa-check'></i> Approval</a></li>
                <li><a href='{{route('delete-iso',['id' => $item->_id,'trn_id' => $item->trn_id,'doc_year' => $item->doc_year])}}' class="dropdown-item" data-toggle='tooltip' onclick="return confirm('All reference data will be deleted. \n Are you sure want to delete this data [{{$item->trn_id}}]?')"> <i class='fas fa-trash'></i> Delete</a></li>
                
              </ul> --}}
            </div>
          </td>
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
          <td>{!! strtotime($date_full) < strtotime(date('Y-m-d')) ? '<span class="badge bg-danger">Expired</span>' : '<span class="badge bg-success">Valid</span>' !!}</td>
          <td>{!!$doc_proccess!!} </td>
          <td>{{ date('d-m-Y', strtotime($item->cert_date)) }}</td>
          <td>{{ $item->cert_name}}</td>
          <td>{{$item->iso_type_name}}</td>
          <td><a href="{{asset('files/regis_iso/'.$item->doc_path)}}" class="btn btn-flat text-primary" target="_blank" data-toggle='tooltip' title='click to preview' >
            <i class="fa fa-file"></i>
          </a></td>
          
          <td>{{date('Y-m-d H:i:s',strtotime($item->ch_date))}}</td>
          <td>{{date('Y-m-d H:i:s',strtotime($item->cr_date))}}</td>
          <td>{{empty($item->remark) ? '-':$item->remark}}</td>
          <td>{{$item->trn_id}} - {{$item->doc_year}}</td>
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
          ?>
          
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
      // autoWidth:true,
      responsive: true,
      columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 1, targets: 2 },
            { responsivePriority: 1, targets: 3 },
            { responsivePriority: 1, targets: 4 },
            { responsivePriority: 1, targets: 5 },
            { responsivePriority: 1, targets: 6 },
            { responsivePriority: 1, targets: 7 },
            { responsivePriority: 1, targets: 8 },
            { responsivePriority: 1, targets: 9 },
        ]
   
  })
</script>
@endsection
