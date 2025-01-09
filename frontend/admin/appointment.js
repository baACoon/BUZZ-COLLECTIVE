   // menu icon
   document.addEventListener('DOMContentLoaded', function() {
    const menuIcon = document.getElementById('menu-icon');
    const sidebar = document.querySelector('.sidebar');
    const closeSidebar = document.getElementById('close-sidebar');

    // Add click event to the menu icon
    menuIcon.addEventListener('click', function() {
        sidebar.classList.toggle('open'); // Toggle the 'open' class on the sidebar
        closeSidebar.style.display = sidebar.classList.contains('open') ? 'block' : 'none'; // Show/hide close button
    });

    // Add click event to the close button
    closeSidebar.addEventListener('click', function() {
        sidebar.classList.remove('open'); // Remove the 'open' class on the sidebar
        closeSidebar.style.display = 'none'; // Hide close button
    });
});

// Select or Deselect all checkboxes
document.getElementById('select-all').addEventListener('click', function() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = this.checked;
    }, this);
});

function getSelectedAppointments() {
    var selectedAppointments = [];
    document.querySelectorAll('input[name="appointments[]"]:checked').forEach(function(checkbox) {
        selectedAppointments.push(checkbox.value);
    });
    return selectedAppointments;
}

// DELETE event handler
document.getElementById('delete-btn').addEventListener('click', function() {
    var form = document.getElementById('delete-form');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/../../backend/delete_appointment.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            document.getElementById('popup-message').innerText = response.message;
            document.getElementById('popup').style.display = 'flex';
        }
    };
    xhr.send(formData);
});

function closePopup() {
    document.getElementById('popup').style.display = 'none';
    location.reload();
}

// Confirm button event handler
document.getElementById('confirm-btn').addEventListener('click', function() {
    var selectedAppointments = getSelectedAppointments();
    if (selectedAppointments.length > 0) {
        var formData = new FormData();
        selectedAppointments.forEach(function(appointmentId) {
            formData.append('appointments[]', appointmentId);
        });

        fetch('/../../backend/confirm_appointment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                document.getElementById('popup-message').innerText = 'Appointment confirmed successfully!';
                document.getElementById('popup').style.display = 'flex';
            } else {
                document.getElementById('popup-message').innerText = 'Error confirmings appointment.';
                document.getElementById('popup').style.display = 'flex';
            }
        })
        .catch(error => {
            document.getElementById('popup-message').innerText = 'Error confirming appointment: ' + error.message;
            document.getElementById('popup').style.display = 'flex';
        });
    } else {
        document.getElementById('popup-message').innerText = 'Please select an appointment to confirm.';
        document.getElementById('popup').style.display = 'flex';
    }
});

// Cancel button event handler
document.getElementById('cancel-btn').addEventListener('click', function() {
    var selectedAppointments = getSelectedAppointments();
    if (selectedAppointments.length > 0) {
        var formData = new FormData();
        selectedAppointments.forEach(function(appointmentId) {
            formData.append('appointments[]', appointmentId);
        });

        fetch('/../../backend/cancel_appointment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                document.getElementById('popup-message').innerText = 'Appointment canceled successfully!';
                document.getElementById('popup').style.display = 'flex';
            } else {
                document.getElementById('popup-message').innerText = 'Error canceling appointment.';
                document.getElementById('popup').style.display = 'flex';
            }
        })
        .catch(error => {
            document.getElementById('popup-message').innerText = 'Error canceling appointment: ' + error.message;
            document.getElementById('popup').style.display = 'flex';
        });
    } else {
        document.getElementById('popup-message').innerText = 'Please select an appointment to cancel.';
        document.getElementById('popup').style.display = 'flex';
    }
});

function showReceiptModal(imageUrl) {
    document.getElementById('receiptImage').src = imageUrl;
    // Show the modal
    document.getElementById('receiptModal').style.display = 'block';
}

function closeReceiptModal() {
    // Hide the modal
    document.getElementById('receiptModal').style.display = 'none';
    document.getElementById('receiptImage').src = '';
}

// Status dropdown change event handler
document.getElementById('status').addEventListener('change', function() {
    var selectedStatus = this.value;
    var appointmentRows = document.querySelectorAll('tbody tr');

    // Loop through each appointment row
    appointmentRows.forEach(function(row) {
        // Map dropdown values to status names
        var statusMap = {
            '1': 'Pending',
            '2': 'Confirmed',
            '3': 'Cancelled'
        };

        var currentStatus = row.querySelector('td:last-child').innerText.trim(); 

        // Show/Hide rows based on selected status
        if (selectedStatus === '0' || currentStatus === statusMap[selectedStatus]) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
});