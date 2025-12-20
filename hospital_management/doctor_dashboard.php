<?php
session_start();
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit();
}
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f4f4f4;
        }
        .header {
            background: #2196F3;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .btn {
            padding: 8px 15px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        .btn:hover {
            background: #45a049;
        }
        .logout-btn {
            background: #f44336;
        }
        .logout-btn:hover {
            background: #d32f2f;
        }
        .appointment-card, .message-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            background: #f9f9f9;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            resize: vertical;
        }
        .reply-form {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome, Dr. <?php echo $_SESSION['doctor_name']; ?>!</h1>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>

        <div class="section">
            <h2>My Appointments</h2>
            <?php
            $doctor_id = $_SESSION['doctor_id'];
            $sql = "SELECT a.*, p.name as patient_name, p.email, p.phone 
                    FROM appointments a 
                    JOIN patients p ON a.patient_id = p.id 
                    WHERE a.doctor_id = ? 
                    ORDER BY a.appointment_date ASC, a.appointment_time ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $doctor_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($appointment = $result->fetch_assoc()) {
                    echo "<div class='appointment-card'>";
                    echo "<h3>Patient: " . $appointment['patient_name'] . "</h3>";
                    echo "<p><strong>Date:</strong> " . $appointment['appointment_date'] . "</p>";
                    echo "<p><strong>Time:</strong> " . $appointment['appointment_time'] . "</p>";
                    echo "<p><strong>Email:</strong> " . $appointment['email'] . "</p>";
                    echo "<p><strong>Phone:</strong> " . $appointment['phone'] . "</p>";
                    echo "<p><strong>Status:</strong> " . ucfirst($appointment['status']) . "</p>";
                    echo "<p><strong>Booked on:</strong> " . $appointment['created_at'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No appointments scheduled.</p>";
            }
            ?>
        </div>

        <div class="section">
            <h2>Messages from Patients</h2>
            <?php
            $sql = "SELECT m.*, p.name as patient_name 
                    FROM messages m 
                    JOIN patients p ON m.sender_id = p.id 
                    WHERE m.receiver_id = ? AND m.receiver_type = 'doctor'
                    ORDER BY m.created_at DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $doctor_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($message = $result->fetch_assoc()) {
                    echo "<div class='message-card'>";
                    echo "<h4>From: " . $message['patient_name'] . "</h4>";
                    echo "<p>" . $message['message'] . "</p>";
                    echo "<small>Received on: " . $message['created_at'] . "</small>";
                    
                    echo "<div class='reply-form'>";
                    echo "<form method='POST' action='send_reply.php'>";
                    echo "<input type='hidden' name='patient_id' value='" . $message['sender_id'] . "'>";
                    echo "<textarea name='reply' placeholder='Reply to " . $message['patient_name'] . "' rows='3' required></textarea>";
                    echo "<button type='submit' class='btn'>Send Reply</button>";
                    echo "</form>";
                    echo "</div>";
                    
                    echo "</div>";
                }
            } else {
                echo "<p>No messages received.</p>";
            }
            ?>
        </div>

        <div class="section">
            <h2>My Replies</h2>
            <?php
            $sql = "SELECT m.*, p.name as patient_name 
                    FROM messages m 
                    JOIN patients p ON m.receiver_id = p.id 
                    WHERE m.sender_id = ? AND m.sender_type = 'doctor'
                    ORDER BY m.created_at DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $doctor_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($reply = $result->fetch_assoc()) {
                    echo "<div class='message-card'>";
                    echo "<h4>To: " . $reply['patient_name'] . "</h4>";
                    echo "<p>" . $reply['message'] . "</p>";
                    echo "<small>Sent on: " . $reply['created_at'] . "</small>";
                    echo "</div>";
                }
            } else {
                echo "<p>No replies sent.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>