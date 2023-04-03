@extends('layouts.main')
@section('title',"Edit Permission ")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Permission</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('monitoring.delivery')}}">Settings</a></li>
                <li class="breadcrumb-item active">Permission</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                     @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    <div class="card">
                        <div class="card-body mt-3">

                           
                           <form action="{{route('config.permission.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$data->_id}}">
                             <div class="row">
                                <div class="col-md-6">
                                    <label>Permission Name *</label>
                                    <input type="text" placeholder="cth: Master Product" class="form-control" value="{{$data->name}}" required  name="name">
                                    @error('name')
                                       <span class="badge border-danger border-1 text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                             </div>

                             <div class="row">
                                <div class="col-md-6">
                                    <label>Icon</label>
                                    <input type="text" placeholder="cth: bi bi-truck" class="form-control" value="{{$data->icon}}"   name="icon">
                                     @error('icon')
                                       <span class="badge border-danger border-1 text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                             </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <label>Description</label>
                                   <textarea class="form-control" placeholder="cth: Menu untuk mengelola produk" name="description" style="height: 100px">{{$data->description}}</textarea>
                                    @error('description')
                                       <span class="badge border-danger border-1 text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                             </div>

                             <div class="row">
                                <div class="col-md-6">
                                    <label>URL *</label>
                                    <input type="text" placeholder="cth: master-data/product" class="form-control" value="{{$data->url}}" required  name="url">
                                     @error('url')
                                       <span class="badge border-danger border-1 text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                             </div>

                             <div class="row">
                                <div class="col-md-6">
                                    <label>Order Number</label>
                                    <input type="text" placeholder="cth: 1.5" class="form-control" value="{{$data->order_number}}" required  name="order_number">
                                      @error('order_number')
                                       <span class="badge border-danger border-1 text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                             </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <label>Parent ID</label>
                                    <select class="form-control select2" name="parent_id">
                                            <option value="" @if($data->permission_type == null)  @endif>-Kosong-</option>
                                        @foreach($parent as $p)
                                            <option  value="{{$p->_id}}" @if($data->parent_id == $p->_id) selected="selected" @endif>{{$p->name}}</option>
                                            <option  value="{{$p->_id}}" @if($data->parent_id == $p->_id) selected="selected" @endif>{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                     @error('parent_id')
                                       <span class="badge border-danger border-1 text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                             </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <label>Type</label>
                                   <select class="form-control select2" name="type">
                                       <option value="page" @if($data->permission_type == "page") selected="selected" @endif>Page</option>
                                       <option value="button" @if($data->permission_type == "button") selected="selected" @endif>Button</option>
                                   </select>
                                      @error('type')
                                       <span class="badge border-danger border-1 text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                             </div>
                             <hr>
                             <div class="row">
                                <div class="col-md-6">
                                  <button class="btn btn-primary btn-block" type="submit">Simpan</button>
                                </div>
                             </div>
                           </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        @endsection
        @section('javascript')
        <script type="text/javascript">
            $(document).ready(function() {
                    $('.select2').select2();
                });
        </script>
        @endsection