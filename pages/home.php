<?php
$search      = isset($_GET['search']) ? trim($_GET['search']) : '';
$genreFilter = isset($_GET['genre'])  ? trim($_GET['genre'])  : '';
$genres      = getGenres();
$movies      = getMovies($search, $genreFilter);

function genreClass($g){$m=['Action'=>'Action','Sci-Fi'=>'Sci-Fi','Drama'=>'Drama','Thriller'=>'Thriller','Horror'=>'Horror','Comedy'=>'Comedy','Romance'=>'Romance','Animation'=>'Animation'];return 'genre-colors-'.(isset($m[$g])?$m[$g]:'default');}
function genreEmoji($g){$m=['Action'=>'⚡','Sci-Fi'=>'🚀','Drama'=>'🎭','Thriller'=>'🔪','Horror'=>'👻','Comedy'=>'😂','Romance'=>'❤️','Animation'=>'✨','Documentary'=>'📹'];return $m[$g]??'🎬';}
?>
<div class="hero-section">
  <div class="container">
    <h1>DISCOVER &amp;<br><span>REVIEW</span> MOVIES</h1>
    <p class="mt-2 mb-4">Share your thoughts. Explore what others are watching.</p>
    <div class="d-flex flex-wrap justify-content-center gap-2">
      <a href="<?php echo $baseUrl ?>" class="btn genre-pill <?php echo ($genreFilter===''&&$search==='') ? 'active':'' ?>">All</a>
      <?php foreach($genres as $g): ?>
        <a href="<?php echo $baseUrl ?>?genre=<?php echo urlencode($g) ?>" class="btn genre-pill <?php echo $genreFilter===$g?'active':'' ?>"><?php echo genreEmoji($g).' '.htmlspecialchars($g) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<div class="container my-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <div class="section-title mb-0">
      <?php if($search): ?>RESULTS FOR "<?php echo strtoupper(htmlspecialchars($search)) ?>"
      <?php elseif($genreFilter): ?><?php echo strtoupper(htmlspecialchars($genreFilter)) ?> MOVIES
      <?php else: ?>ALL MOVIES<?php endif; ?>
    </div>
    <span class="text-muted-mm" style="font-size:.85rem"><?php echo $movies->num_rows ?> movie<?php echo $movies->num_rows!=1?'s':'' ?></span>
  </div>
  <?php if($movies->num_rows===0): ?>
    <div class="empty-state"><div class="empty-icon">🎬</div><p>No movies found. <?php if($search||$genreFilter): ?><a href="<?php echo $baseUrl ?>" class="text-accent">Clear filter</a><?php endif; ?></p></div>
  <?php else: ?>
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-xl-5 g-3">
      <?php while($m=$movies->fetch_object()): ?>
        <div class="col">
          <a href="<?php echo $baseUrl ?>?page=movie&id=<?php echo $m->id ?>" class="movie-card h-100">
            <div class="movie-poster <?php echo genreClass($m->genre) ?>">
              <?php if($m->image && file_exists($m->image)): ?><img src="<?php echo htmlspecialchars($m->image) ?>" alt="">
              <?php else: ?><div class="poster-placeholder"><?php echo genreEmoji($m->genre) ?></div><?php endif; ?>
              <?php if($m->genre): ?><span class="genre-badge"><?php echo htmlspecialchars($m->genre) ?></span><?php endif; ?>
            </div>
            <div class="card-body-inner">
              <div class="movie-title-card"><?php echo htmlspecialchars($m->title) ?></div>
              <div class="movie-year"><?php echo $m->release_date ? date('Y',strtotime($m->release_date)) : '' ?></div>
              <div class="d-flex align-items-center gap-1 mt-1 stars-sm">
                <?php if($m->avg_rating): ?><?php echo renderStars(round($m->avg_rating)) ?>
                  <span class="text-accent ms-1" style="font-size:.8rem;font-weight:700"><?php echo $m->avg_rating ?></span>
                  <span class="text-muted-mm" style="font-size:.75rem">(<?php echo $m->review_count ?>)</span>
                <?php else: ?><span class="text-muted-mm" style="font-size:.75rem">No reviews yet</span><?php endif; ?>
              </div>
            </div>
          </a>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</div>
