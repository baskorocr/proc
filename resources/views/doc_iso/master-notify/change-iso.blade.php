@extends('layouts.main')
@section('title',"Change ISO Document")
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
      <h1>Change ISO Document</h1>
      <nav>
        <ol class="breadcrumb">
          {{-- <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li> --}}
          <li class="breadcrumb-item active">Change ISO Document</li>
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
              <form class="row g-3" action="{{ route('doc-iso.change_iso') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$iso->_id}}">
                <input type="hidden" name="id_vendor" value="{{$iso->id_vendor}}">
                  <div class="form-group">
                <label><b>Doc Status</b></label>
                <h4>
               <span class="badge bg-{{@$iso->transaction->color}}">{{@$iso->transaction->trn_name}}</span>
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
                    <input name="mat_supply" type="text" value="{{$iso->mat_supply}}" class="form-control">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-12 ms-3 form-check">
                    <input type="checkbox" id="simply" name="simply" <?php echo $iso->simply=="X" ?"checked":""; ?> > 
                    <label class="form-check-label" for="simply"> Simplikasi </label>
                  </div>
                </div>
                
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">Certified</label>
                  <div class="col-sm-10">
                    <input name="cert_name" type="text" class="form-control" value="<?php echo $iso->cert_name; ?>">
                  </div>
                </div>
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">ISO Type</label>
                  <div class="col-sm-10">
                    <input name="iso_type_name" type="text" class="form-control" value=" <?php echo $iso->iso_type_name; ?>">
                  </div>
                </div>
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputText" class="col-sm-2 col-form-label">ISO Certified Number</label>
                  <div class="col-sm-10">
                    <input name="cert_num" type="text" class="form-control" value="<?php echo $iso->cert_num; ?>">
                  </div>
                </div>
        
                <div class="row mb-3">
                  <label  style="font-size:15px" for="inputDate" class="col-sm-2 col-form-label">ISO Certified Date</label>
                  <div class="col-sm-10">
                    <input name="cert_date" type="date" class="form-control" value="<?php echo $iso->cert_date; ?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label    style="font-size:15px" for="inputDate" class="col-sm-2 col-form-label">ISO Expired Date</label>
                  <div class="col-sm-10">
                    <input name="exp_date" type="date" class="form-control" value="<?php echo $iso->exp_date; ?>">
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
                        <?php 
                       if ($item->uom == "M"){
                                        $measure = "Months";
                                    } elseif($item->uom == "D"){
                                        $measure = "Days";
                                    } elseif($item->uom  == "Y"){
                                        $measure = "Year";
                                    }
                            ?>
                      <td style="font-size:12px">{{ $item->notif_id }}</td>
                      <td style="font-size:12px">{{ $item->notif_seq }}</td>
                      <td style="font-size:12px">{{ $item->notif_before }} {{$measure}}</td>
                    </tr> 
                    @endforeach
                  </tbody>
                </table> 
                <div style="marginTop: 100%;" class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Remarks</label>
                  <div class="col-sm-10">
                    <textarea name="remark" class="form-control" style="height: 100px">{{$iso->remark}}</textarea>
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
                    <input name="file" class="form-control" type="file" id="formFile">
                  </div>
                </div>
                <div class="text-left">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->

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
