<?php
$conn = new mysqli("localhost", "root", "", "luna_cycle");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // BASIC
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    // PROFESSIONAL
    $license = $_POST['license'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];
    $hospital = $_POST['hospital'];
    $location = $_POST['location'];

    // CHECK EMAIL
    $check = $conn->query("SELECT * FROM doctors WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('⚠️ Email already registered! Please login.');</script>";
    } else {

        // INSERT INTO doctors
        $sql1 = "INSERT INTO doctors (name, email, phone, password)
                 VALUES ('$name','$email','$phone','$password')";

        if ($conn->query($sql1) === TRUE) {

            $doctor_id = $conn->insert_id;

            // INSERT INTO doctor_details
            $sql2 = "INSERT INTO doctor_details 
            (doctor_id, license_number, specialization, experience, hospital, location)
            VALUES
            ('$doctor_id','$license','$specialization','$experience','$hospital','$location')";

            $conn->query($sql2);

            // ================= FILE UPLOAD FIX =================
            if (isset($_FILES['proof']) && $_FILES['proof']['error'] == 0) {

                $file_name = time() . "_" . $_FILES['proof']['name'];
                $tmp_name = $_FILES['proof']['tmp_name'];

                $allowed = ['jpg','jpeg','png','pdf'];
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed)) {
                    echo "<script>alert('Only JPG, PNG, PDF allowed!');</script>";
                    exit();
                }

                $folder = "uploads/" . $file_name;

                if (!move_uploaded_file($tmp_name, $folder)) {
                    echo "<script>alert('File upload failed!');</script>";
                    exit();
                }

                // INSERT INTO verification
                $sql3 = "INSERT INTO doctor_verification (doctor_id, document_path)
                         VALUES ('$doctor_id','$folder')";

                $conn->query($sql3);

            } else {
                echo "<script>alert('Please upload a valid certificate!');</script>";
                exit();
            }
            // ===================================================

            // REDIRECT
            header("Location: doctorlogin.php?success=1");
            exit();

        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doctor Signup - Luna Cycle</title>

<link rel="stylesheet" href="doctor_signup.css">

<style>
.required { color:red; }

/* FILE UI */
.file-upload {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 8px;
}

.file-upload input {
    display: none;
}

.file-label {
    background: linear-gradient(to right, #AE2448, #e05a7a);
    color: white;
    padding: 10px 18px;
    border-radius: 25px;
    cursor: pointer;
}

#file-name {
    font-size: 0.85rem;
    color: #555;
}
</style>

</head>

<body>

<div class="container">

<h1>Doctor Registration</h1>

<form method="POST" enctype="multipart/form-data" onsubmit="return validateDoctor()">

<!-- BASIC -->

<div class="section">
<h2>Basic Information</h2>

<label>Name *</label> <input type="text" name="name" required>

<label>Email *</label> <input type="email" name="email" required>

<label>Phone *</label> <input type="tel" name="phone" required>

</div>

<!-- PROFESSIONAL -->

<div class="section">
<h2>Professional Details</h2>

<label>License Number *</label> <input type="text" name="license" required>

<label>Specialization *</label> <select name="specialization" required>

<option value="">Select</option>
<option>Gynecologist</option>
<option>General Physician</option>
<option>Endocrinologist</option>
<option>Other</option>
</select>

<label>Experience (years) *</label> <input type="number" name="experience" required>

<label>Hospital *</label> <input type="text" name="hospital" required>

<label>Location *</label> <input type="text" name="location" required>

</div>

<!-- VERIFICATION -->

<div class="section">
<h2>Verification</h2>

<label>Upload Certificate <span class="required">*</span></label>

<div class="file-upload">
    <input type="file" id="proof" name="proof" accept=".jpg,.jpeg,.png,.pdf" required>
    <label for="proof" class="file-label">Upload</label>
    <span id="file-name">No file selected</span>
</div>
<p class="file-info">
    📄 Allowed: JPG, PNG, PDF | 📏 Max size: 2MB
</p>
</div>

<!-- PASSWORD -->

<div class="section">
<h2>Security</h2>

<label>Password *</label> <input type="password" id="pass" name="pass" required>

<label>Confirm *</label> <input type="password" id="confirm" required>

</div>

<button type="submit" class="submit-btn">Register as Doctor</button>

<p class="login-text">Already registered?</p>
<a href="doctor_login.php" class="login-btn">Doctor Login</a>

</form>

</div>

<script>
// PASSWORD VALIDATION
function validateDoctor() {
    let pass = document.getElementById("pass").value;
    let confirm = document.getElementById("confirm").value;

    if (pass !== confirm) {
        alert("❌ Passwords do not match!");
        return false;
    }
    return true;
}

// FILE NAME DISPLAY
window.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("proof");
    const fileName = document.getElementById("file-name");

    fileInput.addEventListener("change", function () {
        if (this.files.length > 0) {
            fileName.textContent = this.files[0].name;
        } else {
            fileName.textContent = "No file selected";
        }
    });
});
</script>

</body>
</html>
