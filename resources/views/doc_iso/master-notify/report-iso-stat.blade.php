@extends('layouts.main')
@section('title',"Report ISO")
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css"/>
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Document ISO Report </h1>
      <nav>
        <ol class="breadcrumb">
          {{-- <li class="breadcrumb-item"><a href="index.html">DOC ISO</a></li> --}}
          <li class="breadcrumb-item active">Report ISO</li>
        </ol>
      </nav>
    </div>

<div class="table-responsive">
        <table id="iso"  class="table table-striped table-bordered display nowrap " data-striping="false" data-toggle-column="last" data-paging="true" data-sorting="true" data-filtering="true" style="width:100%">
                  <thead>
                    <tr>
                    <th>#</th>
                    <th>Action</th>
                        <th >Vendor Code</th>
                        <th >Vendor Name</th>
                        <th >Material Supply</th>
                        <th>Simplikasi</th>
                        <th >ISO Cert Num</th>
                        <th  >ISO Cert Date</th>
                        <th  >Certified</th>
                        <th  >ISO Type</th>
                        <th  >Expire Date</th>
                        <th  >Expired Status</th>
                        <th  >Doc Process</th>
                        <th >File</th>
                        <th  >Last change</th>
                        <th  >Entry Date</th>
                        <th  >Remark</th>
                        <th  >Doc Number</th>
                        <th  >Ref Number</th>
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
                              <li><a href="{{route('doc-iso.renew',['id' => $item->_id])}}" class="dropdown-item"> <i class='fas fa-copy'></i> Renew</a></li>
                              <li> <a href="{{route('doc-iso.change',['id' => $item->_id])}}" class="dropdown-item"> <i class='fas fa-edit'></i> Change</a></li>
                              <li> <a href="{{route('approve-iso',['id' => $item->id])}}" class="dropdown-item"> <i class='fas fa-check'></i> Approval</a></li>
                              <li><a href='{{route('delete-iso',['id' => $item->_id,'trn_id' => $item->trn_id,'doc_year' => $item->doc_year])}}' class="dropdown-item" data-toggle='tooltip' onclick="return confirm('All reference data will be deleted. \n Are you sure want to delete this data [{{$item->trn_id}}]?')"> <i class='fas fa-trash'></i> Delete</a></li>
                            </ul>
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
                        <td>{{ date('d-m-Y', strtotime($item->cert_date)) }}</td>
                        <td>{{ $item->cert_name}}</td>
                        <td>{{$item->iso_type_name}}</td>
                        <td>{{date('d-m-Y', strtotime($date_full))}}</td>
                        <td>{!! strtotime($date_full) < strtotime(date('Y-m-d')) ? '<span class="badge bg-danger">Expired</span>' : '<span class="badge bg-success">Valid</span>' !!}</td>
                        <td>{!!$doc_proccess!!} </td>
                        <td><a href="{{asset('files/regis_iso/'.$item->doc_path)}}" class="btn btn-flat" target="_blank" data-toggle='tooltip' title='click to preview' >
                                <i class="fa fa-file"></i>
                            </a></td>
                        
                        <td>{{date('Y-m-d H:i:s',strtotime($item->ch_date))}}</td>
                        <td>{{date('Y-m-d H:i:s',strtotime($item->cr_date))}}</td>
                        <td>{{$item->remark}}</td>
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
     
      responsive: true,
      
   
  })
</script>
@endsection
