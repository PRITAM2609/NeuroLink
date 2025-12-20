<?php
session_start();
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sender_id = $_SESSION['doctor_id'];
    $receiver_id = $_POST['patient_id'];
    $reply = $_POST['reply'];
    
    $sql = "INSERT INTO messages (sender_id, receiver_id, sender_type, receiver_type, message) VALUES (?, ?, 'doctor', 'patient', ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $sender_id, $receiver_id, $reply);
    
    if ($stmt->execute()) {
        header("Location: doctor_dashboard.php?success=reply_sent");
    } else {
        header("Location: doctor_dashboard.php?error=reply_failed");
    }
} else {
    header("Location: doctor_dashboard.php");
}
?>