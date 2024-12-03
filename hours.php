<?php
include 'conn.php';  // Include database connection
include 'head.php';   // Include head HTML code
include 'sidebar.php'; // Include sidebar

// Edit hours functionality
if (isset($_POST['edit_hours'])) {
    $day = $_POST['day'];
    $opening_hour = $_POST['opening_hour'];
    $closing_hour = $_POST['closing_hour'];

    // Determine status: If both opening and closing hours are set, status is 'open', otherwise 'closed'
    $status = (!empty($opening_hour) && !empty($closing_hour)) ? 'open' : 'closed';

    // Update hours of operation for the day in the database
    $sql = "UPDATE operation_hours SET opening_hour='$opening_hour', closing_hour='$closing_hour', status='$status' WHERE day='$day'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Hours updated successfully!');
                window.location.href='hours.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to convert 24-hour time to 12-hour AM/PM format
function convertTo12HourFormat($time24) {
    // Strip seconds if present
    $time24 = substr($time24, 0, 5);  // Extract only HH:mm part
    $date = DateTime::createFromFormat('H:i', $time24);

    // Check if the date object was created successfully
    if ($date === false) {
        return 'Click edit to set time.';  // Return a default value if the time format is incorrect
    }

    return $date->format('g:i A');  // 12-hour format with AM/PM
}

?>


<div id="main">
    <?php include "navbar-a.php"; ?>

    <div class="container py-5">
        <h2 class="text-center mb-4">Edit Business Hours</h2>

        <!-- List of Days and Hours -->
        <div class="table-responsive text-center">
            <table class="table table-striped table-bordered table-hover shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 30%">Day</th>
                        <th style="width: 25%">Opening Hour</th>
                        <th style="width: 25%">Closing Hour</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch current operation hours from the database
                    $sql = "SELECT * FROM operation_hours";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Display each day with its hours and status
                        while ($row = $result->fetch_assoc()) {
                            // Convert opening and closing hours to 12-hour format
                            $opening_hour_12 = convertTo12HourFormat($row['opening_hour']);
                            $closing_hour_12 = convertTo12HourFormat($row['closing_hour']);
                    
                            echo "<tr>
                                    <td>" . ucfirst($row['day']) . "</td>
                                    <td>" . $opening_hour_12 . "</td>
                                    <td>" . $closing_hour_12 . "</td>
                                    <td>" . ucfirst($row['status']) . "</td>
                                    <td class='text-center'>
                                        <!-- Edit Button -->
                                        <button class='btn btn-warning btn-lg rounded-circle shadow-lg' data-bs-toggle='modal' data-bs-target='#editHoursModal' 
                                            data-day='" . $row['day'] . "' 
                                            data-opening-hour='" . $row['opening_hour'] . "' 
                                            data-closing-hour='" . $row['closing_hour'] . "'>
                                            <i class='fas fa-edit'></i>
                                        </button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No hours found</td></tr>";
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Modal for Editing Hours -->
<div class="modal fade" id="editHoursModal" tabindex="-1" aria-labelledby="editHoursModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="editHoursModalLabel">Edit Hours of Operation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" id="day" name="day">
                    <div class="mb-3">
                        <label for="opening_hour" class="form-label">Opening Hour</label>
                        <input type="time" class="form-control" id="opening_hour" name="opening_hour" required>
                    </div>
                    <div class="mb-3">
                        <label for="closing_hour" class="form-label">Closing Hour</label>
                        <input type="time" class="form-control" id="closing_hour" name="closing_hour" required>
                    </div>
                    <button type="submit" name="edit_hours" class="btn btn-warning w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Populate the modal fields with data when the Edit button is clicked
    var editHoursModal = document.getElementById('editHoursModal');
    editHoursModal.addEventListener('show.bs.modal', function(event) {
        // Get the data from the button that triggered the modal
        var button = event.relatedTarget; // Button that triggered the modal
        var day = button.getAttribute('data-day');
        var openingHour = button.getAttribute('data-opening-hour');
        var closingHour = button.getAttribute('data-closing-hour');

        // Update the modal's content
        var dayInput = editHoursModal.querySelector('#day');
        var openingHourInput = editHoursModal.querySelector('#opening_hour');
        var closingHourInput = editHoursModal.querySelector('#closing_hour');

        dayInput.value = day;
        openingHourInput.value = openingHour;
        closingHourInput.value = closingHour;
    });
</script>

<?php
include 'footer.php';
?>