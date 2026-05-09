<?php
session_start();
if(!isset($_SESSION['doctor_id'])){
    header("Location: doctor_login.php");
    exit();
}

$conn = new mysqli("localhost","root","","luna_cycle");
$doctor_id = $_SESSION['doctor_id'];

$doctor = $conn->query("SELECT * FROM doctors WHERE doctor_id='$doctor_id'")->fetch_assoc();
?>

<!DOCTYPE html>

<html>
<head>
<title>Doctor Dashboard</title>
<link rel="stylesheet" href="dashboard.css">
</head>

<body>

<div class="grid-container">

<header class="header doctor">
  <h2>Luna Cycle - Doctor</h2>
</header>

<aside id="sidebar">
  <div class="sidebar-brand">🩺 Doctor Panel</div>

  <ul class="sidebar-list">
    <li><a href="doctor_dashboard.php" class="active">Dashboard</a></li>
    <li><a href="doctor_patients.php">Patients</a></li>
    <li><a href="doctor_profile.php">Profile</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</aside>

<main class="main-container">

<h2>Welcome Dr. <?php echo $doctor['name']; ?> 👋</h2>

<div class="main-cards">

  <div class="card">
    <p>Total Patients</p>
    <span>--</span>
  </div>

  <div class="card">
    <p>Cycle Records</p>
    <span>--</span>
  </div>

  <div class="card">
    <p>Messages</p>
    <span>--</span>
  </div>

</div>

</main>

</div>

</body>
</html>
