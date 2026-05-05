<?php
// controllers/EventController.php
require_once __DIR__ . '/../models/Event.php';

class EventController {
    private $db;

    public function __construct($db) { $this->db = $db; }

    public function getEvents() {
        $event = new Event($this->db);
        return $event->read()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEvent($id) {
        $event = new Event($this->db);
        return $event->readOne($id);
    }

    public function createEvent($data) {
        $event = new Event($this->db);
        return $event->create($data);
    }

    public function updateEvent($id, $data) {
        $event = new Event($this->db);
        return $event->update($id, $data);
    }

    public function deleteEvent($id) {
        $event = new Event($this->db);
        return $event->delete($id);
    }

    public function getStats() {
        $event = new Event($this->db);
        return [
            'total' => $event->countTotal(),
            'upcoming' => $event->countUpcoming(),
            'monthly' => $event->getMonthlyStats()
        ];
    }
}
?>
