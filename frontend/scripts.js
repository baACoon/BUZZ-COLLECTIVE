function showInfo(element) {
  const infoBox = element.querySelector('.info');
  infoBox.style.display = 'block';

  // Adjust the position of the appointment button
  const appointmentBtn = document.querySelector('.appointment-btn');
  const memberBottom = element.getBoundingClientRect().bottom;
  const infoBoxHeight = infoBox.offsetHeight;
  const newMarginTop = memberBottom + infoBoxHeight - window.innerHeight + 40;
  if (newMarginTop > 20) {
      appointmentBtn.style.marginTop = `${newMarginTop}px`;
  } else {
      appointmentBtn.style.marginTop = '20px';
  }
}

function hideInfo(element) {
  const infoBox = element.querySelector('.info');
  infoBox.style.display = 'none';

  // Reset the position of the appointment button
  const appointmentBtn = document.querySelector('.appointment-btn');
  appointmentBtn.style.marginTop = '20px';
}
