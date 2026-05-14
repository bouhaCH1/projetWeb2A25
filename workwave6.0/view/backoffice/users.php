<div class="bg-secondary rounded p-4">
    <h4>Freelancers</h4>
    <div class="table-responsive"><table class="table table-bordered table-hover"><tr><th>Name</th><th>Email</th><th>City</th><th>Status</th><th>Actions</th></tr><?php foreach ($freelancers as $u): ?><tr><td><?= e($u['display_name']) ?></td><td><?= e($u['email']) ?></td><td><?= e($u['city']) ?></td><td><?= e($u['status']) ?></td><td><?= adminUserActions($u) ?></td></tr><?php endforeach; ?></table></div>
</div>
<div class="bg-secondary rounded p-4 mt-4">
    <h4>Companies</h4>
    <div class="table-responsive"><table class="table table-bordered table-hover"><tr><th>Name</th><th>Email</th><th>City</th><th>Status</th><th>Actions</th></tr><?php foreach ($companies as $u): ?><tr><td><?= e($u['display_name']) ?></td><td><?= e($u['email']) ?></td><td><?= e($u['city']) ?></td><td><?= e($u['status']) ?></td><td><?= adminUserActions($u) ?></td></tr><?php endforeach; ?></table></div>
</div>
<?php
function adminUserActions(array $u): string
{
    ob_start(); ?>
    <form method="post" action="<?= routeUrl('admin/status') ?>" class="d-inline"><?= csrf() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><select name="status"><option>active</option><option>inactive</option><option>banned</option></select><button class="btn btn-sm btn-primary">Set</button></form>
    <form method="post" action="<?= routeUrl('admin/delete') ?>" class="d-inline"><?= csrf() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form>
    <?php return ob_get_clean();
}
?>
