// Fetch the counts for Pending, Approved, and Inactive
export function fetchCounts() {
    return fetch('fetchCounts.php', {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('appDis').textContent = data.pending;
        document.getElementById('penDis').textContent = data.approved;
        document.getElementById('innDis').textContent = data.inactive;
    })
    .catch(error => {
        console.error('Error fetching counts:', error);
    });
}

// Fetch pending accounts
export function fetchPendingAccounts() {
    return fetch('fetchPendingAccounts.php', {
        method: 'GET'
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('pending-accounts').innerHTML = data;
    })
    .catch(error => {
        console.error('Error fetching pending accounts:', error);
    });
}

// Fetch inactive accounts
export function fetchInactiveAccounts() {
    return fetch('fetchInactiveAccounts.php', {
        method: 'GET'
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('inactive-accounts').innerHTML = data;
    })
    .catch(error => {
        console.error('Error fetching inactive accounts:', error);
    });
}

// Approve account using fetch
export function approveAccount(regID) {
    return fetch('approveAccount.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'regID=' + encodeURIComponent(regID)
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === 'success') {
            return fetchPendingAccounts(); // Refresh pending accounts
        } else {
            throw new Error('Error approving account');
        }
    })
    .then(() => fetchCounts()) // Refresh counts
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while approving the account.');
    });
}

// Disable account using fetch
export function disableAccount(regID) {
    return fetch('disableAccount.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'regID=' + encodeURIComponent(regID)
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === 'success') {
            return fetchInactiveAccounts(); // Refresh inactive accounts
        } else {
            throw new Error('Error disabling account');
        }
    })
    .then(() => fetchCounts()) // Refresh counts
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while disabling the account.');
    });
}

// Delete account using fetch
export function deleteAccount(regID) {
    if (confirm("Are you sure you want to delete this account?")) {
        return fetch('deleteAccount.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'regID=' + encodeURIComponent(regID)
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === 'success') {
                return fetchInactiveAccounts(); // Refresh inactive accounts
            } else {
                throw new Error('Error deleting account');
            }
        })
        .then(() => fetchCounts()) // Refresh counts
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the account.');
        });
    }
}

// Reactivate account using fetch
export function reactivateAccount(regID) {
    return fetch('reactivateAccount.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'regID=' + encodeURIComponent(regID)
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === 'success') {
            alert('Account reactivated successfully!');
            return fetchInactiveAccounts(); // Refresh inactive accounts
        } else {
            throw new Error('Error reactivating account');
        }
    })
    .then(() => fetchCounts()) // Refresh counts
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while reactivating the account.');
    });
}

// Initialize the dashboard data
export function initializeDashboard() {
    return Promise.all([fetchCounts(), fetchPendingAccounts(), fetchInactiveAccounts()])
        .catch(error => {
            console.error('Error initializing dashboard:', error);
        });
}

// Bind action buttons using event delegation for dynamic elements
document.addEventListener('click', function(event) {
    const target = event.target;

    // Approve Button Click
    if (target.classList.contains('approve-btn')) {
        const regID = target.dataset.id;
        approveAccount(regID);
    }

    // Disable Button Click
    else if (target.classList.contains('disable-btn')) {
        const regID = target.dataset.id;
        disableAccount(regID);
    }

    // Delete Button Click
    else if (target.classList.contains('delete-btn')) {
        const regID = target.dataset.id;
        deleteAccount(regID);
    }

    // Reactivate Button Click
    else if (target.classList.contains('reactivate-btn')) {
        const regID = target.dataset.id;
        reactivateAccount(regID);
    }
});
