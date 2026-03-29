<?php
if(!$user){header('Location: '.$baseUrl.'?page=login');exit();}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $movie_id=(int)($_POST['movie_id']??0);
    $rating  =(int)($_POST['rating']??0);
    $comment =trim($_POST['comment']??'');
    if(!$movie_id||!$rating||$rating<1||$rating>5){
        header('Location: '.$baseUrl.'?page=movie&id='.$movie_id.'&review_error='.urlencode('Invalid rating.'));exit();
    }
    if(getUserReviewForMovie($user->id,$movie_id)){
        header('Location: '.$baseUrl.'?page=movie&id='.$movie_id);exit();
    }
    createReview($user->id,$movie_id,$rating,$comment);
    header('Location: '.$baseUrl.'?page=movie&id='.$movie_id);exit();
}
header('Location: '.$baseUrl);exit();
