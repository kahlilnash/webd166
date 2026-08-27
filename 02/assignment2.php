<?php
    $heading = "Googleplex";
    $street = "1600 Amphitheater Parkway";
    $city = "Mountain View";
    $state = "CA";
    $country = "United States";
?>

<!DOCTYPE html>
<!-- Kahlil Nash -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kahlil Nash</title>
</head>
<body>
    <h1><?php echo $heading; ?></h1>
    <p>
    The <?php echo $heading; ?> is the corporate headquarters complex of Google and its parent company Alphabet Inc. It is located at:
    <br>
    <?php echo $street; ?>
    <br>
    <?php echo $city; ?>, <?php echo $state; ?>, <?php echo $country; ?>
    </p>
</body>
</html>