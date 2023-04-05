@extends('layouts.main')
@section('title',"List PO")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>List PO</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Purchasing Process</a></li>
          <li class="breadcrumb-item active">List PO</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
              <div class="card-body">
                <h5 class="card-title">PO Approved List Master</h5>   
                <table class="table table-striped nowrap table_po" style="width:100%">
                  <thead>
                    <tr>
                      <th data-visible="true">PO Number</th>
                      <th>Rev No</th>
                      <th>Plant</th>
                      <th>Vendor</th>
                      <th>Vendor Name</th>
                      <th>Vendor Mail</th>
                      <th>Doc Date</th>
                      <th>PGr</th>
                      <th title="without Tax">PO Amount</th>
                      <th title="with Tax">Total Amount</th>
                      <th>Curr</th>
                      <th data-placement="left" title="Release Status">
                          <i class="fa fa-check"></i>
                      </th>
                      <th data-placement="left" title="Email Status">
                          <i class="fa fa-envelope"></i>
                      </th>
                      <th data-placement="left" title="File Status">
                          <i class="fa fa-file"></i>
                      </th>
                      <th data-placement="left" title="Download Status">
                          <i class="fa fa-download"></i>
                      </th>
                      <th>Upload Date</th>
                      <th>Upload Group</th>
                      <th data-breakpoints="all">Filename</th>
                    </tr>
                  </thead>
                  <tbody class="table-data"><tr role="row" class="odd"><td>5115004314</td><td>0</td><td>1102</td><td>101491</td><td>SPANSET INDONESIA, PT</td><td class="sorting_1">yunita@spanset.co.id <small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="User active">
                                        </i>
                                        </small></td><td>2022-10-06</td><td>BC1</td><td><p class="text-right">450,000.00</p></td><td><p class="text-right">499,500.00</p></td><td>IDR</td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Released">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Sent">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="Exist">
                                  </i>
                          </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Downloaded">
                                </i>
                          </small></td><td>2022-10-07 12:43:19</td><td>2022437</td><td>5115004314-20221006-164820.pdf</td></tr><tr role="row" class="even"><td>5115004262</td><td>0</td><td>1102</td><td>100069</td><td>BREINDO JAYA TEHNIK, PT</td><td class="sorting_1">yogi@breindo.co.id <small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="User active">
                                        </i>
                                        </small></td><td>2022-09-30</td><td>BC1</td><td><p class="text-right">1,048,500.00</p></td><td><p class="text-right">1,163,835.00</p></td><td>IDR</td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Released">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Sent">
                                </i>
                        </small></td><td><small><i class="fa fa-exclamation-circle" style="color: red;" data-toggle="tooltip" data-placement="left" title="Not exist">
                                </i>
                           </small></td><td><small><i class="fa fa-exclamation-circle" style="color: red;" data-toggle="tooltip'" data-placement="left" title="Not Downloaded">
                                 </i>
                        </small></td><td>2022-09-30 00:00:00</td><td>2022421</td><td>-</td></tr><tr role="row" class="odd"><td>5116008709</td><td>0</td><td>1101</td><td>100260</td><td>SUGIURA INDONESIA, PT</td><td class="sorting_1">yeremia@sugin.co.id <small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="User active">
                                        </i>
                                        </small></td><td>2022-08-24</td><td>BB1</td><td><p class="text-right">0.00</p></td><td><p class="text-right">0.00</p></td><td></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Released">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Sent">
                                </i>
                        </small></td><td><small><i class="fa fa-exclamation-circle" style="color: red;" data-toggle="tooltip" data-placement="left" title="Not exist">
                                </i>
                           </small></td><td><small><i class="fa fa-exclamation-circle" style="color: red;" data-toggle="tooltip'" data-placement="left" title="Not Downloaded">
                                 </i>
                        </small></td><td>2022-08-26 16:27:57</td><td>2022377</td><td>-</td></tr><tr role="row" class="even"><td>5116009031</td><td>0</td><td>1101</td><td>100260</td><td>SUGIURA INDONESIA, PT</td><td class="sorting_1">yeremia@sugin.co.id <small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="User active">
                                        </i>
                                        </small></td><td>2022-09-22</td><td>BB1</td><td><p class="text-right">23,435,500.00</p></td><td><p class="text-right">26,013,405.00</p></td><td>IDR</td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Released">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Sent">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="Exist">
                                  </i>
                          </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Downloaded">
                                </i>
                          </small></td><td>2022-09-22 00:00:00</td><td>2022408</td><td>5116009031-20220927-194731.pdf</td></tr><tr role="row" class="odd"><td>5116009136</td><td>0</td><td>1101</td><td>100260</td><td>SUGIURA INDONESIA, PT</td><td class="sorting_1">yeremia@sugin.co.id <small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="User active">
                                        </i>
                                        </small></td><td>2022-09-29</td><td>BB1</td><td><p class="text-right">72,880,700.00</p></td><td><p class="text-right">80,897,577.00</p></td><td>IDR</td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Released">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Sent">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="Exist">
                                  </i>
                          </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Downloaded">
                                </i>
                          </small></td><td>2022-09-29 00:00:00</td><td>2022428</td><td>5116009136-20220930-151100.pdf</td></tr><tr role="row" class="even"><td>5115004276</td><td>0</td><td>1102</td><td>100416</td><td>WILLIAM JAYA SENTOSA, PT</td><td class="sorting_1">williamjayasentosa@yahoo.co.id <small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="User active">
                                        </i>
                                        </small></td><td>2022-09-30</td><td>BC1</td><td><p class="text-right">2,029,000.00</p></td><td><p class="text-right">2,252,190.00</p></td><td>IDR</td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Released">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Sent">
                                </i>
                        </small></td><td><small><i class="fa fa-exclamation-circle" style="color: red;" data-toggle="tooltip" data-placement="left" title="Not exist">
                                </i>
                           </small></td><td><small><i class="fa fa-exclamation-circle" style="color: red;" data-toggle="tooltip'" data-placement="left" title="Not Downloaded">
                                 </i>
                        </small></td><td>2022-09-30 00:00:00</td><td>2022421</td><td>-</td></tr><tr role="row" class="odd"><td>5115004278</td><td>0</td><td>1102</td><td>101393</td><td>ZI - TECHASIA</td><td class="sorting_1">warsi.mirakanti@zi-tec.com <small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="User active">
                                        </i>
                                        </small></td><td>2022-09-30</td><td>BC1</td><td><p class="text-right">7,500,000.00</p></td><td><p class="text-right">8,325,000.00</p></td><td>IDR</td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Released">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Sent">
                                </i>
                        </small></td><td><small><i class="fa fa-exclamation-circle" style="color: red;" data-toggle="tooltip" data-placement="left" title="Not exist">
                                </i>
                           </small></td><td><small><i class="fa fa-exclamation-circle" style="color: red;" data-toggle="tooltip'" data-placement="left" title="Not Downloaded">
                                 </i>
                        </small></td><td>2022-09-30 00:00:00</td><td>2022421</td><td>-</td></tr><tr role="row" class="even"><td>5116008759</td><td>0</td><td>1101</td><td>101636</td><td>YONG SHIN INDONESIA, PT</td><td class="sorting_1">uthie.purch@yongshin.co.id <small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="User active">
                                        </i>
                                        </small></td><td>2022-08-24</td><td>BJ2</td><td><p class="text-right">0.00</p></td><td><p class="text-right">0.00</p></td><td></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Released">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Sent">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="Exist">
                                  </i>
                          </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Downloaded">
                                </i>
                          </small></td><td>2022-08-26 16:27:57</td><td>2022377</td><td>5116008759-20220824-181921.pdf</td></tr><tr role="row" class="odd"><td>5116009072</td><td>0</td><td>1101</td><td>101636</td><td>YONG SHIN INDONESIA, PT</td><td class="sorting_1">uthie.purch@yongshin.co.id <small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="User active">
                                        </i>
                                        </small></td><td>2022-09-22</td><td>BJ2</td><td><p class="text-right">10,132,000.00</p></td><td><p class="text-right">11,246,520.00</p></td><td>IDR</td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Released">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Sent">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="Exist">
                                  </i>
                          </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Downloaded">
                                </i>
                          </small></td><td>2022-09-22 00:00:00</td><td>2022408</td><td>5116009072-20220927-195451.pdf</td></tr><tr role="row" class="even"><td>5111012265</td><td>0</td><td>1101</td><td>100219</td><td>TRIPUTRA BANGUNJAYA BERSAMA, PT</td><td class="sorting_1">triputrabangunjaya_bersama@yahoo.com <small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip" data-placement="left" title="User active">
                                        </i>
                                        </small></td><td>2022-10-03</td><td>BC1</td><td><p class="text-right">70,000.00</p></td><td><p class="text-right">77,700.00</p></td><td>IDR</td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Released">
                                </i>
                        </small></td><td><small><i class="fa fa-check-circle" style="color: green;" data-toggle="tooltip'" data-placement="left" title="Sent">
                                </i>
                        </small></td><td><small><i class="fa fa-exclamation-circle" style="color: red;" data-toggle="tooltip" data-placement="left" title="Not exist">
                                </i>
                           </small></td><td><small><i class="fa fa-exclamation-circle" style="color: red;" data-toggle="tooltip'" data-placement="left" title="Not Downloaded">
                                 </i>
                        </small></td><td>2022-10-03 00:00:00</td><td>2022429</td><td>-</td></tr></tbody>
                </table>             
              </div>   
          </div>
        </div>
      </div>
    </section>


  </main><!-- End #main -->
@endsection
<script src="{{ asset('assets/template/js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('source_js/po/list_po.js') }}"></script>
