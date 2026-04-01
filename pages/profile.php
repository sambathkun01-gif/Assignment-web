<?php
$pageTitle = 'Profile';
$nameErr=$usernameErr=$emailErr=$oldPasswdErr=$newPasswdErr='';
$name=$user->name; $username=$user->username; $email=$user->email;
$infoSuccess=$passSuccess=false;

// Update profile info
if(isset($_POST['updateInfo'])){
    $name=trim($_POST['name']); $username=trim($_POST['username']); $email=trim($_POST['email']);
    if(empty($name))$nameErr='Name is required.';
    if(empty($username))$usernameErr='Username is required.';
    if(empty($email))$emailErr='Email is required.';
    if($user->username!==$username && usernameExists($username))$usernameErr='Username already taken.';
    if($user->email!==$email && emailExists($email))$emailErr='Email already in use.';
    if(empty($nameErr)&&empty($usernameErr)&&empty($emailErr)){
        $photo=$_FILES['photo']??null;
        if(updateUser($user->id,$name,$username,$email,'',$photo)){
            $infoSuccess=true; $user=loggedInUser();
        }
    }
}

// Change password
if(isset($_POST['changePasswd'])){
    $old=trim($_POST['oldPasswd']); $new=trim($_POST['newPasswd']); $confirm=trim($_POST['confirmPasswd']);
    if(empty($old))$oldPasswdErr='Enter your current password.';
    if(empty($new)||strlen($new)<6)$newPasswdErr='New password must be at least 6 characters.';
    if($new!==$confirm)$newPasswdErr='Passwords do not match.';
    if(!empty($old)&&!isUserHasPassword($old))$oldPasswdErr='Current password is incorrect.';
    if(empty($oldPasswdErr)&&empty($newPasswdErr)){
        setUserNewPassword($new);
        $passSuccess=true;
    }
}

$photo=$user->photo&&file_exists($user->photo)?$user->photo:'./assets/images/image.png';
?>
<div class="container my-4" style="max-width:860px">
  <div class="section-title">PROFILE SETTINGS</div>

  <div class="row g-4">
    <!-- Avatar & Info -->
    <div class="col-lg-6">
      <div class="mm-card">
        <h5 style="font-family:'Bebas Neue',sans-serif;letter-spacing:1px" class="mb-3">ACCOUNT INFO</h5>
        <?php if($infoSuccess):?><div class="alert alert-success py-2">Profile updated!</div><?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
          <div class="text-center mb-3">
            <label for="photoUpload" role="button" title="Click to change photo">
              <img src="<?php echo htmlspecialchars($photo) ?>" id="previewImg" class="rounded-circle" style="width:90px;height:90px;object-fit:cover;border:3px solid var(--accent)">
            </label><br>
            <small class="text-muted-mm">Click photo to change</small>
            <input type="file" name="photo" id="photoUpload" class="d-none" accept="image/*">
          </div>
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input class="form-control <?php echo $nameErr?'is-invalid':'' ?>" name="name" value="<?php echo htmlspecialchars($name) ?>">
            <?php if($nameErr):?><div class="invalid-feedback"><?php echo $nameErr ?></div><?php endif; ?>
          </div>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group"><span class="input-group-text bg-surface border-mm text-muted-mm">@</span>
            <input class="form-control <?php echo $usernameErr?'is-invalid':'' ?>" name="username" value="<?php echo htmlspecialchars($username) ?>">
            <?php if($usernameErr):?><div class="invalid-feedback"><?php echo $usernameErr ?></div><?php endif; ?>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control <?php echo $emailErr?'is-invalid':'' ?>" name="email" value="<?php echo htmlspecialchars($email) ?>">
            <?php if($emailErr):?><div class="invalid-feedback"><?php echo $emailErr ?></div><?php endif; ?>
          </div>
          <button type="submit" name="updateInfo" class="btn btn-mm-primary w-100">Save Changes</button>
        </form>
      </div>
    </div>
    <!-- Change Password -->
    <div class="col-lg-6">
      <div class="mm-card">
        <h5 style="font-family:'Bebas Neue',sans-serif;letter-spacing:1px" class="mb-3">CHANGE PASSWORD</h5>
        <?php if($passSuccess):?><div class="alert alert-success py-2">Password changed!</div><?php endif; ?>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" class="form-control <?php echo $oldPasswdErr?'is-invalid':'' ?>" name="oldPasswd">
            <?php if($oldPasswdErr):?><div class="invalid-feedback"><?php echo $oldPasswdErr ?></div><?php endif; ?>
          </div>
          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" class="form-control <?php echo $newPasswdErr?'is-invalid':'' ?>" name="newPasswd" id="newPass">
            <?php if($newPasswdErr):?><div class="invalid-feedback"><?php echo $newPasswdErr ?></div><?php endif; ?>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" name="confirmPasswd">
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input show-password-toggle" id="showNew" data-target="#newPass">
            <label class="form-check-label text-muted-mm" for="showNew" style="font-size:.85rem">Show password</label>
          </div>
          <button type="submit" name="changePasswd" class="btn btn-mm-primary w-100">Update Password</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
document.getElementById('photoUpload').addEventListener('change',function(){
    const f=this.files[0]; if(!f)return;
    const r=new FileReader(); r.onload=e=>document.getElementById('previewImg').src=e.target.result; r.readAsDataURL(f);
});
</script>
