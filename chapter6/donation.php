<?php 
ini_set('display_errors', 1); 
error_reporting(E_ALL); 

// Get values from the form.
$fname        = trim($_POST['fname'] ?? '');
$lname        = trim($_POST['lname'] ?? '');
$email        = trim($_POST['email'] ?? '');
$amount_raw   = trim($_POST['amount'] ?? '');
$newsletter   = $_POST['subscription'] ?? '';
$donation_level_post = $_POST['donation'] ?? ''; // Safely grab if needed

// Tracking variables
$errors = [];
$okay = true; 

// Validate First Name
if (empty($fname)) {
    $errors[] = 'Please enter your first name.';
    $okay = false;
}

// Validate Last Name
if (empty($lname)) {
    $errors[] = 'Please enter your last name.';
    $okay = false;
}

// Validate Email Address
if (empty($email)) {
    $errors[] = 'Please enter your email.';
    $okay = false;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email format.';
    $okay = false;
}

// Validate Donation Amount
if ($amount_raw === '') {
    $errors[] = 'Amount is missing.';
    $okay = false;
} elseif (!is_numeric($amount_raw)) {
    $errors[] = 'Amount is not a number.';
    $okay = false;
} elseif ($amount_raw <= 0) {
    $errors[] = 'Amount is not greater than 0.';
    $okay = false;
}

// Build Output Content based on Validation Success
if ($okay) {
    // 1. Format the donation amount
    $formatted_amount = number_format((float) $amount_raw, 2);

    // 2. Create Confirmation Number
    $rand = random_int(1000, 9999);
    $last_initial = strtoupper(substr($lname, 0, 1));
    $length = strlen($lname);
    $conf = $length . $last_initial . $rand;

    // 3. Create Subscription Message
    // Adjusted to check the actual value submitted by the form string
    if ($newsletter === 'subscription') {
        $sub_msg = 'You will receive a free one-year subscription to our e-magazine.';
    } else {
        $sub_msg = 'You have chosen not to receive a one year subscription to our e-magazine.';
    }

    // 4. Create Donation Level
    if ($amount_raw >= 100) {
        $level = 'Gold Supporter';
    } elseif ($amount_raw >= 50) {
        $level = 'Silver Supporter';
    } elseif ($amount_raw >= 25) {
        $level = 'Bronze Supporter';
    } else {
        $level = 'Friend of the Animals';
    }

    // 5. Create Repeated Thank-You Message
    $thanks = '';
    for ($i = 1; $i <= 3; $i++) {
        $thanks .= 'Thank you! ';
    }

    // 6. Escape User-Entered Values for Safe Display
    $safe_fname = htmlspecialchars($fname, ENT_QUOTES, 'UTF-8');
    $safe_lname = htmlspecialchars($lname, ENT_QUOTES, 'UTF-8');
    $safe_email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

    // Build the final receipt output HTML
    $output = "<p><strong>$thanks</strong></p>";
    $output .= "<p>Thank you, <strong>$safe_fname $safe_lname</strong>, for your generous donation of <strong>\$$formatted_amount</strong>.</p>";
    $output .= "<p>Your donor tier: <strong>$level</strong></p>";
    $output .= "<p>Confirmation Number: <strong>$conf</strong></p>";
    $output .= "<p>$sub_msg</p>";

} else {
    // Build the Error Message HTML
    $output = "<p>Please <a href=\"donation.html\">GO BACK</a> and fill in the following errors:</p>\n";
    $output .= "<ul>";
    foreach ($errors as $error) {
        $output .= "<li>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</li>";
    }
    $output .= "</ul>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donation Confirmation</title>
    <style>
        body { font-family: arial; font-size: 100%; }
        #outer { width: 960px; margin: 50px auto; padding: 20px; border: 1px solid #a8a8a8; box-shadow: 0px 0px 20px #a8a8a8; background-color: aliceblue; }
        h1, h2 { font-size: 1.5em; color: navy; text-align: center; }
        .info { text-align: left; }
    </style>
</head>
<body>
    <header>
        <h1>Humane Society Donations</h1>
        <h2>Help the Animals</h2>
    </header>
    <section id="outer">
        <h1 class="info"><?php echo $okay ? 'Your Contribution Receipt' : 'Submission Errors'; ?></h1>
        
        <!-- Render Error List OR the Success Receipt -->
        <?php echo $output; ?>
    </section>
</body>
</html>