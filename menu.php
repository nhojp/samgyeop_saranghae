<?php
include 'conn.php';  // Include database connection
include 'head.php';   // Include head HTML code
include 'sidebar.php'; // Include sidebar

// Add menu item functionality
if (isset($_POST['add_item'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    // Insert new menu item into the database
    $sql = "INSERT INTO menu_items (name, description, image) VALUES ('$name', '$description', '$target_file')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Menu item added successfully!'); window.location.href='menu.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Edit menu item functionality
if (isset($_POST['edit_item'])) {
    $item_id = $_POST['item_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);

    // Check if a new image was uploaded
    if (!empty($image)) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $sql = "UPDATE menu_items SET name='$name', description='$description', image='$target_file' WHERE id=$item_id";
    } else {
        $sql = "UPDATE menu_items SET name='$name', description='$description' WHERE id=$item_id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Menu item updated successfully!'); window.location.href='menu.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete menu item functionality
if (isset($_POST['delete_item'])) {
    $item_id = $_POST['item_id'];

    // Fetch the image file path before deleting
    $sql = "SELECT image FROM menu_items WHERE id=$item_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $image_path = $row['image'];

    // Delete the menu item from the database
    $sql = "DELETE FROM menu_items WHERE id=$item_id";
    if ($conn->query($sql) === TRUE) {
        // Delete the image file from the uploads folder
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        echo "<script>alert('Menu item deleted successfully!'); window.location.href='menu.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<div id="main">
    <?php include "navbar-a.php"; ?>

    <div class="container py-5">
        <h2 class="text-center mb-4">Samgyeop Saranghae Menu</h2>

        <!-- Add Menu Item Button with Dropdown -->
        <div class="d-flex justify-content-end mb-4">
            <div class="dropdown">
                <button class="btn btn-success btn-lg rounded-circle shadow-lg" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addMenuItemModal">Add Menu Item</a></li>
                </ul>
            </div>
        </div>

        <!-- List of Menu Items -->
        <h3 class="mb-4">Current Menu</h3>
        <div class="row">
            <?php
            // Fetch menu items from the database
            $sql = "SELECT * FROM menu_items";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Display each menu item as a card
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='col-md-4 mb-4'>
                        <div class='card shadow-sm'>
                            <img src='" . $row['image'] . "' class='card-img-top' alt='" . $row['name'] . "' style='height: 200px; object-fit: cover;'>
                            <div class='card-body'>
                                <h5 class='card-title font-weight-bold'>" . $row['name'] . "</h5>
                                <p class='card-text' style='overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%;'>" . $row['description'] . "</p>
                                <button class='btn btn-warning btn-lg rounded-circle shadow-lg float-right' data-bs-toggle='modal' data-bs-target='#editMenuItemModal' 
                                    data-id='" . $row['id'] . "' 
                                    data-name='" . $row['name'] . "' 
                                    data-description='" . $row['description'] . "' 
                                    data-image='" . $row['image'] . "'>
                                    <i class='fas fa-edit'></i>
                                </button>
                                <button class='btn btn-danger btn-lg rounded-circle shadow-lg float-right mr-2' data-bs-toggle='modal' data-bs-target='#deleteMenuItemModal' 
                                    data-id='" . $row['id'] . "'>
                                    <i class='fas fa-trash'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<p class='text-center col-12'>No menu items found.</p>";
            }
            ?>
        </div>
    </div>
</div>

<!-- Modal for Adding Menu Item -->
<div class="modal fade" id="addMenuItemModal" tabindex="-1" aria-labelledby="addMenuItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="addMenuItemModalLabel">Add Menu Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>
                    <button type="submit" name="add_item" class="btn btn-success w-100">Add Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Menu Item -->
<div class="modal fade" id="editMenuItemModal" tabindex="-1" aria-labelledby="editMenuItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuItemModalLabel">Edit Menu Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="item_id" name="item_id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="edit_image" name="image">
                    </div>
                    <button type="submit" name="edit_item" class="btn btn-warning w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Deleting Menu Item -->
<div class="modal fade" id="deleteMenuItemModal" tabindex="-1" aria-labelledby="deleteMenuItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuItemModalLabel">Delete Menu Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <p>Are you sure you want to delete this menu item?</p>
                    <input type="hidden" id="delete_item_id" name="item_id">
                    <button type="submit" name="delete_item" class="btn btn-danger w-100">Delete Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Edit button click event
    const editButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#editMenuItemModal"]');
    editButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const itemId = e.currentTarget.dataset.id;
            const itemName = e.currentTarget.dataset.name;
            const description = e.currentTarget.dataset.description;
            const image = e.currentTarget.dataset.image;

            document.getElementById('item_id').value = itemId;
            document.getElementById('edit_name').value = itemName;
            document.getElementById('edit_description').value = description;
        });
    });

    // Delete button click event
    const deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#deleteMenuItemModal"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const itemId = e.currentTarget.dataset.id;
            document.getElementById('delete_item_id').value = itemId;
        });
    });
</script>

<?php include 'footer.php'; ?>