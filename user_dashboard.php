<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: user_login.php");
    exit();
}

/* DATABASE CONNECTION */

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "luna_cycle"
);

/* CHECK CONNECTION */

if($conn->connect_error){
    die("Connection Failed");
}

/* USER ID */

$user_id = $_SESSION['user_id'];

/* FETCH USER */

$user = $conn->query("
SELECT *
FROM users
WHERE user_id='$user_id'
")->fetch_assoc();

/* AI PREDICTION */

include("predict.php");

?>

<!DOCTYPE html>

<html>

<head>

<title>Dashboard</title>

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="dashboard.css">


</head>

<body>

<div class="grid-container">

<!-- HEADER -->

<header class="header">

<h2>
Luna Cycle
</h2>

<div class="export-wrapper">

<div
class="export-icon"

onclick="toggleExport()">

📥

</div>

<div
class="export-dropdown"

id="exportDropdown">

<p>
Download AI Report
</p>

<input
type="text"

value="<?php
echo $user['name'];
?>_report.pdf"

readonly>

<a href="export_report.php" target="_blank" class="download-btn">

Download

</a>

</div>

</div>

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

<!-- TITLE -->

<div class="dashboard-title">

<h1>
Dashboard
</h1>

<p>

Welcome to your AI-powered
menstrual health monitoring
dashboard.

Track cycle patterns, symptoms,
lifestyle trends and personalized
health suggestions.

</p>

</div>

<!-- AI SECTION -->

<h3 class="section-title">

AI Health Suggestions

</h3>

<!-- AI CARD -->

<a href="suggestion_details.php"
class="suggestion-card">

<div class="card-icon">
⚠️
</div>

<div class="card-content">

<h3>
<?php echo $prediction; ?>
</h3>

<p>
<?php echo $risk_text; ?>
</p>

<p class="mini-analysis">

AI analyzed your cycle trends,
symptoms, lifestyle patterns,
diet and medical information
to generate this health report.

</p>

<span class="analysis-link">

View Full AI Health Analysis →

</span>

</div>

</a>

<a href="cycle_prediction.php"
class="suggestion-card">

<div class="card-icon">
📅
</div>

<div class="card-content">

<h3>
Cycle Predictions
</h3>

<p>

View your next predicted period,
ovulation window and cycle trend
analysis.

</p>

<span class="analysis-link">

View Cycle Predictions →

</span>

</div>

</a>


<br><br>

<a href="analytics.php"
class="suggestion-card">

<div class="card-icon">
📊
</div>

<div class="card-content">

<h3>
Health Analytics
</h3>

<p>

View AI-generated health
analytics, cycle trends and
lifestyle insights.

</p>

<span class="analysis-link">

View Analytics →

</span>

</div>

</a>

</main>

</div>

<link rel="stylesheet"
href="chatbot.css">

<!-- CHAT BUTTON -->

<div class="chatbot-toggle"
id="chatbotToggle">

💬

</div>

<!-- CHATBOX -->

<div class="chatbot-box"
id="chatbotBox">

<div class="chatbot-header">

Luna AI Assistant

</div>

<div class="chatbot-body"
id="chatbotBody">

<div class="bot-message">

Hello 👋
I am your AI menstrual
health assistant.

</div>

</div>

<div class="chatbot-input">

<input
type="text"
id="userInput"
placeholder="Ask something...">

<button onclick="sendMessage()">

Send

</button>

</div>

</div>

<script src="chatbot.js"></script>

<script>

function toggleExport(){

    document
    .getElementById(
    "exportDropdown"
    )

    .classList
    .toggle(
    "show-export"
    );
}

</script>

</body>

</html>