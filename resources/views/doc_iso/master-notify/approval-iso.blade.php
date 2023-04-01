@extends('layouts.main')
@section('title',"Approval ISO Doc")
@section('content')
<?php
$count = count(IsoHelper::get_transaction_type_id($iso->trn_type));
$trans = IsoHelper::get_transaction_type_id_first($iso->trn_type);
if ($count == 1) {
$color = 'badge bg-'.$trans->color;
$doc_proccess = '<span class="'.$color.'">'.@$trans->trn_name.'</span>';
} else {
$doc_proccess = '<span class="badge bg-primary">'.@$trans->trn_name.'</span>';
}
$countstat = count(IsoHelper::get_transaction_type_id($iso->stat));
$transstat = IsoHelper::get_transaction_type_id_first($iso->stat);
if ($count == 1) {
$colorst = 'badge bg-'.$trans->color;
$stat = '<span class="'.$colorst.'">'.@$trans->trn_name.'</span>';
} else {
$stat = '<span class="badge bg-primary">'.@$trans->trn_name.'</span>';
}
?>
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Approval ISO Document</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Change ISO</li>
      </ol>
    </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          
          <!-- General Form Elements -->
          
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>
              <!-- Multi Columns Form -->
              
              <input type="hidden" name="id" value="{{$iso->_id}}">
              <input type="hidden" name="id_vendor" value="{{$iso->id_vendor}}">
              <div class="form-group">
                <label><b>Doc Status</b></label>
                <h4>
                {!!$stat!!}
                </h4>
              </div>
              <div class="form-group">
                <label><b>Doc Process</b></label>
                <h4>
                {!!$doc_proccess!!}
                </h4>
              </div>
              <div class="row mb-3">
                <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">Vendor</label>
                <div class="col-sm-10">
                  <select name="v" disabled class="form-select" aria-label="Default select example">
                    
                    <option value=""><?php echo $iso->id_vendor." - ".$iso->vendor->nm_vendor; ?></option>
                    
                  </select>
                </div>
              </div>
              <div class="row mb-3">
                <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">Material Supply</label>
                <div class="col-sm-10">
                  <input disabled name="mat_supply" type="text" value="{{$iso->mat_supply}}" class="form-control">
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-12 ms-3 form-check">
                  <input disabled type="checkbox" id="simply" name="simply" <?php echo $iso->simply=="X" ?"checked":""; ?> >
                  <label class="form-check-label" for="simply"> Simplikasi </label>
                </div>
              </div>
              
              <div class="row mb-3">
                <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">Certified</label>
                <div class="col-sm-10">
                  <input disabled name="cert_name" type="text" class="form-control" value="<?php echo $iso->cert_name; ?>">
                </div>
              </div>
              <div class="row mb-3">
                <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">ISO Type</label>
                <div class="col-sm-10">
                  <input disabled name="iso_type_name" type="text" class="form-control" value=" <?php echo $iso->iso_type_name; ?>">
                </div>
              </div>
              <div class="row mb-3">
                <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">ISO Certified Number</label>
                <div class="col-sm-10">
                  <input disabled name="cert_num" type="text" class="form-control" value="<?php echo $iso->cert_num; ?>">
                </div>
              </div>
              
              <div class="row mb-3">
                <label  style="font-size:15px" for="inputDate" class="col-sm-2 col-form-label">ISO Certified Date</label>
                <div class="col-sm-10">
                  <input disabled name="cert_date" type="date" class="form-control" value="<?php echo $iso->cert_date; ?>">
                </div>
              </div>
              <div class="row mb-3">
                <label    style="font-size:15px" for="inputDate" class="col-sm-2 col-form-label">ISO Expired Date</label>
                <div class="col-sm-10">
                  <input disabled name="exp_date" type="date" class="form-control" value="<?php echo $iso->exp_date; ?>">
                </div>
              </div>
              <table  class="table" style="width:100%">
                <thead>
                  <tr>
                    <th style="font-size:12px" >Notif ID</th>
                    <th style="font-size:12px">Notify Sequence</th>
                    <th style="font-size:12px">Notify Before</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($notify as $item)
                  <tr>
                    <td style="font-size:12px">{{ $item->notif_id }}</td>
                    <td style="font-size:12px">{{ $item->notif_seq }}</td>
                    <td style="font-size:12px">{{ $item->notif_before }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div style="marginTop: 100%;" class="row mb-3">
                <label for="inputPassword" class="col-sm-2 col-form-label">Remarks</label>
                <div class="col-sm-10">
                  <textarea name="remark" disabled class="form-control" style="height: 100px">{{$iso->remark}}</textarea>
                </div>
              </div>
              <div class="row mb-3">
                <div class="form-group">
                  <label for="">Last Document</label><br>
                  <a href="{{asset('files/regis_iso/'.$iso->doc_path)}}" class="btn btn-flat" target="_blank" data-toggle='tooltip' title='click to preview' >
                  <i class="fa fa-file"></i> Click to Preview (<?php echo $iso->doc_path; ?>)</label>
                </a>
                
              </div>
              <label for="inputNumber" class="col-sm-2 col-form-label">File Input</label>
              <div class="col-sm-10">
                <input disabled name="file" class="form-control" type="file" id="formFile">
              </div>
            </div>
            <?php
            if ($iso->trn_type != 'R')
            {
            ?>
            <form class="row g-3" action="{{ route('doc-iso.approval_iso') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name ="id" value ="<?php echo $iso->_id; ?>" />
              <input type="hidden" name ="trn_id" value ="<?php echo $iso->trn_id; ?>" />
              <input type="hidden" name ="doc_year" value ="<?php echo $iso->doc_year; ?>" />
              <input type="hidden" name ="vendor_id" value ="<?php echo $iso->id_vendor; ?>">
              <input type="hidden" name ="id_vendor" value ="<?php echo $iso->id_vendor; ?>">
              <input type="hidden" name ="exp_date" value ="<?php echo $iso->exp_date; ?>">
              <div class="text-left">
                <button type="submit" name="approve_doc" onclick="return confirm('Are you sure to approve this doc iso?')" value="1" class="btn btn-success">Approve</button>
                <button type="submit" name="reject_doc" onclick="return confirm('Are you sure to reject this doc iso?')"   value="1" class="btn btn-danger">Reject</button>
              </div>
              </form><!-- End Multi Columns Form -->
              <?php
              }
              ?>
              
              
            </div>
          </div>
        </div>
      </form>
    </div>
    
    
    
  </div>
</div>
</div>
</div>
</section>
</main><!-- End #main -->
@endsection