document.addEventListener('DOMContentLoaded', () => {
    // Function to send AJAX requests to the server
    const sendActionRequest = (action, regId) => {
        fetch('actionHandler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action, regId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`${action.charAt(0).toUpperCase() + action.slice(1)} action performed successfully.`);
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert(`Error: ${data.message}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while performing the action.');
            });
    };

    // Approve Button Click Handler
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            const regId = event.target.dataset.regId;
            sendActionRequest('approve', regId);
        });
    });

    // Disable Button Click Handler
    document.querySelectorAll('.disable-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            const regId = event.target.dataset.regId;
            sendActionRequest('disable', regId);
        });
    });

    // Reactivate Button Click Handler
    document.querySelectorAll('.reactivate-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            const regId = event.target.dataset.regId;
            sendActionRequest('reactivate', regId);
        });
    });

    // Delete Button Click Handler
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            const regId = event.target.dataset.regId;
            if (confirm('Are you sure you want to delete this account? This action cannot be undone.')) {
                sendActionRequest('delete', regId);
            }
        });
    });
});
