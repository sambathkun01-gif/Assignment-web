<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="<?php echo $baseUrl ?>">MOVE<span>REVIEW</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <!-- Search -->
      <form class="d-flex ms-auto me-3 mt-2 mt-lg-0" action="<?php echo $baseUrl ?>" method="GET">
        <input class="form-control search-box me-2" name="search" placeholder="🔍 Search movies..."
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" style="width:200px">
        <button class="btn btn-mm-primary btn-sm" type="submit">Search</button>
      </form>
      <ul class="navbar-nav align-items-center gap-1">
        <li class="nav-item">
          <a class="nav-link <?php echo (!isset($_GET['page'])||$_GET['page']==='') ? 'active':'' ?>" href="<?php echo $baseUrl ?>"><i class="bi bi-house-door-fill"></i>Home</a>
        </li>
        <?php if($isAdmin): ?>
          <li class="nav-item">
            <a class="nav-link <?php echo (isset($_GET['page'])&&strpos($_GET['page'],'admin')===0)?'active':'' ?>" href="<?php echo $baseUrl ?>?page=admin/dashboard"><i class="bi bi-person-fill"></i>Admin</a>
          </li>
        <?php endif; ?>
        <?php if($user): ?>
          <li class="nav-item">
            <a class="nav-link <?php echo (isset($_GET['page'])&&$_GET['page']==='dashboard')?'active':'' ?>" href="<?php echo $baseUrl ?>?page=dashboard"><i class="bi bi-yelp"></i>MyReview</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
              <span class="user-avatar"><?php echo strtoupper(substr($user->name,0,1)); ?></span>
              <?php echo htmlspecialchars($user->name); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?php echo $baseUrl ?>?page=profile"><i class="bi bi-person me-2"></i>Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="<?php echo $baseUrl ?>?page=logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl ?>?page=login"><i class="bi bi-door-open-fill"></i>Login</a></li>
          <li class="nav-item ms-1"><a class="btn btn-mm-primary btn-sm" href="<?php echo $baseUrl ?>?page=register">Sign Up</a></li>
        <?php endif; ?>

        <!-- Theme Toggle Button -->
        <li class="nav-item ms-2">
          <button class="theme-toggle" id="themeToggle" title="Toggle light/dark mode">
            <i class="bi bi-sun-fill" id="themeIcon"></i>
            <span id="themeLabel">Light</span>
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>
