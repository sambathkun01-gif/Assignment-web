<?php $pageTitle='Manage Reviews'; $reviews=getAllReviews(); ?>
<div class="admin-bar"><span class="badge-admin">Admin</span><span class="text-muted-mm">Reviews Management</span></div>
<div class="container my-4">
  <div class="section-title">⭐ ALL REVIEWS</div>
  <div class="mm-table">
    <table class="table table-hover mb-0">
      <thead><tr><th>#</th><th>User</th><th>Movie</th><th>Rating</th><th>Comment</th><th>Date</th><th>Actions</th></tr></thead>
      <tbody>
        <?php $i=1; while($rv=$reviews->fetch_object()): ?>
          <tr>
            <td class="text-muted-mm"><?php echo $i++ ?></td>
            <td><strong>@<?php echo htmlspecialchars($rv->username) ?></strong></td>
            <td><a href="<?php echo $baseUrl ?>?page=movie&id=<?php echo $rv->movie_id ?>" class="text-accent text-decoration-none"><?php echo htmlspecialchars($rv->movie_title) ?></a></td>
            <td class="stars-sm"><?php echo renderStars($rv->rating) ?></td>
            <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:var(--muted)"><?php echo htmlspecialchars($rv->comment??'—') ?></td>
            <td class="text-muted-mm" style="font-size:.8rem;white-space:nowrap"><?php echo date('M d, Y',strtotime($rv->created_at)) ?></td>
            <td><a href="<?php echo $baseUrl ?>?page=review/delete&id=<?php echo $rv->id ?>" class="btn btn-mm-danger btn-sm confirm-delete"><i class="bi bi-trash"></i></a></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php if($reviews->num_rows===0):?><div class="empty-state py-4"><div class="empty-icon">⭐</div><p>No reviews yet.</p></div><?php endif; ?>
  </div>
</div>
