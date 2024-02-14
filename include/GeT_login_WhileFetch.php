<?php
while($row_fetch = $query->fetch(PDO::FETCH_ASSOC)){
$row_id = $row_fetch['id'];
$row_fullname = $row_fetch['fullname'];
$row_username = $row_fetch['username'];
$row_email = $row_fetch['email'];
}

$_SESSION['id'] = $row_id;
$_SESSION['fullname'] = $row_fullname;
$_SESSION['username'] = $row_username;
$_SESSION['email'] = $row_email;
?>
