document.getElementById('appointmentForm').addEventListener('submit', function(event) {
    const firstName = document.getElementById('first_name').value.trim();
    const lastName = document.getElementById('last_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone_num').value.trim();
    const services = document.querySelector('input[name="services"]:checked');
    const barber = document.querySelector('input[name="barber"]:checked');
    const selectedDate = document.getElementById('date').value.trim();
    const timeslot = document.getElementById('timeslot').value.trim();

    if (!firstName || !lastName || !email || !phone || !services || !barber || !timeslot || !selectedDate) {
        document.getElementById('validationMessage').style.display = 'block';
        event.preventDefault(); // Prevent form submission


        
    } else {
        document.getElementById('validationMessage').style.display = 'none';
    }
});

window.onload = function() {
    const selectedDate = "<?php echo $selectedDate; ?>";
    const selectedTime = "<?php echo $selectedTime; ?>";
    
    if (selectedDate && selectedTime) {
        fetchAvailableBarbers(selectedDate);
    }
};

function fetchAvailableBarbers(date) {
    const barberContainer = document.getElementById('barber-container');
    barberContainer.innerHTML = 'Loading barbers...'; // Placeholder text while fetching
    
    // AJAX request to fetch availability
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `barberavailability.php?selected_date=${date}`, true); // Removed selected_time since it's not needed
    xhr.onload = function() {
        if (this.status === 200) {
            const barbers = JSON.parse(this.responseText);
            let barberOptions = '';

            // Display only available barbers
            barbers.forEach(barber => {
                barberOptions += `<div class='barber-item'>
                                    <input type='radio' name='barber' value='${barber.barber_name}' required>
                                    <label>${barber.barber_name}</label>
                                </div>`;
            });

            barberContainer.innerHTML = barberOptions.length ? barberOptions : 'No available barbers for the selected date.';
        }
    };
    xhr.send();
}
