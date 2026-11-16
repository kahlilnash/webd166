<?php

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: contest.html');
    exit;
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));


$photo = $_FILES['photo'] ?? null;

$errors = [];
$uploaded = false;
$storedFilename = '';
$uploadDirectory = __DIR__ . '/uploads/';
$maximumFileSize = 1048576;
$allowedMimeTypes = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
];

function escapeHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

if ($name === '') {
    $errors[] = 'Please enter your name.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // filter_var($email, FILTER_VALIDATE_EMAIL) returns false for an invalid email.
    $errors[] = 'Please enter a valid email address.';
}

$uploadReady = false;
if (!is_array($photo)
    || !isset($photo['error'], $photo['size'], $photo['tmp_name'])
    || !is_int($photo['error'])
    || !is_int($photo['size'])
    || !is_string($photo['tmp_name'])) {
    $errors[] = 'Please select one photograph to upload.';
} elseif ($photo['error'] === UPLOAD_ERR_NO_FILE) {
    $errors[] = 'Please select a photograph to upload.';
} elseif ($photo['error'] === UPLOAD_ERR_FORM_SIZE || $photo['error'] === UPLOAD_ERR_INI_SIZE) {
    $errors[] = 'The photograph exceeds the upload size limit.';
} elseif ($photo['error'] !== UPLOAD_ERR_OK) {
    $errors[] = 'The photograph could not be uploaded (error ' . $photo['error'] . ').';
} else {
    $uploadReady = true;
}

$extension = '';

if ($uploadReady) {
    if ($photo['size'] <= 0) {
        $errors[] = 'The selected photograph is empty.';
    } elseif ($photo['size'] > $maximumFileSize) {
        $errors[] = 'The photograph must not exceed 1 MB (1,048,576 bytes).';
    }

    if (!is_uploaded_file($photo['tmp_name'])) {
        $errors[] = 'The uploaded photograph could not be verified.';
    } elseif ($photo['size'] > 0 && $photo['size'] <= $maximumFileSize) {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($fileInfo === false) {
            $errors[] = 'The server could not inspect the photograph.';
        } else {
            $mimeType = finfo_file($fileInfo, $photo['tmp_name']);
            finfo_close($fileInfo);

            if ($mimeType === false || !isset($allowedMimeTypes[$mimeType])) {
                $errors[] = 'Only JPEG and PNG photographs are allowed.';
            } else {
                $extension = $allowedMimeTypes[$mimeType]; // Gets the trusted extension from $allowedMimeTypes.
            }
        }
    }
}

if ($uploadReady && empty($errors)) {
    if (!is_dir($uploadDirectory)) {
        $errors[] = 'The uploads directory does not exist.';
    } elseif (!is_writable($uploadDirectory)) {
        $errors[] = 'The uploads directory is not writable.';
    } else {
        $storedFilename = bin2hex(random_bytes(16)).'.'.$extension;
        $destination = $uploadDirectory . $storedFilename;

        if (move_uploaded_file($photo['tmp_name'], $destination)) { // Moves an uploaded photograph from a temporary server folder to a permanent location and records an error if the transfer fails
            $uploaded = true;
        } else {
            $errors[] = 'The photograph could not be saved. Please try again.';
            $storedFilename = '';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Contest Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="wrapper">
        <header>
            <h1>Photo Contest</h1>
        </header>
        <main>
            <h2>Submission Results</h2>

            <?php if (!empty($errors)): ?>
                <h3>Please correct the following:</h3>
                <ul class="error">
                    <?php foreach ($errors as $error): ?>
                        <li><?= escapeHtml($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php elseif ($uploaded): ?>
                <!-- Displays the confirmation and saved photograph. -->
                <p class="message">Thank you, <?= escapeHtml($name) ?>, for entering our contest!</p>
                <p>Your photo was uploaded successfully.</p>
                <img class="photo-preview"
                     src="uploads/<?= escapeHtml($storedFilename) ?>"
                     alt="Photograph submitted by <?= escapeHtml($name) ?>">
            <?php else: ?>
                <p class="error">Your photograph has not been saved. Check the TODO sections and try again.</p>
            <?php endif; ?>

            <p><a class="back-link" href="contest.html">Return to the Photo Contest form</a></p>
        </main>
    </div>
</body>
</html>