
// Disable GCash button on page load
document.addEventListener('DOMContentLoaded', function() {
    var gcashButton = document.getElementById('gcashButton');
    gcashButton.disabled = true; // Make sure it's disabled by default
});

// Toggle payment option
document.getElementById('fullPayment').addEventListener('click', function() {
    toggleActive('fullPayment');
});

document.getElementById('appointmentFee').addEventListener('click', function() {
    toggleActive('appointmentFee');
});

function toggleActive(containerId) {
    var containers = document.querySelectorAll('.payment-container');
    containers.forEach(container => {
        container.classList.remove('active');
        container.style.color = ''; // Reset color
    });
    
    var activeContainer = document.getElementById(containerId);
    activeContainer.classList.add('active');
    activeContainer.style.color = 'black'; // Change text color to black
}



// GCash popup logic
var gcashButton = document.getElementById('gcashButton');
var gcashPopup = document.getElementById('gcashPopup');
var closePopup = document.getElementById('closePopup');

gcashButton.addEventListener('click', function() {
    gcashPopup.style.display = 'block';
});

closePopup.addEventListener('click', function() {
    gcashPopup.style.display = 'none';
});

// File input label update
function updateFileName(input) {
    var fileName = input.files[0].name;
    document.getElementById('file-label-text').textContent = fileName;
}

// Receipt form submit
document.getElementById('receiptForm').addEventListener('submit', function(e) {
    // The form will be submitted normally, and PHP will handle the redirect
});
// Enable GCash button when terms are agreed
var termsCheckbox = document.getElementById('termsCheckbox');
termsCheckbox.addEventListener('change', function() {
    var gcashButton = document.getElementById('gcashButton');
    if (termsCheckbox.checked) {
        gcashButton.classList.remove('disabled');
        gcashButton.disabled = false;
    } else {
        gcashButton.classList.add('disabled');
        gcashButton.disabled = true;
    }
});
document.addEventListener("DOMContentLoaded", function() {
// Get the modal
    var modal = document.getElementById("myModal");

    // Get the link that opens the modal
    var termsLink = document.getElementById("termslink");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    var button = document.getElementsByClassName("agree")[0];

    // When the user clicks the link, open the modal
    termsLink.onclick = function(event) {
        event.preventDefault(); // Prevent default anchor behavior
        modal.style.display = "block"; // Show the modal
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none"; // Hide the modal
    }
    button.onclick = function() {
        termsCheckbox.checked = true;
        modal.style.display = "none"; // Hide the modal
        if (termsCheckbox.checked) {
            gcashButton.classList.remove('disabled');
            gcashButton.disabled = false;
            } else {
                gcashButton.classList.add('disabled');
                gcashButton.disabled = true;
            }
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none"; // Hide the modal
        }
    }
});