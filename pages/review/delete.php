<?php
if(!$user){header('Location: '.$baseUrl.'?page=login');exit();}
$rv=getReview((int)($_GET['id']??0));
if(!$rv||($rv->user_id!=$user->id&&!$isAdmin)){header('Location: '.$baseUrl);exit();}
$movie_id=$rv->movie_id;
deleteReview($rv->id);
header('Location: '.$baseUrl.'?page=movie&id='.$movie_id);exit();
