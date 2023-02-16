@extends('layouts.main')
@section('title',"File Master ")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>File Master</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item">File Master</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mt-3 ">
                            <table id="filemaster" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Filename</th>
                                        <th>Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $no = 1;
                                    // $dir_iterator = new RecursiveDirectoryIterator(public_path('DATA/'));
                                    // $iterator = new RecursiveTreeIterator($dir_iterator);
                                    $iterator = File::allFiles(public_path('DATA/'));
                                    // dd($iterator);
                                    foreach ($iterator as $path) {
                                        // dd();
                                    $file = pathinfo($path);
                                    $fullPath = $path->getRelativePathname();
                                    $string = explode(".", $fullPath);

                                    // dd($file);
                                    if(count($string) > 1) {
                                    $data = $string[1];
                                    }
                                    $myfile = str_replace('DATA\\',"",$fullPath);
                                    $myfile = explode('\\DATA\\',$fullPath);
                                    if ($data == "pdf" and strpos($fullPath, '.pdf') !== false) {
                                    echo "
                                    <tr>
                                        <td>$no</td>
                                        <td>".$file['basename']."</td>
                                        <td>
                                            <a href='".asset('DATA')."/view_data.php?p=$myfile[0]' target='_blank' data-toggle='tooltip' title='click to download'>
                                               
                                                <span class='badge bg-success'>Download <i class='fa fa-download'></i></span>
                                                
                                            </a>
                                        </td>
                                    </tr>
                                    ";
                                    $no++;
                                    }//  if ($data == "pdf")
                                    }//foreach ($iterator as $file)
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @endsection
    @section('javascript')
    <script type="text/javascript">
        $('#filemaster').DataTable({})
    </script>
    @endsection