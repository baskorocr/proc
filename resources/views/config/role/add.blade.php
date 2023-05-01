@extends('layouts.main')
@section('title',"Add New Role ")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Add New Role</h1>
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

                           
                           <form action="{{route('config.role.save')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                             <div class="row">
                                <div class="col-md-6">
                                    <label>Role Name *</label>
                                    <input type="text" placeholder="cth: Admin Purchasing" class="form-control" value="" required  name="name">
                                    @error('name')
                                       <span class="badge border-danger border-1 text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                             </div>

                             <div class="row">
                                <div class="col-md-6">
                                    <label>Description</label>
                                   <textarea class="form-control" placeholder="cth: Mengelola Purchasing" name="description" style="height: 100px"></textarea>
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
                                        <input class="form-check-input" show-detail data-detail="#show-{{$p->_id}}" value="{{$p->_id}}" name="permissions[]" type="checkbox" id="lbl-{{$p->_id}}" > 
                                        <label class="form-check-label" for="lbl-{{$p->_id}}">{{$p->name}}</label>
                                        @if(count($p->children) > 0)
                                        <div  style="margin-left:40px; display: none;" id="show-{{$p->_id}}">
                                            @foreach($p->children as $c)
                                             <input class="form-check-input" type="checkbox"  name="permissions[]" value="{{$c->_id}}" id="child-{{$c->_id}}" > <label class="form-check-label" for="child-{{$c->_id}}">{{$c->name}}</label><br>
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