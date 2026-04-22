<?php
session_start();
//check if the user exists
if(!isset($_SESSION['user_id'])){
    header("Location: user_login.php");
    exit();
}
//make connection between db and file
$conn = new mysqli(
    "localhost",
    "root",
    "",
    "luna_cycle"
);

$user_id = $_SESSION['user_id'];
//fetch user details
$user = $conn->query(
"SELECT * FROM users WHERE user_id='$user_id'"
)->fetch_assoc();

/* profile image */

if(
!empty($user['profile']) &&
file_exists("uploads/".$user['profile'])
){

    $img = "uploads/".$user['profile'];

}else{

    $img = "https://cdn-icons-png.flaticon.com/512/847/847969.png";
}
?>

<!DOCTYPE html>

<html>
<head>

<title>Profile</title>

<link rel="stylesheet" href="dashboard.css">
<link rel="stylesheet" href="profile.css">

</head>

<body>

<div class="grid-container">

<header class="header">
    <h2>Luna Cycle</h2>
</header>

<aside id="sidebar">

<ul class="sidebar-list">

<li>
<a href="user_dashboard.php">
Dashboard
</a>
</li>

<li>
<a href="profile.php" class="active">
Profile
</a>
</li>

<li>
<a href="cycle_data.php">
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

<main class="main-container">

<div class="profile-wrapper">

<div class="profile-box">

<h2 class="profile-title">
My Profile
</h2>

<form
method="POST"
action="update_profile.php"
enctype="multipart/form-data"
>

<!-- IMAGE -->


<div class="profile-top">

<img
src="<?php echo $img.'?v='.time(); ?>"
class="profile-img"
id="preview-img"
>

<div class="upload-section">

<input
type="file"
name="profile"
id="file-input"
accept="image/*"
hidden
>

<label for="file-input" class="upload-btn">
Upload Photo
</label>

</div>

</div>

<!-- INPUTS -->

<div class="input-group">

<input
type="text"
name="name"
value="<?php echo $user['name']; ?>"
placeholder="Full Name"
required
>

<input
type="number"
name="age"
value="<?php echo $user['age']; ?>"
placeholder="Age"
required
>

<input
type="text"
name="phone"
value="<?php echo $user['phone']; ?>"
placeholder="Phone"
required
>

<input
type="email"
name="email"
value="<?php echo $user['email']; ?>"
placeholder="Email"
required
>

</div>

<button class="submit-btn">
Update Profile
</button>

</form>

</div>

</div>

</main>

</div>

<script>

const fileInput =
document.getElementById("file-input");

const preview =
document.getElementById("preview-img");

fileInput.addEventListener(
"change",
function(e){

    const file = e.target.files[0];

    if(file){

        preview.src =
        URL.createObjectURL(file);
    }
});

</script>

</body>
</html>