<?php
$conn = new mysqli("localhost", "root", "", "luna_cycle");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // BASIC
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $age = intval($_POST['age']);
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    // INSERT USER
    $sql1 = "INSERT INTO users
    (name, dob, age, phone, email, password)
    VALUES
    ('$name','$dob','$age','$phone','$email','$password')";

    if ($conn->query($sql1) === TRUE) {

        $user_id = $conn->insert_id;

        // ================= CYCLE HISTORY =================

        function insertCycle($conn, $user_id, $start, $end) {

            if(!empty($start) && !empty($end)){

                $duration =
                (strtotime($end) - strtotime($start)) / (60*60*24) + 1;

                $month = date("F", strtotime($start));
                $year = date("Y", strtotime($start));

                $sql = "INSERT INTO cycle_history
                (user_id, start_date, end_date, duration, month, year)
                VALUES
                ('$user_id','$start','$end','$duration','$month','$year')";

                $conn->query($sql);
            }
        }

        insertCycle($conn,$user_id,$_POST['s1'],$_POST['e1']);
        insertCycle($conn,$user_id,$_POST['s2'],$_POST['e2']);
        insertCycle($conn,$user_id,$_POST['s3'],$_POST['e3']);

        // ================= SYMPTOMS =================

        $conn->query("INSERT INTO symptoms
        (
            user_id, cramps, irregular, missed,
            heavy_bleeding, acne, excess_hair,
            hair_loss, mood_swings
        )
        VALUES
        (
            '$user_id',
            '".isset($_POST['cramps'])."',
            '".isset($_POST['irregular'])."',
            '".isset($_POST['missed'])."',
            '".isset($_POST['heavy_bleeding'])."',
            '".isset($_POST['acne'])."',
            '".isset($_POST['excess_hair'])."',
            '".isset($_POST['hair_loss'])."',
            '".isset($_POST['mood_swings'])."'
        )");

        // ================= LIFESTYLE =================

        $conn->query("INSERT INTO lifestyle
        (user_id, stress_level, sleep_hours, exercise)
        VALUES
        (
            '$user_id',
            '".$_POST['stress']."',
            '".$_POST['sleep']."',
            '".$_POST['exercise']."'
        )");

        // ================= DIET =================

        $conn->query("INSERT INTO diet
        (user_id, balanced_diet, junk_food, water_intake)
        VALUES
        (
            '$user_id',
            '".$_POST['balanced']."',
            '".$_POST['junk']."',
            '".$_POST['water']."'
        )");

        // ================= MEDICAL =================

        $conn->query("INSERT INTO medical
        (user_id, condition_type, medication, medication_details)
        VALUES
        (
            '$user_id',
            '".$_POST['condition']."',
            '".$_POST['medication']."',
            '".$_POST['medication_details']."'
        )");

        header("Location: user_login.php?success=1");
        exit();

    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>User Signup - Luna Cycle</title>

<link rel="stylesheet" href="user_signup.css">

</head>

<body>

<div class="container">

<h1>🩺 Menstrual Cycle Form</h1>

<form method="POST" onsubmit="return validateForm()">

<!-- BASIC -->

<div class="section">

<h2>🧍 Basic Details</h2>

<label>Full Name *</label> <input type="text" name="name" required>

<label>Date of Birth *</label> <input type="date" id="dob" name="dob" onchange="calculateAge()" required>

<label>Age</label> <input type="text" id="age" name="age" readonly>

<label>Phone *</label> <input type="tel" name="phone" required>

<label>Email</label> <input type="email" name="email">

<label>Height (cm)</label> <input type="number" name="height">

<label>Weight (kg)</label> <input type="number" name="weight">

</div>

<!-- CYCLE -->

<div class="section">

<h2>🩸 Cycle History</h2>

<h4>Cycle 1</h4>

<input type="date" name="s1" id="s1">
<input type="date" name="e1" id="e1">

<h4>Cycle 2</h4>

<input type="date" name="s2" id="s2">
<input type="date" name="e2" id="e2">

<h4>Cycle 3</h4>

<input type="date" name="s3" id="s3">
<input type="date" name="e3" id="e3">

<label>Average Cycle Length</label>

<input type="number" id="avg_cycle" name="avg_cycle" readonly>

<label>Flow Intensity</label>

<select name="flow">
<option>Light</option>
<option>Medium</option>
<option>Heavy</option>
</select>

<label>Is your cycle regular?</label>

<select name="regular">
<option>Yes</option>
<option>No</option>
</select>

</div>

<!-- SYMPTOMS -->

<div class="section">

<h2>⚠️ Symptoms</h2>

<div class="checkbox-group">

<label><input type="checkbox" name="cramps"> Severe cramps</label>

<label><input type="checkbox" name="irregular"> Irregular periods</label>

<label><input type="checkbox" name="missed"> Missed periods</label>

<label><input type="checkbox" name="heavy_bleeding"> Heavy bleeding</label>

<label><input type="checkbox" name="acne"> Acne</label>

<label><input type="checkbox" name="excess_hair"> Excess facial/body hair</label>

<label><input type="checkbox" name="hair_loss"> Hair loss</label>

<label><input type="checkbox" name="mood_swings"> Mood swings</label>

</div>

</div>

<!-- LIFESTYLE -->

<div class="section">

<h2>🧠 Lifestyle</h2>

<label>Stress Level</label>

<select name="stress">
<option>Low</option>
<option>Moderate</option>
<option>High</option>
</select>

<label>Sleep Duration (hours)</label> <input type="number" name="sleep">

<label>Exercise Frequency</label>

<select name="exercise">
<option>None</option>
<option>1-2 Days</option>
<option>3-5 Days</option>
<option>Daily</option>
</select>

</div>

<!-- DIET -->

<div class="section">

<h2>🍽️ Diet & Nutrition</h2>

<label>Balanced Diet?</label>

<select name="balanced">
<option>Yes</option>
<option>No</option>
</select>

<label>Junk Food Consumption</label>

<select name="junk">
<option>Rare</option>
<option>Sometimes</option>
<option>Frequent</option>
</select>

<label>Water Intake (litres/day)</label>
<input 
type="number"
step="0.1"
min="0.0"
value="0.0"
name="water"
placeholder="0.0">

</div>

<!-- MEDICAL -->

<div class="section">

<h2>🏥 Medical Information</h2>

<label>Condition</label>

<select name="condition">
<option>None</option>
<option>PCOS</option>
<option>Hypothyroidism</option>
<option>Diabetes</option>
</select>

<label>Taking Medication?</label>

<select name="medication">
<option>No</option>
<option>Yes</option>
</select>

<label>Medication Details</label>

<textarea name="medication_details"></textarea>

</div>

<!-- PASSWORD -->

<div class="section">

<h2>🔒 Security</h2>

<label>Password *</label> <input type="password" id="pass" name="pass" required>

<label>Confirm Password *</label> <input type="password" id="confirm" required>

</div>

<button type="submit" class="submit-btn">
Create Account
</button>

<p class="login-text">Already have an account?</p>

<a href="user_login.php" class="login-btn">
Login
</a>

</form>

</div>

<script>
//AGE calculation
function calculateAge() {

    let dob = document.getElementById("dob").value;

    let birth = new Date(dob);
    let today = new Date();

    let age = today.getFullYear() - birth.getFullYear();

    let m = today.getMonth() - birth.getMonth();

    if(m < 0 || (m === 0 && today.getDate() < birth.getDate())){
        age--;
    }

    document.getElementById("age").value = age;
}

//cal avg cycle
function calculateAverageCycle() {

    let cycles = [];

    for(let i=1; i<=3; i++) {

        let start =
        document.getElementById("s"+i).value;

        let end =
        document.getElementById("e"+i).value;

        if(start && end) {

            let s = new Date(start);
            let e = new Date(end);

            let diff =
            (e - s) / (1000 * 60 * 60 * 24) + 1;

            if(diff > 0) {
                cycles.push(diff);
            }
        }
    }

    if(cycles.length > 0) {

        let total = 0;

        cycles.forEach(c => total += c);

        let avg = total / cycles.length;

        document.getElementById("avg_cycle").value =
        avg.toFixed(1);
    }
}

/* AUTO CALCULATE */

document.querySelectorAll("input[type='date']")
.forEach(input => {

    input.addEventListener(
        "change",
        calculateAverageCycle
    );
});
function validateForm() {

    let pass = document.getElementById("pass").value;
    let confirm = document.getElementById("confirm").value;

    if(pass !== confirm){
        alert("Passwords do not match!");
        return false;
    }

    return true;
}

</script>

</body>
</html>
