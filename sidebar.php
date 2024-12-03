<div class="w3-sidebar w3-bar-block w3-card w3-animate-left bg-dark text-white " style="display:none" id="mySidebar">
    <button class="w3-bar-item w3-button w3-xlarge text-white text-right" onclick="w3_close()">&times;</button>
    <a href="dashboard.php" class="w3-bar-item w3-button text-white text-decoration-none"><i class="fas fa-tachometer-alt m-3"></i>Dashboard</a>
    <a class="w3-bar-item w3-button text-white text-decoration-none text-decoration-none" data-toggle="collapse" href="#restaurantAccordion" role="button" aria-expanded="false" aria-controls="restaurantAccordion">
        <i class="fas fa-utensils m-3 "></i> Restaurant
    </a>

    <div class="collapse" id="restaurantAccordion">
        <a href="tables.php" class="w3-bar-item w3-button text-white pl-5 ml-5 text-decoration-none"><i class="fas fa-table mr-2"></i> Tables</a>
        <a href="menu.php" class="w3-bar-item w3-button text-white pl-5 ml-5 text-decoration-none"><i class="fas fa-list mr-2"></i> Menu</a>
        <a href="bundles.php" class="w3-bar-item w3-button text-white pl-5 ml-5 text-decoration-none"><i class="fas fa-gift mr-2"></i> Bundles</a>
        <a href="hours.php" class="w3-bar-item w3-button text-white pl-5 ml-5 text-decoration-none"><i class="fas fa-clock mr-2"></i> Opening/Closing Hours</a>
    </div>

    <a class="w3-bar-item w3-button text-white text-decoration-none" data-toggle="collapse" href="#reservationsAccordion" role="button" aria-expanded="false" aria-controls="reservationsAccordion">
        <i class="fas fa-calendar-check m-3 "></i> Reservations
    </a>
    <div class="collapse" id="reservationsAccordion">
        <a href="#" class="w3-bar-item w3-button text-white pl-5 ml-5 text-decoration-none"><i class="fas fa-hourglass-half mr-2"></i> Pending</a>
        <a href="#" class="w3-bar-item w3-button text-white pl-5 ml-5 text-decoration-none"><i class="fas fa-thumbs-up mr-2"></i> Accepted</a>
        <a href="#" class="w3-bar-item w3-button text-white pl-5 ml-5 text-decoration-none"><i class="fas fa-times-circle mr-2"></i> Canceled</a>
        <a href="#" class="w3-bar-item w3-button text-white pl-5 ml-5 text-decoration-none"><i class="fas fa-check-circle mr-2"></i> Complete</a>
    </div>

    <a href="#" class="w3-bar-item w3-button text-white text-decoration-none"><i class="fas fa-calendar m-3 "></i> Calendar</a>
    <a href="#" class="w3-bar-item w3-button text-white text-decoration-none"><i class="fas fa-cogs m-3"></i> Settings</a>
    <a href="#" class="w3-bar-item w3-button text-white text-decoration-none" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fas fa-sign-out-alt m-3 "></i> Logout</a>
</div>
<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <!-- Link to logout.php -->
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>
