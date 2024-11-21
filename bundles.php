<?php
include 'conn.php';  // Include database connection
include 'head.php';   // Include head HTML code
include 'sidebar.php'; // Include sidebar

// Add Bundle functionality
if (isset($_POST['add_bundle'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $items = isset($_POST['items']) ? $_POST['items'] : []; // List of selected menu items

    if (!empty($items)) {
        // Insert new bundle into the database
        $sql = "INSERT INTO bundles (name, price) VALUES ('$name', '$price')";
        if ($conn->query($sql) === TRUE) {
            $bundle_id = $conn->insert_id;  // Get the last inserted bundle ID

            // Insert selected items into the bundle_items table
            foreach ($items as $item_id) {
                $sql_item = "INSERT INTO bundle_items (bundle_id, item_id) VALUES ('$bundle_id', '$item_id')";
                if (!$conn->query($sql_item)) {
                    echo "Error: " . $sql_item . "<br>" . $conn->error;
                }
            }
            echo "<script>alert('Bundle added successfully!'); window.location.href='bundles.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('Please select at least one item to add to the bundle.');</script>";
    }
}

// Edit Bundle functionality
if (isset($_POST['edit_bundle'])) {
    $bundle_id = $_POST['bundle_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $items = isset($_POST['items']) ? $_POST['items'] : [];

    // Update bundle details
    $sql = "UPDATE bundles SET name='$name', price='$price' WHERE id='$bundle_id'";
    if ($conn->query($sql) === TRUE) {
        // Delete existing items in the bundle_items table
        $conn->query("DELETE FROM bundle_items WHERE bundle_id = '$bundle_id'");

        // Insert updated items into the bundle_items table
        foreach ($items as $item_id) {
            $sql_item = "INSERT INTO bundle_items (bundle_id, item_id) VALUES ('$bundle_id', '$item_id')";
            if (!$conn->query($sql_item)) {
                echo "Error: " . $sql_item . "<br>" . $conn->error;
            }
        }
        echo "<script>alert('Bundle updated successfully!'); window.location.href='bundles.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete Bundle functionality (will now use modal)
if (isset($_POST['delete_bundle'])) {
    $bundle_id = $_POST['bundle_id'];

    // Delete bundle from bundles table and corresponding items in bundle_items table
    $conn->query("DELETE FROM bundle_items WHERE bundle_id = '$bundle_id'");
    $conn->query("DELETE FROM bundles WHERE id = '$bundle_id'");

    echo "<script>alert('Bundle deleted successfully!'); window.location.href='bundles.php';</script>";
}

// Fetch Bundles and their Items
$sql = "SELECT * FROM bundles";
$bundles_result = $conn->query($sql);
?>

<div id="main">
    <?php include "navbar-a.php"; ?>

    <div class="container py-5">
        <h2 class="text-center mb-4">Bundle Menu</h2>

        <!-- Add Bundle Button with Dropdown -->
        <div class="d-flex justify-content-end mb-4">
            <div class="dropdown">
                <button class="btn btn-success btn-lg rounded-circle shadow-lg" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addBundleModal">Add Bundle</a></li>
                </ul>
            </div>
            
        </div>

        <!-- List of Bundles -->
        <h3 class="mb-4">Current Bundles</h3>
        <div class="row">
            <?php
            if ($bundles_result->num_rows > 0) {
                // Display each bundle as a card
                while ($row = $bundles_result->fetch_assoc()) {
                    $bundle_id = $row['id'];
                    $bundle_name = $row['name'];
                    $bundle_price = $row['price'];

                    // Fetch items in the bundle
                    $sql_items = "SELECT m.id, m.name FROM menu_items m 
                                  JOIN bundle_items bi ON m.id = bi.item_id 
                                  WHERE bi.bundle_id = $bundle_id";
                    $items_result = $conn->query($sql_items);
                    $items = [];
                    while ($item = $items_result->fetch_assoc()) {
                        $items[] = $item;
                    }

                    $items_list = implode(", ", array_map(function($item) { return $item['name']; }, $items));

                    echo "
                    <div class='col-md-4 mb-4'>
                        <div class='card shadow-sm'>
                            <div class='card-body'>
                                <h5 class='card-title font-weight-bold'>$bundle_name</h5>
                                <p class='card-text'>Price: PHP $bundle_price</p>
                                <p class='card-text' style='overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%;'>$items_list</p>
                                <button class='btn btn-warning btn-lg rounded-circle shadow-lg float-right' data-bs-toggle='modal' data-bs-target='#editBundleModal' data-bundle-id='$bundle_id' data-name='$bundle_name' data-price='$bundle_price' data-items='" . json_encode($items) . "'>
                                    <i class='fas fa-edit'></i>
                                </button>
                                <!-- Trigger for Delete Confirmation Modal -->
                                <button class='btn btn-danger btn-lg rounded-circle shadow-lg float-right mr-2' data-bs-toggle='modal' data-bs-target='#deleteBundleModal' data-bundle-id='$bundle_id' data-bundle-name='$bundle_name'>
                                    <i class='fas fa-trash'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<p class='text-center col-12'>No bundles found.</p>";
            }
            ?>
        </div>
    </div>
</div>

<!-- Modal for Adding Bundle -->
<div class="modal fade" id="addBundleModal" tabindex="-1" aria-labelledby="addBundleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="addBundleModalLabel">Add Bundle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Bundle Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="items" class="form-label">Items</label>
                        <div class="form-check">
                            <?php
                            $sql_menu = "SELECT * FROM menu_items";
                            $menu_items_result = $conn->query($sql_menu);
                            while ($menu_item = $menu_items_result->fetch_assoc()) {
                                echo "<input type='checkbox' class='form-check-input' id='item_" . $menu_item['id'] . "' name='items[]' value='" . $menu_item['id'] . "'>";
                                echo "<label class='form-check-label' for='item_" . $menu_item['id'] . "'>" . $menu_item['name'] . "</label><br>";
                            }
                            ?>
                        </div>
                    </div>
                    <button type="submit" name="add_bundle" class="btn btn-success w-100">Add Bundle</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Bundle -->
<div class="modal fade" id="editBundleModal" tabindex="-1" aria-labelledby="editBundleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="editBundleModalLabel">Edit Bundle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" id="bundle_id" name="bundle_id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Bundle Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="edit_price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_items" class="form-label">Items</label>
                        <div class="form-check">
                            <?php
                            $menu_items_result = $conn->query($sql_menu);
                            while ($menu_item = $menu_items_result->fetch_assoc()) {
                                echo "<input type='checkbox' class='form-check-input' id='edit_item_" . $menu_item['id'] . "' name='items[]' value='" . $menu_item['id'] . "'>";
                                echo "<label class='form-check-label' for='edit_item_" . $menu_item['id'] . "'>" . $menu_item['name'] . "</label><br>";
                            }
                            ?>
                        </div>
                    </div>
                    <button type="submit" name="edit_bundle" class="btn btn-warning w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Bundle Confirmation Modal -->
<div class="modal fade" id="deleteBundleModal" tabindex="-1" aria-labelledby="deleteBundleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBundleModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the selected bundle?</p>
            </div>
            <div class="modal-footer">
                <form method="POST">
                    <input type="hidden" id="delete_bundle_id" name="bundle_id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="delete_bundle" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script>
    // Pass bundle ID to delete confirmation modal
    const deleteBundleModal = document.getElementById('deleteBundleModal');
    deleteBundleModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const bundleId = button.getAttribute('data-bundle-id');
        document.getElementById('delete_bundle_id').value = bundleId;
    });

    // Populate edit modal with bundle details
    const editBundleModal = document.getElementById('editBundleModal');
    editBundleModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const bundleId = button.getAttribute('data-bundle-id');
        const name = button.getAttribute('data-name');
        const price = button.getAttribute('data-price');
        const items = JSON.parse(button.getAttribute('data-items'));

        document.getElementById('bundle_id').value = bundleId;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_price').value = price;

        // Set checkboxes for items in the bundle
        document.querySelectorAll('.form-check-input').forEach(input => {
            if (items.some(item => item.id == input.value)) {
                input.checked = true;
            }
        });
    });
</script>
