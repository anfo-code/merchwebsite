<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require_once("../phpClassesUtils/Validation.php");
require_once("../phpClassesUtils/Utils.php");
require_once("../database/DatabaseHandler.php");

$validation = new Validation();
$utils = new Utils();
$database = new DatabaseHandler();

// Initialize variables
$email = $name = $surname = $address = $country = $city = $postCode = $phoneNumber = $purchaseDescription = null;
$isFormValid = false;

// Process form submission
if ($utils->isPostSet($_POST)) {
    $email = $_POST["email"];
    $name = $_POST["name"];
    // ... continue fetching other POST data ...
    $purchaseDescription = $_POST["purchase-description"];

    // Validate the form data
    $isFormValid = $validation->validatePurchaseForm($email, $name, $surname, $address, $country, $city, $postCode, $phoneNumber, $purchaseDescription);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase products</title>
    <link rel="stylesheet" href="../styles/formStyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;700&family=Roboto:wght@500&display=swap"
          rel="stylesheet">
</head>
<body>

<!-- Navigation Link -->
<div>
    <a href="../index.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
            <path d="M0 0h48v48h-48z" fill="none"/>
            <path d="M40 22h-24.34l11.17-11.17-2.83-2.83-16 16 16 16 2.83-2.83-11.17-11.17h24.34v-4z"/>
        </svg>
    </a>
</div>

<!-- Purchase Form Block -->
<div class="<?php echo $isFormValid ? 'block-hidden' : 'content-block'; ?>">
    <h1>Make a purchase</h1>
    <div class="form-block">
        <form name="form" action="purchasePage.php" method="post">
            <!-- Email -->
            <div class="input-block" id="email-input-block">
                <div class="label-block">
                    <label for="email-input">Email:</label>
                </div>
                <input type="email" id="email-input" name="email"
                       value="<?php
                       if (isset($_SESSION["user"])) {
                           echo $_SESSION["user"]["email"];
                       } elseif ($utils->isPostSet($_POST)) {
                           echo htmlspecialchars($email);
                       } ?>"
                       required>
                <div class="validation-error-block">
                    <p class="js-validation-message">Invalid Email</p>
                    <?php
                    if ($utils->isPostSet($_POST) && !$validation->isEmailValid($email)) {
                        echo "<p>*</p>";
                        $isFormValid = false;
                    }
                    ?>
                </div>
            </div>

            <!-- Name and Surname -->
            <div class="two-inputs-in-one-row-block">
                <!-- Name -->
                <div class="input-block" id="name-input-block">
                    <div class="label-block">
                        <label for="name-input">Name:</label>
                    </div>
                    <input type="text" id="name-input" name="name"
                           value="<?php
                           if (isset($_SESSION["user"])) {
                               echo $_SESSION["user"]["name"];
                           } elseif ($utils->isPostSet($_POST)) {
                               echo htmlspecialchars($name);
                           } ?>"
                           required>
                    <div class="validation-error-block">
                        <p class="js-validation-message">Invalid Name</p>
                        <?php
                        if ($utils->isPostSet($_POST) && !$validation->isNameValid($name)) {
                            echo "<p>*</p>";
                            $isFormValid = false;
                        }
                        ?>
                    </div>
                </div>

                <!-- Surname -->
                <div class="input-block" id="surname-input-block">
                    <div class="label-block">
                        <label for="surname-input">Surname:</label>
                    </div>
                    <input type="text" id="surname-input" name="surname"
                           value="<?php
                           if (isset($_SESSION["user"])) {
                               echo $_SESSION["user"]["surname"];
                           } elseif ($utils->isPostSet($_POST)) {
                               echo htmlspecialchars($surname);
                           } ?>"
                           required>
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

            <!-- Address -->
            <div class="input-block" id="address-input-block">
                <div class="label-block">
                    <label for="address-input">Address:</label>
                </div>
                <input type="text" id="address-input" name="address"
                       value="<?php
                       if (isset($_SESSION["user"])) {
                           echo $_SESSION["user"]["address"];
                       } elseif ($utils->isPostSet($_POST)) {
                           echo htmlspecialchars($address);
                       } ?>"
                       required>
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

            <!-- Country and City -->
            <div class="two-inputs-in-one-row-block">
                <!-- Country -->
                <div class="input-block" id="country-input-block">
                    <div class="label-block">
                        <label for="country-input">Country:</label>
                    </div>
                    <input type="text" id="country-input" name="country"
                           value="<?php
                           if (isset($_SESSION["user"])) {
                               echo $_SESSION["user"]["country"];
                           } elseif ($utils->isPostSet($_POST)) {
                               echo htmlspecialchars($country);
                           } ?>"
                           required>
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

                <!-- City -->
                <div class="input-block" id="city-input-block">
                    <div class="label-block">
                        <label for="city-input">City:</label>
                    </div>
                    <input type="text" id="city-input" name="city"
                           value="<?php
                           if (isset($_SESSION["user"])) {
                               echo $_SESSION["user"]["city"];
                           } elseif ($utils->isPostSet($_POST)) {
                               echo htmlspecialchars($city);
                           } ?>"
                           required>
                    <div class="validation-error-block">
                        <p class="js-validation-message">Invalid City</p>
                        <?php
                        if ($utils->isPostSet($_POST) && !$validation->isCountryOrCityValid($city)) {
                            echo "<p>*</p>";
                            $isFormValid = false;
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Post Code and Phone Number -->
            <div class="two-inputs-in-one-row-block">
                <!-- Post Code -->
                <div class="input-block" id="post-code-input-block">
                    <div class="label-block">
                        <label for="post-code-input">Post Code:</label>
                    </div>
                    <input type="text" id="post-code-input" name="post-code"
                           value="<?php
                           if (isset($_SESSION["user"])) {
                               echo $_SESSION["user"]["post-code"];
                           } elseif ($utils->isPostSet($_POST)) {
                               echo htmlspecialchars($postCode);
                           } ?>"
                           required>
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

                <!-- Phone Number -->
                <div class="input-block" id="phone-number-input-block">
                    <div class="label-block">
                        <label for="phone-number-input">Phone Number:</label>
                    </div>
                    <input type="text" id="phone-number-input" name="phone-number"
                           value="<?php
                           if (isset($_SESSION["user"])) {
                               echo $_SESSION["user"]["phone-number"];
                           } elseif ($utils->isPostSet($_POST)) {
                               echo htmlspecialchars($phoneNumber);
                           } ?>"
                           required>
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

            <!-- Purchase Description -->
            <div class="input-block" id="purchase-description-input-block">
                <div class="label-block">
                    <label for="purchase-describe-input">Describe your purchase:</label>
                </div>
                <input type="text" id="purchase-describe-input" name="purchase-description"
                       value="<?php echo $utils->isPostSet($_POST) ? htmlspecialchars($purchaseDescription) : ''; ?>"
                       required>
                <div class="validation-error-block">
                    <p class="js-validation-message">Invalid Description</p>
                    <?php
                    if ($utils->isPostSet($_POST) && !$validation->isPurchaseDescriptionValid($purchaseDescription)) {
                        echo "<p>*</p>";
                        $isFormValid = false;
                    }
                    ?>
                </div>
            </div>

            <!-- Validation Error Message -->
            <div class="validation-error-block">
                <?php
                if ($utils->isPostSet($_POST) && $isFormValid) {
                    echo "<p>Invalid inputs. Check the inputs marked by *</p>";
                }
                ?>
            </div>

            <button class="confirm-button" id="confirm-button-purchase" name="confirm" value="confirm" type="button">
                Confirm
            </button>
        </form>
    </div>
</div>

<!-- Success Message Block -->
<div class="<?php echo $isFormValid ? 'content-block' : 'block-hidden'; ?>">
    <h1>Purchase was made successfully!</h1>
    <h2>Wait for the response on your email</h2>
    <!-- Confirmation Form -->
    <div class="form-block">
        <form id="registration-success-form" name="form" action="../index.php" method="post">
            <button class="confirm-button" id="confirm-registration-success-button" name="confirm" value="confirm"
                    type="button">
                Confirm
            </button>
        </form>
    </div>
</div>

<!-- Empty Block for Spacing -->
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