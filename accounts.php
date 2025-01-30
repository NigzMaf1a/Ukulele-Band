<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not authenticated
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="lele.css"/>
    <script src="theme.js" defer></script>
	<script src="Ukulele.js" defer></script>
    <style>
        /* Fixed top strip */
        .top-strip {
            position: fixed;
            top: 0;
            width: 100%;
            height: 100px;
            background-color: rgba(0, 0, 50, 0.8);
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        /* Positioning and styling for UZZER container */
        #UZZER {
            position: relative;
            top: 20px; /*below the strip*/
            width: 80%;
            margin: auto;
            padding: 2rem;
            
        }
        .tab-content .tab-pane .table {
             background-color: white;
             color: black; /* Ensures the text is visible against the white background */
         }
         .table{
            border-radius: 15px;
         }
    </style>
</head>
<body id="Trey">
<!-- Top Strip -->
<div class="top-strip"></div>
<!-- Sidebar -->
<div id="Sidebar">
    <div class="toggle-btn" onclick="show()">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <ul class="list-unstyled">
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-house-door-fill me-3 text-white"></i>
            <a href="dashboard.php" class="text-white text-decoration-none">Dashboard</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-person-circle me-3 text-white"></i>
            <a href="accounts.php" class="text-white text-decoration-none">Accounts</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-file-earmark-text me-3 text-white"></i>
            <a href="reports.php" class="text-white text-decoration-none">Reports</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-graph-up-arrow me-3 text-white"></i>
            <a href="analytics.php" class="text-white text-decoration-none">Analytics</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-chat-left-text me-3 text-white"></i>
            <a href="feedback.php" class="text-white text-decoration-none">Feedback</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-info-circle me-3 text-white"></i> <!-- Icon for About & Contact -->
            <a href="about.php" class="text-white text-decoration-none">About & Contact</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-people me-3 text-white"></i>
            <a href="admUser.php" class="text-white text-decoration-none">User</a>
        </li>
    </ul>
</div>
<div id="UZZER" class="text-center">
<div class="container my-5">
    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="accountTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="customer-tab" data-bs-toggle="tab" href="#customer" role="tab">Customer</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="band-tab" data-bs-toggle="tab" href="#band" role="tab">Band</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="dj-tab" data-bs-toggle="tab" href="#dj" role="tab">DJ</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="mcee-tab" data-bs-toggle="tab" href="#mcee" role="tab">Mcee</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="accountant-tab" data-bs-toggle="tab" href="#accountant" role="tab">Finance Manager</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="storeman-tab" data-bs-toggle="tab" href="#storeman" role="tab">Inventory Manager</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="dispatchman-tab" data-bs-toggle="tab" href="#dispatchman" role="tab">Dispatch Manager</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="inspector-tab" data-bs-toggle="tab" href="#inspector" role="tab">Inspector</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="supplier-tab" data-bs-toggle="tab" href="#supplier" role="tab">Supplier</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content mt-4">
        <!-- Repeated div structure for all tabs -->
        <div class="tab-pane fade show active" id="customer" role="tabpanel">
            <div id="customer-table"></div>
            <button class="btn btn-primary mt-3 print-btn" data-target="customer">
                <i class="fas fa-print"></i> Print
            </button>
            <!--<button class="btn btn-danger mt-3 pdf-btn" data-target="customer">
                <i class="fas fa-file-pdf"></i> Download
            </button>-->
        </div>
        <div class="tab-pane fade" id="band" role="tabpanel">
            <div id="band-table"></div>
            <button class="btn btn-primary mt-3 print-btn" data-target="band">
                <i class="fas fa-print"></i> Print
            </button>
            <!--<button class="btn btn-danger mt-3 pdf-btn" data-target="customer">
                <i class="fas fa-file-pdf"></i> Download
            </button>-->
        </div>
        <div class="tab-pane fade" id="dj" role="tabpanel">
            <div id="dj-table"></div>
            <button class="btn btn-primary mt-3 print-btn" data-target="dj">
                <i class="fas fa-print"></i> Print
            </button>
            <!--<button class="btn btn-danger mt-3 pdf-btn" data-target="customer">
                <i class="fas fa-file-pdf"></i> Download
            </button>-->
        </div>
        <div class="tab-pane fade" id="mcee" role="tabpanel">
            <div id="mcee-table"></div>
            <button class="btn btn-primary mt-3 print-btn" data-target="mcee">
                <i class="fas fa-print"></i> Print
            </button>
            <!--<button class="btn btn-danger mt-3 pdf-btn" data-target="customer">
                <i class="fas fa-file-pdf"></i> Download
            </button>-->
        </div>
        <!-- Finance Manager -->
        <div class="tab-pane fade" id="accountant" role="tabpanel">
            <div id="accountant-table"></div>
            <button class="btn btn-primary mt-3 print-btn" data-target="accountant">
                <i class="fas fa-print"></i> Print
            </button>
            <!--<button class="btn btn-danger mt-3 pdf-btn" data-target="customer">
                <i class="fas fa-file-pdf"></i> Download
            </button>-->
        </div>
        <!-- Inventory Manager -->
        <div class="tab-pane fade" id="storeman" role="tabpanel">
            <div id="storeman-table"></div>
            <button class="btn btn-primary mt-3 print-btn" data-target="storeman">
                <i class="fas fa-print"></i> Print
            </button>
            <!--<button class="btn btn-danger mt-3 pdf-btn" data-target="customer">
                <i class="fas fa-file-pdf"></i> Download
            </button>-->
        </div>
        <!-- Dispatch Manager -->
        <div class="tab-pane fade" id="dispatchman" role="tabpanel">
            <div id="dispatchman-table"></div>
            <button class="btn btn-primary mt-3 print-btn" data-target="dispatchman">
                <i class="fas fa-print"></i> Print
            </button>
            <!--<button class="btn btn-danger mt-3 pdf-btn" data-target="customer">
                <i class="fas fa-file-pdf"></i> Download
            </button>-->
        </div>
        <!-- Inspector -->
        <div class="tab-pane fade" id="inspector" role="tabpanel">
            <div id="inspector-table"></div>
            <button class="btn btn-primary mt-3 print-btn" data-target="inspector">
                <i class="fas fa-print"></i> Print
            </button>
            <!--<button class="btn btn-danger mt-3 pdf-btn" data-target="customer">
                <i class="fas fa-file-pdf"></i> Download
            </button>-->
        </div>
        <!-- Supplier -->
        <div class="tab-pane fade" id="supplier" role="tabpanel">
            <div id="supplier-table"></div>
            <button class="btn btn-primary mt-3 print-btn" data-target="supplier">
                <i class="fas fa-print"></i> Print
            </button>
            <!--<button class="btn btn-danger mt-3 pdf-btn" data-target="customer">
                <i class="fas fa-file-pdf"></i> Download
            </button>-->
        </div>
    </div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.2/jspdf.plugin.autotable.min.js"></script>
