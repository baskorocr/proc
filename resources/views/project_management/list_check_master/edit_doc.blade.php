@extends('layouts.main')
@section('title',"Edit Part")
@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>Edit List Check Doc</h1>
		<nav>
			<ol class="breadcrumb">
				{{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li> --}}
				<li class="breadcrumb-item active">Edit List Check Doc</li>
			</ol>
		</nav>
		</div><!-- End Page Title -->
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form role=form name="myForm" id="myForm"  action="{{route('project.management.master.listcheck.modify.doc.updateDocPart')}}" method="post" enctype="multipart/form-data">
								@csrf
								<div class="box-body">
									
					                    <div class="form-group"> <!-- change get updatet user id -->
					                        <label>ID Document</label>
					                        <input type="text" class="form-control" value ="<?php echo $doc->id_doc_part; ?>" disabled="true">
					                        <input type="hidden" id="id_doc" name="id_doc" value ="<?php echo $doc->id_doc_part; ?>">
					                    </div>

					                    <div class="form-group">
					                        <label>Nama Document</label>
					                        <input type="text" value="{{$doc->nm_doc_part}}" class="form-control" id="nm_doc" name="nm_doc" placeholder="Document Name" focused required> 
					                    </div> 

					                    <div class="form-group">
					                        <label>Tipe Document</label>
					                        <select class="form-control selectpicker" id="doc_type" name="doc_type" required>
					                            <option value="P" @if($doc->doc_type == "P") selected @endif>Doc for Procurement </option>
					                            <option value="V" @if($doc->doc_type == "V") selected @endif>Doc for Vendor </option>
					                        </select>
					                    </div>  

					                    <!--
					                    <div class="form-group">
					                        <input type="checkbox" class="form-control" id="doc_required" name="doc_required" value="Y"> 
					                        <label>Required Document</label>
					                    </div>
					                    -->

					                    <div class="form-group">
					                        <label>Requirement Type</label>
					                        <select class="form-control selectpicker" id="doc_required" name="doc_required" required>
					                            <option value="M" @if($doc->doc_required == "M") selected @endif style='color: #00cc00;'>Mandatory </option>
					                            <option value="Y" @if($doc->doc_required == "Y") selected @endif>Required </option>
					                            <option value="N" @if($doc->doc_required == "N") selected @endif style='color: #ff8000;'>Not required</option>
					                        </select>
					                    </div>
									</div><!-- /.box-body -->
									<div class="box-footer"><hr>
										<button type="submit" id="edit-prodmaster" name="edit-prodMaster" class="btn btn-primary"><i class="fas fa-edit"></i> Update</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
		@endsection