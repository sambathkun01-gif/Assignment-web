<?php
$db_host = '127.0.0.1';
$db_name = 'movemovie';
$db_user = 'root';
$db_pass = '';
$db_port = 3306;

$db = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
if ($db->connect_error) {
    die('<div class="alert alert-danger m-3">Database connection failed: ' . $db->connect_error . '</div>');
}
$db->set_charset('utf8mb4');
?>
