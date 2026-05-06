<?php
// models/ApiService.php

class ApiService {
    
    // --- STRIPE (PAIEMENT) ---
    public function createStripeCheckout($eventId, $amount) {
        // Simulation d'appel Stripe API
        // require_once('vendor/stripe/stripe-php/init.php');
        // \Stripe\Stripe::setApiKey('sk_test_...');
        return "https://checkout.stripe.com/pay/simulated_session_" . bin2hex(random_bytes(8));
    }

    // --- SENDGRID (EMAIL) ---
    public function sendRealEmail($apiKey, $from, $to, $subject, $message) {
        $url = 'https://api.sendgrid.com/v3/mail/send';
        $data = [
            'personalizations' => [['to' => [['email' => $to]]]],
            'from' => ['email' => $from, 'name' => 'Admin Event Pro'],
            'subject' => $subject,
            'content' => [['type' => 'text/html', 'value' => $message]]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($status == 202);
    }

    // --- GOOGLE CALENDAR ---
    public function addToGoogleCalendar($eventData) {
        // Simulation d'ajout au calendrier Google
        // $client = new Google_Client();
        // $service = new Google_Service_Calendar($client);
        // $event = new Google_Service_Calendar_Event(array(...));
        return "https://calendar.google.com/calendar/render?action=TEMPLATE&text=" . urlencode($eventData['title']);
    }

    // --- GOOGLE MAPS DISTANCE ---
    public function calculateDistance($origin, $destination) {
        // Simulation d'appel Distance Matrix API
        return "12.5 km (Estimé)";
    }
}
?>
