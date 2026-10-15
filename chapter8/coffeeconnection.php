<?php 

// Initialize variables and error states
$firstName = '';
$lastName = '';
$email = '';
$age = false;
$errors = [];
$msg = '';
$okay = false;

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"]==="POST") {

    // Retrieve and sanitize form data
    $firstName = trim($_POST['fname'] ?? '');
    $lastName = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $age = isset($_POST['age']);

    // Validate form values
    $okay = true;

    if($firstName === '') {
        $errors['fname'] = 'Please enter your first name.';
        $okay = false;
    }

    if($lastName === '') {
        $errors['lname'] = 'Please enter your last name.';
        $okay = false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email.';
        $okay = false;
    }

    if (!$age) { 
        $errors['age'] = 'Please confirm age.'; 
        $okay = false; 
    }
}

// Redirect after successful validation
if ($okay === true) {
    header('Location: subscribed.php');
    exit;
}
require 'includes/header.php'; 
?>

    <main id="content">

        <h2 class="center">Welcome to Coffee Connection!</h2>

        <p>
            We’re not just passionate lovers of coffee, but everything else that goes
            with a full and rewarding coffeehouse experience. We also offer a selection
            of premium teas, fine pastries, and other delectable treats. The music you
            hear in store is chosen for its artistry and appeal. It’s not unusual to see
            people coming to Coffee Connection to chat, meet up, or even work. We’re a
            neighborhood gathering place, a part of the daily routine, and would like
            to be part of your way of life.
        </p>

        <section id="contact">
            <h2 class="center">Sign Up to Receive Our Newsletter</h2>

            <?php if (!empty($msg)): ?>
                <p class="green center"><strong><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></strong></p>
            <?php endif; ?>

            <form method="post" novalidate>

                <div class="flexcontainer">
                    <label for="fname">First Name:</label>
                    <input type="text" name="fname" id="fname" value="<?php echo htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <?php if (!empty($errors['fname'])): ?>
                <p class="red"><?php echo htmlspecialchars($errors['fname'], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endif; ?>

                <div class="flexcontainer">
                    <label for="lname">Last Name:</label>
                    <input type="text" name="lname" id="lname" value="<?php echo htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <!-- Replace this placeholder with the PHP last-name error message. -->
                <?php if (!empty($errors['lname'])): ?>
                <p class="red"><?php echo htmlspecialchars($errors['lname'], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endif; ?>

                <div class="flexcontainer">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <!-- Replace this placeholder with the PHP email error message. -->
                <?php if (!empty($errors['email'])): ?>
                <p class="red"><?php echo htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endif; ?>

                <div class="flexcontainer2">
                    <label for="age">I am over 18:</label>
                    <input type="checkbox" name="age" id="age" value="yes" <?= $age ? 'checked' : '' ?>>
                </div>

                <!-- Replace this placeholder with the PHP checkbox error message. -->
                <?php if (!empty($errors['age'])): ?>
                <p class="red"><?php echo htmlspecialchars($errors['age'], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endif; ?>
                <!--
                    The submitted text values will eventually be placed back
                    into the form so they remain visible after an error.
                    This creates a sticky form.
                -->
                <div class="form-actions">
                    <button type="submit">Submit</button>
                    <a class="clear-link" href="coffeeconnection.php">Clear Form</a>
                </div>

            </form>
        </section>

        <section id="products">

            <div class="product center">
                <h3>Espresso</h3>
                <p><img src="images/coffee_espresso.jpg" alt="Espresso coffee"></p>
                <p>Popular espresso beverages — latte, americano, cappuccino, macchiato, and cold espresso drinks</p>
            </div>

            <div class="product center">
                <h3>Blended</h3>
                <p><img src="images/coffee_blended.jpg" alt="Blended coffee drinks"></p>
                <p>Delicious icy blends</p>
            </div>

            <div class="product center">
                <h3>Pastries</h3>
                <p><img src="images/coffee_pastries.jpg" alt="Pastries"></p>
                <p>Muffins, bagels, coffee cakes, and more</p>
            </div>

            <div class="product center">
                <h3>Food</h3>
                <p><img src="images/coffee_food.jpg" alt="Sandwiches, salads, and other food"></p>
                <p>Sandwiches, paninis, salads, and more</p>
            </div>

            <div class="product center">
                <h3>Breakfast</h3>
                <p><img src="images/coffee_breakfast.jpg" alt="Breakfast food"></p>
                <p>Biscuits, muffins, wraps, croissants, oatmeal, and more</p>
            </div>

        </section>

    </main>

    <!--
        This footer also appears on more than one page.
        You will move it into a reusable PHP file.
    -->
    <?php 
require 'includes/footer.php'; 
?>