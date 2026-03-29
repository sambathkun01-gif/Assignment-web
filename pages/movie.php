<?php
if (!isset($_GET['id'])) { header('Location: '.$baseUrl); exit(); }
$movie = getMovie((int)$_GET['id']);
if (!$movie) { header('Location: '.$baseUrl); exit(); }
$pageTitle = $movie->title;
$reviews   = getMovieReviews($movie->id);
$myReview  = $user ? getUserReviewForMovie($user->id, $movie->id) : null;

function genreClass($g){$m=['Action'=>'Action','Sci-Fi'=>'Sci-Fi','Drama'=>'Drama','Thriller'=>'Thriller','Horror'=>'Horror','Comedy'=>'Comedy','Romance'=>'Romance','Animation'=>'Animation'];return 'genre-colors-'.(isset($m[$g])?$m[$g]:'default');}
function genreEmoji($g){$m=['Action'=>'⚡','Sci-Fi'=>'🚀','Drama'=>'🎭','Thriller'=>'🔪','Horror'=>'👻','Comedy'=>'😂','Romance'=>'❤️','Animation'=>'✨','Documentary'=>'📹'];return $m[$g]??'🎬';}
?>

<div class="container my-4">
  <!-- Back -->
  <a href="<?php echo $baseUrl ?>" class="btn btn-mm-ghost btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Back to Movies</a>

  <!-- Movie Info -->
  <div class="d-flex gap-4 flex-wrap mb-4">
    <div class="detail-poster <?php echo genreClass($movie->genre) ?>">
      <?php if($movie->image && file_exists($movie->image)): ?>
        <img src="<?php echo htmlspecialchars($movie->image) ?>" alt="">
      <?php else: ?>
        <span><?php echo genreEmoji($movie->genre) ?></span>
      <?php endif; ?>
    </div>
    <div class="flex-grow-1" style="min-width:200px">
      <?php if($movie->genre): ?><span class="badge mb-2" style="background:rgba(232,184,75,.15);color:var(--accent);font-size:.75rem"><?php echo htmlspecialchars($movie->genre) ?></span><?php endif; ?>
      <h1 style="font-family:'Bebas Neue',sans-serif;font-size:clamp(2rem,5vw,3rem);letter-spacing:3px"><?php echo htmlspecialchars($movie->title) ?></h1>
      <!-- Stars & Rating -->
      <div class="d-flex align-items-center gap-2 mb-2">
        <?php if($movie->avg_rating): ?>
          <span><?php echo renderStars(round($movie->avg_rating)) ?></span>
          <span style="font-family:'Bebas Neue',sans-serif;font-size:1.5rem;color:var(--accent)"><?php echo $movie->avg_rating ?></span>
          <span class="text-muted-mm">(<?php echo $movie->review_count ?> review<?php echo $movie->review_count!=1?'s':'' ?>)</span>
        <?php else: ?>
          <span class="text-muted-mm">No reviews yet — be the first!</span>
        <?php endif; ?>
      </div>
      <!-- Meta Chips -->
      <div class="d-flex gap-2 flex-wrap mb-3">
        <?php if($movie->release_date): ?><span class="badge bg-surface border border-mm text-muted-mm">📅 <?php echo date('Y', strtotime($movie->release_date)) ?></span><?php endif; ?>
        <?php if($movie->genre): ?><span class="badge bg-surface border border-mm text-muted-mm">🎭 <?php echo htmlspecialchars($movie->genre) ?></span><?php endif; ?>
      </div>
      <?php if($movie->description): ?>
        <p style="color:var(--muted);line-height:1.7;max-width:600px"><?php echo nl2br(htmlspecialchars($movie->description)) ?></p>
      <?php endif; ?>
      <?php if($isAdmin): ?>
        <div class="d-flex gap-2 mt-3">
          <a href="<?php echo $baseUrl ?>?page=admin/movie/edit&id=<?php echo $movie->id ?>" class="btn btn-mm-ghost btn-sm"><i class="bi bi-pencil me-1"></i>Edit Movie</a>
          <a href="<?php echo $baseUrl ?>?page=admin/movie/delete&id=<?php echo $movie->id ?>" class="btn btn-mm-danger btn-sm confirm-delete" data-msg="This will delete the movie and all its reviews."><i class="bi bi-trash me-1"></i>Delete</a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <hr>

  <div class="row g-4">
    <!-- Write Review -->
    <div class="col-lg-4">
      <div class="mm-card mb-3">
        <?php if(!$user): ?>
          <h5 style="font-family:'Bebas Neue',sans-serif;letter-spacing:1px">LEAVE A REVIEW</h5>
          <p class="text-muted-mm mb-2" style="font-size:.9rem">You need to be logged in to write a review.</p>
          <a href="<?php echo $baseUrl ?>?page=login" class="btn btn-mm-primary w-100 mb-2">Login</a>
          <a href="<?php echo $baseUrl ?>?page=register" class="btn btn-mm-ghost w-100">Sign Up</a>
        <?php elseif($myReview): ?>
          <h5 style="font-family:'Bebas Neue',sans-serif;letter-spacing:1px">✅ YOUR REVIEW</h5>
          <div class="mb-2"><?php echo renderStars($myReview->rating) ?> <strong class="text-accent"><?php echo $myReview->rating ?>/5</strong></div>
          <?php if($myReview->comment): ?><p class="text-muted-mm" style="font-size:.9rem"><?php echo nl2br(htmlspecialchars($myReview->comment)) ?></p><?php endif; ?>
          <div class="d-flex gap-2 mt-2">
            <a href="<?php echo $baseUrl ?>?page=review/edit&id=<?php echo $myReview->id ?>" class="btn btn-mm-ghost btn-sm"><i class="bi bi-pencil me-1"></i>Edit</a>
            <a href="<?php echo $baseUrl ?>?page=review/delete&id=<?php echo $myReview->id ?>" class="btn btn-mm-danger btn-sm confirm-delete"><i class="bi bi-trash me-1"></i>Delete</a>
          </div>
        <?php else: ?>
          <h5 style="font-family:'Bebas Neue',sans-serif;letter-spacing:1px">✍️ WRITE A REVIEW</h5>
          <?php if(isset($_GET['review_error'])): ?><div class="alert alert-danger py-2 mb-2" style="font-size:.85rem"><?php echo htmlspecialchars($_GET['review_error']) ?></div><?php endif; ?>
          <form method="POST" action="<?php echo $baseUrl ?>?page=review/create">
            <input type="hidden" name="movie_id" value="<?php echo $movie->id ?>">
            <div class="mb-3">
              <label class="form-label">Your Rating</label>
              <div class="star-picker">
                <?php for($i=5;$i>=1;$i--): ?>
                  <input type="radio" name="rating" id="star<?php echo $i ?>" value="<?php echo $i ?>" required>
                  <label for="star<?php echo $i ?>" title="<?php echo $i ?> stars"><i class="bi bi-star-fill"></i></label>
                <?php endfor; ?>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Comment (optional)</label>
              <textarea class="form-control" name="comment" rows="3" placeholder="Share your thoughts..."></textarea>
            </div>
            <button type="submit" class="btn btn-mm-primary w-100"><i class="bi bi-send me-1"></i>Post Review</button>
          </form>
        <?php endif; ?>
      </div>
    </div>

    <!-- Reviews List -->
    <div class="col-lg-8">
      <div class="section-title">REVIEWS (<?php echo $movie->review_count ?>)</div>
      <?php if($movie->review_count == 0): ?>
        <div class="empty-state"><div class="empty-icon">⭐</div><p>No reviews yet. Be the first to review!</p></div>
      <?php else: ?>
        <?php while($rv = $reviews->fetch_object()): ?>
          <div class="review-card">
            <div class="d-flex justify-content-between align-items-start">
              <div class="d-flex align-items-center gap-2">
                <div class="review-avatar"><?php echo strtoupper(substr($rv->user_name,0,1)) ?></div>
                <div>
                  <div style="font-weight:600;font-size:.9rem"><?php echo htmlspecialchars($rv->user_name) ?> <span class="text-muted-mm" style="font-size:.8rem">@<?php echo htmlspecialchars($rv->username) ?></span></div>
                  <div class="text-muted-mm" style="font-size:.75rem"><?php echo date('M d, Y', strtotime($rv->created_at)) ?></div>
                </div>
              </div>
              <div class="d-flex align-items-center gap-2">
                <span class="stars-sm"><?php echo renderStars($rv->rating) ?></span>
                <?php if($user && ($user->id==$rv->user_id || $isAdmin)): ?>
                  <div class="d-flex gap-1">
                    <?php if($user->id==$rv->user_id): ?><a href="<?php echo $baseUrl ?>?page=review/edit&id=<?php echo $rv->id ?>" class="btn btn-mm-ghost btn-sm py-0 px-2"><i class="bi bi-pencil"></i></a><?php endif; ?>
                    <a href="<?php echo $baseUrl ?>?page=review/delete&id=<?php echo $rv->id ?>" class="btn btn-mm-danger btn-sm py-0 px-2 confirm-delete"><i class="bi bi-trash"></i></a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            <?php if($rv->comment): ?><p class="text-muted-mm mt-2 mb-0" style="font-size:.9rem;line-height:1.6"><?php echo nl2br(htmlspecialchars($rv->comment)) ?></p><?php endif; ?>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>
</div>
