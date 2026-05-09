<?php

session_start();

/* DATABASE */

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

/* USER MESSAGE */

$message =
strtolower($_POST['message']);

/* =========================
   FETCH USER DATA
========================= */

/* PREDICTION */

$prediction = $conn->query("
SELECT *
FROM predictions
WHERE user_id='$user_id'
ORDER BY prediction_id DESC
LIMIT 1
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

/* MEDICAL */

$medical = $conn->query("
SELECT *
FROM medical
WHERE user_id='$user_id'
")->fetch_assoc();

/* CYCLE */

$cycle = $conn->query("
SELECT AVG(duration) AS avg_duration
FROM cycle_history
WHERE user_id='$user_id'
")->fetch_assoc();

/* =========================
   DEFAULT RESPONSE
========================= */

$response =
"I am your Luna Cycle AI assistant. Ask me about your cycle health, symptoms, stress, sleep or AI report.";

/* =========================
   AI REPORT
========================= */

if(
    strpos($message,"report") !== false
    ||
    strpos($message,"prediction") !== false
){

    $response =
    "Your current AI prediction is: "
    . $prediction['prediction'] .
    ". " .
    $prediction['risk_text'] .
    ".";
}

/* =========================
   WHY REPORT
========================= */

elseif(
    strpos($message,"why") !== false
    ||
    strpos($message,"reason") !== false
){

    $response =
    "Your AI report was generated using your cycle trends, symptoms, stress levels, lifestyle and health patterns.";
}

/* =========================
   HEALTH STATUS
========================= */

elseif(
    strpos($message,"health") !== false
){

    $response =
    "Your average cycle duration is "
    . round($cycle['avg_duration'],1) .
    " days. Current AI analysis indicates: "
    . $prediction['prediction'] .
    ".";
}

/* =========================
   CRAMPS
========================= */

elseif(
    strpos($message,"cramp") !== false
){

    if($symptom['cramps']){

        $response =
        "You recently reported cramps symptoms. Proper hydration, light exercise and sleep may help reduce discomfort.";

    }else{

        $response =
        "No major cramps symptoms were recently detected in your records.";
    }
}

/* =========================
   STRESS
========================= */

elseif(
    strpos($message,"stress") !== false
){

    if(
    $lifestyle['stress_level']
    == "High"
    ){

        $response =
        "Your recent lifestyle analysis detected high stress levels which may affect hormonal balance and menstrual regularity.";
    }

    elseif(
    $lifestyle['stress_level']
    == "Moderate"
    ){

        $response =
        "Moderate stress levels were detected. Proper sleep and relaxation may help maintain hormonal balance.";
    }

    else{

        $response =
        "Your stress levels currently appear stable according to your recent lifestyle analysis.";
    }
}
/* =========================
   SLEEP
========================= */

elseif(
    strpos($message,"sleep") !== false
){

    if(
    $lifestyle['sleep_hours']
    < 6
    ){

        $response =
        "Your recent health analysis detected low sleep duration. Poor sleep may affect hormonal balance and menstrual regularity.";
    }

    elseif(
    $lifestyle['sleep_hours']
    < 8
    ){

        $response =
        "Your sleep duration appears moderate. Improving sleep quality may help support better menstrual wellness.";
    }

    else{

        $response =
        "Your current sleep duration appears healthy according to your lifestyle analysis.";
    }
}

/* =========================
   WATER
========================= */

elseif(
    strpos($message,"water") !== false
){

    if(
    $diet['water_intake']
    < 2
    ){

        $response =
        "Your hydration level appears lower than recommended. Increasing water intake may help improve menstrual wellness and reduce fatigue.";
    }

    elseif(
    $diet['water_intake']
    < 3
    ){

        $response =
        "Your hydration level appears moderate. Maintaining regular water intake supports hormonal and menstrual health.";
    }

    else{

        $response =
        "Your hydration tracking appears healthy according to your recent lifestyle analysis.";
    }
}

/* =========================
   PCOS
========================= */

elseif(
    strpos($message,"pcos") !== false
){

    if(
        $symptom['acne']
        &&
        $symptom['irregular']
    ){

        $response =
        "Your records show symptoms sometimes associated with hormonal imbalance such as acne and irregular cycles. Consulting a healthcare professional may help.";

    }else{

        $response =
        "PCOS may cause irregular periods, acne and hormonal imbalance. Healthy lifestyle habits may help improve symptoms.";
    }
}

/* =========================
   PERIOD
========================= */

elseif(
    strpos($message,"period") !== false
){

    $response =
    "Your average menstrual cycle length is approximately "
    . round($cycle['avg_duration'],1) .
    " days based on your recorded cycle history.";
}

/* =========================
   MEDICAL
========================= */

elseif(
    strpos($message,"medical") !== false
    ||
    strpos($message,"condition") !== false
){

    $response =
    "Your recorded medical condition is: "
    . $medical['condition_type'] .
    ". Continue regular monitoring and follow medical guidance if necessary.";
}

/* =========================
   DIET
========================= */

elseif(
    strpos($message,"diet") !== false
    ||
    strpos($message,"food") !== false
){

    $response =
    "Balanced nutrition, hydration and reduced junk food intake may help improve menstrual health and hormonal balance.";
}

/* =========================
   EXERCISE
========================= */

elseif(
    strpos($message,"exercise") !== false
){

    $response =
    "Your recorded exercise frequency is "
    . $lifestyle['exercise_frequency'] .
    ". Regular exercise may help improve hormonal balance and reduce stress.";
}

echo $response;

?>