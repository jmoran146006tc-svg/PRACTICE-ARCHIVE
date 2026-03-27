<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id        = (int) $_POST["id"];
    $firstname = htmlspecialchars($_POST["firstname"]);
    $lastname  = htmlspecialchars($_POST["lastname"]);
    $gender    = htmlspecialchars($_POST["gender"]);
    $course    = htmlspecialchars($_POST["course"]);
    $email     = htmlspecialchars($_POST["email"]);
    $phone     = htmlspecialchars($_POST["phone"]);

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE students
        SET firstname=?, lastname=?, gender=?, course=?, email=?, phone=?
         WHERE id=?"
    );
    mysqli_stmt_bind_param($stmt, "ssssssi", $firstname, $lastname, $gender, $course, $email, $phone, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
header("Location: index.php");
exit();
