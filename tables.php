<?php
include 'conn.php';  // Include database connection
include 'head.php';   // Include head HTML code
include 'sidebar.php'; // Include sidebar

// Add table functionality
if (isset($_POST['add_table'])) {
    $table_name = $_POST['table_name'];
    $seats = $_POST['seats'];

    // Insert new table into the database
    $sql = "INSERT INTO tables (table_name, seats) VALUES ('$table_name', '$seats')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Table added successfully!'); window.location.href='tables.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Edit table functionality
if (isset($_POST['edit_table'])) {
    $table_id = $_POST['table_id'];
    $table_name = $_POST['table_name'];
    $seats = $_POST['seats'];

    // Update table details in the database
    $sql = "UPDATE tables SET table_name='$table_name', seats='$seats' WHERE id=$table_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Table updated successfully!');
                window.location.href='tables.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete table functionality
if (isset($_POST['delete_table'])) {
    $table_id = $_POST['table_id'];

    // Delete the table from the database
    $sql = "DELETE FROM tables WHERE id=$table_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Table deleted successfully!');
                window.location.href='tables.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<div id="main">
    <?php include "navbar-a.php"; ?>

    <div class="container py-5">
        <h2 class="text-center mb-4">Tables Management</h2>

        <!-- Add Table Button with Dropdown -->
        <div class="d-flex justify-content-end mb-4">
            <div class="dropdown">
                <button class="btn btn-success btn-lg rounded-circle shadow-lg" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addTableModal">Add Table</a></li>
                </ul>
            </div>
        </div>

        <!-- List of Tables -->
        <h3 class="mb-4">Current Tables</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover shadow-sm">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="width: 50%">Table Name</th>
                        <th style="width: 30%">Seats</th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch tables from the database
                    $sql = "SELECT * FROM tables";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Display each table
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row['table_name'] . "</td>
                                <td>" . $row['seats'] . "</td>
                                <td class='text-center'>
                                            <!-- Edit Button -->
                                    <button class='btn btn-warning btn-lg rounded-circle shadow-lg' data-bs-toggle='modal' data-bs-target='#editTableModal' 
                                        data-id='" . $row['id'] . "' 
                                        data-name='" . $row['table_name'] . "' 
                                        data-seats='" . $row['seats'] . "'>
                                        <i class='fas fa-edit'></i>
                                    </button>
                                    <!-- Delete Button -->
                                    <button class='btn btn-danger btn-lg rounded-circle shadow-lg' data-bs-toggle='modal' data-bs-target='#deleteTableModal' 
                                        data-id='" . $row['id'] . "'>
                                        <i class='fas fa-trash'></i>
                                    </button>

                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>No tables found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Adding Table -->
<div class="modal fade" id="addTableModal" tabindex="-1" aria-labelledby="addTableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="addTableModalLabel">Add Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="table_name" class="form-label">Table Name</label>
                        <input type="text" class="form-control" id="table_name" name="table_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="seats" class="form-label">Number of Seats</label>
                        <input type="number" class="form-control" id="seats" name="seats" required>
                    </div>
                    <button type="submit" name="add_table" class="btn btn-success w-100">Add Table</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Table -->
<div class="modal fade" id="editTableModal" tabindex="-1" aria-labelledby="editTableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="editTableModalLabel">Edit Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" id="table_id" name="table_id">
                    <div class="mb-3">
                        <label for="edit_table_name" class="form-label">Table Name</label>
                        <input type="text" class="form-control" id="edit_table_name" name="table_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_seats" class="form-label">Number of Seats</label>
                        <input type="number" class="form-control" id="edit_seats" name="seats" required>
                    </div>
                    <button type="submit" name="edit_table" class="btn btn-warning w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Deleting Table -->
<div class="modal fade" id="deleteTableModal" tabindex="-1" aria-labelledby="deleteTableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTableModalLabel">Delete Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this table?</p>
                <form method="POST">
                    <input type="hidden" id="delete_table_id" name="table_id">
                    <button type="submit" name="delete_table" class="btn btn-danger w-100">Delete Table</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Populate the modal fields with data when the Delete button is clicked
    var deleteTableModal = document.getElementById('deleteTableModal');
    deleteTableModal.addEventListener('show.bs.modal', function(event) {
        // Get the data from the button that triggered the modal
        var button = event.relatedTarget; // Button that triggered the modal
        var tableId = button.getAttribute('data-id');

        // Update the modal's content
        var tableIdInput = deleteTableModal.querySelector('#delete_table_id');
        tableIdInput.value = tableId;
    });
</script>
<script>
    // Populate the modal fields with data when the Edit button is clicked
    var editTableModal = document.getElementById('editTableModal');
    editTableModal.addEventListener('show.bs.modal', function(event) {
        // Get the data from the button that triggered the modal
        var button = event.relatedTarget; // Button that triggered the modal
        var tableId = button.getAttribute('data-id');
        var tableName = button.getAttribute('data-name');
        var seats = button.getAttribute('data-seats');

        // Update the modal's content
        var tableIdInput = editTableModal.querySelector('#table_id');
        var tableNameInput = editTableModal.querySelector('#edit_table_name');
        var seatsInput = editTableModal.querySelector('#edit_seats');

        tableIdInput.value = tableId;
        tableNameInput.value = tableName;
        seatsInput.value = seats;
    });
</script>

<?php
include 'footer.php';
?>