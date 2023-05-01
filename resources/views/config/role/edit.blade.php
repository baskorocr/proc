@extends('layouts.main')
@section('title',"Edit Role ")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Role</h1>
        <nav>
            <ol class="breadcrumb">
               {{--  <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('monitoring.delivery')}}">Settings</a></li> --}}
                <li class="breadcrumb-item active">Roles</li>
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

                           
                           <form action="{{route('config.role.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$data->_id}}">
                             <div class="row">
                                <div class="col-md-6">
                                    <label>Role Name *</label>
                                    <input type="text" placeholder="cth: Admin Purchasing" class="form-control" value="{{$data->name}}" required  name="name">
                                    @error('name')
                                       <span class="badge border-danger border-1 text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                             </div>

                             <div class="row">
                                <div class="col-md-6">
                                    <label>Description</label>
                                   <textarea class="form-control" placeholder="cth: Mengelola Purchasing" name="description" style="height: 100px">{{$data->name}}</textarea>
                                    @error('description')
                                       <span class="badge border-danger border-1 text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                             </div> 

                             <div class="row">
                                <div class="col-md-6">
                                    <label>Permissions</label>
                                   <div class="form-check form-switch"> 
                                    @foreach($parent as $p)
                                        <input class="form-check-input" show-detail {{in_array($p->_id, $arrPermisssion)?"checked":null}} data-detail="#show-{{$p->_id}}" value="{{$p->_id}}" name="permissions[]" type="checkbox" id="lbl-{{$p->_id}}" > 
                                        <label class="form-check-label" for="lbl-{{$p->_id}}">{{$p->name}}</label>
                                        @if(count($p->children) > 0)
                                        <div  style="margin-left:40px; display: none;" class="edit" id="show-{{$p->_id}}">
                                            @foreach($p->children as $c)
                                             <input class="form-check-input" {{in_array($c->_id, $arrPermisssion)?"checked":null}} type="checkbox"  name="permissions[]" value="{{$c->_id}}" id="child-{{$c->_id}}" > <label class="form-check-label" for="child-{{$c->_id}}">{{$c->name}}</label><br>
                                             @endforeach
                                        </div>
                                        @endif
                                        <br>
                                        

                                    @endforeach
                                </div>
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
                    @foreach($arrPermisssion as $key =>$p)
                        $('#show-{{$p}}').slideDown();
                    @endforeach
                });

            $('[show-detail]').click(function(){
                if($(this).is(':checked'))
                {   
                    var detail = $(this).data('detail')
                    $(detail).slideDown();
                } else{
                     var detail = $(this).data('detail')
                    $(detail).slideUp();
                }
            })



          
        </script>
        @endsection