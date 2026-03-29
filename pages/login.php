<?php
$pageTitle = 'Login';
$usernameErr = $passwdErr = '';
$username = '';

if (isset($_POST['username'], $_POST['passwd'])) {
    $username = trim($_POST['username']);
    $passwd   = trim($_POST['passwd']);
    if (empty($username)) $usernameErr = 'Username is required.';
    if (empty($passwd))   $passwdErr   = 'Password is required.';
    if (empty($usernameErr) && empty($passwdErr)) {
        $loggedUser = loginUser($username, $passwd);
        if ($loggedUser) {
            $_SESSION['user_id'] = $loggedUser->id;
            header('Location: '.$baseUrl.'?page=dashboard'); exit();
        } else {
            $usernameErr = 'Invalid username or password.';
        }
    }
}
?>
<div class="container" style="max-width:440px;margin-top:4rem">
  <div class="mm-card">
    <h2 style="font-family:'Bebas Neue',sans-serif;letter-spacing:3px;font-size:2rem" class="mb-1">SIGN IN</h2>
    <p class="text-muted-mm mb-4" style="font-size:.875rem">Welcome back to MoveMovie</p>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <div class="input-group">
          <span class="input-group-text bg-surface border-mm text-muted-mm"><i class="bi bi-person-fill"></i></span>
          <input class="form-control <?php echo $usernameErr?'is-invalid':'' ?>" name="username" value="<?php echo htmlspecialchars($username) ?>" placeholder="Enter username" autofocus>
          <?php if($usernameErr): ?><div class="invalid-feedback"><?php echo $usernameErr ?></div><?php endif; ?>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text bg-surface border-mm text-muted-mm"><i class="bi bi-lock-fill"></i></span>
          <input class="form-control <?php echo $passwdErr?'is-invalid':'' ?>" type="password" name="passwd" id="passwd" placeholder="Enter password">
          <?php if($passwdErr): ?><div class="invalid-feedback"><?php echo $passwdErr ?></div><?php endif; ?>
        </div>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input show-password-toggle" id="showPass" data-target="#passwd">
        <label class="form-check-label text-muted-mm" for="showPass" style="font-size:.85rem">Show password</label>
      </div>
      <button type="submit" class="btn btn-mm-primary w-100 py-2">Login</button>
    </form>

    <div class="text-center mt-3 text-muted-mm" style="font-size:.875rem">
      Don't have an account? <a href="<?php echo $baseUrl ?>?page=register" class="text-accent">Sign up</a>
    </div>
    <hr>
    <div class="text-center text-muted-mm" style="font-size:.78rem">
      Demo — Admin: <strong class="text-accent">admin / admin123</strong> &nbsp;|&nbsp; User: <strong class="text-accent">john / john123</strong>
    </div>
  </div>
</div>
