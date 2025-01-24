<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="lele.css" />
    <!-- Theme Script -->
    <script src="theme.js" defer></script>

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .top-strip {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background-color: rgba(0, 0, 50, 0.8);
        }

        .login-form-container {
            position: relative;
            left:20%;
            margin-top: 120px;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-control-icon {
            position: relative;
        }

        .form-control-icon i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .show-password-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center" id="Trey">
    <div class="top-strip"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-form-container">
                    <h2 class="text-center mb-4">Login</h2>
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <div class="form-control-icon">
                                <input type="email" class="form-control" id="Email" placeholder="Enter your email">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="Password" class="form-label">Password</label>
                            <div class="form-control-icon">
                                <input type="password" class="form-control" id="Password" placeholder="Enter your password">
                                <i class="bi bi-lock"></i>
                                <span class="show-password-btn" id="showPassword">👁️</span>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary w-100" id="loginBtn">Login</button>
                    </form>

                    <p class="text-center mt-3">
                        <a href="registration.php">Sign up</a> <!--| <a href="changePassword.php">Forgot Password?</a>-->
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom Script -->
    <script src="strip.js"></script>

    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('#showPassword').click(function() {
                const passwordField = $('#Password');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
            });

            $('#loginBtn').click(function() {
                const email = $('#Email').val();
                const password = $('#Password').val();

                // Validation for empty fields
                if (!email || !password) {
                    alert('Please fill in both fields.');
                    return;
                }

                // Email format validation
                const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (!emailPattern.test(email)) {
                    alert('Please enter a valid email address.');
                    return;
                }

                // Prepare data for login verification
                const data = {
                    Email: email,
                    Password: password
                };

                // AJAX request to loginEndpoint.php
                $.ajax({
                    url: 'loginEndpoint.php',
                    type: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Redirect to the URL returned from the server
                            window.location.href = response.redirect_url || 'custDash.php'; // Default to custDash.php
                        } else {
                            alert(response.message); // Display error message from server
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });
        });
    </script>
</body>
</html>
