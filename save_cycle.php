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

if($conn->connect_error){
    die("Connection Failed");
}

$user_id = $_SESSION['user_id'];

/* =========================
   CYCLE DATES
========================= */

$start = $_POST['start'];
$end = $_POST['end'];

/* VALIDATION */

if(empty($start) || empty($end)){

    echo "
    <script>
    alert('Please select both dates');
    window.location='cycle_data.php';
    </script>
    ";

    exit();
}

if($end < $start){

    echo "
    <script>
    alert('End date cannot be before start date');
    window.location='cycle_data.php';
    </script>
    ";

    exit();
}

/* CALCULATE DURATION */

$duration =
(strtotime($end) - strtotime($start))
/ (60*60*24) + 1;

/* MONTH + YEAR */

$month = date("F", strtotime($start));

$year = date("Y", strtotime($start));

/* =========================
   SAVE CYCLE HISTORY
========================= */

$cycle_sql = "
INSERT INTO cycle_history
(
    user_id,
    start_date,
    end_date,
    duration,
    month,
    year
)

VALUES

(
    '$user_id',
    '$start',
    '$end',
    '$duration',
    '$month',
    '$year'
)
";

if(!$conn->query($cycle_sql)){
    die($conn->error);
}

/* =========================
   SYMPTOMS
========================= */

$cramps =
isset($_POST['cramps']) ? 1 : 0;

$heavy_bleeding =
isset($_POST['heavy_bleeding']) ? 1 : 0;

$mood_swings =
isset($_POST['mood_swings']) ? 1 : 0;

$acne =
isset($_POST['acne']) ? 1 : 0;

$hair_loss =
isset($_POST['hair_loss']) ? 1 : 0;

$irregular =
isset($_POST['irregular']) ? 1 : 0;

/* UPDATE SYMPTOMS */

$conn->query("
UPDATE symptoms SET

cramps='$cramps',
heavy_bleeding='$heavy_bleeding',
mood_swings='$mood_swings',
acne='$acne',
hair_loss='$hair_loss',
irregular='$irregular'

WHERE user_id='$user_id'
");

/* =========================
   LIFESTYLE
========================= */

$stress = $_POST['stress'];

$sleep = $_POST['sleep'];

$exercise = $_POST['exercise'];

/* UPDATE LIFESTYLE */

$conn->query("
UPDATE lifestyle SET

stress_level='$stress',
sleep_duration='$sleep',
exercise_frequency='$exercise'

WHERE user_id='$user_id'
");

/* =========================
   DIET
========================= */

$balanced = $_POST['balanced'];

$junk = $_POST['junk'];

$water = $_POST['water'];

/* UPDATE DIET */

$conn->query("
UPDATE diet SET

balanced_diet='$balanced',
junk_food='$junk',
water_intake='$water'

WHERE user_id='$user_id'
");

/* =========================
   MEDICAL
========================= */

$condition = $_POST['condition'];

$medication = $_POST['medication'];

$medication_details =
$_POST['medication_details'];

/* UPDATE MEDICAL */

$conn->query("
UPDATE medical SET

condition_type='$condition',
medication='$medication',
medication_details='$medication_details'

WHERE user_id='$user_id'
");

/* =========================
   DELETE OLD PREDICTION
========================= */

$conn->query("
DELETE FROM predictions
WHERE user_id='$user_id'
");

/* =========================
   RUN AI PREDICTION
========================= */

include("predict.php");

/* =========================
   REDIRECT
========================= */

header("Location: user_dashboard.php");

?>