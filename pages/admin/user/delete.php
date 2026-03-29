<?php
$target=readUser((int)($_GET['id']??0));
if($target&&$target->role!=='admin') deleteUser($target->id);
header('Location: '.$baseUrl.'?page=admin/users');exit();
