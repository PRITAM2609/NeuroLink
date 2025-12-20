<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sender_id = $_SESSION['patient_id'];
    $receiver_id = $_POST['doctor_id'];
    $message = $_POST['message'];
    
    $sql = "INSERT INTO messages (sender_id, receiver_id, sender_type, receiver_type, message) VALUES (?, ?, 'patient', 'doctor', ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    
    if ($stmt->execute()) {
        header("Location: patient_dashboard.php?success=message_sent");
    } else {
        header("Location: patient_dashboard.php?error=message_failed");
    }
} else {
    header("Location: patient_dashboard.php");
}
?>