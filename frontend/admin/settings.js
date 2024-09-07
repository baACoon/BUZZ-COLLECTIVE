 // Add event listener for "Add New Administrator" button
 document.getElementById('add-new-btn').addEventListener('click', function() {
    // Change the header title
    document.getElementById('settings-title').textContent = "Settings: Add New Admin";
    
    // Hide the button container
    document.getElementById('button-container').style.display = "none";
    
    // Show the new admin container
    document.getElementById('new-admin-container').style.display = "block";
});

// Add event listener for the Cancel button
document.getElementById('cancel-btn').addEventListener('click', function() {
    // Change the header title back to "Settings"
    document.getElementById('settings-title').textContent = "Settings";
    
    // Show the button container again
    document.getElementById('button-container').style.display = "flex";
    
    // Hide the new admin container
    document.getElementById('new-admin-container').style.display = "none";
});