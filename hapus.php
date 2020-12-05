<?php
$conn = mysqli_connect("localhost","root","","cedova");

$id = $_GET["id"];

mysqli_query($conn, "DELETE FROM imagetb WHERE id = '$id'");
header("location: index.php");
?>
