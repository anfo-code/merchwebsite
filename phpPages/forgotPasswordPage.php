<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../styles/formStyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;700&family=Roboto:wght@500&display=swap"
          rel="stylesheet">
</head>
<body>
<?php
require_once("../phpClassesUtils/Validation.php");
require_once("../phpClassesUtils/Utils.php");
require_once("../database/DatabaseHandler.php");

$validation = new Validation();
$utils = new Utils();
$database = new DatabaseHandler();
$email = null;
$isFormValid = false;

if ($utils->isPostSet($_POST)) {
    $email = $_POST["email"];

    if ($validation->isEmailValid($email)) {
        if ($database->checkIfUserWithEmailExists($email)) {
            $isFormValid = true;
        } else {
            $errorMessage = "User with the entered email wasn't found. Please check the email you entered.";
        }
    } else {
        $errorMessage = "Please enter a valid email address.";
    }
}
?>

<div>
    <a href="signInPage.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
            <path d="M0 0h48v48h-48z" fill="none"/>
            <path d="M40 22h-24.34l11.17-11.17-2.83-2.83-16 16 16 16 2.83-2.83-11.17-11.17h24.34v-4z"/>
        </svg>
    </a>
</div>

<div class="<?php echo $isFormValid ? "block-hidden" : "content-block"; ?>">
    <h1>Forgot Password</h1>
    <div class="form-block">
        <form id="form-forgot-password" action="forgotPasswordPage.php" method="post">
            <div class="input-block" id="email-input-block">
                <div class="label-block">
                    <label for="email-input">Email:</label>
                </div>
                <input type="email" id="email-input" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                <div class="validation-error-block">
                    <?php
                    if (isset($errorMessage)) {
                        echo "<p class='js-validation-message'>$errorMessage</p>";
                    }
                    ?>
                </div>
            </div>
            <button class="confirm-button" id="confirm-button-forgot-password" type="submit" name="confirm"
                    value="confirm">Confirm
            </button>
        </form>
    </div>
</div>

<div class="<?php echo $isFormValid ? "content-block" : "block-hidden"; ?>">
    <h1>Check your email to continue!</h1>
    <div class="form-block">
        <form id="registration-success-form" name="form" action="signInPage.php" method="post">
            <button class="confirm-button" id="confirm-registration-success-button" name="confirm" value="confirm"
                    type="submit">Confirm
            </button>
        </form>
    </div>
</div>

<script src="../javaScript/formHandling.js"></script>
</body>
</html>
