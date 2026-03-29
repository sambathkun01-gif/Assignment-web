<?php
if(!$user){header('Location: '.$baseUrl.'?page=login');exit();}
$rv=getReview((int)($_GET['id']??0));
if(!$rv||($rv->user_id!=$user->id&&!$isAdmin)){header('Location: '.$baseUrl);exit();}
$movie=getMovie($rv->movie_id);
$pageTitle='Edit Review';
$ratingErr=$commentErr='';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $rating=(int)($_POST['rating']??0);
    $comment=trim($_POST['comment']??'');
    if(!$rating||$rating<1||$rating>5)$ratingErr='Please select a rating.';
    if(empty($ratingErr)){
        updateReview($rv->id,$rating,$comment);
        header('Location: '.$baseUrl.'?page=movie&id='.$rv->movie_id);exit();
    }
}
?>
<div class="container my-4" style="max-width:560px">
  <a href="<?php echo $baseUrl ?>?page=movie&id=<?php echo $rv->movie_id ?>" class="btn btn-mm-ghost btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Back to Movie</a>
  <div class="mm-card">
    <h4 style="font-family:'Bebas Neue',sans-serif;letter-spacing:2px" class="mb-1">EDIT REVIEW</h4>
    <p class="text-muted-mm mb-4" style="font-size:.875rem">Movie: <strong class="text-accent"><?php echo htmlspecialchars($movie->title) ?></strong></p>
    <?php if($ratingErr):?><div class="alert alert-danger py-2"><?php echo $ratingErr ?></div><?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Your Rating</label>
        <div class="star-picker">
          <?php for($i=5;$i>=1;$i--): ?>
            <input type="radio" name="rating" id="star<?php echo $i ?>" value="<?php echo $i ?>" <?php echo $rv->rating==$i?'checked':'' ?> required>
            <label for="star<?php echo $i ?>"><i class="bi bi-star-fill"></i></label>
          <?php endfor; ?>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Comment</label>
        <textarea class="form-control" name="comment" rows="4" placeholder="Update your thoughts..."><?php echo htmlspecialchars($rv->comment??'') ?></textarea>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-mm-primary flex-grow-1">Save Changes</button>
        <a href="<?php echo $baseUrl ?>?page=movie&id=<?php echo $rv->movie_id ?>" class="btn btn-mm-ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>
