<?php
include "head.php";
include "navbar.php";
?>

<div class="container" style="margin-top:10%;">
    <!-- Payment Methods Tabs -->
    <ul class="nav nav-pills mb-3" id="paymentTabs" role="tablist">
        <!-- Default tab: Choose a payment option -->
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="choose-payment-tab" data-bs-toggle="pill" href="#choose-payment" role="tab" aria-controls="choose-payment" aria-selected="true">
                Choose a payment option
            </a>
        </li>
        <!-- Other payment options tabs -->
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="bank-tab" data-bs-toggle="pill" href="#bank" role="tab" aria-controls="bank" aria-selected="false">
                <img src="img/bank.png" alt="Bank" class="payment-tab-img">
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="gcash-tab" data-bs-toggle="pill" href="#gcash" role="tab" aria-controls="gcash" aria-selected="false">
                <img src="img/gcash.png" alt="GCash" class="payment-tab-img">
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="paymaya-tab" data-bs-toggle="pill" href="#paymaya" role="tab" aria-controls="paymaya" aria-selected="false">
                <img src="img/paymaya.jpg" alt="PayMaya" class="payment-tab-img">
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="paypal-tab" data-bs-toggle="pill" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false">
                <img src="img/paypal.png" alt="PayPal" class="payment-tab-img">
            </a>
        </li>
    </ul>


    <!-- Payment Method Content -->
    <div class="tab-content" id="paymentTabsContent">
        <!-- Default content for choosing payment option -->
        <div class="tab-pane fade show active" id="choose-payment" role="tabpanel" aria-labelledby="choose-payment-tab">
            <h4>Select your payment method to proceed.</h4>
            <p>Choose from the available payment methods below.</p>
        </div>

        <!-- Bank Payment Form -->
        <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="bank-tab">
            <h4>Bank Payment</h4>
            <form>
                <div class="mb-3">
                    <label for="bank-name" class="form-label">Bank Name</label>
                    <input type="text" class="form-control" id="bank-name" placeholder="Enter Bank Name">
                </div>
                <div class="mb-3">
                    <label for="account-number" class="form-label">Account Number</label>
                    <input type="text" class="form-control" id="account-number" placeholder="Enter Account Number">
                </div>
                <div class="mb-3">
                    <label for="account-name" class="form-label">Account Name</label>
                    <input type="text" class="form-control" id="account-name" placeholder="Enter Account Name">
                </div>
                <div class="mb-3">
                    <label for="transaction-id" class="form-label">Transaction ID</label>
                    <input type="text" class="form-control" id="transaction-id" placeholder="Enter Transaction ID">
                </div>
            </form>
        </div>

        <!-- GCash Payment Form -->
        <div class="tab-pane fade" id="gcash" role="tabpanel" aria-labelledby="gcash-tab">
            <h4>GCash Payment</h4>
            <form>
                <div class="mb-3">
                    <label for="gcash-number" class="form-label">GCash Number</label>
                    <input type="text" class="form-control" id="gcash-number" placeholder="Enter GCash Number">
                </div>
                <div class="mb-3">
                    <label for="gcash-name" class="form-label">Name on GCash Account</label>
                    <input type="text" class="form-control" id="gcash-name" placeholder="Enter Name">
                </div>
                <div class="mb-3">
                    <label for="gcash-transaction-id" class="form-label">Transaction ID</label>
                    <input type="text" class="form-control" id="gcash-transaction-id" placeholder="Enter Transaction ID">
                </div>
            </form>
        </div>

        <!-- PayMaya Payment Form -->
        <div class="tab-pane fade" id="paymaya" role="tabpanel" aria-labelledby="paymaya-tab">
            <h4>PayMaya Payment</h4>
            <form>
                <div class="mb-3">
                    <label for="paymaya-number" class="form-label">PayMaya Number</label>
                    <input type="text" class="form-control" id="paymaya-number" placeholder="Enter PayMaya Number">
                </div>
                <div class="mb-3">
                    <label for="paymaya-name" class="form-label">Name on PayMaya Account</label>
                    <input type="text" class="form-control" id="paymaya-name" placeholder="Enter Name">
                </div>
                <div class="mb-3">
                    <label for="paymaya-transaction-id" class="form-label">Transaction ID</label>
                    <input type="text" class="form-control" id="paymaya-transaction-id" placeholder="Enter Transaction ID">
                </div>
            </form>
        </div>

        <!-- PayPal Payment Form -->
        <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
            <h4>PayPal Payment</h4>
            <form>
                <div class="mb-3">
                    <label for="paypal-email" class="form-label">PayPal Email</label>
                    <input type="email" class="form-control" id="paypal-email" placeholder="Enter PayPal Email">
                </div>
                <div class="mb-3">
                    <label for="paypal-transaction-id" class="form-label">Transaction ID</label>
                    <input type="text" class="form-control" id="paypal-transaction-id" placeholder="Enter Transaction ID">
                </div>
            </form>
        </div>

        <!-- Confirm Button -->
        <div class="mt-4">
        <button id="confirm-payment-btn" class="btn btn-success float-right" onclick="window.location.href='reserve_complete.php'">Confirm Payment</button>
        </div>
    </div>
</div>
<script>
    // Hide the "Confirm Payment" button initially when the page loads on the first tab
    document.addEventListener('DOMContentLoaded', function() {
        var activeTab = document.querySelector('.nav-link.active');
        var confirmButton = document.getElementById('confirm-payment-btn');

        // Hide button if the active tab is the first one (Choose Payment Tab)
        if (activeTab && activeTab.id === 'choose-payment-tab') {
            confirmButton.style.display = 'none';
        }
    });

    // Listen for tab changes and show/hide the "Confirm Payment" button
    var paymentTabs = document.getElementById('paymentTabs');
    paymentTabs.addEventListener('shown.bs.tab', function(e) {
        var activeTab = e.target; // Newly activated tab
        var confirmButton = document.getElementById('confirm-payment-btn');

        // Show button if the active tab is not the first one (Choose Payment Tab)
        if (activeTab.id !== 'choose-payment-tab') {
            confirmButton.style.display = 'inline-block'; // Show the button
        } else {
            confirmButton.style.display = 'none'; // Hide the button
        }
    });
</script>

<?php include "footer.php" ?>