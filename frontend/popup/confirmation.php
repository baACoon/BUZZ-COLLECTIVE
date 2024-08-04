<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            height: 20%;
            width: 20%;
        }
        .message {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="message ">
        <?php echo "NEW RECORD CREATED SUCCESSFULLY";?>
    </div>

    <?php if (!empty($services)): ?>
        <div class="message success">
            <p>Services: <?php echo htmlspecialchars($services, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    <?php endif; ?>
</body>
</html>