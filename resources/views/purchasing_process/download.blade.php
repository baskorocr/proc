@extends('layouts.main')
@section('title',"Download List PO")
@section('content')
<style type="text/css">
  div.table-responsive > div.dataTables_wrapper > div.row
{
    overflow:auto !important;
}
</style>
 <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Download List PO</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Purchasing Process</a></li> --}}
				<li class="breadcrumb-item active">Download List PO</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
      
     <div class="card">
        <div class="card-header">
          Search Option
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="">
                <label>Document Date</label>
                <?php
                $date_from = "";
                $date_to = "";
                $list_po;
                $list_vendor;
                if (isset($_POST['submit-find'])) {
                $date_from      = trim($_POST['date_from']);
                $date_to        = trim($_POST['date_to']);
                $list_po        = rtrim($_POST['po_sel']);
                $list_vendor    = rtrim($_POST['vend_sel']);
                }
                ?>
                <div class="" style="width: 400px;">
                  <!-- <i class="fa fa-calendar"></i> -->
                 <div class="row">
                    <div class="col-md-6">
                      from
                      <input type="text" enable-search name="date_from" id="date_from" placeholder="YYYY/MM/DD" class="datepicker form-control" value = "<?php if (isset($_POST['submit-find'])) {echo $date_from;} ?>"/>
                    </div>
                    <div class="col-md-6"> to
                      <input type="text" enable-search name="date_to" id="date_to" placeholder="YYYY/MM/DD" class="datepicker form-control" value = "<?php if (isset($_POST['submit-find'])) {echo $date_to;} ?>"/></div>
                    </div>
                    
                    <div class="col-12">
                      <label>Purchase Order</label>
                      <textarea class="form-control"  enable-search rows="3" name="po_sel" id="po_textarea"  placeholder="5111000xxx"><?php if (isset($_POST['submit-find'])) { echo $list_po; } ?></textarea>
                       <a href="javascript:void(0);" onclick="$('#po_textarea').val('');">Clear</a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-5">
                  <div class="input-group col-sm-3" style="margin-top: 10px; margin-bottom: 5px">
                    <button type="submit" disabled id="enable-search-btn" name="submit-find" class="btn btn-primary btn-block" style="min-width: 100%;" onclick="search()">
                    <i class="fa fa-search"></i> Search
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-lg-5">
                 @if(auth()->user()->is_vendor)
                                        <div>
                                            <label class="col-sm-5 col-form-label">Vendor</label>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-12">
                                                       
                                                        <select name="vendor" disabled class="form-select select2" id="select_vendor_usr" aria-label="Default select example">
                                                            
                                                            <option selected value="{{ auth()->user()->foreign_id }}">
                                                                {{ auth()->user()->foreign_id }} - {{ auth()->user()->vendor->nm_vendor }}
                                                            </option>
                                               
                                                        </select>
                                                      
                                                    </div>
                                                   
                                                </div>
                                                <textarea class="form-control" disabled rows="3" name="vend" id="vend"  placeholder="1000xxx">{{ auth()->user()->foreign_id }}</textarea>
                                                {{-- <a href="javascript:void(0);" onclick="$('#vendor_list').val('');">Clear</a> --}}
                                            </div>
                                        </div>
                                        @else
                                        <div>
                                            <label class="col-sm-5 col-form-label">Vendor</label>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-10">
                                                       
                                                        <select name="vendor_select" class="form-select select2" id="select_vendor" aria-label="Default select example">
                                                            <option value="" >Choose Vendor</option>
                                                            @foreach($list_vendor as $vendor)
                                                            <option value="{{ $vendor->id_vendor }}">{{ $vendor->id_vendor }} - {{ $vendor->nm_vendor }}</option>
                                                            @endforeach
                                                        </select>
                                                      
                                                    </div>
                                                    <div class="col-2">
                                                        <button id="add_vendor" type="button" class="btn btn-primary btn-sm" onclick="addVendor()" style="margin-left:-22px;min-width: 100%;" ><i class="fas fa-plus"></i></button>
                                                    </div>
                                                </div>
                                                <textarea class="form-control" rows="3" name="vendor_list" id="vendor_list"  placeholder="1000xxx">{{Request::get('vendor_list')}}</textarea>
                                                <a href="javascript:void(0);" onclick="$('#vendor_list').val('');">Clear</a>
                                            </div>
                                        </div>
                                        @endif
                <br>
              </div>
            </div>
          </div>
        </div>


			<div class="row">
        <div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							
							<!-- <div class="filter mt-2 " align="right">
								<a class="btn btn-outline-secondary" href="#" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="bi bi-list"></i></a>
								<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
									{{-- <li class="dropdown-header text-start"><h6>Filter</h6></li> --}}
									<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#create-project" href="#"><i class="fas fa-plus-square"></i>Create Project</a></li>
									<li><a class="dropdown-item" href="#"><i class="fas fa-arrow-down"></i>Assign Project Details</a></li>
									<li><a class="dropdown-item" href="#"><i class="fa fa-table"></i>Project Assignment Data</a></li>
								</ul>
								
							</div> -->

							<div class="table-responsive mt-3">
                <button class="btn btn-secondary btn-sm mb-2" disabled select-all><i id="select-all-spinner" class="fas fa-check-square"></i> Select-All</button>
                <button class="btn btn-secondary btn-sm mb-2" style="display: none;" deselect-all><i class="far fa-square"></i> Deselect-All</button>
								<table  class="table table-bordered table-striped nowrap table-sm" id="tb-download-list-po">
									<thead>
                    <th>
                      <i class="fa fa-list"></i>
                    </th>
										<th style="min-width: 106px" data-visible="true">PO Number</th>
                      <th style="min-width: 65px">Rev No</th>
                      <th style="min-width: 65px">Plant</th>
                      <th style="min-width: 80px">Vendor</th>
                      <th style="min-width: 156px">Vendor Name</th>
                      {{-- <th style="min-width: 106px">Vendor Mail</th> --}}
                      <th style="min-width: 106px">Doc Date</th>
                      <th style="min-width: 30px">PGr</th>
                      <th style="min-width: 106px" title="without Tax">PO Amount</th>
                      <th style="min-width: 106px" title="with Tax">Total Amount</th>
                      <th style="min-width: 50px">Curr</th>
                      <th style="min-width: 106px">Sent Date</th>
                      <th style="min-width: 26px">
                          <i class="fa fa-envelope"></i>
                      </th>
                      <th style="min-width: 26px" >
                          <i class="fa fa-file"></i>
                      </th>
                      <th style="min-width: 26px">
                          <i class="fa fa-download"></i>
                      </th>

                      <th style="min-width: 26px">
                          <i class="fa fa-clock"  title="Active Status (3 Months)"></i>



                      </th>
                      <th style="min-width: 106px">Upload Date</th>
                      <th style="min-width: 106px">Upload Group</th>
                      <th style="min-width: 106px" data-breakpoints="all">File Ver</th>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
              <div class="card-footer">
                <form action="{{route('purchasing.process.download.zip')}}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-6 col-xs-12">
                      <div class="row">
                        <div class="col-md-6 col-xs-12">
                          <div id="download-list-checked">
                          </div>
                          <button type="submit" name="checked-po" class="btn btn-block btn-success">
                            <i class="fas fa-download"></i> Download Checked
                          </button>
                        </div>
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
	</main>
	@endsection
	@section('javascript')
   <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
	<script>
     $('[enable-search]').on('keyup change', function(e) {
          $('#enable-search-btn').prop('disabled',false)
      });

     $(document).ready(function(){
      
       $('#enable-search-btn').prop('disabled',true)
      })
    
      var data = [];
    $('[select-all]').click(function(){
      var select = $(this);
      $('#select-all-spinner').removeClass('fa-check-square')
      $('#select-all-spinner').addClass('fa-spin fa-spinner')
      select.prop('disabled',true)
      var route = '{{route('purchasing.process.selectAll')}}';
      axios.post(route, {
          _token: '{{csrf_token()}}',
          po_num : $('#po_textarea').val(),
          date_from : $('#date_from').val(),
          date_to : $('#date_to').val(),
          id_vendor : $('#select_vendor').val().toString(),
          vendor_list : $('#vendor_list').val(),
          vendor_select : $('#select_vendor').val()
        })
        .then(function (response) {
         var total = response.data.po.length;
         var select_count = 0;
        $.each(response.data.po, function (key, value) {
          var dtval = value._id;
          var flnm = value.file_nm;
          
          if(value.selected)
          {
            if($("#fl"+dtval).length == 0) {
              data.push(dtval);
              select_count+=1;
              $(".cl-"+dtval).addClass('selected');
              $('#download-list-checked').append('<input type="hidden" id="fl'+dtval+'" name="download_doc[]" value="'+flnm+'" /> <input type="hidden" id="po'+dtval+'" name="id_po[]" value="'+dtval+'" />');
              $('.checked-'+value._id).prop('checked',true);
              $(".cl-"+value._id).addClass('selected');
            } else{
              // console.log(dtval+' is Exists.');
            }
          }
          
         
          

        });
        if(select_count > 0)
        {   
          select.prop('disabled',false)
          $('#select-all-spinner').addClass('fa-check-square')
          $('#select-all-spinner').removeClass('fa-spin fa-spinner')
          $('[deselect-all]').show();
          $('[select-all]').hide();
        } else{
          select.prop('disabled',false)
          $('#select-all-spinner').addClass('fa-check-square')
          $('#select-all-spinner').removeClass('fa-spin fa-spinner')
        }
        })
        .catch(function (error) {
          $('#select-all-spinner').addClass('fa-check-square')
          $('#select-all-spinner').removeClass('fa-spin fa-spinner')
          // console.log(error);
        });
             // $('input:checkbox:checked').trigger('click')
      //  $('input:checkbox').prop('checked', true);
      //  $('input:checkbox').each(function(i, obj) {
      //     console.log();
      // });
    })

    $('[deselect-all]').click(function(){
      data =[]
      $('.checked').prop('checked', false);
      $(".selected").removeClass('selected');
      $('[deselect-all]').hide();
      $('[select-all]').show();
      $('#download-list-checked').empty();
    })
   
		function addVendor()
     {
      const textarea = document.getElementById('vendor_list');

      textarea.value += document.getElementById('select_vendor').value+'\n'
     }

      $('#date_from').datepicker({
            uiLibrary: 'bootstrap5',
             format: 'yyyy-mm-dd'
        });
 $('#date_to').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'yyyy-mm-dd'
        });

	// 	$(document).ready(function(){

	// 	window.table = $('#tb-list-po').DataTable({
	// 		columnDefs: [
	// {
	// searchable: false,
	// orderable: false,
	// targets: 0,
	// }],

		// 	"order": [[ 1, "DESC" ]],
		// 	processing: true,
		// 	serverSide: true,
		// 	autoWidth:false,
		// 	"language": {
		// 	"processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
		// 	},
		// 	ajax: "{{ route('datatables.purchasing.process.listpo')}}",
		// 	columns: [
        //         {
		// 				data: 'DT_RowIndex',
		// 				name: 'DT_RowIndex'
		// 				},
		// 				{
		// 				data: 'po_num',
		// 				name: 'po_num'
		// 				},
		// 	]
		// 	});
		// window.table.on('order.dt search.dt', function () {
		// let i = 1;
		
		// window.table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
		// this.data(i++);
		// });
		// }).draw();
		// })
  Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
    
		  function selectedDwn(id)
		  {
        var val = $(id).val();
        var dtval = $(id).data('mgid');
        var flnm = $(id).data('filenm');
        // console.log($(id).val());
        if(!$(id).is(':checked'))
        {
          data.remove(dtval);
          $('#fl'+dtval).remove();
          $('#po'+dtval).remove();
          $(".cl-"+dtval).removeClass('selected');
        } else{
          if($("#fl"+dtval).length == 0) {
            data.push(dtval);
            $(".cl-"+dtval).addClass('selected');
            $('#download-list-checked').append('<input type="hidden" id="fl'+dtval+'" name="download_doc[]" value="'+flnm+'" /> <input type="hidden" id="po'+dtval+'" name="id_po[]" value="'+dtval+'" />');
          } else{
            // console.log(dtval+' is Exists.');
          }
          
        }
        console.log(data);
		  }

          $.fn.dataTable.ext.errMode = 'none';
      $('#tb-download-list-po').on('draw.dt',   function () {
      // console.log($('#63460809220e0000eb00d4b8').is('checked'))
      // if($('#63460809220e0000eb00d4b8').is(':checked'))
      // {
      //  alert('SS')
      // } 

      var all = $(".checked").map(function() {
        // console.log("#"+$(this).data('mgid'))
          if(data.includes($(this).data('mgid')))
          {
            $("#"+$(this).data('mgid')).prop('checked', true);
            if($("#"+$(this).data('mgid')).prop('checked'))
            {
              $(".cl-"+$(this).data('mgid')).addClass('selected');
            } else{
              $(".cl-"+$(this).data('mgid')).removeClass('selected');
            }
          }
      }).get();

      console.log(all.join());
    }
       ).DataTable();
      function search() {
        $('[select-all]').prop('disabled',false);
        $('#download-list-checked').empty();
         $('#tb-download-list-po').DataTable().destroy();
        var table = $('#tb-download-list-po').DataTable({ autoWidth:false,
        "order": [[ 11, "DESC" ]],
        processing: true,
        serverSide: true,
        autoWidth:false,
          "lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50,100, "All"] ],
        "language": {
        "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },
        ajax: {
            data: (item) => {
                item.po_num = $('#po_textarea').val();
                item.date_from = $('#date_from').val();
                item.date_to = $('#date_to').val();
                item.id_vendor = $('#select_vendor').val().toString();
                 item.vendor_list = $('#vendor_list').val();
                 item.vendor_select = $('#select_vendor').val();
            },
            url:"{{ route('datatables.purchasing.process.download.listpo')}}",
        },  
        'columnDefs': [
              {
                  'targets': [19],
                  'visible': false,
                  'searchable': false
              },
          ],
        columns: [
          {
            data: 'download_check',
            name: 'download_check'
          },
           {
            data: 'po_num',
            name: 'po_num'
            },
            {
            data: 'revno',
            name: 'revno'
            },
            {
            data: 'plant',
            name: 'plant'
            },
            {
            data: 'id_vendor',
            name: 'id_vendor'
            },
            {
            data: 'nm_vendor',
            name: 'nm_vendor'
            },
            // {
            // data: 'vend_email',
            // name: 'vend_email'
            // },
            {
            data: 'doc_date',
            name: 'doc_date'
            },
            {
            data: 'pgr',
            name: 'pgr'
            },
            {
            data: 'po_amount',
            name: 'po_amount'
            },
            {
            data: 'total_amount',
            name: 'total_amount'
            },
            {
            data: 'curr',
            name: 'curr'
            },
            {
            data: 'sent',
            name: 'sent'
            },
            {
            data: 'mail_stat',
            name: 'mail_stat'
            },
            {
            data: 'file_exist',
            name: 'file_exist'
            },
            {
            data: 'download_stat',
            name: 'download_stat'
            },
            {
            data: 'active',
            name: 'active'
            },
            {
            data: 'upload_date',
            name: 'upload_date'
            },
            {
            data: 'upload_group',
            name: 'upload_group'
            },
            {
            data: 'file_nm',
            name: 'file_nm'
            },
            {
              data: '_id',
              name: '_id'
              },
        ],

    "createdRow": function( row, data, dataIndex ) {
       $(row).addClass('cl-'+data._id)
      }
      });
      }

      $('.select2').select2();
	
	</script>
	@endsection