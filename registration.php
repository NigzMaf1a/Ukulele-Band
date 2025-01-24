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

        .registration-form {
            margin-top: 150px;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center" id="Trey">
    <div class="top-strip"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="registration-form" id="registrationForm">
                    <h2 class="text-center">Register</h2>
                    <div class="mb-3">
                        <label for="Name1" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="Name1" placeholder="Enter First Name">
                    </div>
                    <div class="mb-3">
                        <label for="Name2" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="Name2" placeholder="Enter Last Name">
                    </div>
                    <div class="mb-3">
                        <label for="PhoneNo" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="PhoneNo" placeholder="Enter Phone Number">
                    </div>
                    <div class="mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="Email" placeholder="Enter Email">
                    </div>
                    <div class="mb-3">
                        <label for="Password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="Password" placeholder="Enter Password">
                    </div>
                    <div class="mb-3">
                        <label for="Gender" class="form-label">Gender</label>
                        <select class="form-select" id="Gender">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dLocation" class="form-label">Location</label>
                        <select class="form-select" id="dLocation">
                            <option value="">Select Location</option>
                            <option value="Nairobi CBD">Nairobi CBD</option>
                            <option value="Westlands">Westlands</option>
                            <option value="Karen">Karen</option>
                            <option value="Langata">Langata</option>
                            <option value="Kilimani">Kilimani</option>
                            <option value="Eastleigh">Eastleigh</option>
                            <option value="Umoja">Umoja</option>
                            <option value="Parklands">Parklands</option>
                            <option value="Ruiru">Ruiru</option>
                            <option value="Ruai">Ruai</option>
                            <option value="Gikambura">Gikambura</option>
                            <option value="Kitengela">Kitengela</option>
                            <option value="Nairobi West">Nairobi West</option>
                            <option value="Nairobi East">Nairobi East</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary w-100" id="registerBtn">Register</button>
                </form>
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
            $('#registerBtn').click(function() {
                // Collect form data
                const firstName = $('#Name1').val();
                const lastName = $('#Name2').val();
                const phoneNo = $('#PhoneNo').val();
                const email = $('#Email').val();
                const password = $('#Password').val();
                const gender = $('#Gender').val();
                const location = $('#dLocation').val();

                // Validation
                if (!firstName || !lastName || !phoneNo || !email || !password || !gender || !location) {
                    alert('Please fill in all fields.');
                    return;
                }

                // Validate Email
                const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (!emailPattern.test(email)) {
                    alert('Please enter a valid email address.');
                    return;
                }

                // Validate Password (minimum 8 characters)
                if (password.length < 8) {
                    alert('Password must be at least 8 characters long.');
                    return;
                }

                // Prepare data for submission
                const data = {
                    Name1: firstName,
                    Name2: lastName,
                    PhoneNo: phoneNo,
                    Email: email,
                    Password: password,
                    Gender: gender,
                    dLocation: location,
                    accStatus: 'Pending'
                };

                // Send data to server
                $.ajax({
                    url: 'registrationEndpoint.php',
                    type: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    success: function(response) {
                        alert('Registration successful!');
                        window.location.href = 'login.php';  // Redirect to login page after successful registration
                    },
                    error: function(xhr, status, error) {
                        alert('Registration failed: ' + error);
                    }
                });
            });
        });
    </script>
</body>
</html>
