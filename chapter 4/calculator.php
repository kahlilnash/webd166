<?php
// retrieves values from the form
$milesDriven = $_POST['miles_driven'];
$gallonsUsed = $_POST['gallons_used'];
$pricePerGallon = $_POST['price_per_gallon'];

//Calculates the math
$mpg = $milesDriven / $gallonsUsed;
$total = ($gallonsUsed * $pricePerGallon);
?>
<!DOCTYPE html>
<!-- Kahlil Nash -->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trip Calculator Results</title>
</head>
<body>
  <h1>Trip Calculations</h1>
<h2>Values Entered</h2>

<!-- Displays the values that the client entered-->
<p>Miles Driven: <?php print number_format($milesDriven) ?></p>
<p>Gallons of Gas Used: <?php print number_format($gallonsUsed, 2) ?></p>
<p>Price per gallon: $ <?php print number_format($pricePerGallon, 2) ?></p>

<!-- Displays the math calculated from the submitted form information-->
<h2>Your Results</h2>
<p>Miles Per Gallon: <?php print number_format($mpg) ?> </p>
<p>Cost of the Trip: $<?php print number_format($total, 2) ?></p>
</body>
</html>