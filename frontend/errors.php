<?php if (count($errors) > 0) : ?>
  <style>
    .error-container {
      background-color: white; /* Background color for the error container */
      color: black; /* Text color for the error messages */
      padding: 30px; /* Padding around the error messages */
      border: 1px solid  #E43A19; /* Border color for the error container */
      border-radius: 5px; /* Rounded corners for the error container */
      font-weight: 400;
      font-size: 10px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);

	}

    .error-message {
      margin: 0; /* Remove default margin for paragraphs */
      font-size: 1rem;
    }
  </style>

  <div class="error-container">
    <?php foreach ($errors as $error) : ?>
      <p class="error-message"><?php echo $error ?></p>
    <?php endforeach ?>
  </div>



  <script> //JS to hide the error prompt message
	document.addEventListener('DOMContentLoaded', function() {
		var errorContainer = document.querySelector('.error-container');
		var inputFields = document.querySelectorAll('input');

		function hideError() {
			errorContainer.style.display = 'none';
		}

		inputFields.forEach(function(input) {
			input.addEventListener('click', hideError);
		});

		errorContainer.addEventListener('click', hideError);
		});
  </script>
<?php endif ?>
