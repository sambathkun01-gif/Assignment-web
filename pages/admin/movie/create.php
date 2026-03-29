<?php
$pageTitle='Add Movie';
$titleErr=$genreErr='';
$title=$desc=$genre=$release_date='';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $title       =trim($_POST['title']??'');
    $desc        =trim($_POST['description']??'');
    $genre       =trim($_POST['genre']??'');
    $release_date=trim($_POST['release_date']??'');
    $image       =$_FILES['image']??['name'=>''];
    if(empty($title))$titleErr='Title is required.';
    if(empty($titleErr)){
        try{
            if(createMovie($title,$desc,$genre,$release_date,$image)){
                header('Location: '.$baseUrl.'?page=admin/movies&success=1');exit();
            } else { $titleErr='Failed to add movie.'; }
        }catch(Exception $e){ $titleErr=$e->getMessage(); }
    }
}
$genres=['Action','Comedy','Drama','Horror','Sci-Fi','Thriller','Romance','Animation','Documentary'];
?>
<div class="admin-bar"><span class="badge-admin">Admin</span><span class="text-muted-mm">Add New Movie</span></div>
<div class="container my-4" style="max-width:680px">
  <a href="<?php echo $baseUrl ?>?page=admin/movies" class="btn btn-mm-ghost btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Back to Movies</a>
  <div class="mm-card">
    <h4 style="font-family:'Bebas Neue',sans-serif;letter-spacing:2px" class="mb-4">➕ ADD NEW MOVIE</h4>
    <?php if($titleErr):?><div class="alert alert-danger py-2"><?php echo $titleErr ?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
      <div class="row g-3 mb-3">
        <div class="col-12">
          <label class="form-label">Movie Title *</label>
          <input class="form-control" name="title" value="<?php echo htmlspecialchars($title) ?>" placeholder="e.g. Inception" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Genre</label>
          <select class="form-select" name="genre">
            <option value="">Select genre...</option>
            <?php foreach($genres as $g): ?><option value="<?php echo $g ?>" <?php echo $genre===$g?'selected':'' ?>><?php echo $g ?></option><?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Release Date</label>
          <input type="date" class="form-control" name="release_date" value="<?php echo $release_date ?>">
        </div>
        <div class="col-12">
          <label class="form-label">Description</label>
          <textarea class="form-control" name="description" rows="4" placeholder="Movie description..."><?php echo htmlspecialchars($desc) ?></textarea>
        </div>
        <div class="col-12">
          <label class="form-label">Poster Image</label>
          <div class="text-center mb-2">
            <img id="posterPreview" src="./assets/images/image.png" style="width:120px;height:170px;object-fit:cover;border-radius:8px;border:2px solid var(--border)">
          </div>
          <input type="file" class="form-control" name="image" id="imageInput" accept="image/*">
          <div class="form-text text-muted-mm">JPG/PNG, max 2MB</div>
        </div>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-mm-primary flex-grow-1"><i class="bi bi-plus-circle me-1"></i>Add Movie</button>
        <a href="<?php echo $baseUrl ?>?page=admin/movies" class="btn btn-mm-ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>
<script>
document.getElementById('imageInput').addEventListener('change',function(){
    const f=this.files[0]; if(!f)return;
    const r=new FileReader(); r.onload=e=>document.getElementById('posterPreview').src=e.target.result; r.readAsDataURL(f);
});
</script>
