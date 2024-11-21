<?php
include 'conn.php';
include 'head.php';
session_start(); // Start the session to track user login status

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Securely query the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Store user information in the session
        $_SESSION['username'] = $username;

        // Display success message and redirect to dashboard
        echo "<div class='alert alert-success text-center'>Login Successful! Redirecting...</div>";
        header("refresh:2; url=dashboard.php"); // Redirect after 2 seconds
        exit(); // Stop further execution
    } else {
        echo "<div class='alert alert-danger text-center'>Invalid Credentials.</div>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center bg-secondary text-white">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-secondary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
