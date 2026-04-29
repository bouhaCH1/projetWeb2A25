<?php
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /workwave/Controller/index.php');
    exit;
}
$pageTitle = 'Gérer les utilisateurs';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h6 class="mb-0">Gérer les utilisateurs</h6>
        <small>Tous les candidats et employeurs enregistrés</small>
    </div>
    <div class="d-flex gap-2">
        <button onclick="exportTableToCSV('utilisateurs.csv')" class="btn btn-success"><i class="fa fa-file-csv me-2"></i>CSV</button>
        <button onclick="exportTableToExcel('usersTable', 'utilisateurs')" class="btn btn-success" style="background:#207245;"><i class="fa fa-file-excel me-2"></i>Excel</button>
        <button onclick="exportTableToPDF()" class="btn btn-danger"><i class="fa fa-file-pdf me-2"></i>PDF</button>
        <a href="/workwave/Controller/index.php?action=admin_add_user" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Ajouter</a>
    </div>
</div>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="bg-secondary rounded p-4 mb-4">
    <form method="GET" action="/workwave/Controller/index.php" class="row g-3 align-items-end">
        <input type="hidden" name="action" value="admin_users">
        
        <div class="col-md-5">
            <label class="form-label text-muted mb-1">Rechercher</label>
            <input type="text" name="search" class="form-control bg-dark border-0" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Nom, e-mail...">
        </div>
        
        <div class="col-md-4">
            <label class="form-label text-muted mb-1">Trier par</label>
            <select name="sort" class="form-select bg-dark border-0">
                <?php $currentSort = $_GET['sort'] ?? 'created_at_desc'; ?>
                <option value="created_at_desc" <?= $currentSort === 'created_at_desc' ? 'selected' : '' ?>>Plus récents</option>
                <option value="created_at_asc" <?= $currentSort === 'created_at_asc' ? 'selected' : '' ?>>Plus anciens</option>
                <option value="name_asc" <?= $currentSort === 'name_asc' ? 'selected' : '' ?>>Nom (A-Z)</option>
                <option value="name_desc" <?= $currentSort === 'name_desc' ? 'selected' : '' ?>>Nom (Z-A)</option>
                <option value="role_asc" <?= $currentSort === 'role_asc' ? 'selected' : '' ?>>Rôle (A-Z)</option>
                <option value="role_desc" <?= $currentSort === 'role_desc' ? 'selected' : '' ?>>Rôle (Z-A)</option>
            </select>
        </div>
        
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100 mb-2">Filtrer</button>
            <?php if(!empty($_GET['search']) || !empty($_GET['sort'])): ?>
                <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-outline-primary w-100">Réinitialiser</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="bg-secondary rounded p-4">
    <div class="table-responsive" id="exportContent">
        <table class="table text-start align-middle table-hover mb-0" id="usersTable">
            <thead>
                <tr class="text-white">
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Rôle</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Enregistré le</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($users)): ?>
                <tr><td colspan="8" class="text-center py-4">Aucun utilisateur trouvé.</td></tr>
            <?php else: ?>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td class="fw-bold">
                        <?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?>
                        <?php if (($u['is_verified'] ?? 0) == 1): ?>
                            <i class="fa fa-check-circle text-info ms-1" title="Certifié"></i>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['phone'] ?? '—') ?></td>
                    <td>
                        <?php if ($u['role'] === 'employer'): ?>
                            <span class="badge bg-warning text-dark">Employeur</span>
                        <?php else: ?>
                            <span class="badge bg-info text-dark">Candidat</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (($u['status'] ?? 'active') === 'active'): ?>
                            <span class="text-success"><i class="fa fa-circle text-success me-1" style="font-size: 8px;"></i>Actif</span>
                        <?php else: ?>
                            <span class="text-danger"><i class="fa fa-circle text-danger me-1" style="font-size: 8px;"></i>Suspendu</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars(substr((string)$u['created_at'], 0, 10)) ?></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="/workwave/Controller/index.php?action=admin_edit_user&id=<?= $u['id'] ?>" class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                            <?php if (($u['status'] ?? 'active') === 'active'): ?>
                                <a href="/workwave/Controller/index.php?action=admin_toggle_user&id=<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Suspendre cet utilisateur ? Il ne pourra plus se connecter.')"><i class="fa fa-ban"></i></a>
                            <?php else: ?>
                                <a href="/workwave/Controller/index.php?action=admin_toggle_user&id=<?= $u['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Réactiver cet utilisateur ?')"><i class="fa fa-check"></i></a>
                            <?php endif; ?>
                            <?php if (($u['is_verified'] ?? 0) == 1): ?>
                                <a href="/workwave/Controller/index.php?action=admin_toggle_verify&id=<?= $u['id'] ?>" class="btn btn-sm btn-secondary" onclick="return confirm('Retirer la certification de cet utilisateur ?')"><i class="fa fa-times-circle"></i></a>
                            <?php else: ?>
                                <a href="/workwave/Controller/index.php?action=admin_toggle_verify&id=<?= $u['id'] ?>" class="btn btn-sm btn-info text-white" onclick="return confirm('Certifier cet utilisateur (badge bleu) ?')"><i class="fa fa-check-circle"></i></a>
                            <?php endif; ?>
                            <a href="/workwave/Controller/index.php?action=admin_delete_user&id=<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet utilisateur définitivement ?')"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <small class="text-muted d-block mt-3">* Les comptes administrateurs sont exclus de cette liste.</small>
</div>

<!-- html2pdf library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function downloadCSV(csv, filename) {
        let csvFile = new Blob([csv], {type: "text/csv"});
        let downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
    }

    function exportTableToCSV(filename) {
        let csv = [];
        let rows = document.querySelectorAll("#usersTable tr");
        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");
            for (let j = 0; j < cols.length - 1; j++) { // Exclude Actions column
                let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, "").trim();
                row.push('"' + data + '"');
            }
            csv.push(row.join(","));
        }
        downloadCSV(csv.join("\n"), filename);
    }

    function exportTableToExcel(tableID, filename = ''){
        let tableSelect = document.getElementById(tableID);
        // Clone table to remove actions column
        let clone = tableSelect.cloneNode(true);
        let rows = clone.rows;
        for (let i = 0; i < rows.length; i++) {
            rows[i].deleteCell(-1); // Delete last cell (Actions)
        }
        let tableHTML = clone.outerHTML.replace(/ /g, '%20');
        
        let dataType = 'application/vnd.ms-excel';
        filename = filename?filename+'.xls':'excel_data.xls';
        
        let downloadLink = document.createElement("a");
        document.body.appendChild(downloadLink);
        
        if(navigator.msSaveOrOpenBlob){
            let blob = new Blob(['\ufeff', tableHTML], { type: dataType });
            navigator.msSaveOrOpenBlob( blob, filename);
        }else{
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            downloadLink.download = filename;
            downloadLink.click();
        }
    }

    function exportTableToPDF() {
        let element = document.getElementById('exportContent').cloneNode(true);
        // Remove actions column
        let rows = element.querySelectorAll('tr');
        rows.forEach(row => row.lastElementChild.remove());

        let opt = {
            margin:       0.5,
            filename:     'utilisateurs.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
