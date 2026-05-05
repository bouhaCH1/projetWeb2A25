<?php
// controllers/ResourceController.php
require_once __DIR__ . '/../models/Resource.php';

class ResourceController {
    private $db;

    public function __construct($db) { $this->db = $db; }

    public function getResources() {
        $resource = new Resource($this->db);
        return $resource->read()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getResource($id) {
        $resource = new Resource($this->db);
        return $resource->readOne($id);
    }

    public function createResource($data) {
        $resource = new Resource($this->db);
        return $resource->create($data);
    }

    public function updateResource($id, $data) {
        $resource = new Resource($this->db);
        return $resource->update($id, $data);
    }

    public function deleteResource($id) {
        $resource = new Resource($this->db);
        return $resource->delete($id);
    }

    public function getStats() {
        $resource = new Resource($this->db);
        return [
            'total' => $resource->sumQuantity(),
            'low_stock' => $resource->countLowStock(),
            'types' => $resource->getTypeStats()
        ];
    }
}
?>
