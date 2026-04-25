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

if($conn->connect_error){
    die("Connection Failed : ".$conn->connect_error);
}

$user_id = $_SESSION['user_id'];

/* CURRENT USER */

$user = $conn->query(
"SELECT * FROM users WHERE user_id='$user_id'"
)->fetch_assoc();

/* FORM DATA */

$name  = $_POST['name'];
$age   = $_POST['age'];
$phone = $_POST['phone'];
$email = $_POST['email'];

/* OLD IMAGE */

$profile_name = $user['profile'];

/* IMAGE UPLOAD */

if(
isset($_FILES['profile']) &&
$_FILES['profile']['error'] == 0
){

    /* CREATE uploads FOLDER */

    if(!is_dir("uploads")){
        mkdir("uploads",0777,true);
    }

    /* FILE */

    $tmp_name =
    $_FILES['profile']['tmp_name'];

    $original_name =
    $_FILES['profile']['name'];

    /* EXTENSION */

    $extension =
    strtolower(
        pathinfo(
            $original_name,
            PATHINFO_EXTENSION
        )
    );

    /* ALLOWED TYPES */

    $allowed =
    ['jpg','jpeg','png','gif','webp'];

    if(in_array($extension,$allowed)){

        /* NEW FILE NAME */

        $new_name =
        time()."_".$original_name;

        /* TARGET */

        $target =
        "uploads/".$new_name;

        /* MOVE FILE */

        if(
        move_uploaded_file(
            $tmp_name,
            $target
        )){

            $profile_name =
            $new_name;

        }else{

            die("Image upload failed");
        }

    }else{

        die("Invalid image type");
    }
}

/* UPDATE QUERY */

$sql = "

UPDATE users SET

name='$name',
age='$age',
phone='$phone',
email='$email',
profile='$profile_name'

WHERE user_id='$user_id'

";

/* EXECUTE */

if($conn->query($sql)){

    header("Location: profile.php");
    exit();

}else{

    echo "Database Error : ".$conn->error;
}
?>