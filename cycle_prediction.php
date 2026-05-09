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

/* =========================
   FETCH CYCLE HISTORY
========================= */

$result = $conn->query("
SELECT start_date
FROM cycle_history
WHERE user_id='$user_id'
ORDER BY start_date ASC
");

$dates = [];

while($row = $result->fetch_assoc()){

    $dates[] =
    strtotime($row['start_date']);
}

/* =========================
   CALCULATE AVERAGE GAP
========================= */

$total_gap = 0;

$count_gap = 0;

for($i = 1; $i < count($dates); $i++){

    $gap =
    ($dates[$i] - $dates[$i-1])
    / (60*60*24);

    $total_gap += $gap;

    $count_gap++;
}

/* DEFAULT */

$average_gap = 28;

/* IF HISTORY EXISTS */

if($count_gap > 0){

    $average_gap =
    round($total_gap / $count_gap);
}

/* =========================
   LATEST PERIOD
========================= */

$latest_date =
end($dates);

/* NEXT PERIOD */

$next_period_timestamp =
strtotime(
    "+$average_gap days",
    $latest_date
);

$next_period =
date(
    "d M Y",
    $next_period_timestamp
);

/* =========================
   OVULATION WINDOW
========================= */

$ovulation_start =
date(
    "d M Y",
    strtotime("-16 days",
    $next_period_timestamp)
);

$ovulation_end =
date(
    "d M Y",
    strtotime("-12 days",
    $next_period_timestamp)
);

/* =========================
   LAST PERIOD
========================= */

$last_period =
date(
    "d M Y",
    $latest_date
);

?>

<!DOCTYPE html>

<html>

<head>

<title>
Cycle Prediction
</title>

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="dashboard.css">

<style>

/* MAIN */

.prediction-container{

    padding:30px;
}

/* TITLE */

.page-title{

    margin-bottom:30px;
}

.page-title h1{

    color:#AE2448;

    margin-bottom:10px;
}

.page-title p{

    color:#666;

    line-height:1.7;
}

/* GRID */

.prediction-grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(250px,1fr));

    gap:20px;

    margin-bottom:30px;
}

/* CARD */

.prediction-card{

    background:white;

    padding:25px;

    border-radius:24px;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.08);
}

/* HEADINGS */

.prediction-card h3{

    color:#AE2448;

    margin-bottom:15px;
}

/* VALUE */

.prediction-value{

    font-size:1.3rem;

    font-weight:bold;

    color:#333;
}

/* INFO CARD */

.info-card{

    background:white;

    padding:30px;

    border-radius:24px;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.08);

    margin-bottom:25px;
}

.info-card h2{

    color:#AE2448;

    margin-bottom:15px;
}

.info-card p{

    color:#555;

    line-height:1.8;
}

/* LIST */

.info-card ul{

    padding-left:20px;

    margin-top:15px;
}

.info-card li{

    margin-bottom:12px;

    line-height:1.7;
}

/* RESPONSIVE */

@media(max-width:768px){

    .prediction-container{
        padding:18px;
    }

    .prediction-grid{
        grid-template-columns:1fr;
    }
}

</style>

</head>

<body>

<div class="grid-container">

<!-- HEADER -->

<header class="header">

<h2>
Luna Cycle
</h2>

</header>

<!-- SIDEBAR -->

<aside id="sidebar">

<div class="sidebar-brand">
❤️ Luna Cycle
</div>

<ul class="sidebar-list">

<li class="sidebar-list-item">
<a href="user_dashboard.php">
Dashboard
</a>
</li>

<li class="sidebar-list-item">
<a href="profile.php">
Profile
</a>
</li>

<li class="sidebar-list-item">
<a href="cycle_data.php">
Cycle Data
</a>
</li>

<li class="sidebar-list-item">
<a href="logout.php">
Logout
</a>
</li>

</ul>

</aside>

<!-- MAIN -->

<main class="main-container">

<div class="prediction-container">

<!-- TITLE -->

<div class="page-title">

<h1>
Cycle Predictions
</h1>

<p>

AI-based menstrual prediction
generated using your cycle history
and pattern analysis.

</p>

</div>

<!-- PREDICTION GRID -->

<div class="prediction-grid">

<!-- NEXT PERIOD -->

<div class="prediction-card">

<h3>
📅 Next Predicted Period
</h3>

<div class="prediction-value">

<?php echo $next_period; ?>

</div>

</div>

<!-- OVULATION -->

<div class="prediction-card">

<h3>
🌸 Ovulation Window
</h3>

<div class="prediction-value">

<?php
echo $ovulation_start;
?>

<br><br>

to

<br><br>

<?php
echo $ovulation_end;
?>

</div>

</div>

<!-- AVG CYCLE -->

<div class="prediction-card">

<h3>
🩸 Average Cycle Length
</h3>

<div class="prediction-value">

<?php echo $average_gap; ?>
 Days

</div>

</div>

<!-- LAST PERIOD -->

<div class="prediction-card">

<h3>
📌 Last Recorded Period
</h3>

<div class="prediction-value">

<?php echo $last_period; ?>

</div>

</div>

</div>

<!-- AI ANALYSIS -->

<div class="info-card">

<h2>
🧠 AI Cycle Analysis
</h2>

<p>

The AI system analyzed your
previous cycle history to identify
cycle duration patterns and predict
your upcoming menstrual cycle.

The prediction becomes more
accurate as more cycle data is
added over time.

</p>

</div>

<!-- HEALTH TIPS -->

<div class="info-card">

<h2>
💡 Cycle Health Tips
</h2>

<ul>

<li>
Track your cycle consistently
for better predictions
</li>

<li>
Maintain balanced nutrition
and hydration
</li>

<li>
Reduce stress and improve sleep
routine
</li>

<li>
Exercise regularly to support
hormonal balance
</li>

<li>
Consult healthcare professional
if cycles become highly irregular
</li>

</ul>

</div>

</div>

</main>

</div>

</body>

</html>