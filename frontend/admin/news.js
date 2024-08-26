document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all images
    document.querySelectorAll('.news img').forEach(img => {
        img.addEventListener('click', function() {
        // Populate the form with the image details
        document.getElementById('editTitle').value = img.dataset.title;
        document.getElementById('editSubtitle').value = img.dataset.subtitle;
        document.getElementById('editDescription').value = img.dataset.description;

        // Store the reference to the clicked image
        document.getElementById('editNewsForm').dataset.currentImageId = img.id;

        // Show the Edit News form
        document.getElementById('editNewsForm').style.display = 'block';

        // Vertical Images
        document.querySelector('.news').classList.add('vertical');
        });
    });

// Handle form submission for editing news
document.getElementById('editNewsSubmissionForm').addEventListener('submit', function(event) {
    event.preventDefault();

// Get the current image being edited
const currentImageId = document.getElementById('editNewsForm').dataset.currentImageId;
const currentImage = document.getElementById(currentImageId);

// Update image details
const newTitle = document.getElementById('editTitle').value;
const newSubtitle = document.getElementById('editSubtitle').value;
const newDescription = document.getElementById('editDescription').value;
const newPoster = document.getElementById('editPoster').files[0];

if (newPoster) {
    const reader = new FileReader();
    reader.onload = function (e) {
        currentImage.src = e.target.result;
    }
    reader.readAsDataURL(newPoster);
}

// Update data attributes
currentImage.dataset.title = newTitle;
currentImage.dataset.subtitle = newSubtitle;
currentImage.dataset.description = newDescription;

// Hide the Edit News form
document.getElementById('editNewsForm').style.display = 'none';

// Restore the original layout
document.querySelector('.news').classList.remove('vertical');
});

// Handle Delete button click
document.getElementById('deleteButton').addEventListener('click', function() {
const currentImageId = document.getElementById('editNewsForm').dataset.currentImageId;
const currentImage = document.getElementById(currentImageId);

// Remove the image from the DOM
currentImage.remove();

// Hide the Edit News form
document.getElementById('editNewsForm').style.display = 'none';

// Restore the original layout
document.querySelector('.news').classList.remove('vertical');
});

// Handle Edit News form cancel
document.getElementById('cancelEditButton').addEventListener('click', function() {
document.getElementById('editNewsForm').style.display = 'none';

// Restore the original layout
document.querySelector('.news').classList.remove('vertical');
});

// Handle Add News button click
document.getElementById('addButton').addEventListener('click', function() {
document.getElementById('addButton').style.display = 'none'; // Hide ADD button
document.getElementById('newsForm').style.display = 'block'; // Show Add News form
document.querySelector('.news').classList.add('vertical'); //  images vertically
});

// Handle Add News form cancel
document.getElementById('cancelButton').addEventListener('click', function() {
document.getElementById('addButton').style.display = 'block'; // Show the ADD button
document.getElementById('newsForm').style.display = 'none'; // Hide the Add News form
document.querySelector('.news').classList.remove('vertical'); // Restore image layout
});

// Handle Add News form submission
document.getElementById('newsSubmissionForm').addEventListener('submit', function(event) {
event.preventDefault(); // Prevent form from submitting

// Get form data
const posterInput = document.getElementById('poster');
const title = document.getElementById('title').value;
const subtitle = document.getElementById('subtitle').value;
const description = document.getElementById('description').value;

// Check if a file is selected
if (posterInput.files && posterInput.files[0]) {
    const reader = new FileReader();

    reader.onload = function (e) {
        // Create new image element
        const newImage = document.createElement('img');
        newImage.src = e.target.result;
        newImage.alt = title;
        newImage.dataset.title = title;
        newImage.dataset.subtitle = subtitle;
        newImage.dataset.description = description;

        // event listener to the new image for editing
        newImage.addEventListener('click', function() {
            document.getElementById('editTitle').value = newImage.dataset.title;
            document.getElementById('editSubtitle').value = newImage.dataset.subtitle;
            document.getElementById('editDescription').value = newImage.dataset.description;
            document.getElementById('editNewsForm').dataset.currentImageId = newImage.id;
            document.getElementById('editNewsForm').style.display = 'block';
            document.querySelector('.news').classList.add('vertical'); // Apply vertical layout
        });

        // Append new image to the news container
        document.getElementById('newsContainer').appendChild(newImage);
    }

    reader.readAsDataURL(posterInput.files[0]);
}

// Hide Add News form and show the ADD button
document.getElementById('addButton').style.display = 'block';
document.getElementById('newsForm').style.display = 'none';
document.querySelector('.news').classList.remove('vertical'); // Restore image layout
});
});