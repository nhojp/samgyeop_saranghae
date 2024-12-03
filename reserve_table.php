<?php
include 'head.php';
include 'navbar.php';
include 'conn.php';

// Initialize variables
$selected_date = '';
$selected_time = '';
$available_tables = [];
$show_modal = false; // Initialize the modal flag

// Get the selected date and time from the query parameters or form submission
if (isset($_GET['date']) && isset($_GET['time'])) {
    $selected_date = $_GET['date'];
    $selected_time = $_GET['time'];

    // Fetch the tables and check availability for the selected date and time
    $sql_tables = "SELECT id, table_name, seats FROM tables";
    $result_tables = $conn->query($sql_tables);

    // Check if any table is available at the selected time
    $sql_reservations = "SELECT table_id FROM reservations WHERE reservation_date = ? AND reservation_time = ?";
    $stmt_reservations = $conn->prepare($sql_reservations);
    $stmt_reservations->bind_param("ss", $selected_date, $selected_time);
    $stmt_reservations->execute();
    $result_reservations = $stmt_reservations->get_result();
    
    // Collect the table IDs that are already reserved
    $reserved_tables = [];
    while ($row = $result_reservations->fetch_assoc()) {
        $reserved_tables[] = $row['table_id'];
    }

    // Filter the available tables
    while ($row = $result_tables->fetch_assoc()) {
        if (!in_array($row['id'], $reserved_tables)) {
            $available_tables[] = $row;
        }
    }
}
?>

<div class="container mt-5 pt-5">
    <!-- Reservation details -->
    <h2 class="text-center text-white mb-4">Choose an Available Table for <?php echo date('F j, Y', strtotime($selected_date)); ?> at <?php echo $selected_time; ?></h2>

    <?php if (!empty($available_tables)): ?>
        <div class="container">
            <table class="table table-striped table-hover table-bordered text-center table-dark">
                <thead>
                    <tr>
                        <th>Table Name</th>
                        <th>Seats</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($available_tables as $table): ?>
                        <tr>
                            <td><?php echo $table['table_name']; ?></td>
                            <td><?php echo $table['seats']; ?></td>
                            <td>
                                <!-- Link to proceed with reservation -->
                                <a href="reserve_confirm.php?date=<?php echo $selected_date; ?>&time=<?php echo $selected_time; ?>&table_id=<?php echo $table['id']; ?>" class="btn btn-outline-light">Reserve</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="container text-center">
            <h3 class="text-white">No tables available for the selected time.</h3>
        </div>
    <?php endif; ?>
</div>

<?php
include 'footer.php';
?>
