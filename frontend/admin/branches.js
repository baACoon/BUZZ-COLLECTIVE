function showForm() {
    const addBranch = document.getElementById('addBranch');
    const branchForm = document.getElementById('branchForm');

    // Move the Add Branch button to the left (or down-left)
    addBranch.style.transform = 'translateX(-110%)';
    addBranch.style.opacity = '0.5';

    // Display the form in place of the Add Branch button
    branchForm.style.display = 'flex';
    branchForm.style.opacity = '1';
}

function hideForm() {
    const addBranch = document.getElementById('addBranch');
    const branchForm = document.getElementById('branchForm');

    // Reset the Add Branch button position
    addBranch.style.transform = 'translateX(0)';
    addBranch.style.opacity = '1';

    // Hide the form
    branchForm.style.display = 'none';
    branchForm.style.opacity = '0';
}

function saveBranch() {
    const branchId = document.getElementById('branchId').value;
    const branchName = document.getElementById('branchName').value;
    const branchLocation = document.getElementById('branchLocation').value;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "admin-branches.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText); // Handle the response here
            location.reload(); // Reload page to update displayed branches
        }
    };
    xhr.send(`branchId=${branchId}&branchName=${branchName}&branchLocation=${branchLocation}`);
}


/*function saveBranch() {
    // Get form values
    const branchId = document.getElementById('branchId').value;
    const branchName = document.getElementById('branchName').value;
    const branchLocation = document.getElementById('branchLocation').value;

    // Create a new branch element
    const newBranch = document.createElement('div');
    newBranch.classList.add('branch');

    // Add content to the new branch
    newBranch.innerHTML = `
        <img src="images/BUZZ-Black.png" alt="branch-logo">
        <h4>${branchName}</h4>
        <p>${branchLocation}</p>
        <p>Cavite, Philippines</p>
    `;

    // Append the new branch to the container
    const container = document.querySelector('.box-container');
    container.insertBefore(newBranch, container.querySelector('.add-branch'));

    // Hide the form
    hideForm();
}*/
