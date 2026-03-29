<?php $pageTitle='Manage Movies'; $movies=getAllMovies(); ?>
<div class="admin-bar"><span class="badge-admin">Admin</span><span class="text-muted-mm">Movies Management</span></div>
<div class="container my-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <div class="section-title mb-0">🎬 MOVIES</div>
    <a href="<?php echo $baseUrl ?>?page=admin/movie/create" class="btn btn-mm-primary btn-sm"><i class="bi bi-plus me-1"></i>Add Movie</a>
  </div>
  <div class="mm-table">
    <table class="table table-hover mb-0">
      <thead><tr><th>#</th><th>Poster</th><th>Title</th><th>Genre</th><th>Year</th><th>Avg Rating</th><th>Reviews</th><th>Actions</th></tr></thead>
      <tbody>
        <?php $i=1; while($m=$movies->fetch_object()): ?>
          <tr>
            <td class="text-muted-mm"><?php echo $i++ ?></td>
            <td>
              <?php if($m->image&&file_exists($m->image)): ?>
                <img src="<?php echo htmlspecialchars($m->image) ?>" style="width:40px;height:55px;object-fit:cover;border-radius:4px">
              <?php else: ?><span style="font-size:1.5rem">🎬</span><?php endif; ?>
            </td>
            <td><strong><?php echo htmlspecialchars($m->title) ?></strong></td>
            <td><?php echo htmlspecialchars($m->genre??'—') ?></td>
            <td><?php echo $m->release_date?date('Y',strtotime($m->release_date)):'—' ?></td>
            <td><?php echo $m->avg_rating?'<span class="text-accent">'.$m->avg_rating.'</span>':'<span class="text-muted-mm">—</span>' ?></td>
            <td><?php echo $m->review_count ?></td>
            <td>
              <div class="d-flex gap-1">
                <a href="<?php echo $baseUrl ?>?page=movie&id=<?php echo $m->id ?>" class="btn btn-mm-dark btn-sm" title="View"><i class="bi bi-eye"></i></a>
                <a href="<?php echo $baseUrl ?>?page=admin/movie/edit&id=<?php echo $m->id ?>" class="btn btn-mm-ghost btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                <a href="<?php echo $baseUrl ?>?page=admin/movie/delete&id=<?php echo $m->id ?>" class="btn btn-mm-danger btn-sm confirm-delete" data-msg="This will delete the movie and ALL its reviews!" title="Delete"><i class="bi bi-trash"></i></a>
              </div>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php if($movies->num_rows===0): ?><div class="empty-state py-4"><div class="empty-icon">🎬</div><p>No movies yet.</p></div><?php endif; ?>
  </div>
</div>
