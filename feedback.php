<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Feedback</title>

<link rel="stylesheet" href="./dashboard.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html,
body{
    width:100%;
    height:100%;
    overflow:hidden;
    font-family:Arial,sans-serif;
    background:#e6e8ed;
}

.grid-container,
.main-container{
    width:100%;
    height:100vh;
}

.feedback-container{

    width:100%;
    height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    padding:20px;
}

.feedback-card{

    width:100%;

    max-width:520px;

    background:white;

    padding:35px;

    border-radius:24px;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.08);
}

.feedback-card h1{

    color:#AE2448;

    margin-bottom:14px;

    text-align:center;

    font-size:42px;
}

.feedback-card p{

    color:#666;

    margin-bottom:24px;

    line-height:1.6;

    text-align:center;

    font-size:18px;
}

.feedback-form{

    display:flex;

    flex-direction:column;

    gap:18px;

    width:100%;
}

.feedback-form textarea{

    width:100%;

    min-height:170px;

    padding:18px;

    border:1px solid #ddd;

    border-radius:16px;

    resize:none;

    font-size:16px;

    outline:none;

    transition:0.3s;
}

.feedback-form textarea:focus{

    border-color:#AE2448;

    box-shadow:
    0 0 8px rgba(174,36,72,0.2);
}

.feedback-btn{

    width:100%;

    background:
    linear-gradient(
    to right,
    #AE2448,
    #e05a7a
    );

    color:white;

    border:none;

    padding:16px;

    border-radius:14px;

    cursor:pointer;

    font-size:18px;

    font-weight:bold;

    transition:0.3s;
}

.feedback-btn:hover{

    opacity:0.9;
}

.success-box{

    margin-top:20px;

    color:green;

    font-weight:bold;

    text-align:center;
}

@media(max-width:768px){

    .feedback-container{

        padding:16px;
    }

    .feedback-card{

        padding:24px;
    }

    .feedback-card h1{

        font-size:34px;
    }

    .feedback-card p{

        font-size:16px;
    }
}

</style>
</head>

<body>

<div class="grid-container">

<main class="main-container">

<div class="feedback-container">

<div class="feedback-card">

<h1>
💬 Feedback Form
</h1>

<p>
Help us improve Luna Cycle by sharing your experience.
</p>

<form
class="feedback-form"
id="feedbackForm">

<textarea
name="feedback"
placeholder="Write your feedback..."
required></textarea>

<button
class="feedback-btn"
type="submit">

Submit Feedback

</button>

</form>

<div
class="success-box"
id="successBox">
</div>

</div>

</div>

</main>

</div>

<script>

/* GOOGLE SHEET URL */

const scriptURL =
"https://script.google.com/a/macros/heritageit.edu.in/s/AKfycbymojP9UovWMgBjh4j_Bxj6I11pDr_I8CeksKRcfVVRP6OqnMZEciTVr-LuvME__INgAA/exec";

/* FORM */

const form =
document.getElementById(
"feedbackForm"
);

/* SUBMIT */

form.addEventListener(
"submit",

function(e){

    e.preventDefault();

    const formData =
    new FormData(form);

    const data = {

        feedback:
        formData.get("feedback")
    };

    fetch(scriptURL,{

        method:"POST",

        body:JSON.stringify(data)
    })

    .then(response => response.json())

    .then(data => {

        document
        .getElementById(
        "successBox"
        )

        .innerHTML =
        "✅ Feedback Submitted Successfully";

        form.reset();
    })

    .catch(error => {

        document
        .getElementById(
        "successBox"
        )

        .innerHTML =
        "❌ Submission Failed";
    });
});

</script>

</body>
</html>