<?php
include 'head.php';
include 'navbar.php';
include 'conn.php';

// Initialize variables
$selected_date = '';
$time_slots = [];
$reservations = [];
$show_modal = false; // Initialize the modal flag
$day_of_week = ''; // Initialize day_of_week to avoid undefined variable warning

// Check if the date is selected
if (isset($_POST['date'])) {
    $selected_date = $_POST['date'];

    // Get the day of the week for the selected date
    $day_of_week = date('l', strtotime($selected_date)); // Get the day (e.g., Monday, Tuesday)

    // Fetch operation hours for the selected day from the database
    $sql = "SELECT opening_hour, closing_hour FROM operation_hours WHERE day = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $day_of_week);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $operation_hours = $result->fetch_assoc();
        $opening_hour = $operation_hours['opening_hour'];
        $closing_hour = $operation_hours['closing_hour'];

        // Convert opening and closing hours to 24-hour format for calculations
        $open_time = strtotime($opening_hour);
        $close_time = strtotime($closing_hour);

        // Generate time slots with 2-hour duration
        while ($open_time < $close_time) {
            // Ensure the 2-hour slot does not exceed the closing time
            $end_time = $open_time + 2 * 60 * 60; // 2-hour slot
            if ($end_time > $close_time) {
                break;
            }

            // Convert to 12-hour format with AM/PM
            $start_time = date('g:i A', $open_time); // 12-hour format with AM/PM
            $end_time = date('g:i A', $end_time); // 12-hour format with AM/PM

            $time_slots[] = [
                'start_time' => $start_time,
                'end_time' => $end_time,
            ];

            $open_time += 2 * 60 * 60; // Increment by 2 hours
        }

        // Fetch existing reservations for the selected date
        $sql_reservations = "SELECT reservation_time, status FROM reservations WHERE reservation_date = ?";
        $stmt_reservations = $conn->prepare($sql_reservations);
        $stmt_reservations->bind_param("s", $selected_date);
        $stmt_reservations->execute();
        $result_reservations = $stmt_reservations->get_result();

        while ($row = $result_reservations->fetch_assoc()) {
            $reservations[$row['reservation_time']] = $row['status'];
        }
    }
}
?>

<div class="container mt-5 pt-5">
    <!-- Reservation Form to select a date -->
    <form method="POST" action="" class="mb-4">
        <label for="date" class="form-label text-white">Select a date:</label>
        <div class="container">
            <div class="row">
                <!-- Input Field -->
                <div class="col-md-9">
                    <input type="date" id="date" name="date" class="form-control bg-dark text-white border-light" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                <!-- Submit Button -->
                <div class="col-md-3">
                    <button type="submit" class="btn btn-danger w-100">Check Availability</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php if (!empty($time_slots)): ?>
    <h2 class="text-center text-white mb-4">Available Time Slots for
        <span class="text-danger">
            <?php echo date('F j, Y', strtotime($selected_date)); ?></span>
        <?php echo $day_of_week; ?>
    </h2>
    <div class="container">
        <table class="table table-striped table-hover table-bordered text-center table-dark">
            <thead>
                <tr>
                    <th style="width:50%;">Time</th>
                    <th style="width:30%;">Status</th>
                    <th style="width:20%;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($time_slots as $slot): ?>
                    <tr>
                        <td><?php echo $slot['start_time'] . ' - ' . $slot['end_time']; ?></td>
                        <td>
                            <?php
                            $slot_time = $slot['start_time'];
                            if (isset($reservations[$slot_time]) && $reservations[$slot_time] == 'confirmed') {
                                echo '<span class="badge bg-danger p-2">Reserved</span>';
                            } else {
                                echo '<span class="badge bg-success p-2">Available</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if (!isset($reservations[$slot_time]) || $reservations[$slot_time] != 'confirmed') {
                                echo '<div class="dropdown">
                                        <button class="btn btn-outline-light w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-calendar-plus"></i>
                                        </button>
                                        <ul class="dropdown-menu w-100 text-center" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item text-dark" href="reserve_table.php?date=<?php echo $selected_date; ?>&time=<?php echo urlencode($slot["start_time"]); ?>Reserve</a></li>
                                        </ul>
                                      </div>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="container text-center">
        <?php if (empty($selected_date)): ?>
            <h2 class="text-white font-weight-bold">SELECT A DATE TO CHECK AVAILABILITY <i class="bi bi-arrow-up-circle"></i>

            </h2>
        <?php else: ?>
            <h2 class="text-white font-weight-bold">Closed for <?php echo $day_of_week ?: 'the selected date'; ?></h2>
        <?php endif; ?>
    </div>
<?php endif; ?>


<?php
include 'footer.php';
?>
