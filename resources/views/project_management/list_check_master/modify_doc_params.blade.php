@extends('layouts.main')
@section('title',"Modify Document Check List Parameters")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Modify Document Check List Parameters</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
				<li class="breadcrumb-item active">Modify Document Check List Parameters</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="" method="get" enctype="multipart/form-data">
								
								<div class="box-body mt-3">
									
									<label>Choose Document</label>
									<select  style="width: 100%;"  class="form-control  option-select-doc" id="id_doc" name="id_doc_assign" required>
                                

			                                       
			                               @foreach($doc as $d)
			                               <option value="{{$d->id_doc_part}}">{{$d->nm_doc_part}} 
			                                    ( @if ($d->doc_required == "M") 
			                                            Mandatory
			                                        @elseif ($d->doc_required == "Y")
			                                           Required
			                                        @elseif ($d->doc_required== "N")
			                                            Not-required
			                                        @endif )</option>
			                               @endforeach
                            </select>
									</div><!-- /.box-body -->
									<div class="box-footer"><hr>
										<button type="submit"  class="btn btn-primary"><i class="fas fa-pencil"></i> View</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
		@endsection