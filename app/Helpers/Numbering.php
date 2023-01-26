<?php 
namespace App\Helpers;
use App\Models\Project;

class Numbering {

	public static function generateAuto($model,$kolom, $lebar, $ambil, $start, $id_data)
	{
		$hasil = $model->select($kolom)->orderBy($kolom,"DESC")->first();
		$jumlahRecord = $model->select($kolom)->orderBy($kolom)->count();

		if($jumlahRecord == 0)
		{
			$nomor = $start;
		}
		else{
			$row=$hasil;
        	$nomor=intval(substr($row->{$kolom},$ambil))+1;
		}

		if($lebar>0)
		{
			$angka = $id_data.str_pad($nomor,$lebar,"0",STR_PAD_LEFT);
		} else{
			$angka = substr($nomor);
		}

		return $angka;
	}

    // $conn=mysqli_connect("localhost","root","") or die(mysqli_error($conn));
    // mysql_select_db("dp_eproc");
    // unset($hasil);
    // unset($query);
    // $query="select $kolom from $tabel order by $kolom desc limit 1";
    // $hasil=mysqli_query($conn,$query) or die(mysqli_error($conn));
    // $jumlahrecord = mysqli_num_rows($hasil);
    
    // //$row[0] ='DN1772120181189999';
    // if($jumlahrecord == 0)
    //     $nomor=$start;
    // else
    // {
    //     $row=mysqli_fetch_array($hasil);
    //     $nomor=intval(substr($row[0],$ambil))+1;
    // }
    // if($lebar>0)
    //     $angka = $id_data.str_pad($nomor,$lebar,"0",STR_PAD_LEFT);
    // else
    //     $angka = substr($nomor);
    // return $angka;

}