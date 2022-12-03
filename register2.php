<?php
$username = $_POST['username'];
$email = $_POST['email'];
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$guests = $_POST['guests'];
$children= $_POST['children'];
$room = $_POST['room'];
$roomtype = $_POST['roomtype'];

if (!empty($username) ||  !empty($email) ||  !empty($checkin) || !empty($checkout) || !empty($guests) || !empty($children) || !empty($room)|| !empty($roomtype)) 
{
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "hotelbrooke";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } 
  else {
     $SELECT = "SELECT username From booking Where username = ? Limit 1";
     $INSERT = "INSERT Into booking (username, email, checkin, checkout, guests, children, room, roomtype) values (?, ?, ?, ?, ?, ?, ?, ?)";
     
//Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param('s', $username);
     $stmt->execute();
     $stmt->bind_result($username);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param('ssssiiis', $username, $email, $checkin,  $checkout, $guests, $children, $room, $roomtype);
      $stmt->execute();
      header("location: bookingsucces.html");
     } else {
      header("location: bookingunsucessful.html");
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>