<script>
    $(document).ready(function() {
        // Load customer table on page load
        loadTable('customer');

        // Handle tab switch
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href").substring(1); // Get the tab ID (without #)
            loadTable(target); // Load the data for that tab
        });

        // Function to load table data via AJAX
        function loadTable(tab) {
            $.ajax({
                url: 'fetchData.php',
                type: 'POST',
                data: { regType: tab },
                success: function(response) {
                    $('#' + tab + '-table').html(response);
                }
            });
        }

        // Print functionality
        $(document).on('click', '.print-btn', function() {
            var targetTab = $(this).data('target');
            var printContent = $('#' + targetTab + '-table').html();
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
        });

        // Check if jsPDF is loaded
        const { jsPDF } = window.jspdf || {}; // Adjust for UMD module
        if (!jsPDF) {
            console.error('jsPDF is not available.');
            return;
        }

        // Handle the download button click event
        $(document).on('click', '.pdf-btn', function() {
            var targetTable = $(this).data('target'); // Get the target table ID (e.g., 'customer')
            var tableElement = document.getElementById(targetTable + '-table'); // Assume table ID ends with '-table'

            if (!tableElement) {
                console.error('Table with ID "' + targetTable + '-table" not found.');
                return; // Exit if the table doesn't exist
            }

            downloadTableAsPDF(tableElement, targetTable);
        });

        // Function to download table content as PDF
        function downloadTableAsPDF(tableElement, fileName) {
            // Initialize jsPDF
            const doc = new jsPDF();

            // Check if autoTable is available
            if (typeof doc.autoTable !== 'function') {
                console.error("autoTable is not available.");
                return;
            }

            // Use autoTable to generate the table in the PDF
            doc.autoTable({
                html: tableElement, // Use the table element as the source
                startY: 20, // Optional: Set the start position
                theme: 'grid', // Optional: Use a grid-style theme
                styles: {
                    fontSize: 10, // Optional: Adjust font size for readability
                    cellPadding: 3, // Optional: Adjust cell padding
                },
                headStyles: {
                    fillColor: [22, 160, 133], // Optional: Custom header background color
                    textColor: 255, // Optional: Header text color
                    fontSize: 12, // Optional: Header font size
                }
            });

            // Save the generated PDF
            doc.save(fileName + '_data.pdf');
        }
    });
</script>

<script src="strip.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
