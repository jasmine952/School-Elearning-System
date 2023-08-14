<?php
date_default_timezone_set("Africa/Lagos");
include('session.php');
require("opener_db.php");
$conn = $connector->DbConnector();

//die(print_r($_POST));//
$student_id = $_POST['student_id'];
$upload_id = $_POST['upload_id'];
$comment = mysqli_real_escape_string($conn, $_POST['comment']);
$stamp = date("D, M Y, h:i A");
$link = "window.location='view.php?up_id=$upload_id';";
// echo $link;
$sql = "INSERT INTO comments (student_id, upload_id, comment, stamp) VALUES ('$student_id','$upload_id','$comment','$stamp')";
// die($sql);
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Comment Saved, please wait for response!'); $link</script>";
} else {
    echo "<script>alert('Oops! Unknown Error Occurred. Please try again!'); $link</script>";
}