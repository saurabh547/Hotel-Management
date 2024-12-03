<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success" role="alert">
        <?php
        if ($_GET['message'] == 'success') echo "Reservation added successfully!";
        if ($_GET['message'] == 'updated') echo "Reservation updated successfully!";
        if ($_GET['message'] == 'deleted') echo "Reservation deleted successfully!";
        ?>
    </div>
<?php endif; ?>

<?php
include 'db.php';

// Fetch all reservations
$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Hotel Reservation System</h2>
    <div class="card p-4">
        <h4 class="card-title">Make a Reservation</h4>
        <form id="reservationForm" action="process_booking.php" method="POST">
            <input type="hidden" name="id" id="reservation_id">
            <div class="mb-3">
                <label for="guest_name" class="form-label">Guest Name</label>
                <input type="text" class="form-control" id="guest_name" name="guest_name" required>
            </div>
            <div class="mb-3">
                <label for="booking_date" class="form-label">Booking Date</label>
                <input type="date" class="form-control" id="booking_date" name="booking_date" required>
            </div>
            <div class="mb-3">
                <label for="booking_time" class="form-label">Booking Time</label>
                <input type="time" class="form-control" id="booking_time" name="booking_time" required>
            </div>
            <div class="mb-3">
                <label for="room_no" class="form-label">Room Number</label>
                <input type="number" class="form-control" id="room_no" name="room_no" required>
            </div>
            <button type="submit" name="action" value="insert" class="btn btn-success">Book Now</button>
            <button type="submit" name="action" value="update" class="btn btn-primary" id="updateButton" style="display: none;">Update</button>
        </form>
    </div>

    <div class="mt-5">
        <h4>Current Reservations</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Guest Name</th>
                    <th>Booking Date</th>
                    <th>Booking Time</th>
                    <th>Room No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['guest_name'] ?></td>
                            <td><?= $row['booking_date'] ?></td>
                            <td><?= $row['booking_time'] ?></td>
                            <td><?= $row['room_no'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-name="<?= $row['guest_name'] ?>" data-date="<?= $row['booking_date'] ?>" data-time="<?= $row['booking_time'] ?>" data-room="<?= $row['room_no'] ?>">Edit</button>
                                <a href="process_booking.php?action=delete&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No reservations found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).on('click', '.edit-btn', function () {
    $('#reservation_id').val($(this).data('id'));
    $('#guest_name').val($(this).data('name'));
    $('#booking_date').val($(this).data('date'));
    $('#booking_time').val($(this).data('time'));
    $('#room_no').val($(this).data('room'));
    $('#updateButton').show();
});
</script>
</body>
</html>
