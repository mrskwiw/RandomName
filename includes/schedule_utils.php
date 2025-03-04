<?php

function get_db() {
  $db = new PDO('sqlite:' . __DIR__ . '/../schedule.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $db;
}

function init_db() {
  $db = get_db();
  $db->exec("
    CREATE TABLE IF NOT EXISTS events (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      date TEXT NOT NULL,
      time TEXT NOT NULL,
      location TEXT NOT NULL,
      address TEXT NOT NULL,
      status TEXT DEFAULT 'active'
    )
  ");
  $db->exec("
    CREATE TABLE IF NOT EXISTS sent_emails (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        date TEXT NOT NULL,
        time TEXT NOT NULL,
        recipients TEXT NOT NULL,
        subject TEXT NOT NULL,
        body TEXT NOT NULL
    )
  ");
}

// Call this function to initialize the database if it doesn't exist
init_db();

function get_active_events() {
  try {
    $db = get_db();
    $stmt = $db->prepare("SELECT * FROM events WHERE date >= DATE('now') AND status = 'active' ORDER BY date ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    error_log("Error fetching events: " . $e->getMessage());
    return [];
  }
}

function add_event($date, $time, $location, $address) {
  try {
    $db = get_db();
    $stmt = $db->prepare("INSERT INTO events (date, time, location, address) VALUES (?, ?, ?, ?)");
    $stmt->execute([$date, $time, $location, $address]);
  } catch (PDOException $e) {
    error_log("Error adding event: " . $e->getMessage());
  }
}

function cancel_event($id) {
  try {
    $db = get_db();
    $stmt = $db->prepare("UPDATE events SET status = 'cancelled' WHERE id = ?");
    $stmt->execute([$id]);
  } catch (PDOException $e) {
    error_log("Error cancelling event: " . $e->getMessage());
  }
}

function remove_expired_events() {
  try {
    $db = get_db();
    $stmt = $db->prepare("DELETE FROM events WHERE date < DATE('now') AND status = 'cancelled'");
    $stmt->execute();
  } catch (PDOException $e) {
    error_log("Error removing expired events: " . $e->getMessage());
  }
}

function record_sent_email($recipients, $subject, $body) {
    try {
        $db = get_db();
        $stmt = $db->prepare("INSERT INTO sent_emails (date, time, recipients, subject, body) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([date('Y-m-d'), date('H:i:s'), implode(', ', $recipients), $subject, $body]);
    } catch (PDOException $e) {
        error_log("Error recording sent email: " . $e->getMessage());
    }
}
?>
