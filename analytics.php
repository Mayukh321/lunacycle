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
   CYCLE ANALYTICS
========================= */

$cycle = $conn->query("
SELECT
AVG(duration) AS avg_duration,
MAX(duration) AS max_duration,
MIN(duration) AS min_duration,
COUNT(*) AS total_cycles
FROM cycle_history
WHERE user_id='$user_id'
")->fetch_assoc();

/* =========================
   SYMPTOMS
========================= */

$symptom = $conn->query("
SELECT *
FROM symptoms
WHERE user_id='$user_id'
")->fetch_assoc();

/* =========================
   LIFESTYLE
========================= */

$lifestyle = $conn->query("
SELECT *
FROM lifestyle
WHERE user_id='$user_id'
")->fetch_assoc();

/* =========================
   DIET
========================= */

$diet = $conn->query("
SELECT *
FROM diet
WHERE user_id='$user_id'
")->fetch_assoc();

/* =========================
   PREDICTION
========================= */

$prediction = $conn->query("
SELECT *
FROM predictions
WHERE user_id='$user_id'
ORDER BY prediction_id DESC
LIMIT 1
")->fetch_assoc();

/* =========================
   COMMON SYMPTOM
========================= */

$common_symptom = "No Major Symptoms";

if($symptom['cramps']){
    $common_symptom = "Cramps";
}

if($symptom['mood_swings']){
    $common_symptom = "Mood Swings";
}

if($symptom['heavy_bleeding']){
    $common_symptom = "Heavy Bleeding";
}

if($symptom['acne']){
    $common_symptom = "Acne";
}

/* =========================
   HEALTH STATUS
========================= */

$health_status = "Stable";

if(
    $lifestyle['stress_level'] == "High"
    ||
    $diet['water_intake'] < 2
){
    $health_status = "Needs Attention";
}



/* =========================
   MONTHLY CHART DATA
========================= */

$chart_result = $conn->query("
SELECT month, duration
FROM cycle_history
WHERE user_id='$user_id'
ORDER BY start_date ASC
");

$months = [];

$durations = [];

while($chart = $chart_result->fetch_assoc()){

    $months[] =
    $chart['month'];

    $durations[] =
    $chart['duration'];
}

/* =========================
   HEALTH SCORE
========================= */

$health_score = 100;

/* STRESS */

if(
$lifestyle['stress_level']
== "High"
){
    $health_score -= 15;
}

/* LOW SLEEP */

if(
$lifestyle['sleep_duration']
< 6
){
    $health_score -= 10;
}

/* LOW WATER */

if(
$diet['water_intake']
< 2
){
    $health_score -= 10;
}

/* HEAVY BLEEDING */

if(
$symptom['heavy_bleeding']
){
    $health_score -= 15;
}

/* IRREGULAR */

if(
$symptom['irregular']
){
    $health_score -= 15;
}

/* CRAMPS */

if(
$symptom['cramps']
){
    $health_score -= 10;
}

/* ACNE */

if(
$symptom['acne']
){
    $health_score -= 5;
}

/* EXERCISE BONUS */

if(
$lifestyle['exercise_frequency']
== "Daily"
){
    $health_score += 5;
}

/* BALANCED DIET BONUS */

if(
$diet['balanced_diet']
== "Balanced Diet"
){
    $health_score += 5;
}

/* LIMITS */

if($health_score > 100){
    $health_score = 100;
}

if($health_score < 0){
    $health_score = 0;
}

/* DEFAULT */

$score_color = "#b0b0b0";

/* HEALTHY */

if($health_score >= 71){

    $score_color = "#4CAF50";
}

/* MODERATE */

elseif($health_score >= 41){

    $score_color = "#fbc02d";
}

/* LOW */

else{

    $score_color = "#e53935";
}

?>

<!DOCTYPE html>

<html>

<head>

<title>
Health Analytics
</title>

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="dashboard.css">
<script src=
"https://cdn.jsdelivr.net/npm/chart.js">
</script>
<style>

/* MAIN */

.analytics-container{

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

.analytics-grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(240px,1fr));

    gap:20px;

    margin-bottom:30px;
}

/* CARD */

.analytics-card{

    background:white;

    padding:25px;

    border-radius:24px;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.08);

    transition:0.3s;
}

.analytics-card:hover{

    transform:translateY(-4px);
}

/* CARD TITLE */

.analytics-card h3{

    color:#AE2448;

    margin-bottom:15px;

    font-size:1.1rem;
}

/* VALUE */

.analytics-value{

    font-size:1.8rem;

    font-weight:bold;

    color:#333;
}

/* SUBTEXT */

.analytics-sub{

    margin-top:10px;

    color:#777;

    line-height:1.6;
}

/* INSIGHT CARD */

.insight-card{

    background:white;

    padding:30px;

    border-radius:24px;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.08);

    margin-bottom:25px;
}

.insight-card h2{

    color:#AE2448;

    margin-bottom:18px;
}

.insight-card p{

    color:#555;

    line-height:1.8;
}

/* HEALTH STATUS */

.health-status{

    display:inline-block;

    margin-top:15px;

    padding:10px 18px;

    border-radius:30px;

    background:#fff5f8;

    color:#AE2448;

    font-weight:600;
}

/* HEALTH CIRCLE */

.health-circle{

    position:relative;

    width:160px;

    height:160px;

    margin:20px auto;
}

.health-circle svg{

    width:160px;

    height:160px;
}

/* SCORE TEXT */

.health-score-text{

    position:absolute;

    top:50%;

    left:50%;

    transform:
    translate(-50%,-50%);

    font-size:2rem;

    font-weight:bold;

    color:#333;
}

.health-score-text span{

    font-size:1rem;

    color:#777;
}


/* RESPONSIVE */

@media(max-width:768px){

    .analytics-container{
        padding:18px;
    }

    .analytics-grid{
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

<div class="analytics-container">

<!-- TITLE -->

<div class="page-title">

<h1>
Health Analytics
</h1>

<p>

AI-generated menstrual health
analytics based on your cycle
history, symptoms and lifestyle
patterns.

</p>

</div>

<!-- GRID -->

<div class="analytics-grid">




<!-- AVG CYCLE -->

<div class="analytics-card">

<h3>
🩸 Average Cycle Length
</h3>

<div class="analytics-value">

<?php
echo round($cycle['avg_duration'],1);
?>

Days

</div>

<div class="analytics-sub">

Average cycle duration based
on your recorded cycle history.

</div>

</div>

<!-- TOTAL CYCLES -->

<div class="analytics-card">

<h3>
📅 Total Cycles Tracked
</h3>

<div class="analytics-value">

<?php
echo $cycle['total_cycles'];
?>

</div>

<div class="analytics-sub">

Total menstrual cycles recorded
in your health history.

</div>

</div>

<!-- COMMON SYMPTOM -->

<div class="analytics-card">

<h3>
⚠️ Common Symptom
</h3>

<div class="analytics-value">

<?php
echo $common_symptom;
?>

</div>

<div class="analytics-sub">

Most recently detected symptom
from your health records.

</div>

</div>

<!-- WATER -->

<div class="analytics-card">

<h3>
💧 Water Intake
</h3>

<div class="analytics-value">

<?php
echo $diet['water_intake'];
?>


</div>




<div class="analytics-sub">

Daily hydration tracking based
on your lifestyle records.

</div>

</div>
<!-- HEALTH SCORE -->

<div class="analytics-card">

<h3>
🧠 AI Health Score
</h3>

<div class="health-circle">

<svg width="160" height="160">

<!-- BACKGROUND -->

<circle
cx="80"
cy="80"
r="65"
stroke="#eee"
stroke-width="12"
fill="none"
/>

<!-- PROGRESS -->

<circle
cx="80"
cy="80"
r="65"

stroke="<?php echo $score_color; ?>"

stroke-width="12"

fill="none"

stroke-linecap="round"

stroke-dasharray="408"

stroke-dashoffset="<?php
echo 408 - (($health_score / 100) * 408);
?>"

transform="rotate(-90 80 80)"
/>

</svg>

<div class="health-score-text">

<?php
echo $health_score;
?>

<span>/100</span>

</div>

</div>

<div class="analytics-sub">

AI-generated menstrual
wellness score based on
cycle trends, symptoms,
stress and lifestyle data.

</div>

</div>
</div>

<!-- AI INSIGHTS -->

<div class="insight-card">

<h2>
🧠 AI Health Insights
</h2>

<p>

Your cycle analytics indicate
an average menstrual duration
of approximately

<strong>
<?php
echo round($cycle['avg_duration'],1);
?>
days
</strong>.

The AI system also analyzed
stress levels, symptoms,
hydration patterns and
lifestyle information to detect
possible health trends.

</p>

<div class="health-status">

Current Health Status:
<?php echo $health_status; ?>

</div>

</div>

<!-- CHART CARD -->

<div class="insight-card">

<h2>
📊 Monthly Cycle Trend
</h2>

<p>

This chart shows how your
cycle duration changes
month-to-month.

</p>

<canvas id="cycleChart"></canvas>

</div>


<!-- PREDICTION INSIGHT -->

<div class="insight-card">

<h2>
📊 Current AI Prediction
</h2>

<p>

<strong>
<?php
echo $prediction['prediction'];
?>
</strong>

</p>

<p>

<?php
echo $prediction['suggestion'];
?>

</p>

</div>

</div>

</main>

</div>

<script>

const ctx =
document.getElementById(
'cycleChart'
);

new Chart(ctx, {

    type: 'bar',

    data: {

        labels:
        <?php
        echo json_encode($months);
        ?>,

        datasets: [{

            label:
            'Cycle Duration',

            data:
            <?php
            echo json_encode($durations);
            ?>,

            borderWidth:1,

            borderRadius:10,

            backgroundColor:
            '#AE2448'
        }]
    },

    options: {

        responsive:true,

        plugins:{

            legend:{
                display:true
            }
        },

        scales:{

            y:{
                beginAtZero:true
            }
        }
    }
});

</script>

</body>

</html>