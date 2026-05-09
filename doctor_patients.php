<?php
session_start();
if(!isset($_SESSION['doctor_id'])){
    header("Location: doctor_login.php");
    exit();
}

$conn = new mysqli("localhost","root","","luna_cycle");
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>

<html>
<head>
<title>Patients</title>
<link rel="stylesheet" href="dashboard_doctor.css">
</head>

<body>

<div class="grid-container">

<header class="header doctor">
  <h2>Patients</h2>
</header>

<aside id="sidebar">
  <ul class="sidebar-list">
    <li><a href="doctor_dashboard.php">Dashboard</a></li>
    <li><a href="doctor_patients.php" class="active">Patients</a></li>
    <li><a href="doctor_profile.php">Profile</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</aside>

<main class="main-container">

<h2>All Patients</h2>

<div class="main-cards">

<?php while($row = $result->fetch_assoc()) { ?>

<div class="card">
  <p><b><?php echo $row['name']; ?></b></p>
  <p>Age: <?php echo $row['age']; ?></p>
  <p>Phone: <?php echo $row['phone']; ?></p>
</div>

<?php } ?>

</div>

</main>

</div>

</body>
</html>
