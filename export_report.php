<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: user_login.php");
    exit();
}

/* DATABASE */

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "luna_cycle"
);

$user_id = $_SESSION['user_id'];

/* USER */

$user = $conn->query("
SELECT *
FROM users
WHERE user_id='$user_id'
")->fetch_assoc();

/* PREDICTION */

$prediction = $conn->query("
SELECT *
FROM predictions
WHERE user_id='$user_id'
ORDER BY prediction_id DESC
LIMIT 1
")->fetch_assoc();

/* CYCLE */

$cycle = $conn->query("
SELECT
AVG(duration) AS avg_duration,
COUNT(*) AS total_cycles
FROM cycle_history
WHERE user_id='$user_id'
")->fetch_assoc();

/* SYMPTOMS */

$symptom = $conn->query("
SELECT *
FROM symptoms
WHERE user_id='$user_id'
")->fetch_assoc();

/* LIFESTYLE */

$lifestyle = $conn->query("
SELECT *
FROM lifestyle
WHERE user_id='$user_id'
")->fetch_assoc();

/* DIET */

$diet = $conn->query("
SELECT *
FROM diet
WHERE user_id='$user_id'
")->fetch_assoc();

?>

<!DOCTYPE html>

<html>

<head>

<title>
AI Health Report
</title>
<script src=
"https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js">
</script>
<style>

body{

    background:#f4f5f8;

    font-family:sans-serif;

    padding:40px;
}

.report-container{

    max-width:900px;

    margin:auto;

    background:white;

    padding:40px;

    border-radius:24px;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.08);
}

h1{

    color:#AE2448;

    margin-bottom:10px;
}

.section{

    margin-top:30px;
}

.section h2{

    color:#AE2448;

    margin-bottom:15px;
}

.info-box{

    background:#fafafa;

    padding:18px;

    border-radius:18px;

    margin-bottom:15px;
}

p{

    line-height:1.8;

    color:#444;
}

.download-note{

    margin-top:30px;

    text-align:center;

    color:#777;
}


</style>

</head>

<body>

<div class="report-container"
id="reportContent">

<h1>
Luna Cycle AI Health Report
</h1>

<p>

Generated AI-based menstrual
health analysis report.

</p>

<!-- USER -->

<div class="section">

<h2>
👤 User Information
</h2>

<div class="info-box">

<p>
<strong>Name:</strong>

<?php
echo $user['name'];
?>
</p>

<p>
<strong>Total Cycles:</strong>

<?php
echo $cycle['total_cycles'];
?>
</p>

<p>
<strong>Average Cycle:</strong>

<?php
echo round($cycle['avg_duration'],1);
?>

days
</p>

</div>

</div>

<!-- AI REPORT -->

<div class="section">

<h2>
🧠 AI Prediction
</h2>

<div class="info-box">

<p>

<strong>
<?php
echo $prediction['prediction'];
?>
</strong>

</p>

<p>

<?php
echo $prediction['risk_text'];
?>

</p>

<p>

<?php
echo $prediction['suggestion'];
?>

</p>

</div>

</div>

<!-- LIFESTYLE -->

<div class="section">

<h2>
🌿 Lifestyle Analysis
</h2>

<div class="info-box">

<p>

Stress Level:
<strong>

<?php
echo $lifestyle['stress_level'];
?>

</strong>

</p>

<p>

Sleep Duration:
<strong>

<?php
echo $lifestyle['sleep_duration'];
?>

hours

</strong>

</p>

<p>

Exercise Frequency:
<strong>

<?php
echo $lifestyle['exercise_frequency'];
?>

</strong>

</p>

</div>

</div>

<!-- DIET -->

<div class="section">

<h2>
💧 Diet & Hydration
</h2>

<div class="info-box">

<p>

Water Intake:
<strong>

<?php
echo $diet['water_intake'];
?>

L/day

</strong>

</p>

<p>

Balanced Diet:
<strong>

<?php
echo $diet['balanced_diet'];
?>

</strong>

</p>

</div>

</div>

<!-- SYMPTOMS -->

<div class="section">

<h2>
⚠️ Symptoms
</h2>

<div class="info-box">

<p>

Cramps:
<strong>

<?php
echo $symptom['cramps']
? "Yes" : "No";
?>

</strong>

</p>

<p>

Heavy Bleeding:
<strong>

<?php
echo $symptom['heavy_bleeding']
? "Yes" : "No";
?>

</strong>

</p>

<p>

Mood Swings:
<strong>

<?php
echo $symptom['mood_swings']
? "Yes" : "No";
?>

</strong>

</p>

</div>

</div>

<div class="download-note">

AI-generated report created by
Luna Cycle.

</div>


</button>

</div>

</div>

<script>

/* AUTO PDF DOWNLOAD */

window.onload = function(){

    const element =
    document.getElementById(
    "reportContent"
    );

    const options = {

        margin:0.5,

        filename:
        '<?php
        echo $user["name"];
        ?>_report.pdf',

        image:{
            type:'jpeg',
            quality:0.98
        },

        html2canvas:{
            scale:2
        },

        jsPDF:{
            unit:'in',
            format:'a4',
            orientation:'portrait'
        }
    };

    html2pdf()
    .set(options)
    .from(element)
    .save();
};

</script>

</body>

</html>