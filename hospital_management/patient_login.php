<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            max-width: 450px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3), 0 0 0 1px rgba(255,255,255,0.2);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 2.2em;
            font-weight: 300;
        }
        .subtitle {
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 1em;
        }
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #34495e;
            font-weight: 500;
            font-size: 0.9em;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #ecf0f1;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.9);
        }
        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #2ecc71;
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
            transform: translateY(-2px);
        }
        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(145deg, #2ecc71, #27ae60);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(46, 204, 113, 0.4);
        }
        .signup-btn {
            background: linear-gradient(145deg, #3498db, #2980b9);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        .signup-btn:hover {
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
        }
        .back-link {
            text-align: center;
            margin-top: 25px;
        }
        .back-link a {
            color: #7f8c8d;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .back-link a:hover {
            color: #34495e;
        }
        .error {
            background: linear-gradient(145deg, #e74c3c, #c0392b);
            color: white;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Patient Login</h2>
        <p class="subtitle">Access your healthcare portal</p>
        
        <?php
        session_start();
        include 'config.php';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['login'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                $sql = "SELECT * FROM patients WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $patient = $result->fetch_assoc();
                    if (password_verify($password, $patient['password'])) {
                        $_SESSION['patient_id'] = $patient['id'];
                        $_SESSION['patient_name'] = $patient['name'];
                        header("Location: patient_dashboard.php");
                        exit();
                    } else {
                        echo "<div class='error'>Invalid password!</div>";
                    }
                } else {
                    echo "<div class='error'>Patient not found! Please register first.</div>";
                }
            }
        }
        ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" name="login" class="btn">Login</button>
            <a href="patient_signup.php" class="btn signup-btn" style="text-decoration: none; text-align: center; display: block;">Sign Up</a>
        </form>
        
        <div class="back-link">
            <a href="index.html">← Back to Home</a>
        </div>
    </div>
</body>
</html>