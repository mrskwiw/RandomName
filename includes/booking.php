<?php
require_once 'config.php';
require_once 'db.php';

function save_booking($data) {
    try {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO bookings (
                name, email, phone, event_date, 
                event_type, guest_count, message, status
            ) VALUES (
                :name, :email, :phone, :event_date,
                :event_type, :guest_count, :message, 'pending'
            )
        ");
        
        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'event_date' => $data['eventDate'],
            'event_type' => $data['eventType'],
            'guest_count' => $data['guestCount'],
            'message' => $data['message']
        ]);
    } catch (Exception $e) {
        error_log("Error saving booking: " . $e->getMessage());
        return false;
    }
}
