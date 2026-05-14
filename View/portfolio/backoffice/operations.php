<div class="bg-secondary rounded p-4">
    <h4>Jobs</h4>
    <div class="table-responsive"><table class="table table-bordered table-hover"><tr><th>Company</th><th>Title</th><th>Status</th><th>Expires</th><th>Action</th></tr><?php foreach ($jobs as $j): ?><tr><td><?= e($j['company_name']) ?></td><td><?= e($j['title']) ?></td><td><?= e($j['status']) ?></td><td><?= e($j['expiration_date']) ?></td><td><form method="post" action="<?= routeUrl('admin/job-status') ?>"><?= csrf() ?><input type="hidden" name="id" value="<?= (int)$j['id'] ?>"><select name="status"><option>open</option><option>closed</option></select><button class="btn btn-sm btn-primary">Save</button></form></td></tr><?php endforeach; ?></table></div>
</div>
<div class="bg-secondary rounded p-4 mt-4">
    <h4>Applications</h4>
    <div class="table-responsive"><table class="table table-bordered table-hover"><tr><th>Freelancer</th><th>Company</th><th>Job</th><th>Status</th><th>Action</th></tr><?php foreach ($applications as $a): ?><tr><td><?= e($a['freelancer']) ?></td><td><?= e($a['company_name']) ?></td><td><?= e($a['title']) ?></td><td><?= e($a['status']) ?></td><td><form method="post" action="<?= routeUrl('admin/application-status') ?>"><?= csrf() ?><input type="hidden" name="id" value="<?= (int)$a['id'] ?>"><select name="status"><option>pending</option><option>accepted</option><option>rejected</option></select><button class="btn btn-sm btn-primary">Save</button></form></td></tr><?php endforeach; ?></table></div>
</div>
<div class="row g-4 mt-1">
    <div class="col-xl-6"><div class="bg-secondary rounded p-4"><h4>Uploaded Files</h4><table class="table table-bordered table-hover"><tr><th>Type</th><th>Name</th><th>File</th></tr><?php foreach ($uploads as $u): ?><tr><td><?= e($u['type']) ?></td><td><?= e($u['name']) ?></td><td><?= e($u['file_path']) ?></td></tr><?php endforeach; ?></table></div></div>
    <div class="col-xl-6"><div class="bg-secondary rounded p-4"><h4>Reports & Activity</h4><table class="table table-bordered table-hover"><tr><th>Action</th><th>Details</th><th>Date</th></tr><?php foreach ($activities as $a): ?><tr><td><?= e($a['action']) ?></td><td><?= e($a['details']) ?></td><td><?= e($a['created_at']) ?></td></tr><?php endforeach; ?></table></div></div>
</div>
