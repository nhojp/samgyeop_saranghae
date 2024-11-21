<?php
// Include this file in other pages with `include 'navbar.php';`
?>
<nav class="navbar navbar-expand-lg navbar-light bg-dark shadow-sm">
    <div class="container ">
        <a class="navbar-brand text-white" href="index.php">
            <img src="logo.png" alt="Samgyeop Saranghae" width="30" height="30" class="d-inline-block align-text-top ">
            Samgyeop Saranghae
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link text-white" href="#menu">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-secondary text-white ms-2" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
