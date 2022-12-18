<?php 
function konek($host, $username, $password, $schemaname = 'presensi_cloud') {
    /* You should enable error reporting for mysqli before attempting to make a connection */
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $mysqli = new mysqli($host, $username, $password, $schemaname);

    /* Set the desired charset after establishing a connection */
    $mysqli->set_charset('utf8mb4');

    return $mysqli;
}
?>