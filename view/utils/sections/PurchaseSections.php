<?php

namespace view\utils\sections;

use controller\utlis\Utils;
use controller\utlis\Validation;
use HrefsConstants;
use Inputs;
use model;

require_once __DIR__ . '/../Icons.php';
require_once __DIR__ . '/../Inputs.php';
require_once __DIR__ . '/../HrefsConstants.php';


class PurchaseSections
{
    public static function renderForm($isPostSet, $isFormValid, $isAlreadyRegistered, $email, $name, $surname, $address, $country, $city, $postCode, $phoneNumber, $purchaseDescription)
    {
        ?>
        <div class="content-block">
            <h1>Change User Data</h1>
            <div class="form-block">
                <form name="form" action="<?php echo HrefsConstants::SIGN_UP ?>" method="post">
                    <?php
                    //Email input
                    echo Inputs::printInputBlock("email-input-block", "Email", "email", $email, "Invalid Email", Validation::isEmailValid($email), $isPostSet);
                    ?>

                    <div class="two-inputs-in-one-row-block">
                        <?php
                        //Name input
                        echo Inputs::printInputBlock("name-input-block", "Name", "name", $name, "Invalid Name", Validation::isNameValid($name), $isPostSet);
                        //Surname input
                        echo Inputs::printInputBlock("surname-input-block", "Surname", "surname", $surname, "Invalid Surname", Validation::isNameValid($surname), $isPostSet);
                        ?>
                    </div>

                    <?php
                    //Address input
                    echo Inputs::printInputBlock("address-input-block", "Address", "address", $address, "Invalid Address", Validation::isAddressValid($address), $isPostSet);
                    //Country input
                    echo Inputs::printInputBlock("country-input-block", "Country", "country", $country, "Invalid Country", Validation::isCountryOrCityValid($country), $isPostSet);
                    //City input
                    echo Inputs::printInputBlock("city-input-block", "City", "city", $city, "Invalid City", Validation::isCountryOrCityValid($city), $isPostSet);
                    ?>

                    <div class="two-inputs-in-one-row-block">
                        <?php
                        //Post code input
                        echo Inputs::printInputBlock("post-code-input-block", "Post Code", "post-code", $postCode, "Invalid Post Code", Validation::isPostCodeValid($postCode), $isPostSet);
                        //Phone number input
                        echo Inputs::printInputBlock("phone-number-input-block", "Phone Number", "phone-number", $phoneNumber, "Invalid Phone Number", Validation::isPhoneNumberValid($phoneNumber), $isPostSet);
                        ?>
                    </div>

                    <?php
                    // Purchase Description
                    echo Inputs::printInputBlock("purchase-description-input-block", "Describe your purchase", "purchase-description", $purchaseDescription, "Invalid Purchase Description", Validation::isPurchaseDescriptionValid($city), $isPostSet);
                    ?>

                    <div class="validation-error-block">
                        <?php
                        if (Utils::isPostSet($_POST)) {

                            if (!$isFormValid) {
                                echo "<p>Invalid inputs. Check the inputs marked by *</p>";
                            }
                            if ($isAlreadyRegistered) {
                                echo "<p>User with such email address is already registered!</p>";
                            }
                        }
                        ?>
                    </div>

                    <button class="confirm-button" id="confirm-button-sign-up" name="confirm" value="confirm"
                            type="button">
                        Confirm
                    </button>
                </form>
            </div>
        </div>
        <?php
    }

    static function renderSuccessMessage()
    {
        ?>
        <!-- Success Message Block -->
        <div class="content-block">
            <h1>Purchase was made successfully!</h1>
            <h2>Wait for the response on your email</h2>
            <!-- Confirmation Form -->
            <div class="form-block">
                <form id="registration-success-form" name="form" action="<?php echo HrefsConstants::INDEX?>" method="post">
                    <button class="confirm-button" id="confirm-registration-success-button" name="confirm" value="confirm"
                            type="button">
                        Confirm
                    </button>
                </form>
            </div>
        </div>
        <?php
    }

    static function renderScripts(): void
    {
        ?>
        <script src="http://zwa.toad.cz/~fomenart/controller/javaScript/formHandling.js"></script>
        <?php
    }
}