<?php
require_once 'Database.php';

class JobModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // ========== GESTION DES OFFRES D'EMPLOI ==========
    
    public function submitJob($data, $entreprise_id, $company_name) {
        $sql = "INSERT INTO job_postings (entreprise_id, title, description, requirements, status) 
                VALUES (:entreprise_id, :title, :description, :requirements, 'pending')";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':entreprise_id' => $entreprise_id,
            ':title' => htmlspecialchars($data['title']),
            ':description' => htmlspecialchars($data['description']),
            ':requirements' => htmlspecialchars($data['requirements'])
        ]);
        
        if ($result) {
            $job_id = $this->db->lastInsertId();
            // Notifier l'admin (id 1)
            $this->createNotification(1, "Nouvelle demande d'emploi", "L'entreprise {$company_name} a soumis une offre : {$data['title']}", "info", "index.php?action=admin-pending-jobs");
        }
        
        return ['success' => $result, 'id' => $job_id ?? null];
    }
    
    public function getPendingJobs() {
        $sql = "SELECT j.*, u.company as company_name 
                FROM job_postings j 
                JOIN users u ON j.entreprise_id = u.id 
                WHERE j.status = 'pending' 
                ORDER BY j.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getApprovedJobs() {
        $sql = "SELECT j.*, u.company as company_name 
                FROM job_postings j 
                JOIN users u ON j.entreprise_id = u.id 
                WHERE j.status = 'approved' 
                ORDER BY j.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getEnterpriseJobs($entreprise_id) {
        $sql = "SELECT * FROM job_postings WHERE entreprise_id = :entreprise_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':entreprise_id' => $entreprise_id]);
        return $stmt->fetchAll();
    }
    
    public function getJobById($id) {
        $sql = "SELECT j.*, u.company as company_name 
                FROM job_postings j 
                JOIN users u ON j.entreprise_id = u.id 
                WHERE j.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    public function approveJob($job_id) {
        $sql = "UPDATE job_postings SET status = 'approved' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([':id' => $job_id]);
        
        if ($result) {
            $job = $this->getJobById($job_id);
            if ($job) {
                $this->createNotification($job['entreprise_id'], "Offre validée", "Votre offre d'emploi '{$job['title']}' a été validée et est maintenant publique.", "success", "index.php?action=entreprise-dashboard");
            }
        }
        return $result;
    }
    
    public function rejectJob($job_id) {
        $job = $this->getJobById($job_id);
        $sql = "UPDATE job_postings SET status = 'rejected' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([':id' => $job_id]);
        
        if ($result && $job) {
            $this->createNotification($job['entreprise_id'], "Offre refusée", "Votre offre d'emploi '{$job['title']}' a été refusée.", "danger", "index.php?action=entreprise-dashboard");
        }
        return $result;
    }
    
    // ========== GESTION DES CANDIDATURES ==========
    
    public function applyToJob($job_id, $candidat_id, $message, $candidat_name) {
        // Vérifier si déjà postulé
        $sql_check = "SELECT id FROM job_applications WHERE job_id = :job_id AND client_id = :candidat_id";
        $stmt_check = $this->db->prepare($sql_check);
        $stmt_check->execute([':job_id' => $job_id, ':candidat_id' => $candidat_id]);
        if ($stmt_check->fetch()) {
            return ['success' => false, 'error' => 'Vous avez déjà postulé à cette offre.'];
        }
        
        $sql = "INSERT INTO job_applications (job_id, client_id, message, status) VALUES (:job_id, :candidat_id, :message, 'pending')";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':job_id' => $job_id,
            ':candidat_id' => $candidat_id,
            ':message' => htmlspecialchars($message)
        ]);
        
        if ($result) {
            $job = $this->getJobById($job_id);
            // Notifier l'entreprise
            $this->createNotification($job['entreprise_id'], "Nouvelle candidature", "{$candidat_name} a postulé à votre offre : {$job['title']}", "info", "index.php?action=entreprise-applications&job_id={$job_id}");
        }
        
        return ['success' => $result];
    }
    
    public function getJobApplications($job_id, $entreprise_id) {
        $sql = "SELECT a.*, u.full_name as candidat_name, u.email as candidat_email 
                FROM job_applications a 
                JOIN users u ON a.client_id = u.id 
                JOIN job_postings j ON a.job_id = j.id
                WHERE a.job_id = :job_id AND j.entreprise_id = :entreprise_id
                ORDER BY a.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':job_id' => $job_id, ':entreprise_id' => $entreprise_id]);
        return $stmt->fetchAll();
    }

    public function getCandidatApplications($candidat_id) {
        $sql = "SELECT a.*, j.title as job_title, u.company as company_name 
                FROM job_applications a 
                JOIN job_postings j ON a.job_id = j.id 
                JOIN users u ON j.entreprise_id = u.id
                WHERE a.client_id = :candidat_id 
                ORDER BY a.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':candidat_id' => $candidat_id]);
        return $stmt->fetchAll();
    }
    
    public function updateApplicationStatus($application_id, $entreprise_id, $status) {
        // Vérifier que la candidature appartient bien à un job de cette entreprise
        $sql_check = "SELECT a.*, j.title as job_title FROM job_applications a JOIN job_postings j ON a.job_id = j.id WHERE a.id = :id AND j.entreprise_id = :entreprise_id";
        $stmt_check = $this->db->prepare($sql_check);
        $stmt_check->execute([':id' => $application_id, ':entreprise_id' => $entreprise_id]);
        $app = $stmt_check->fetch();
        
        if (!$app) return false;
        
        $sql = "UPDATE job_applications SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([':status' => $status, ':id' => $application_id]);
        
        if ($result) {
            $status_fr = ($status == 'accepted') ? 'acceptée' : 'refusée';
            $notif_type = ($status == 'accepted') ? 'success' : 'danger';
            $this->createNotification($app['client_id'], "Mise à jour de candidature", "Votre candidature pour le poste '{$app['job_title']}' a été {$status_fr}.", $notif_type, "index.php?action=candidat-dashboard");
        }
        
        return $result;
    }
    
    // ========== NOTIFICATIONS REUTILISEES ==========
    private function createNotification($user_id, $title, $message, $type = 'info', $link = null) {
        $sql = "INSERT INTO notifications (user_id, title, message, type, link) VALUES (:user_id, :title, :message, :type, :link)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $user_id,
            ':title' => $title,
            ':message' => $message,
            ':type' => $type,
            ':link' => $link
        ]);
    }
}
?>
