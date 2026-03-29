<?php $pageTitle='Manage Users'; $users=getUsers(); ?>
<div class="admin-bar"><span class="badge-admin">Admin</span><span class="text-muted-mm">Users Management</span></div>
<div class="container my-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <div class="section-title mb-0">👤 USERS</div>
    <a href="<?php echo $baseUrl ?>?page=admin/user/create" class="btn btn-mm-primary btn-sm"><i class="bi bi-plus me-1"></i>Add User</a>
  </div>
  <?php if(isset($_GET['success'])):?><div class="alert alert-success py-2 mb-3">User created successfully!</div><?php endif; ?>
  <div class="mm-table">
    <table class="table table-hover mb-0">
      <thead><tr><th>#</th><th>Photo</th><th>Name</th><th>Username</th><th>Email</th><th>Role</th><th>Reviews</th><th>Actions</th></tr></thead>
      <tbody>
        <?php $i=1; while($u=$users->fetch_object()):
            global $db;
            $rCount=$db->query("SELECT COUNT(*) AS c FROM reviews WHERE user_id=$u->id")->fetch_object()->c;
        ?>
          <tr>
            <td class="text-muted-mm"><?php echo $i++ ?></td>
            <td><?php $photo=($u->photo&&file_exists($u->photo))?$u->photo:'./assets/images/image.png'; ?>
              <img src="<?php echo htmlspecialchars($photo) ?>" class="rounded-circle" style="width:36px;height:36px;object-fit:cover"></td>
            <td><strong><?php echo htmlspecialchars($u->name) ?></strong></td>
            <td class="text-muted-mm">@<?php echo htmlspecialchars($u->username) ?></td>
            <td><?php echo htmlspecialchars($u->email) ?></td>
            <td><span class="badge" style="background:rgba(232,184,75,.15);color:var(--accent)"><?php echo $u->role ?></span></td>
            <td><?php echo $rCount ?></td>
            <td><div class="d-flex gap-1">
              <a href="<?php echo $baseUrl ?>?page=admin/user/edit&id=<?php echo $u->id ?>" class="btn btn-mm-ghost btn-sm"><i class="bi bi-pencil"></i></a>
              <a href="<?php echo $baseUrl ?>?page=admin/user/delete&id=<?php echo $u->id ?>" class="btn btn-mm-danger btn-sm confirm-delete" data-msg="This will delete the user and all their reviews!"><i class="bi bi-trash"></i></a>
            </div></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php if($users->num_rows===0):?><div class="empty-state py-4"><div class="empty-icon">👤</div><p>No users yet.</p></div><?php endif; ?>
  </div>
</div>
