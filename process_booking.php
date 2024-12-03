<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<?php

include 'db.php';

// Helper function for bootstrap alerts
function showMessage($message, $type) {
    
    echo "<div class='alert alert-$type' role='alert'>$message</div>";
}


// Insert booking
if ($_POST['action'] == 'insert') {
    $guest_name = $_POST['guest_name'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $room_no = $_POST['room_no'];

    $opening_time = "12:00";
    $closing_time = "23:00";

    // Validate time
    if ($booking_time < $opening_time || $booking_time > $closing_time) {
        showMessage("Booking allowed only between 12:00 PM and 11:00 PM.", "danger");
        exit();
    }

    // Validate date
    if ($booking_date < date("Y-m-d")) {
        showMessage("Pre-date booking is not allowed.", "danger");
        exit();
    }

    $sql = "INSERT INTO reservations (guest_name, booking_date, booking_time, room_no) 
            VALUES ('$guest_name', '$booking_date', '$booking_time', $room_no)";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?message=success");
    } else {
        showMessage("Error: " . $conn->error, "danger");
    }
}



// Update booking
if ($_POST['action'] == 'update') {
    $id = $_POST['id'];
    $guest_name = $_POST['guest_name'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $room_no = $_POST['room_no'];

    $sql = "UPDATE reservations SET guest_name='$guest_name', booking_date='$booking_date', 
            booking_time='$booking_time', room_no=$room_no WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?message=updated");
    } else {
        showMessage("Error: " . $conn->error, "danger");
    }
}

// Delete booking
if ($_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM reservations WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?message=deleted");
    } else {
        showMessage("Error: " . $conn->error, "danger");
    }
}
?>
