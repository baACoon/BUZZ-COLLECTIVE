function displayServiceDetails(serviceId) {
    fetch('data/services.json')
        .then(response => response.json())
        .then(services => {
            const service = services.find(s => s.id === serviceId);
            if (service) {
                document.getElementById('service-name').innerText = service.name;
                document.getElementById('service-id').innerText = service.id;
                document.getElementById('service-with').innerText = service.with;
                document.getElementById('service-price-terms').innerText = service.price_terms;
                document.getElementById('service-fee').innerText = service.fee;
            }
        });
}

function openModal() {
    document.getElementById('myModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('myModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('myModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
function openEditForm() {
    openModal();
}

function closeEditForm() {
    closeModal();
}


function deleteService() {
    alert('Delete service functionality to be implemented');

}


function openEditForm() {
    const id = document.getElementById('service-id').innerText;
    const name = document.getElementById('service-name').innerText;
    const withText = document.getElementById('service-with').innerText;
    const priceTerms = document.getElementById('service-price-terms').innerText;
    const fee = document.getElementById('service-fee').innerText;

    document.getElementById('edit-id').value = id;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-with').value = withText;
    document.getElementById('edit-price-terms').value = priceTerms;
    document.getElementById('edit-fee').value = fee;

    document.getElementById('edit-form').style.display = 'block';
    document.querySelector('.service-details').style.display = 'none';
}

function closeEditForm() {
    document.getElementById('edit-form').style.display = 'none';
    document.querySelector('.service-details').style.display = 'block';
}

function saveService() {
    const formData = new FormData(document.getElementById('edit-service-form'));

    fetch('includes/edit_service.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('success-message').style.display = 'block';
            setTimeout(() => {
                document.getElementById('success-message').style.display = 'none';
            }, 3000);

            // Update the displayed details with the new input values
            document.getElementById('service-name').innerText = formData.get('name');
            document.getElementById('service-id').innerText = formData.get('id');
            document.getElementById('service-with').innerText = formData.get('with');
            document.getElementById('service-price-terms').innerText = formData.get('price_terms');
            document.getElementById('service-fee').innerText = formData.get('fee');

            closeEditForm();
        } else {
            alert('Failed to update service. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });

    closeModal();
    document.getElementById('success-message').style.display = 'block';
    setTimeout(() => {
        document.getElementById('success-message').style.display = 'none';
    }, 3000);
}




/*function addService() {
    const name = document.getElementById('add-service').value;
   
    fetch('includes/add_services.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            services.push({name});
            const ul = document.getElementById('services-list');
            const li = document.createElement('li');
            li.textContent = name;
            li.onclick = () => displayServiceDetails(id);
            ul.appendChild(li);
            closeAddForm();
            document.getElementById('success-message').style.display = 'block';
            setTimeout(() => {
                document.getElementById('success-message').style.display = 'none';
            }, 2000);
        } else {
            alert('Failed to add service');
        }
    });
}*/
