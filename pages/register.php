<?php
$pageTitle = 'Register';
$nameErr = $usernameErr = $emailErr = $passwordErr = '';
$name = $username = $email = '';
$success = false;

if (isset($_POST['name'],$_POST['username'],$_POST['email'],$_POST['password'],$_POST['confirm_password'])) {
    $name     = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);

    if (empty($name))     $nameErr     = 'Name is required.';
    if (empty($username)) $usernameErr = 'Username is required.';
    if (empty($email))    $emailErr    = 'Email is required.';
    if (empty($password)) $passwordErr = 'Password is required.';
    if (strlen($password)<6||strlen($password)>50) $passwordErr='Password must be 6–50 characters.';
    if ($password !== $confirm) $passwordErr = 'Passwords do not match.';
    if (!empty($username) && usernameExists($username)) $usernameErr = 'Username already taken.';
    if (!empty($email) && emailExists($email)) $emailErr = 'Email already in use.';

    if (empty($nameErr)&&empty($usernameErr)&&empty($emailErr)&&empty($passwordErr)) {
        if (registerUser($name, $username, $email, $password)) {
            $success = true; $name=$username=$email='';
        } else {
            $nameErr = 'Registration failed. Please try again.';
        }
    }
}
?>
<div class="container" style="max-width:480px;margin-top:3rem">
  <div class="mm-card">
    <h2 style="font-family:'Bebas Neue',sans-serif;letter-spacing:3px;font-size:2rem" class="mb-1">CREATE ACCOUNT</h2>
    <p class="text-muted-mm mb-4" style="font-size:.875rem">Join the MoveMovie community</p>

    <?php if($success): ?>
      <div class="alert alert-success">🎉 Account created! <a href="<?php echo $baseUrl ?>?page=login" class="alert-link">Login now</a></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input class="form-control <?php echo $nameErr?'is-invalid':'' ?>" name="name" value="<?php echo htmlspecialchars($name) ?>" placeholder="Your full name">
        <?php if($nameErr): ?><div class="invalid-feedback"><?php echo $nameErr ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <div class="input-group">
          <span class="input-group-text bg-surface border-mm text-muted-mm">@</span>
          <input class="form-control <?php echo $usernameErr?'is-invalid':'' ?>" name="username" value="<?php echo htmlspecialchars($username) ?>" placeholder="Choose username">
          <?php if($usernameErr): ?><div class="invalid-feedback"><?php echo $usernameErr ?></div><?php endif; ?>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control <?php echo $emailErr?'is-invalid':'' ?>" name="email" value="<?php echo htmlspecialchars($email) ?>" placeholder="your@email.com">
        <?php if($emailErr): ?><div class="invalid-feedback"><?php echo $emailErr ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control <?php echo $passwordErr?'is-invalid':'' ?>" name="password" id="reg_pass" placeholder="At least 6 characters">
        <?php if($passwordErr): ?><div class="invalid-feedback"><?php echo $passwordErr ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" class="form-control" name="confirm_password" placeholder="Repeat password">
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input show-password-toggle" id="showReg" data-target="#reg_pass">
        <label class="form-check-label text-muted-mm" for="showReg" style="font-size:.85rem">Show password</label>
      </div>
      <button type="submit" class="btn btn-mm-primary w-100 py-2">Create Account</button>
    </form>
    <div class="text-center mt-3 text-muted-mm" style="font-size:.875rem">
      Already have an account? <a href="<?php echo $baseUrl ?>?page=login" class="text-accent">Login</a>
    </div>
  </div>
</div>
