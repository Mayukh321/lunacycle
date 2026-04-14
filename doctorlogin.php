<?php
session_start();

$conn = new mysqli("localhost", "root", "", "luna_cycle");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// LOGIN
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = $_POST['login'];
    $password = $_POST['pass'];

    // ✅ PREPARED STATEMENT (SECURE)
    $stmt = $conn->prepare("SELECT * FROM doctors WHERE email=? OR phone=?");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {

            // SESSION
            $_SESSION['doctor_id'] = $row['doctor_id'];
            $_SESSION['doctor_name'] = $row['name'];

            header("Location: doctor_dashboard.php");
            exit();

        } else {
            echo "<script>alert('❌ Wrong password');</script>";
        }

    } else {
        echo "<script>alert('❌ No account found');</script>";
    }
}
?>

<!DOCTYPE html>

<html>
<head>
<title>Doctor Login</title>
<link rel="stylesheet" href="login.css">
</head>

<body>

<div class="container">

<h1>Doctor Login</h1>

<form method="POST">
<input type="text" name="login" placeholder="Email or Phone" required>
<input type="password" name="pass" placeholder="Password" required>

<button class="submit-btn">Login</button>

<p class="login-text">Don't have an account?</p>
<a href="doctor_signup.php" class="login-btn">Create Account</a>

</form>

</div>
//POP UP
<?php if(isset($_GET['success'])) { ?>

<script>alert("✅ Signup successful! Please login.");</script>

<?php } ?>

</body>
</html>
