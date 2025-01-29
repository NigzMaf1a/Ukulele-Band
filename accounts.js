// Function to change account status from Pending to Approved
function accApprove() {
    const regID = await getRegID();

    // Make an AJAX request to update the account status
    fetch('/updateStatus', {  // Update this URL to your actual endpoint
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            RegID: regID,
            accStatus: 'Approved'
        })
    })
    .then(response => {
        if (response.ok) {
            return response.json(); // Parse the JSON response
        }
        throw new Error('Network response was not ok.');
    })
    .then(data => {
        console.log('Success:', data);
        // Optionally update the UI to reflect the change
        alert('Account approved successfully!');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to approve account.');
    });
}

// Attach the accApprove function to the button click event
document.getElementById('acc').addEventListener('click', accApprove);

// Function to get the RegID and update the accStatus
async function getRegID() {
    // Example: Assume we want to update the first record; adjust as needed
    const regIDToUpdate = 1; // Replace with logic to get the specific RegID if needed

    // Make an AJAX request to the PHP script to update the account status
    fetch('approve.php', {  // Adjust the path if necessary
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            regId: regIDToUpdate
        })
    })
    .then(response => response.text()) // Expecting a plain text response
    .then(data => {
        if (data === 'success') {
            alert('Account approved successfully!');
            // Additional logic to update the UI can go here
        } else {
            alert('Failed to approve account.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing the request.');
    });
}

//Account Status 
function changeAccStatus() {
    // Make an AJAX request to the PHP script
    fetch('changeStatus.php')  // Adjust the path if necessary
        .then(response => response.json()) // Expecting a JSON response
        .then(data => {
            if (data.status === 'success') {
                console.log('Account status updated successfully.');
            } else {
                console.log('Failed to update account status.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Call changeAccStatus() when the page loads
window.onload = changeAccStatus;

//Function to delete Inactive Accounts 
function removeAcc() {
    // Make an AJAX request to the PHP script to remove inactive accounts
    fetch('remove.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded' // or 'application/json' depending on your preference
        },
        body: new URLSearchParams({
            regId: 'someRegId' // Replace 'someRegId' with the actual RegID to delete if needed.
        })
    })
    .then(response => response.text()) // Expecting a plain text response
    .then(data => {
        if (data === 'success') {
            alert('Inactive account deleted successfully.');
            // Optionally, refresh the page or update the UI to reflect the changes
            location.reload(); // Reloads the page to refresh the data
        } else {
            alert('Failed to delete the account.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the account.');
    });
}

// Add an event listener to the button with ID 'del'
document.getElementById('del').addEventListener('click', removeAcc);

