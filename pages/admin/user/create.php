<?php
$pageTitle='Create User';
$nameErr=$usernameErr=$emailErr=$passwdErr='';
$name=$username=$email='';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $name    =trim($_POST['name']??'');
    $username=trim($_POST['username']??'');
    $email   =trim($_POST['email']??'');
    $passwd  =trim($_POST['passwd']??'');
    $photo   =$_FILES['photo']??['name'=>''];
    if(empty($name))    $nameErr    ='Name is required.';
    if(empty($username))$usernameErr='Username is required.';
    if(empty($email))   $emailErr   ='Email is required.';
    if(empty($passwd))  $passwdErr  ='Password is required.';
    if(!empty($username)&&usernameExists($username))$usernameErr='Username already taken.';
    if(!empty($email)&&emailExists($email))$emailErr='Email already in use.';
    if(empty($nameErr)&&empty($usernameErr)&&empty($emailErr)&&empty($passwdErr)){
        try{
            if(createUserAdmin($name,$username,$email,$passwd,$photo)){
                header('Location: '.$baseUrl.'?page=admin/users&success=1');exit();
            }else{$nameErr='Failed to create user.';}
        }catch(Exception $e){$nameErr=$e->getMessage();}
    }
}
?>
<div class="admin-bar"><span class="badge-admin">Admin</span><span class="text-muted-mm">Create User</span></div>
<div class="container my-4" style="max-width:560px">
  <a href="<?php echo $baseUrl ?>?page=admin/users" class="btn btn-mm-ghost btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Back to Users</a>
  <div class="mm-card">
    <h4 style="font-family:'Bebas Neue',sans-serif;letter-spacing:2px" class="mb-4">➕ CREATE USER</h4>
    <form method="POST" enctype="multipart/form-data">
      <div class="text-center mb-3">
        <label for="photoUpload" role="button">
          <img id="previewImg" src="./assets/images/image.png" class="rounded-circle" style="width:80px;height:80px;object-fit:cover;border:3px solid var(--accent)">
        </label><br><small class="text-muted-mm">Click to upload photo</small>
        <input type="file" name="photo" id="photoUpload" class="d-none" accept="image/*">
      </div>
      <div class="mb-3">
        <label class="form-label">Full Name *</label>
        <input class="form-control <?php echo $nameErr?'is-invalid':'' ?>" name="name" value="<?php echo htmlspecialchars($name) ?>">
        <?php if($nameErr):?><div class="invalid-feedback"><?php echo $nameErr ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Username *</label>
        <input class="form-control <?php echo $usernameErr?'is-invalid':'' ?>" name="username" value="<?php echo htmlspecialchars($username) ?>">
        <?php if($usernameErr):?><div class="invalid-feedback"><?php echo $usernameErr ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Email *</label>
        <input type="email" class="form-control <?php echo $emailErr?'is-invalid':'' ?>" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <?php if($emailErr):?><div class="invalid-feedback"><?php echo $emailErr ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Password *</label>
        <input type="password" class="form-control <?php echo $passwdErr?'is-invalid':'' ?>" name="passwd">
        <?php if($passwdErr):?><div class="invalid-feedback"><?php echo $passwdErr ?></div><?php endif; ?>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-mm-primary flex-grow-1">Create User</button>
        <a href="<?php echo $baseUrl ?>?page=admin/users" class="btn btn-mm-ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>
<script>
document.getElementById('photoUpload').addEventListener('change',function(){
    const f=this.files[0]; if(!f)return;
    const r=new FileReader(); r.onload=e=>document.getElementById('previewImg').src=e.target.result; r.readAsDataURL(f);
});
</script>
