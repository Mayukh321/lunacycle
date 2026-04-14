<?php
session_start();

$conn= new mysqli("localhost", "root", "", "luna_cycle");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// LOGIN
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = $_POST['login'];
    $password = $_POST['pass'];

    // ✅ USERS TABLE
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? OR phone=?");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['name'];

            header("Location: user_dashboard.php");
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
<title>User Login</title>
<link rel="stylesheet" href="login.css">
</head>

<body>

<div class="container">

<h1>User Login</h1>

<form method="POST">
<input type="text" name="login" placeholder="Email or Phone" required>
<input type="password" name="pass" placeholder="Password" required>

<button class="submit-btn">Login</button>

<p class="login-text">Don't have an account?</p>
<a href="user_signup.php" class="login-btn">Create Account</a>

</form>

</div>

<?php if(isset($_GET['success'])) { ?>

<script>alert("✅ Signup successful! Please login.");</script>

<?php } ?>

</body>
</html>
