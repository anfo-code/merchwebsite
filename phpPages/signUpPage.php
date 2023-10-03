<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if (isset($_SESSION["user"])) {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create an account</title>
    <link rel="stylesheet" href="../styles/formStyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;700&family=Roboto:wght@500&display=swap"
          rel="stylesheet">

</head>
<body>
<?php
require_once("../phpClassesUtils/Validation.php");
require_once("../phpClassesUtils/Utils.php");
include_once("../database/DatabaseHandler.php");
$validation = new Validation();
$utils = new Utils();
$database = new DatabaseHandler();
$email = $name = $surname = $password = $passwordRepeat = $address = $country = $city = $postCode = $phoneNumber = null;
$isFormValid = false;
$isUserWithSuchEmailAlreadyRegistered = false;
if ($utils->isPostSet($_POST)) {
    $email = $_POST["email"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["password-repeat"];
    $address = $_POST["address"];
    $country = $_POST["country"];
    $city = $_POST["city"];
    $postCode = $_POST["post-code"];
    $phoneNumber = $_POST["phone-number"];
    $isFormValid = $validation->validateSignUpForm($email, $name, $surname, $password, $passwordRepeat, $address, $country, $city, $postCode, $phoneNumber);
    $isUserWithSuchEmailAlreadyRegistered = $database->checkIfUserWithEmailExists($email);
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
<div class="<?php if ($isFormValid  && !$isUserWithSuchEmailAlreadyRegistered) {
    echo "block-hidden";
} else {
    echo "content-block";
} ?>">
    <h1>Sign up</h1>
    <div class="form-block">
        <form name="form" action="signUpPage.php" method="post">
            <div class="hidden-input-block">
                <input name="hidden" value="sign-in">
            </div>
            <div class="input-block" id="email-input-block">
                <div class="label-block">
                    <label for="email-input">Email:</label>
                </div>
                <input type="email" id="email-input" name="email" value="<?php if ($utils->isPostSet($_POST)) {
                    echo htmlspecialchars($email);
                } ?>" required>
                <div class="validation-error-block">
                    <p class="js-validation-message">Invalid Email</p>
                    <?php
                    if ($utils->isPostSet($_POST) && !$validation->isEmailValid($email)) {
                        echo "<p>*</p>";
                        $isFormValid = false;
                    } ?>
                </div>
            </div>
            <div class="two-inputs-in-one-row-block">
                <div class="input-block" id="name-input-block">
                    <div class="label-block">
                        <label for="name-input">Name:</label>
                    </div>
                    <input type="text" id="name-input" name="name" value="<?php if ($utils->isPostSet($_POST)) {
                        echo htmlspecialchars($name);
                    } ?>" required>
                    <div class="validation-error-block">
                        <p class="js-validation-message">Invalid Name</p>
                        <?php
                        if ($utils->isPostSet($_POST) && !$validation->isNameValid($name)) {
                            echo "<p>*</p>";
                            $isFormValid = false;
                        } ?>
                    </div>
                </div>
                <div class="input-block" id="surname-input-block">
                    <div class="label-block">
                        <label for="surname-input">Surname:</label>
                    </div>
                    <input type="text" id="surname-input" name="surname" value="<?php if ($utils->isPostSet($_POST)) {
                        echo htmlspecialchars($surname);
                    } ?>" required>
                    <div class="validation-error-block">
                        <p class="js-validation-message">Invalid Surname</p>
                        <?php
                        if ($utils->isPostSet($_POST) && !$validation->isNameValid($surname)) {
                            echo "<p>*</p>";
                            $isFormValid = false;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="input-block" id="password-input-block">
                <div class="label-block">
                    <label for="password-input">Password:</label>
                </div>
                <input type="password" id="password-input" name="password" minlength="8"
                       value="<?php if ($utils->isPostSet($_POST)) {
                           echo htmlspecialchars($password);
                       } ?>" required>
                <div class="validation-error-block">
                    <p class="js-validation-message">Invalid Password</p>
                    <?php
                    if ($utils->isPostSet($_POST) && !$validation->isPasswordValid($password)) {
                        echo "<p>*</p>";
                        $isFormValid = false;
                    }
                    ?>
                </div>
            </div>
            <div class="input-block" id="repeat-password-input-block">
                <div class="label-block">
                    <label for="repeat-password-input">Repeat the password:</label>
                </div>
                <input type="password" id="repeat-password-input" name="password-repeat" minlength="8"
                       value="<?php if ($utils->isPostSet($_POST)) {
                           echo htmlspecialchars($passwordRepeat);
                       } ?>" required>
                <div class="validation-error-block">
                    <p class="js-validation-message">Passwords don't match</p>
                    <?php
                    if ($utils->isPostSet($_POST) && !$validation->isPasswordRepeatValid($password, $passwordRepeat)) {
                        echo "<p>*</p>";
                        $isFormValid = false;
                    }
                    ?>
                </div>
            </div>
            <div class="input-block" id="address-input-block">
                <div class="label-block">
                    <label for="address-input">Address:</label>
                </div>
                <input type="text" id="address-input" name="address" value="<?php if ($utils->isPostSet($_POST)) {
                    echo htmlspecialchars($address);
                } ?>" required>
                <div class="validation-error-block">
                    <p class="js-validation-message">Invalid Address</p>
                    <?php
                    if ($utils->isPostSet($_POST) && !$validation->isAddressValid($address)) {
                        echo "<p>*</p>";
                        $isFormValid = false;
                    }
                    ?>
                </div>
            </div>
            <div class="input-block" id="country-input-block">
                <div class="label-block">
                    <label for="country-input">Country:</label>
                </div>
                <input type="text" id="country-input" name="country" value="<?php if ($utils->isPostSet($_POST)) {
                    echo htmlspecialchars($country);
                } ?>" required>
                <div class="validation-error-block">
                    <p class="js-validation-message">Invalid Country</p>
                    <?php
                    if ($utils->isPostSet($_POST) && !$validation->isCountryOrCityValid($country)) {
                        echo "<p>*</p>";
                        $isFormValid = false;
                    }
                    ?>
                </div>
            </div>
            <div class="input-block" id="city-input-block">
                <div class="label-block">
                    <label for="city-input">City:</label>
                </div>
                <input type="text" id="city-input" name="city" value="<?php if ($utils->isPostSet($_POST)) {
                    echo htmlspecialchars($city);
                } ?>" required>
                <div class="validation-error-block">
                    <p class="js-validation-message">Invalid City</p>
                    <?php
                    if ($utils->isPostSet($_POST)) {
                        if (!$validation->isCountryOrCityValid($city)) {
                            echo "<p>*</p>";
                            $isFormValid = false;
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="two-inputs-in-one-row-block">
                <div class="input-block" id="post-code-input-block">
                    <div class="label-block">
                        <label for="post-code-input">Post Code:</label>
                    </div>
                    <input type="text" id="post-code-input" name="post-code"
                           value="<?php if ($utils->isPostSet($_POST)) {
                               echo htmlspecialchars($postCode);
                           } ?>" required>
                    <div class="validation-error-block">
                        <p class="js-validation-message">Invalid Post Code</p>
                        <?php
                        if ($utils->isPostSet($_POST) && !$validation->isPostCodeValid($postCode)) {
                            echo "<p>*</p>";
                            $isFormValid = false;
                        }
                        ?>
                    </div>
                </div>
                <div class="input-block" id="phone-number-input-block">
                    <div class="label-block">
                        <label for="phone-number-input">Phone Number:</label>
                    </div>
                    <input type="text" id="phone-number-input" name="phone-number"
                           value="<?php if ($utils->isPostSet($_POST)) {
                               echo htmlspecialchars($phoneNumber);
                           } ?>" required/>
                    <div class="validation-error-block">
                        <p class="js-validation-message">Invalid Phone Number</p>
                        <?php
                        if ($utils->isPostSet($_POST) && !$validation->isPhoneNumberValid($phoneNumber)) {
                            echo "<p>*</p>";
                            $isFormValid = false;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="validation-error-block">
                <?php
                if ($utils->isPostSet($_POST)) {
                    if (!$isFormValid) {
                        echo "<p>Invalid inputs. Check the inputs marked by *</p>";
                    }
                    if ($isUserWithSuchEmailAlreadyRegistered) {
                        echo "<p>User with such email address is already registered!</p>";
                    }
                }
                ?>
            </div>
            <button class="confirm-button" id="confirm-button-sign-up" name="confirm" value="confirm" type="button">
                Confirm
            </button>

        </form>
    </div>
</div>
<div class="<?php if ($isFormValid && !$isUserWithSuchEmailAlreadyRegistered) {
    echo "content-block";
    $database->createUser($email, $password, $name, $surname, $address, $country, $city, $postCode, $postCode);
} else {
    echo "block-hidden";
} ?>">
    <h1>Registration Successful!</h1>
    <div class="form-block">
        <form id="registration-success-form" name="form" action="signInPage.php" method="post">
            <button class="confirm-button" id="confirm-registration-success-button" name="confirm" value="confirm"
                    type="button">
                Confirm
            </button>
        </form>
    </div>
</div>

</div>
<div class="empty-block">
    &nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
</div>
<script src="../javaScript/formHandling.js"></script>
</body>
</html>