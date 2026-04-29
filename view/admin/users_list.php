<?php
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /workwave/Controller/index.php');
    exit;
}
$pageTitle = 'Gérer les utilisateurs';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="page-header" style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:15px; align-items:center;">
    <div>
        <div class="page-header-title">Gérer les utilisateurs</div>
        <div class="page-header-sub">Tous les candidats et employeurs enregistrés</div>
    </div>
    <div style="display:flex; gap:10px;">
        <button onclick="exportTableToCSV('utilisateurs.csv')" class="btn btn-secondary" style="background:#27ae60; color:#fff; border:none;">CSV</button>
        <button onclick="exportTableToExcel('usersTable', 'utilisateurs')" class="btn btn-secondary" style="background:#207245; color:#fff; border:none;">Excel</button>
        <button onclick="exportTableToPDF()" class="btn btn-secondary" style="background:#c0392b; color:#fff; border:none;">PDF</button>
        <a href="/workwave/Controller/index.php?action=admin_add_user" class="btn btn-primary">+ Ajouter un utilisateur</a>
    </div>
</div>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger"><ul>
        <?php foreach ($_SESSION['errors'] as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; unset($_SESSION['errors']); ?>
    </ul></div>
<?php endif; ?>

<div class="dsh-card" style="margin-bottom: 20px; padding: 15px 24px;">
    <form method="GET" action="/workwave/Controller/index.php" style="display:flex; gap:15px; align-items:flex-end; flex-wrap:wrap;">
        <input type="hidden" name="action" value="admin_users">
        
        <div style="flex:1; min-width:200px;">
            <label style="margin-top:0; font-size:.7rem; color:#888;">Rechercher</label>
            <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Nom, e-mail..." style="margin-top:4px;">
        </div>
        
        <div style="width:200px;">
            <label style="margin-top:0; font-size:.7rem; color:#888;">Trier par</label>
            <select name="sort" style="margin-top:4px;">
                <?php $currentSort = $_GET['sort'] ?? 'created_at_desc'; ?>
                <option value="created_at_desc" <?= $currentSort === 'created_at_desc' ? 'selected' : '' ?>>Plus récents</option>
                <option value="created_at_asc" <?= $currentSort === 'created_at_asc' ? 'selected' : '' ?>>Plus anciens</option>
                <option value="name_asc" <?= $currentSort === 'name_asc' ? 'selected' : '' ?>>Nom (A-Z)</option>
                <option value="name_desc" <?= $currentSort === 'name_desc' ? 'selected' : '' ?>>Nom (Z-A)</option>
                <option value="role_asc" <?= $currentSort === 'role_asc' ? 'selected' : '' ?>>Rôle (A-Z)</option>
                <option value="role_desc" <?= $currentSort === 'role_desc' ? 'selected' : '' ?>>Rôle (Z-A)</option>
            </select>
        </div>
        
        <div>
            <button type="submit" class="btn btn-primary" style="padding:10px 18px; margin-bottom: 2px;">Filtrer</button>
            <?php if(!empty($_GET['search']) || !empty($_GET['sort'])): ?>
                <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary" style="padding:10px 18px; margin-bottom: 2px;">Réinitialiser</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="dsh-table-wrap" id="exportContent">
    <table id="usersTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>E-mail</th>
                <th>Téléphone</th>
                <th>Rôle</th>
                <th>Statut</th>
                <th>Enregistré le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($users)): ?>
            <tr><td colspan="7" style="text-align:center;color:#555;padding:24px;">Aucun utilisateur trouvé.</td></tr>
        <?php else: ?>
            <?php foreach ($users as $u): ?>
            <tr>
                <td style="color:#555;"><?= $u['id'] ?></td>
                <td style="color:#e0e0e0;font-weight:500;">
                    <?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?>
                    <?php if (($u['is_verified'] ?? 0) == 1): ?>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#3498db" stroke="#fff" stroke-width="2" style="vertical-align:middle; margin-left:4px;"><polygon points="12 2 15.09 5.09 19.5 5.5 20.91 9.91 24 12 20.91 14.09 19.5 18.5 15.09 18.91 12 22 8.91 18.91 4.5 18.5 3.09 14.09 0 12 3.09 9.91 4.5 5.5 8.91 5.09 12 2"></polygon><polyline points="9 12 11 14 15 10"></polyline></svg>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['phone'] ?? '—') ?></td>
                <td>
                    <span class="badge <?= $u['role'] === 'employer' ? 'badge-employer' : 'badge-seeker' ?>">
                        <?php
                        if ($u['role'] === 'job_seeker') echo 'Candidat';
                        elseif ($u['role'] === 'employer') echo 'Employeur';
                        else echo htmlspecialchars($u['role']);
                        ?>
                    </span>
                </td>
                <td>
                    <?php if (($u['status'] ?? 'active') === 'active'): ?>
                        <span style="color:#27ae60; font-weight:bold; font-size:.8rem;">Actif</span>
                    <?php else: ?>
                        <span style="color:#c0392b; font-weight:bold; font-size:.8rem;">Suspendu</span>
                    <?php endif; ?>
                </td>
                <td style="color:#555;"><?= htmlspecialchars(substr((string)$u['created_at'], 0, 10)) ?></td>
                <td>
                    <a href="/workwave/Controller/index.php?action=admin_edit_user&id=<?= $u['id'] ?>"
                       class="btn btn-warning btn-sm" style="margin-bottom:4px;">Modifier</a>
                    <?php if (($u['status'] ?? 'active') === 'active'): ?>
                        <a href="/workwave/Controller/index.php?action=admin_toggle_user&id=<?= $u['id'] ?>"
                           class="btn btn-danger btn-sm" style="margin-bottom:4px;"
                           onclick="return confirm('Suspendre cet utilisateur ? Il ne pourra plus se connecter.')">Suspendre</a>
                    <?php else: ?>
                        <a href="/workwave/Controller/index.php?action=admin_toggle_user&id=<?= $u['id'] ?>"
                           class="btn btn-success btn-sm" style="background:#27ae60; color:#fff; border:none; margin-bottom:4px;"
                           onclick="return confirm('Réactiver cet utilisateur ?')">Activer</a>
                    <?php endif; ?>
                    <?php if (($u['is_verified'] ?? 0) == 1): ?>
                        <a href="/workwave/Controller/index.php?action=admin_toggle_verify&id=<?= $u['id'] ?>"
                           class="btn btn-secondary btn-sm" style="margin-bottom:4px;"
                           onclick="return confirm('Retirer la certification de cet utilisateur ?')">Retirer Certif.</a>
                    <?php else: ?>
                        <a href="/workwave/Controller/index.php?action=admin_toggle_verify&id=<?= $u['id'] ?>"
                           class="btn btn-primary btn-sm" style="background:#3498db; color:#fff; border:none; margin-bottom:4px;"
                           onclick="return confirm('Certifier cet utilisateur (badge bleu) ?')">Certifier</a>
                    <?php endif; ?>
                    <a href="/workwave/Controller/index.php?action=admin_delete_user&id=<?= $u['id'] ?>"
                       class="btn btn-danger btn-sm" style="margin-bottom:4px;"
                       onclick="return confirm('Supprimer cet utilisateur définitivement ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<p style="margin-top:12px;color:#444;font-size:.78rem;">* Les comptes administrateurs sont exclus de cette liste.</p>

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
