<?php
$movie=getMovie((int)($_GET['id']??0));
if($movie){deleteMovie($movie->id);}
header('Location: '.$baseUrl.'?page=admin/movies');exit();
