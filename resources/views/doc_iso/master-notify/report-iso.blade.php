@extends('layouts.main')
@section('title',"Form Input Page")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Document ISO Report</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">DOC ISO</a></li>
          <li class="breadcrumb-item active">Report ISO</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
      <div class="flex-parent jc-center">
          <div style="float:left"; >
            <table>
                <tr>
                    <th id="table" >
                    <div style="background-color:MediumBlue; width:153px;" class="card info-card revenue-card">
                      <div class="card-body">
                        <h5 style="color:white" class="card-title">Submitted Document</h5>
                          <div class="ps-3">
                            <h6 style="color:white">0</h6>
                          </div>
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
                  <div style="background-color:Salmon; width:153px;"  class="card info-card sales-card">
                    <div class="card-body">
                      <h5 style ="color:white"class="card-title">Rejected Document</h5>
                      <div class="d-flex align-items-center">
                        <div class="ps-3">
                          <h6 style ="color:white">0</h6>
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
                    <div style="background-color:Orange; width:153px;"class="card info-card revenue-card">
                      <div class="card-body">
                        <h5 style="color:white"class="card-title">Updated Document</h5>
                          <div class="ps-3">
                            <h6 style ="color:white">0</h6>
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
                  <div style="background-color:#5cb85c; width:153px; "class="card info-card sales-card">
                      <div class="card-body">
                        <h5 style="color:white" class="card-title">Approved Document</h5>
                        <div class="d-flex align-items-center">
                          <div class="ps-3">
                            <h6 style="color:white">0</h6>
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
              <th id="table" > <div style="background-color:Orange; width:153px;"class="card info-card revenue-card">
                    <div class="card-body">
                      <h5 style="color:white"class="card-title">Notified Document</h5>
                        <div class="ps-3">
                          <h6 style ="color:white">0</h6>
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
                    <div style="background-color:MidnightBlue; width:153px;"class="card info-card revenue-card">
                    <div class="card-body">
                      <h5 style="color:white"class="card-title">Total Document</h5>
                        <div class="ps-3">
                          <h6 style ="color:white">0</h6>
                        </div>
                      </div>
                    </div>
                  </div>
              </th>
            </tr>
            </table>
            </div>
      </div>

        <table  class="table table-striped datatables" style="width:100%">
                  <thead>
                    <tr>
                    <th style="font-size:12px" >Action</th>
                      <th style="font-size:12px" >Vendor Code</th>
                      <th style="font-size:12px">Vendor Name</th>
                      <th style="font-size:12px">Material Supply</th>
                      <th style="font-size:12px">Simplikasi</th>
                      <th style="font-size:12px">ISO Cert Num</th>
                      <th style="font-size:12px">Expire Date</th>
                      <th style="font-size:12px">Expire Status</th>
                      <th style="font-size:12px">Doc Process</th>
                    </tr>
                  </thead>          
         </table>
    </section>
  </main>
@endsection
