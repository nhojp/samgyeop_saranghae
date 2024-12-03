<?php
include 'head.php';
include 'navbar.php';
include 'conn.php';

// Fetch bundles (id, name, price)
$sql_bundles = "SELECT id, name, price FROM bundles";
$result_bundles = $conn->query($sql_bundles);

// If no bundles found
if ($result_bundles->num_rows == 0) {
    echo "<div class='alert alert-danger text-center'>No bundles found.</div>";
    exit;
}

// Fetch bundle items (item_id, bundle_id)
$sql_bundle_items = "SELECT id, bundle_id, item_id FROM bundle_items";
$result_bundle_items = $conn->query($sql_bundle_items);
$bundle_items = [];

while ($item = $result_bundle_items->fetch_assoc()) {
    if (!isset($bundle_items[$item['bundle_id']])) {
        $bundle_items[$item['bundle_id']] = [];
    }
    $bundle_items[$item['bundle_id']][] = $item['item_id'];
}

// Fetch items and their details (id, name, description, price, image)
$sql_menu_items = "SELECT id, name, description, price, image FROM menu_items";
$result_menu_items = $conn->query($sql_menu_items);
$menu_items = [];
while ($item = $result_menu_items->fetch_assoc()) {
    $menu_items[$item['id']] = $item; // Map item_id to item details
}
?>

<div class="container mt-5 pt-5">
    <h2 class="text-center text-white mb-4">Choose a Bundle</h2>

    <div class="row">
        <?php while ($bundle = $result_bundles->fetch_assoc()): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($bundle['name']); ?></h5>
                        <p class="card-text">Price: ₱<?php echo number_format($bundle['price'], 2); ?></p>

                        <!-- Show contents of the bundle -->
                        <ul class="list-group">
                            <?php foreach ($bundle_items[$bundle['id']] as $item_id): ?>
                                <li class="list-group-item d-flex align-items-center">
                                    <img src="<?php echo htmlspecialchars($menu_items[$item_id]['image']); ?>"
                                        alt="<?php echo htmlspecialchars($menu_items[$item_id]['name']); ?>"
                                        style="width: 30px; height: 30px; margin-right: 10px;">
                                    <?php echo htmlspecialchars($menu_items[$item_id]['name']); ?>
                                </li>
                            <?php endforeach; ?>

                        </ul>

                        <!-- Button to select this bundle -->
                        <button class="btn btn-danger select-bundle-btn mt-5" data-bundle-id="<?php echo $bundle['id']; ?>" data-bundle-name="<?php echo $bundle['name']; ?>" data-bundle-price="<?php echo $bundle['price']; ?>">Select Bundle</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Floating Tray for Selected Bundles -->
<div id="floating-tray" class="floating-tray">
    <h5 class="text-white">Selected Bundles</h5>
    <div id="selected-bundles-list"></div>
    <button class="btn btn-success" id="confirm-selection" style="display: none;">Confirm Order</button>
    <button class="btn btn-danger" id="clear-selection" style="display: none;">Clear Selection</button>
</div>

<?php
include 'footer.php';
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectedBundles = {}; // Store selected bundles in an object

        // Handle "Select Bundle" button click
        const selectButtons = document.querySelectorAll('.select-bundle-btn');
        selectButtons.forEach(button => {
            button.addEventListener('click', function() {
                const bundleId = this.getAttribute('data-bundle-id');
                const bundleName = this.getAttribute('data-bundle-name');
                const bundlePrice = parseFloat(this.getAttribute('data-bundle-price'));

                // Add or update the selected bundle in the selectedBundles object
                if (!selectedBundles[bundleId]) {
                    selectedBundles[bundleId] = {
                        name: bundleName,
                        price: bundlePrice,
                        quantity: 1
                    };
                } else {
                    selectedBundles[bundleId].quantity += 1; // Increase quantity if bundle already selected
                }

                // Display the floating tray
                const tray = document.getElementById('floating-tray');
                tray.style.display = 'block';

                // Update the selected bundles list
                updateSelectedBundlesList();

                // Show the "Confirm Order" and "Clear Selection" buttons
                const confirmButton = document.getElementById('confirm-selection');
                confirmButton.style.display = 'block';
                const clearButton = document.getElementById('clear-selection');
                clearButton.style.display = 'block';
            });
        });

        // Update the selected bundles list in the floating tray
        function updateSelectedBundlesList() {
            const selectedBundlesList = document.getElementById('selected-bundles-list');
            selectedBundlesList.innerHTML = ''; // Clear the list

            for (const bundleId in selectedBundles) {
                const bundle = selectedBundles[bundleId];
                const itemHTML = `
                    <div class="d-flex justify-content-between">
                        <span>${bundle.name}</span>
                        <div>
                            <input type="number" value="${bundle.quantity}" min="1" class="form-control form-control-sm quantity-input" data-bundle-id="${bundleId}" style="width: 60px;">
                        </div>
                    </div>
                    <hr>`;
                selectedBundlesList.innerHTML += itemHTML;
            }

            // Add event listeners for quantity inputs
            const quantityInputs = document.querySelectorAll('.quantity-input');
            quantityInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const bundleId = this.getAttribute('data-bundle-id');
                    const newQuantity = parseInt(this.value);
                    if (newQuantity >= 1) {
                        selectedBundles[bundleId].quantity = newQuantity;
                    }
                    updateSelectedBundlesList();
                });
            });
        }

        // Handle "Confirm Order" button click
        const confirmButton = document.getElementById('confirm-selection');
        confirmButton.addEventListener('click', function() {
            // Proceed to reserve_payment.php
            window.location.href = 'reserve_payment.php';
        });

        // Handle "Clear Selection" button click
        const clearButton = document.getElementById('clear-selection');
        clearButton.addEventListener('click', function() {
            selectedBundles = {}; // Clear the selected bundles
            updateSelectedBundlesList();
            const tray = document.getElementById('floating-tray');
            tray.style.display = 'none'; // Hide the tray
        });
    });
</script>

<style>
    .floating-tray {
        position: fixed;
        bottom: 10px;
        right: 10px;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 20px;
        width: 250px;
        border-radius: 10px;
        display: none;
        z-index: 1000;
    }

    .floating-tray h5 {
        margin-top: 0;
    }

    .quantity-input {
        max-width: 80px;
        margin-left: 10px;
    }
</style>