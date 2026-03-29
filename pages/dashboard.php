<?php
$pageTitle  = 'My Dashboard';
$myReviews  = getUserReviews($user->id);
$totalCount = $myReviews->num_rows;
function genreEmoji($g){$m=['Action'=>'⚡','Sci-Fi'=>'🚀','Drama'=>'🎭','Thriller'=>'🔪','Horror'=>'👻','Comedy'=>'😂','Romance'=>'❤️','Animation'=>'✨','Documentary'=>'📹'];return $m[$g]??'🎬';}
?>
<div class="user-header-bar">
  <div class="container d-flex align-items-center gap-3">
    <div class="user-avatar user-avatar-lg"><?php echo strtoupper(substr($user->name,0,1)) ?></div>
    <div>
      <div style="font-family:'Bebas Neue',sans-serif;font-size:1.6rem;letter-spacing:2px">HELLO, <?php echo strtoupper(htmlspecialchars($user->name)) ?></div>
      <div class="text-muted-mm" style="font-size:.875rem">@<?php echo htmlspecialchars($user->username) ?> &nbsp;·&nbsp; <?php echo htmlspecialchars($user->email) ?></div>
    </div>
    <a href="<?php echo $baseUrl ?>?page=profile" class="btn btn-mm-ghost btn-sm ms-auto"><i class="bi bi-gear me-1"></i>Settings</a>
  </div>
</div>

<div class="container my-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <div class="section-title mb-0">MY REVIEWS (<?php echo $totalCount ?>)</div>
    <a href="<?php echo $baseUrl ?>" class="btn btn-mm-primary btn-sm"><i class="bi bi-plus me-1"></i>Browse Movies</a>
  </div>

  <?php if($totalCount===0): ?>
    <div class="empty-state"><div class="empty-icon">🎬</div><p>You haven't reviewed any movies yet.<br><a href="<?php echo $baseUrl ?>" class="text-accent">Browse movies</a> and share your thoughts!</p></div>
  <?php else: ?>
    <?php while($rv=$myReviews->fetch_object()): ?>
      <div class="mm-card mb-3 d-flex gap-3 align-items-start p-3">
        <div style="width:52px;height:70px;border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:1.8rem;background:var(--surface)">
          <?php echo genreEmoji($rv->genre) ?>
        </div>
        <div class="flex-grow-1">
          <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
              <a href="<?php echo $baseUrl ?>?page=movie&id=<?php echo $rv->movie_id ?>" style="font-weight:700;color:var(--text);text-decoration:none"><?php echo htmlspecialchars($rv->movie_title) ?></a>
              <div class="d-flex align-items-center gap-2 mt-1 stars-sm">
                <?php echo renderStars($rv->rating) ?>
                <span class="text-muted-mm" style="font-size:.75rem"><?php echo date('M d, Y',strtotime($rv->created_at)) ?></span>
              </div>
            </div>
            <div class="d-flex gap-2">
              <a href="<?php echo $baseUrl ?>?page=review/edit&id=<?php echo $rv->id ?>" class="btn btn-mm-ghost btn-sm"><i class="bi bi-pencil"></i></a>
              <a href="<?php echo $baseUrl ?>?page=review/delete&id=<?php echo $rv->id ?>" class="btn btn-mm-danger btn-sm confirm-delete"><i class="bi bi-trash"></i></a>
            </div>
          </div>
          <?php if($rv->comment): ?><p class="text-muted-mm mt-2 mb-0" style="font-size:.875rem"><?php echo nl2br(htmlspecialchars($rv->comment)) ?></p><?php endif; ?>
        </div>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>
