<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit();
}
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f4f4f4;
        }
        .header {
            background: #4CAF50;
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
        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .doctor-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .btn {
            padding: 8px 15px;
            background: #2196F3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        .btn:hover {
            background: #1976D2;
        }
        .logout-btn {
            background: #f44336;
        }
        .logout-btn:hover {
            background: #d32f2f;
        }
        .filter-section {
            margin-bottom: 20px;
        }
        select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .message-form {
            margin-top: 15px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome, <?php echo $_SESSION['patient_name']; ?>!</h1>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>

        <div class="section">
            <h2>Available Doctors</h2>
            
            <div class="filter-section">
                <label for="specialization">Filter by Specialization:</label>
                <select id="specialization" onchange="filterDoctors()">
                    <option value="">All Specializations</option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="Neurologist">Neurologist</option>
                    <option value="Orthopedic">Orthopedic</option>
                    <option value="Pediatrician">Pediatrician</option>
                    <option value="Dermatologist">Dermatologist</option>
                    <option value="General Physician">General Physician</option>
                </select>
            </div>

            <div class="doctors-grid" id="doctorsGrid">
                <?php
                $sql = "SELECT * FROM doctors ORDER BY name";
                $result = $conn->query($sql);
                
                while ($doctor = $result->fetch_assoc()) {
                    echo "<div class='doctor-card' data-specialization='" . $doctor['specialization'] . "'>";
                    echo "<h3>" . $doctor['name'] . "</h3>";
                    echo "<p><strong>Specialization:</strong> " . $doctor['specialization'] . "</p>";
                    echo "<p><strong>Email:</strong> " . $doctor['email'] . "</p>";
                    echo "<p><strong>Phone:</strong> " . $doctor['phone'] . "</p>";
                    
                    echo "<form method='POST' action='book_appointment.php' style='display: inline;'>";
                    echo "<input type='hidden' name='doctor_id' value='" . $doctor['id'] . "'>";
                    echo "<input type='date' name='appointment_date' required style='margin: 5px;'>";
                    echo "<input type='time' name='appointment_time' required style='margin: 5px;'>";
                    echo "<button type='submit' class='btn'>Book Appointment</button>";
                    echo "</form>";
                    
                    echo "<div class='message-form'>";
                    echo "<form method='POST' action='send_message.php'>";
                    echo "<input type='hidden' name='doctor_id' value='" . $doctor['id'] . "'>";
                    echo "<textarea name='message' placeholder='Send a message to Dr. " . $doctor['name'] . "' rows='3' required></textarea>";
                    echo "<button type='submit' class='btn'>Send Message</button>";
                    echo "</form>";
                    echo "</div>";
                    
                    echo "</div>";
                }
                ?>
            </div>
        </div>

        <div class="section">
            <h2>My Appointments</h2>
            <?php
            $patient_id = $_SESSION['patient_id'];
            $sql = "SELECT a.*, d.name as doctor_name, d.specialization 
                    FROM appointments a 
                    JOIN doctors d ON a.doctor_id = d.id 
                    WHERE a.patient_id = ? 
                    ORDER BY a.appointment_date DESC, a.appointment_time DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $patient_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                echo "<table style='width: 100%; border-collapse: collapse;'>";
                echo "<tr style='background: #f0f0f0;'>";
                echo "<th style='padding: 10px; border: 1px solid #ddd;'>Doctor</th>";
                echo "<th style='padding: 10px; border: 1px solid #ddd;'>Specialization</th>";
                echo "<th style='padding: 10px; border: 1px solid #ddd;'>Date</th>";
                echo "<th style='padding: 10px; border: 1px solid #ddd;'>Time</th>";
                echo "<th style='padding: 10px; border: 1px solid #ddd;'>Status</th>";
                echo "</tr>";
                
                while ($appointment = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $appointment['doctor_name'] . "</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $appointment['specialization'] . "</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $appointment['appointment_date'] . "</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $appointment['appointment_time'] . "</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . ucfirst($appointment['status']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No appointments found.</p>";
            }
            ?>
        </div>

        <div class="section">
            <h2>Messages</h2>
            <?php
            $sql = "SELECT m.*, d.name as doctor_name 
                    FROM messages m 
                    JOIN doctors d ON m.receiver_id = d.id 
                    WHERE m.sender_id = ? AND m.sender_type = 'patient'
                    ORDER BY m.created_at DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $patient_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($message = $result->fetch_assoc()) {
                    echo "<div style='border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
                    echo "<strong>To Dr. " . $message['doctor_name'] . ":</strong><br>";
                    echo "<p>" . $message['message'] . "</p>";
                    echo "<small>Sent on: " . $message['created_at'] . "</small>";
                    echo "</div>";
                }
            } else {
                echo "<p>No messages sent.</p>";
            }
            ?>
        </div>
    </div>

    <script>
        function filterDoctors() {
            const specialization = document.getElementById('specialization').value;
            const doctorCards = document.querySelectorAll('.doctor-card');
            
            doctorCards.forEach(card => {
                if (specialization === '' || card.dataset.specialization === specialization) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>