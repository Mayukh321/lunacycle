<?php

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
   FETCH USER DATA
========================= */

/* SYMPTOMS */

$symptom = $conn->query("
SELECT * FROM symptoms
WHERE user_id='$user_id'
")->fetch_assoc();

/* LIFESTYLE */

$lifestyle = $conn->query("
SELECT * FROM lifestyle
WHERE user_id='$user_id'
")->fetch_assoc();

/* DIET */

$diet = $conn->query("
SELECT * FROM diet
WHERE user_id='$user_id'
")->fetch_assoc();

/* MEDICAL */

$medical = $conn->query("
SELECT * FROM medical
WHERE user_id='$user_id'
")->fetch_assoc();

/* CYCLE HISTORY */

$cycles = $conn->query("
SELECT * FROM cycle_history
WHERE user_id='$user_id'
");

/* =========================
   ANALYZE CYCLE HISTORY
========================= */

$total_duration = 0;

$total_cycles = 0;

$long_cycles = 0;

while($row = $cycles->fetch_assoc()){

    $total_duration += $row['duration'];

    $total_cycles++;

    if($row['duration'] > 7){
        $long_cycles++;
    }
}

/* AVERAGE */

$avg_duration = 0;

if($total_cycles > 0){

    $avg_duration =
    $total_duration / $total_cycles;
}

/* =========================
   AI RISK ENGINE
========================= */

$risk_score = 0;

$analysis_notes = [];

/* =========================
   CYCLE ANALYSIS
========================= */

if($avg_duration > 7){

    $risk_score += 15;

    $analysis_notes[] =
    "Long cycle duration detected.";
}

/* =========================
   HEAVY BLEEDING
========================= */

if($symptom['heavy_bleeding']){

    $risk_score += 20;

    $analysis_notes[] =
    "Heavy bleeding symptoms found.";
}

/* =========================
   CRAMPS
========================= */

if($symptom['cramps']){

    $risk_score += 10;

    $analysis_notes[] =
    "Menstrual cramps detected.";
}

/* =========================
   STRESS
========================= */

if(
$lifestyle['stress_level']
== "High"
){

    $risk_score += 15;

    $analysis_notes[] =
    "High stress levels detected.";
}

/* =========================
   LOW SLEEP
========================= */

if(
$lifestyle['sleep_hours']
< 6
){

    $risk_score += 10;

    $analysis_notes[] =
    "Low sleep duration detected.";
}

/* =========================
   LOW WATER
========================= */

if(
$diet['water_intake']
< 2
){

    $risk_score += 10;

    $analysis_notes[] =
    "Low hydration level found.";
}

/* =========================
   JUNK FOOD
========================= */

if(
$diet['junk_food']
== "Frequent"
){

    $risk_score += 5;

    $analysis_notes[] =
    "Frequent junk food intake detected.";
}

/* =========================
   POSSIBLE PCOS
========================= */

if(
$symptom['acne']
&&
$symptom['irregular']
&&
$symptom['hair_loss']
){

    $risk_score += 25;

    $analysis_notes[] =
    "Possible hormonal imbalance patterns detected.";
}

/* =========================
   THYROID
========================= */

if(
$medical['condition_type']
== "Hypothyroidism"
){

    $risk_score += 15;

    $analysis_notes[] =
    "Hypothyroidism may affect cycle regularity.";
}

/* =========================
   FINAL AI RESULT
========================= */

if($risk_score >= 60){

    $prediction =
    "High Menstrual Health Risk";

    $risk_text =
    "Multiple health risk factors detected.";

    $suggestion =
    "Consult healthcare professional and monitor symptoms carefully.";
}

elseif($risk_score >= 30){

    $prediction =
    "Moderate Menstrual Health Concern";

    $risk_text =
    "Some menstrual irregularities and lifestyle concerns detected.";

    $suggestion =
    "Improve sleep, hydration, nutrition and stress management.";
}

else{

    $prediction =
    "Normal Cycle";

    $risk_text =
    "No major menstrual health concerns detected.";

    $suggestion =
    "Maintain healthy lifestyle and continue regular cycle tracking.";
}

/* =========================
   ADD ANALYSIS NOTES
========================= */

$risk_text .= " ";

$risk_text .= implode(
" ",
$analysis_notes
);

/* =========================
   INSERT PREDICTION
========================= */

$insert = $conn->query("
INSERT INTO predictions
(
    user_id,
    prediction,
    risk_text,
    suggestion,
    analysis_notes
)

VALUES

(
    '$user_id',
    '$prediction',
    '$risk_text',
    '$suggestion',
    '".implode(" ",$analysis_notes)."'
)
");

if(!$insert){
    die($conn->error);
}

?>