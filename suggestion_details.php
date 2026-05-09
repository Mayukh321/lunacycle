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
   FETCH PREDICTION
========================= */

$result = $conn->query("
SELECT * FROM predictions
WHERE user_id='$user_id'
ORDER BY prediction_id DESC
LIMIT 1
");

$data = $result->fetch_assoc();

if(!$data){
    die("No prediction data found.");
}

/* =========================
   FETCH USER HEALTH DATA
========================= */

$symptom = $conn->query("
SELECT * FROM symptoms
WHERE user_id='$user_id'
")->fetch_assoc();

$lifestyle = $conn->query("
SELECT * FROM lifestyle
WHERE user_id='$user_id'
")->fetch_assoc();

$diet = $conn->query("
SELECT * FROM diet
WHERE user_id='$user_id'
")->fetch_assoc();

$medical = $conn->query("
SELECT * FROM medical
WHERE user_id='$user_id'
")->fetch_assoc();

$cycle = $conn->query("
SELECT AVG(duration) AS avg_duration
FROM cycle_history
WHERE user_id='$user_id'
")->fetch_assoc();

?>

<!DOCTYPE html>

<html>

<head>

<title>AI Health Report</title>

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="dashboard.css">

<style>

.details-container{

    padding:30px;
}

.report-title{

    margin-bottom:25px;
}

.report-title h1{

    color:#AE2448;

    margin-bottom:8px;
}

.report-title p{

    color:#666;
}

/* CARD */

.report-card{

    background:white;

    padding:30px;

    border-radius:25px;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.08);

    margin-bottom:25px;
}

/* SECTION TITLE */

.section-heading{

    color:#AE2448;

    margin-bottom:15px;

    font-size:1.3rem;
}

/* PREDICTION */

.prediction-box{

    background:
    linear-gradient(
    to right,
    #AE2448,
    #e05a7a
    );

    color:white;

    padding:25px;

    border-radius:20px;

    margin-bottom:25px;
}

.prediction-box h2{

    margin-bottom:10px;
}

/* ANALYSIS GRID */

.analysis-grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(220px,1fr));

    gap:18px;
}

/* ANALYSIS CARD */

.analysis-card{

    background:#fafafa;

    padding:18px;

    border-radius:18px;

    border:1px solid #f1d4dc;
}

.analysis-card h4{

    color:#AE2448;

    margin-bottom:10px;
}

.analysis-card p{

    color:#444;

    line-height:1.6;
}

/* LIST */

.action-list{

    margin-top:15px;

    padding-left:20px;
}

.action-list li{

    margin-bottom:12px;

    line-height:1.6;
}

/* INFO BOX */

.info-box{

    background:#fff5f8;

    padding:20px;

    border-left:5px solid #AE2448;

    border-radius:15px;

    margin-top:20px;
}

.info-box p{

    line-height:1.8;

    color:#444;
}

/* FACTOR LIST */

.factor-list{

    margin-top:20px;

    display:flex;

    flex-direction:column;

    gap:12px;
}

/* FACTOR ITEM */

.factor-item{

    background:white;

    padding:14px 18px;

    border-radius:14px;

    border-left:5px solid #AE2448;

    font-weight:500;

    color:#444;

    box-shadow:
    0 3px 10px rgba(0,0,0,0.04);
}


/* RESPONSIVE */

@media(max-width:768px){

    .details-container{
        padding:18px;
    }

    .report-card{
        padding:20px;
    }

    .analysis-grid{
        grid-template-columns:1fr;
    }
}

</style>

</head>

<body>

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
<a href="analytics.php">
Analytics
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

<div class="details-container">

<!-- TITLE -->

<div class="report-title">

<h1>
AI Health Report
</h1>

<p>
Personalized menstrual health analysis
based on your cycle patterns,
symptoms and lifestyle.
</p>

</div>

<!-- MAIN PREDICTION -->

<div class="prediction-box">

<h2>
<?php echo $data['prediction']; ?>
</h2>

<p>
<?php echo $data['risk_text']; ?>
</p>

</div>

<!-- DETECTED ANALYSIS -->

<div class="report-card">

<h3 class="section-heading">
📊 Detected Analysis
</h3>

<div class="analysis-grid">

<div class="analysis-card">

<h4>
Average Cycle Duration
</h4>

<p>
<?php echo round($cycle['avg_duration'],1); ?>
days
</p>

</div>

<div class="analysis-card">

<h4>
Stress Level
</h4>

<p>
<?php echo $lifestyle['stress_level']; ?>
</p>

</div>

<div class="analysis-card">

<h4>
Water Intake
</h4>

<p>
<?php echo $diet['water_intake']; ?>
L/day
</p>

</div>

<div class="analysis-card">

<h4>
Medical Condition
</h4>

<p>
<?php echo $medical['condition_type']; ?>
</p>

</div>

</div>

</div>

<!-- WHY THIS ANALYSIS -->

<div class="report-card">

<h3 class="section-heading">
🧠 Why This Analysis Was Generated
</h3>

<div class="info-box">

<p>

The AI system analyzed your
cycle duration trends, symptoms,
stress levels, hydration patterns,
diet and medical information
to generate this health report.

</p>

<div class="factor-list">

<?php

$notes =
explode(
".",
$data['analysis_notes']
);

foreach($notes as $note){

    if(trim($note) != ""){

        echo "
        <div class='factor-item'>
        ✔ ".trim($note)."
        </div>
        ";
    }
}

?>

</div>

</div>

</div>

<!-- SUGGESTIONS -->

<div class="report-card">

<h3 class="section-heading">
💡 Personalized Suggestions
</h3>

<div class="info-box">

<p>
<?php echo $data['suggestion']; ?>
</p>

</div>

</div>

<!-- RECOMMENDED ACTIONS -->

<div class="report-card">

<h3 class="section-heading">
✅ Recommended Actions
</h3>

<ul class="action-list">

<li>
Track your menstrual cycle regularly
</li>

<li>
Maintain proper hydration and
balanced nutrition
</li>

<li>
Exercise consistently for better
hormonal balance
</li>

<li>
Reduce stress through proper
sleep and relaxation
</li>

<li>
Monitor recurring symptoms carefully
</li>

<li>
Consult a healthcare professional
if symptoms continue
</li>

</ul>

</div>

</div>

</main>

</div>

</body>

</html>