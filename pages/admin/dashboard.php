<?php $pageTitle='Admin Dashboard'; ?>
<div class="admin-bar">
  <span class="badge-admin">Admin</span>
  <span class="text-muted-mm">Welcome back, <?php echo htmlspecialchars($user->name) ?></span>
</div>

<div class="container my-4">
  <div class="section-title">ADMIN DASHBOARD</div>

  <!-- Stats -->
  <div class="row g-3 mb-4">
    <?php
    $stats=[
      ['icon'=>'🎬','label'=>'Total Movies','num'=>countMovies(),'link'=>'admin/movies','color'=>'var(--accent)'],
      ['icon'=>'👤','label'=>'Total Users','num'=>(function(){global $db;return $db->query("SELECT COUNT(*) AS c FROM users WHERE role='user'")->fetch_object()->c;})(),'link'=>'admin/users','color'=>'#4ac57e'],
      ['icon'=>'⭐','label'=>'Total Reviews','num'=>countReviews(),'link'=>'admin/reviews','color'=>'#7e6ff7'],
    ];
    foreach($stats as $s): ?>
      <div class="col-md-4">
        <a href="<?php echo $baseUrl ?>?page=<?php echo $s['link'] ?>" class="stat-card d-block text-decoration-none">
          <div style="font-size:2rem;margin-bottom:.25rem"><?php echo $s['icon'] ?></div>
          <div class="stat-num" style="color:<?php echo $s['color'] ?>"><?php echo $s['num'] ?></div>
          <div class="stat-label"><?php echo $s['label'] ?></div>
        </a>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Quick nav -->
  <div class="row g-3">
    <?php $links=[
      ['page'=>'admin/movies','icon'=>'bi-film','label'=>'Manage Movies','desc'=>'Add, edit and delete movies'],
      ['page'=>'admin/users','icon'=>'bi-people','label'=>'Manage Users','desc'=>'View and manage user accounts'],
      ['page'=>'admin/reviews','icon'=>'bi-star','label'=>'Manage Reviews','desc'=>'Moderate all user reviews'],
      ['page'=>'admin/movie/create','icon'=>'bi-plus-circle','label'=>'Add New Movie','desc'=>'Add a movie to the database'],
    ];
    foreach($links as $l): ?>
      <div class="col-sm-6 col-lg-3">
        <a href="<?php echo $baseUrl ?>?page=<?php echo $l['page'] ?>" class="mm-card d-block text-decoration-none h-100 text-center p-3">
          <i class="bi <?php echo $l['icon'] ?>" style="font-size:1.8rem;color:var(--accent)"></i>
          <div style="font-weight:700;margin-top:.5rem"><?php echo $l['label'] ?></div>
          <div class="text-muted-mm" style="font-size:.8rem"><?php echo $l['desc'] ?></div>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</div>
