<?php
include 'db.php';
 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    $firstname = htmlspecialchars($_POST["firstname"]);
    $lastname  = htmlspecialchars($_POST["lastname"]);
    $gender    = htmlspecialchars($_POST["gender"]);
    $course    = htmlspecialchars($_POST["course"]);
    $email     = htmlspecialchars($_POST["email"]);
    $phone     = htmlspecialchars($_POST["phone"]);
 
    $stmt = mysqli_prepare($conn,
        "INSERT INTO students (firstname, lastname, gender, course, email, phone)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "ssssss", $firstname, $lastname, $gender, $course, $email, $phone);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
 
mysqli_close($conn);
header("Location: index.php");
exit();
?>