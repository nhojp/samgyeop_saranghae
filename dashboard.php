<?php
include 'conn.php';
include 'head.php';
include 'sidebar.php';

// Fetch reservations data
$reservationsQuery = "SELECT `id`, `user_id`, `table_id`, `reservation_date`, `reservation_time`, `duration`, `total_price`, `status`, `payment_method` FROM `reservations` WHERE 1";
$reservationsResult = mysqli_query($conn, $reservationsQuery);

// Fetch tables data
$tablesQuery = "SELECT `id`, `table_name`, `seats` FROM `tables` WHERE 1";
$tablesResult = mysqli_query($conn, $tablesQuery);

// Fetch menu items data
$menuItemsQuery = "SELECT `id`, `name`, `description`, `price`, `image` FROM `menu_items` WHERE 1";
$menuItemsResult = mysqli_query($conn, $menuItemsQuery);

// Fetch bundle items data
$bundleItemsQuery = "SELECT `id`, `bundle_id`, `item_id` FROM `bundle_items` WHERE 1";
$bundleItemsResult = mysqli_query($conn, $bundleItemsQuery);

// Fetch bundles data
$bundlesQuery = "SELECT `id`, `name`, `price` FROM `bundles` WHERE 1";
$bundlesResult = mysqli_query($conn, $bundlesQuery);
?>

<div id="main" class="mb-5" style="margin-top:5%;">
    <?php include "navbar-a.php"; ?>

    <div class="w3-container">
        <!-- Dashboard Heading -->
        <h3 class="text-center mb-4">Dashboard Overview</h3>
        <div class="row ">
            <!-- Reservations Overview -->
            <div class="card mb-4 dashboard-card">
                <div class="card-header">
                    <h5 class="card-title">Reservations</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Table</th>
                                <th>Reservation Date</th>
                                <th>Reservation Time</th>
                                <th>Duration</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Payment Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($reservationsResult)): ?>
                                <tr>
                                    <td><?php echo $row['table_id']; ?></td>
                                    <td><?php echo $row['reservation_date']; ?></td>
                                    <td><?php echo $row['reservation_time']; ?></td>
                                    <td><?php echo $row['duration']; ?> hours</td>
                                    <td><?php echo number_format($row['total_price'], 2); ?> USD</td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td><?php echo $row['payment_method']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <!-- Tables Overview -->
                <div class="card mb-4 dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title">Tables</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Table ID</th>
                                    <th>Table Name</th>
                                    <th>Seats</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($tablesResult)): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['table_name']; ?></td>
                                        <td><?php echo $row['seats']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Menu Items Overview -->
                <div class="card mb-4 dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title">Menu Items</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:30%;">Name</th>
                                    <th style="width:70%;">Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($menuItemsResult)): ?>
                                    <tr>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><img class="menu-img" src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>"></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Bundles Overview -->
                <div class="card mb-4 dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title">Bundles</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Bundle ID</th>
                                    <th>Bundle Name</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($bundlesResult)): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo number_format($row['price'], 2); ?> USD</td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<style>
    #main {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .dashboard-card {
        max-height: 300px; /* Set a max height for the cards */
        overflow-y: auto; /* Make the card content scrollable */
    }
</style>

