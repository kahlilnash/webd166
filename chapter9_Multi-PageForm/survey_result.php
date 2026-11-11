<?php
// Chapter 9: PHP Sessions and a Multi-Page Form - Final Results
// Name: Kahlil Nash

session_start();

if (!isset($_SESSION['age']) || !isset($_SESSION['education'])) {
    header('Location: survey.php');
    exit();
}

$allowed_income = [
    'under $20,000',
    '$20,000 to $39,000',
    '$40,000 to $59,000',
    '$60,000 to $80,000',
    'over $80,000'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['income'])) {
    $submitted_income = $_POST['income'] ?? '';

    if (in_array($submitted_income, $allowed_income, true)) {
        $_SESSION['income'] = $submitted_income;
    } else {

        header('Location: survey3.php');
        exit();
    }
}

if (!isset($_SESSION['income'])) {
    header('Location: survey3.php');
    exit();
}

$age       = $_SESSION['age'];
$education = $_SESSION['education'];
$income    = $_SESSION['income'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Results</title>
    <link rel="stylesheet" href="survey.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>Thank You for Your Submission!</h1>
        </header>
        
        <main>
            <h2>Your Responses:</h2>
            <ul>
                <li><strong>Age Group:</strong> <?php echo htmlspecialchars($age); ?></li>
                <li><strong>Education Level:</strong> <?php echo htmlspecialchars($education); ?></li>
                <li><strong>Income Bracket:</strong> <?php echo htmlspecialchars($income); ?></li>
            </ul>
            
            <p><a href="survey.php">Retake Survey</a></p>
        </main>
    </div>
</body>
</html>
