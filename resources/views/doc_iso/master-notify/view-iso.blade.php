@extends('layouts.main')
@section('title',"Review ISO Document")
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
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
    <h1>Review ISO Document</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Review ISO Document</li>
      </ol>
    </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
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
              <div class="form-group">
                <label><b>Vendor</b></label>
                <h6><?php echo $iso->id_vendor." - ".$iso->vendor->nm_vendor; ?></h6>
              </div>
              <?php
              if(session('role') != 'vendor')
              {
              ?>
              <div class="form-group">
                <label><b>Material Supply</b></label>
                <h6><?php echo $iso->mat_supply; ?></h6>
              </div>
              <div class="checkbox">
               <label>
                  <input type="checkbox" name="simply" <?php echo $iso->simply=="X" ?"checked":""; ?> disabled> Simplikasi
                </label>
              </div>
              <?php
              }
              ?>
              <div class="form-group">
                <label><b>Certified</b></label>
                <h6>
                 <?php echo $iso->cert_name; ?>
               </h6>
              </div>
              <div class="form-group">
                <label><b>ISO Type</b></label>
                 <h6>
                 <?php echo $iso->iso_type_name; ?>
               </h6>
               
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><b>ISO Certified Number</b></label>
                  <h6>
                 <?php echo $iso->cert_num; ?>
               </h6>
              </div>
              <div class="form-group">
                <label><b>ISO Certified Date</b></label>
                   <h6>
                   <?php echo date('d/m/Y',strtotime($iso->cert_date)); ?>
                 </h6>
                  </div><!-- /.form group -->
                  
                  <div class="form-group">
                    <label><b>ISO Expired Date</b></label>
                      <h6>
                     <?php echo date('d/m/Y',strtotime($iso->exp_date)); ?>
                   </h6>
                </div>
                <div class="form-group">
                  <label><b>Notify Before</b></label>
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
              </div>
            </div>
            </div>
          </div>
        </section>
      </main>
      @endsection