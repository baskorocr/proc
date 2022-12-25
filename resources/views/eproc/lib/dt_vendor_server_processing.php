<?php
/**
 * Copyright (c) 2017. Don't copy or use the source code without author permission for comercial purpose(s)
 */

/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 20-Nov-17
 * Time: 10:51 AM
 */

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'vendor';

// Table's primary key
$primaryKey = 'id_vendor';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'id_vendor', 'dt' => 0 ),
    array( 'db' => 'nm_vendor',  'dt' => 1 ),
    array( 'db' => 'allias',   'dt' => 2 ),
    array( 'db' => 'street',     'dt' => 3 ),
    array( 'db' => 'status_vendor',     'dt' => 4 )
);

// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'dp_eproc',
    'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);


?>