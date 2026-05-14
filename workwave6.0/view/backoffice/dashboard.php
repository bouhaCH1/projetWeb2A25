<div class="row g-4">
    <?php foreach (['freelancers'=>'Freelancers','companies'=>'Companies','jobs'=>'Jobs','applications'=>'Applications','uploads'=>'Uploads'] as $key => $label): ?>
        <div class="col-sm-6 col-xl-3"><div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4"><div><p class="mb-2"><?= e($label) ?></p><h6 class="mb-0"><?= (int)$stats[$key] ?></h6></div></div></div>
    <?php endforeach; ?>
</div>
<div class="row g-4 mt-1">
    <div class="col-xl-6"><div class="bg-secondary rounded p-4"><h5>Platform Analytics</h5><canvas id="adminChart" data-stats='<?= e(json_encode($stats)) ?>'></canvas></div></div>
    <div class="col-xl-6"><div class="bg-secondary rounded p-4"><h5>Recent Activity</h5><div class="table-responsive"><table class="table text-start align-middle table-bordered table-hover mb-0"><tr><th>Action</th><th>Details</th><th>Date</th></tr><?php foreach ($activities as $a): ?><tr><td><?= e($a['action']) ?></td><td><?= e($a['details']) ?></td><td><?= e($a['created_at']) ?></td></tr><?php endforeach; ?></table></div></div></div>
</div>
<div class="bg-secondary rounded p-4 mt-4">
    <h5>All Accounts</h5>
    <div class="table-responsive"><table class="table table-bordered table-hover"><tr><th>ID</th><th>Email</th><th>Role</th><th>Status</th><th>Created</th></tr><?php foreach ($users as $u): ?><tr><td><?= (int)$u['id'] ?></td><td><?= e($u['email']) ?></td><td><?= e($u['role']) ?></td><td><?= e($u['status']) ?></td><td><?= e($u['created_at']) ?></td></tr><?php endforeach; ?></table></div>
</div>
