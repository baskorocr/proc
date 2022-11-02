<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- bootstrap 3.0.2 -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- sweet alert -->
    <link href="../css/sweet-alert.css" rel="stylesheet" type="text/css" />
    <script src="../js/sweet-alert/sweetalert.min.js" type="text/javascript"></script>

    <link rel="icon" type="image/x-icon" href="../img/favicon3.png" />

</head>

<?php

/*
session_start();
session_destroy();
echo "<script>alert('Anda telah keluar dari eProc Dharma Polimetal'); window.location ='login.php'</script>";
*/
session_start();

// Unset all session values
$_SESSION = array();

// get session parameters
$params = session_get_cookie_params();

// Delete the actual cookie.
setcookie(session_name(),
    '', time() - 42000,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]);

// Destroy session
session_destroy();

?>
<body onload="">
<script>
        swal({
            title: "Logged out!",
            text: "You've logged out from eProc Dharma Polimetal!",
            type: "info",
            customClass: 'swal-wide',
            allowOutsideClick: false
        }).then(function() {
            swal({
                title: 'Thank you',
                text: 'Redirect you to eProc Dharma Polimetal',
                allowOutsideClick: false,
                timer: 2000,
                onOpen: function () {
                    swal.showLoading()
                }
            }).then(function () {
                },
                // handling the promise rejection
                function (dismiss) {
                    if (dismiss === 'timer') {
                        window.location.href = 'login.php';
                    }
                }
            )
        });

</script>

<script src="../jquery/jquery.min.js"></script>
<!-- jQuery UI 1.10.3 -->
<script src="../js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="../js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>


</body>