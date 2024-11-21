<?php 
include 'head.php'; 
include 'navbar.php'; 
include 'conn.php';  // Database connection

// Get the current day of the week
$currentDay = strtolower(date("l")); // Get the current day and convert to lowercase

// Fetch operation hours from the database for the current day
$sql = "SELECT * FROM operation_hours WHERE day = '$currentDay'";
$result = $conn->query($sql);
$hours = $result->fetch_assoc();

// Fetch menu_items items from the database
$menu_itemsSql = "SELECT * FROM menu_items";
$menu_itemsResult = $conn->query($menu_itemsSql);

// Fetch bundles from the database
$bundleSql = "SELECT * FROM bundles";
$bundleResult = $conn->query($bundleSql);
?>

<!-- Home Section -->
<div class="container text-center mt-5">
    <h1 class="display-4 mb-3">Welcome to Samgyeop Saranghae!</h1>
    <p class="lead mb-4">Experience the best Korean BBQ with a touch of love.</p>
    <a href="reserve.php" class="btn btn-secondary btn-lg">Reserve Now</a>
</div>

<!-- Opening Hours Section (only for the current day) -->
<div class="container py-5">
    <h2 class="text-center mb-4">Today's Opening Hours</h2>
    <?php if ($hours && $hours['opening_hour'] && $hours['closing_hour']) { ?>
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Opening Hour</th>
                    <th>Closing Hour</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo ucfirst($currentDay); ?></td>
                    <td><?php echo $hours['opening_hour']; ?></td>
                    <td><?php echo $hours['closing_hour']; ?></td>
                    <td><?php echo ucfirst($hours['status']); ?></td>
                </tr>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center text-danger" style="font-size: 24px;">CLOSED TODAY</p>
    <?php } ?>
</div>

<!-- menu_items Section -->
<div class="container py-5">
    <h2 class="text-center mb-4">Our Menu</h2>
    <div class="row">
        <?php
        if ($menu_itemsResult->num_rows > 0) {
            while ($row = $menu_itemsResult->fetch_assoc()) {
                echo "
                <div class='col-md-3 mb-4'>
                    <div class='card'>
                        <div class='card-img-container'>
                            <img src='{$row['image']}' class='card-img-top' alt='{$row['name']}'>
                        </div>
                        <div class='card-body'>
                            <h5 class='card-title font-weight-bold'>{$row['name']}</h5>
                            <p class='card-text-1 description'>{$row['description']}</p>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<p class='text-center'>No menu items available.</p>";
        }
        ?>
    </div>
</div>

<!-- Bundles Section -->
<div class="container py-5">
    <h2 class="text-center mb-4">Our Bundles</h2>
    <div class="row">
        <?php
        if ($bundleResult->num_rows > 0) {
            while ($row = $bundleResult->fetch_assoc()) {
                // Fetch associated items from the bundle_items table
                $bundleItemsSql = "SELECT m.name FROM bundle_items bi 
                                   JOIN menu_items m ON bi.item_id = m.id 
                                   WHERE bi.bundle_id = {$row['id']}";
                $bundleItemsResult = $conn->query($bundleItemsSql);
                $bundleItems = [];
                while ($item = $bundleItemsResult->fetch_assoc()) {
                    $bundleItems[] = $item['name'];
                }
                $bundleItemsList = implode(", ", $bundleItems); // List of items for the bundle
                
                echo "
                <div class='col-md-4 mb-4'>
                    <div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$row['name']}</h5>
                            <p class='card-text'>Price: ₱{$row['price']}</p>
                            <p><strong>Items Included:</strong> {$bundleItemsList}</p>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<p class='text-center'>No bundles available.</p>";
        }
        ?>
    </div>
</div>




<!-- Reservation Section -->
<div class="container py-5">
    <h2 class="text-center mb-4">Available Tables for Reservation</h2>
    <table class="table table-bordered table-striped text-center">
        <thead>
            <tr>
                <th>Table Number</th>
                <th>Seats</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- For now, mock up some tables -->
            <tr>
                <td>1</td>
                <td>4</td>
                <td>Available</td>
            </tr>
            <tr>
                <td>2</td>
                <td>2</td>
                <td>Available</td>
            </tr>
            <tr>
                <td>3</td>
                <td>6</td>
                <td>Reserved</td>
            </tr>
            <tr>
                <td>4</td>
                <td>4</td>
                <td>Available</td>
            </tr>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>