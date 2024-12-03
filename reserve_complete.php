<?php
include "head.php";
include "navbar.php";
?>

<div class="container text-center" style="margin-top: 10%;">

    <!-- Success Message Card -->
    <div class="card shadow-lg bg-dark text-white" style="max-width: 500px; margin: 0 auto;">
        <div class="card-body">
            <!-- Success Icon -->
            <div>
                <i class="bi bi-check-circle text-success" style="font-size: 100px;"></i>
            </div>
            
            <!-- Payment Success Message -->
            <h4 class="card-title mb-3 text-success">Payment Successful!</h4>
            <p class="card-text">Your payment has been successfully processed. Thank you for your reservation!</p>

            <!-- Buttons -->
            <div class="d-flex justify-content-around mt-4">
                <a href="reserve.php" class="btn btn-primary btn-lg">Reserve Again</a>
                <a href="index.php" class="btn btn-outline-secondary btn-lg">Go Back Home</a>
            </div>
        </div>
    </div>

</div>

<?php include "footer.php"; ?>
