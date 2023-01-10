<?php

//include_once "conn/conn.php";

//USER DATA

function autonum( $tabel, $kolom, $lebar, $ambil, $start, $id_data)
{
    $conn=mysqli_connect("localhost","remote","lact0bas1lus") or die(mysqli_error($conn));
    mysqli_select_db($conn,"dp_eproc");
    unset($hasil);
    unset($query);
    $query="select $kolom from $tabel order by $kolom desc limit 1";
    $hasil=mysqli_query($conn,$query) or die(mysqli_error($conn));
    $jumlahrecord = mysqli_num_rows($hasil);
    
    //$row[0] ='DN1772120181189999';
    if($jumlahrecord == 0)
        $nomor=$start;
    else
    {
        $row=mysqli_fetch_array($hasil);
        $nomor=intval(substr($row[0],$ambil))+1;
    }
    if($lebar>0)
        $angka = $id_data.str_pad($nomor,$lebar,"0",STR_PAD_LEFT);
    else
        $angka = substr($nomor);
    return $angka;
}


function autoNumber($id, $table){
    
        $conn = mysqli_connect("localhost","remote","lact0bas1lus") or die("Gagal melakukan Koneksi!");
        mysqli_select_db($conn,"dp_eproc") or die("Gagal memilih Database!");

        $query = 'SELECT MAX(RIGHT('.$id.', 5)) as max_id FROM '.$table.' ORDER BY '.$id;
        $result = mysqli_query($conn,$query);
        $data = mysqli_fetch_array($result);
        $id_max = $data['max_id'];
        //$id_max = '00000';
        $sort_num = (int) substr($id_max, 0, 5);
        $sort_num++;
        $new_code = sprintf("%05s", $sort_num);

    return $new_code;
    }

?>