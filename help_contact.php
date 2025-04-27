<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["attachment"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["attachment"]["name"]);

    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
        $upload_message = "Thanks! We'll check your file: <a href='$target_file'>" . htmlspecialchars(basename($_FILES["attachment"]["name"])) . "</a>";
    } else {
        $upload_message = "Error uploading the file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Help & Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
        }
        .container {
            background: #fff;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #007bb5;
        }
        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="submit"] {
            background-color: #007bb5;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .message {
            padding: 10px;
            background: #e2f0cb;
            border: 1px solid #9ecb8d;
            border-radius: 6px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container">
   	 <a href="index.php" style="text-decoration: none; padding: 8px 16px; background-color: #007bb5; color: white; border-radius: 4px; font-weight: bold; display: inline-block;">Back</a>

	 <h2>Contact Support</h2>
    <p>If you're facing issues, send us a message. You can attach a file (e.g., screenshot or log).</p>

    <form method="post" enctype="multipart/form-data">
        <label>Your Name:</label>
        <input type="text" name="name" required>

        <label>Message:</label>
        <textarea name="message" rows="5" required></textarea>

        <label>Attachment:</label>
        <input type="file" name="attachment">

        <input type="submit" value="Submit">
    </form>

    <?php if (!empty($upload_message)) echo "<div class='message'>$upload_message</div>"; ?>
</div>
</body>
</html>
