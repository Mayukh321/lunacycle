<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: user_login.php");
    exit();
}

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "luna_cycle"
);

$user_id = $_SESSION['user_id'];

$result = $conn->query("
SELECT * FROM cycle_history
WHERE user_id='$user_id'
ORDER BY start_date DESC
");
?>

<!DOCTYPE html>

<html>

<head>

<title>Cycle Data</title>

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="dashboard.css">

<link rel="stylesheet"
href="cycle_data.css">

</head>

<body>

<div class="grid-container">

<!-- HEADER -->

<header class="header">

<h2>Luna Cycle</h2>

</header>

<!-- SIDEBAR -->

<aside id="sidebar">

<div class="sidebar-brand">
❤️ Luna Cycle
</div>

<ul class="sidebar-list">

<li>
<a href="user_dashboard.php">
Dashboard
</a>
</li>

<li>
<a href="profile.php">
Profile
</a>
</li>

<li>
<a href="cycle_data.php"
class="active">
Cycle Data
</a>
</li>

<li>
<a href="logout.php">
Logout
</a>
</li>

</ul>

</aside>

<!-- MAIN -->

<main class="main-container">

<div class="page-title">

<h1>
Cycle Health Tracker
</h1>

<p>
Track your menstrual cycle,
symptoms and lifestyle patterns.
</p>

</div>

<!-- HISTORY SECTION -->

<div class="section-card">

<div class="section-header">

<h3>
🩸 Cycle History
</h3>

</div>

<?php if($result->num_rows > 0){ ?>

<div class="history-grid">

<?php while($row = $result->fetch_assoc()) { ?>

<div class="history-card">

<h4>
<?php
echo $row['month']." ".$row['year'];
?>
</h4>

<p>
<strong>Start:</strong>
<?php echo $row['start_date']; ?>
</p>

<p>
<strong>End:</strong>
<?php echo $row['end_date']; ?>
</p>

<p>
<strong>Duration:</strong>
<?php echo $row['duration']; ?> days
</p>

</div>

<?php } ?>

</div>

<?php } else { ?>

<div class="empty-box">

<p>No cycle data available</p>

</div>

<?php } ?>

</div>

<!-- FORM -->

<form method="POST"
action="save_cycle.php">

<!-- CYCLE DATES -->

<div class="section-card">

<div class="section-header">

<h3>
📅 Cycle Dates
</h3>

</div>

<div class="form-grid">

<div>

<label>Start Date</label>

<input
type="date"
name="start"
required>

</div>

<div>

<label>End Date</label>

<input
type="date"
name="end"
required>

</div>

</div>

</div>

<!-- SYMPTOMS -->

<div class="section-card">

<div class="section-header">

<h3>
⚠️ Symptoms
</h3>

</div>

<div class="checkbox-grid">

<label>
<input type="checkbox"
name="cramps">
Cramps
</label>

<label>
<input type="checkbox"
name="heavy_bleeding">
Heavy Bleeding
</label>

<label>
<input type="checkbox"
name="mood_swings">
Mood Swings
</label>

<label>
<input type="checkbox"
name="acne">
Acne
</label>

<label>
<input type="checkbox"
name="hair_loss">
Hair Loss
</label>

<label>
<input type="checkbox"
name="irregular">
Irregular Periods
</label>

</div>

</div>

<!-- LIFESTYLE -->

<div class="section-card">

<div class="section-header">

<h3>
🧠 Lifestyle
</h3>

</div>

<div class="form-grid">

<div>

<label>Stress Level</label>

<select name="stress">

<option>Low</option>
<option>Moderate</option>
<option>High</option>

</select>

</div>

<div>

<label>Sleep Hours</label>

<input
type="number"
name="sleep"
placeholder="Hours">

</div>

<div>

<label>Exercise</label>

<select name="exercise">

<option>None</option>
<option>1-2 Days</option>
<option>3-5 Days</option>
<option>Daily</option>

</select>

</div>

</div>

</div>

<!-- DIET -->

<div class="section-card">

<div class="section-header">

<h3>
🍽️ Diet & Nutrition
</h3>

</div>

<div class="form-grid">

<div>

<label>Balanced Diet</label>

<select name="balanced">

<option>Yes</option>
<option>No</option>

</select>

</div>

<div>

<label>Junk Food</label>

<select name="junk">

<option>Rare</option>
<option>Sometimes</option>
<option>Frequent</option>

</select>

</div>

<div>

<label>Water Intake</label>

<input
type="number"
step="0.1"
name="water"
placeholder="Litres/day">

</div>

</div>

</div>

<!-- MEDICAL -->

<div class="section-card">

<div class="section-header">

<h3>
🏥 Medical Information
</h3>

</div>

<div class="form-grid">

<div>

<label>Condition</label>

<select name="condition">

<option>None</option>
<option>PCOS</option>
<option>Hypothyroidism</option>
<option>Diabetes</option>

</select>

</div>

<div>

<label>Medication</label>

<select name="medication">

<option>No</option>
<option>Yes</option>

</select>

</div>

</div>

<label>Medication Details</label>

<textarea
name="medication_details"
placeholder="Optional details"></textarea>

</div>

<button type="submit"
class="update-btn">

Update Cycle Data

</button>

</form>

</main>

</div>

</body>

</html>