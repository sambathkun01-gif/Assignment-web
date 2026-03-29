<?php
$pageTitle='Edit User';
$target=readUser((int)($_GET['id']??0));
if(!$target){header('Location: '.$baseUrl.'?page=admin/users');exit();}
$nameErr=$usernameErr=$emailErr='';
$name=$target->name; $username=$target->username; $email=$target->email;

if($_SERVER['REQUEST_METHOD']==='POST'){
    $name    =trim($_POST['name']??'');
    $username=trim($_POST['username']??'');
    $email   =trim($_POST['email']??'');
    $passwd  =trim($_POST['passwd']??'');
    $photo   =$_FILES['photo']??['name'=>''];
    if(empty($name))    $nameErr    ='Name is required.';
    if(empty($username))$usernameErr='Username is required.';
    if(empty($email))   $emailErr   ='Email is required.';
    if($target->username!==$username&&usernameExists($username))$usernameErr='Username already taken.';
    if($target->email!==$email&&emailExists($email))$emailErr='Email already in use.';
    if(empty($nameErr)&&empty($usernameErr)&&empty($emailErr)){
        try{
            updateUser($target->id,$name,$username,$email,$passwd,$photo);
            header('Location: '.$baseUrl.'?page=admin/users');exit();
        }catch(Exception $e){$nameErr=$e->getMessage();}
    }
}
$photo=($target->photo&&file_exists($target->photo))?$target->photo:'./assets/images/image.png';
?>
<div class="admin-bar"><span class="badge-admin">Admin</span><span class="text-muted-mm">Edit User</span></div>
<div class="container my-4" style="max-width:560px">
  <a href="<?php echo $baseUrl ?>?page=admin/users" class="btn btn-mm-ghost btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Back</a>
  <div class="mm-card">
    <h4 style="font-family:'Bebas Neue',sans-serif;letter-spacing:2px" class="mb-4">✏️ EDIT USER</h4>
    <form method="POST" enctype="multipart/form-data">
      <div class="text-center mb-3">
        <label for="photoUpload" role="button">
          <img id="previewImg" src="<?php echo htmlspecialchars($photo) ?>" class="rounded-circle" style="width:80px;height:80px;object-fit:cover;border:3px solid var(--accent)">
        </label><br><small class="text-muted-mm">Click to change photo</small>
        <input type="file" name="photo" id="photoUpload" class="d-none" accept="image/*">
      </div>
      <div class="mb-3"><label class="form-label">Full Name *</label>
        <input class="form-control <?php echo $nameErr?'is-invalid':'' ?>" name="name" value="<?php echo htmlspecialchars($name) ?>">
        <?php if($nameErr):?><div class="invalid-feedback"><?php echo $nameErr ?></div><?php endif; ?></div>
      <div class="mb-3"><label class="form-label">Username *</label>
        <input class="form-control <?php echo $usernameErr?'is-invalid':'' ?>" name="username" value="<?php echo htmlspecialchars($username) ?>">
        <?php if($usernameErr):?><div class="invalid-feedback"><?php echo $usernameErr ?></div><?php endif; ?></div>
      <div class="mb-3"><label class="form-label">Email *</label>
        <input type="email" class="form-control <?php echo $emailErr?'is-invalid':'' ?>" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <?php if($emailErr):?><div class="invalid-feedback"><?php echo $emailErr ?></div><?php endif; ?></div>
      <div class="mb-3"><label class="form-label">New Password <span class="text-muted-mm">(leave blank to keep)</span></label>
        <input type="password" class="form-control" name="passwd" placeholder="Leave blank to keep current"></div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-mm-primary flex-grow-1">Save Changes</button>
        <a href="<?php echo $baseUrl ?>?page=admin/users" class="btn btn-mm-ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>
<script>document.getElementById('photoUpload').addEventListener('change',function(){const f=this.files[0];if(!f)return;const r=new FileReader();r.onload=e=>document.getElementById('previewImg').src=e.target.result;r.readAsDataURL(f);});</script>
