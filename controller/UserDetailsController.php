<?php

namespace controller;

use controller\utlis\FormValidation;
use HrefsConstants;
use model\database\DatabaseHandler;
use model\models\User;
use view\UserDetailsView;

require_once __DIR__ . '/../view/UserDetailsView.php';

/**
 * Class UserDetailsController
 *
 * This class manages user details and user details editing.
 */
class UserDetailsController
{
    /**
     * @var UserDetailsView
     */
    private UserDetailsView $view;

    /**
     * UserDetailsController constructor.
     *
     * Initializes the user details controller, validates the form, and handles user details editing.
     */
    public function __construct()
    {
        if (isset($_POST['action']) && $_POST['action'] == 'unset') {
            session_destroy();
        }

        $isFormValid = $this->validateForm();

        $userDetailsEditResult = false;
        $isCsrfSuccess = false;

        if (isset($_POST['csrf-token']) && isset($_SESSION['csrf-token']) && $_POST['csrf-token'] == $_SESSION['csrf-token']) {
            $isCsrfSuccess = true;
        }

        if ($isFormValid && isset($_POST['csrf-token']) && isset($_SESSION['csrf-token']) && $_POST['csrf-token'] == $_SESSION['csrf-token']) {
            $userDetailsEditResult = $this->editUserDetails();
            $_POST = array();
        }

        if (!isset($_SESSION['csrf-token'])) {
            $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        }

        $this->view = new UserDetailsView(
            email: $_POST['email'] ?? $_SESSION['email'] ?? "",
            name: $_POST['name'] ?? $_SESSION['name'] ?? "",
            surname: $_POST['surname'] ?? $_SESSION['surname'] ?? "",
            password: $_POST['password'] ?? $_SESSION['password'] ?? "",
            address: $_POST['address'] ?? $_SESSION['address'] ?? "",
            country: $_POST['country'] ?? $_SESSION['country'] ?? "",
            city: $_POST['city'] ?? $_SESSION['city'] ?? "",
            postCode: $_POST['post-code'] ?? $_SESSION['post-code'] ?? "",
            phoneNumber: $_POST['phone-number'] ?? $_SESSION['phone-number'] ?? "",
            userDetailsEditResult: $userDetailsEditResult,
            csrfToken: $_SESSION['csrf-token'],
            isCsrfSuccess: $isCsrfSuccess
        );
    }

    /**
     * Render the user details page.
     *
     * @return void
     */
    public function index(): void
    {
        $this->view->render();
    }

    /**
     * Validate the user details form data.
     *
     * @return bool True if the form data is valid, otherwise false.
     */
    private function validateForm(): bool
    {
        if (isset($_POST['email'])) {
            return FormValidation::validateUserDetailsForm(
                email: $_POST['email'],
                name: $_POST['name'],
                surname: $_POST['surname'],
                password: $_POST['password'],
                address: $_POST['address'],
                country: $_POST['country'],
                city: $_POST['city'],
                postCode: $_POST['post-code'],
                phoneNumber: $_POST['phone-number'],
            );
        }
        return false;
    }

    /**
     * Edit user details and update the session variables.
     *
     * @return bool True if the user details editing is successful, otherwise false.
     */
    private function editUserDetails(): bool
    {
        $dbHandler = new DatabaseHandler();
        unset($_SESSION['csrf-token']);
        $isSuccess = $dbHandler->changeUserDatabaseData(
            new User(
                id: $_SESSION['user-id'],
                email: $_POST['email'],
                password: $_POST['password'],
                name: $_POST['name'],
                surname: $_POST['surname'],
                address: $_POST['address'],
                country: $_POST['country'],
                city: $_POST['city'],
                postCode: $_POST['post-code'],
                phoneNumber: $_POST['phone-number'],
            )
        );
        if ($isSuccess) {
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['surname'] = $_POST['surname'];
            $_SESSION['address'] = $_POST['address'];
            $_SESSION['country'] = $_POST['country'];
            $_SESSION['city'] = $_POST['city'];
            $_SESSION['post-code'] = $_POST['post-code'];
            $_SESSION['phone-number'] = $_POST['phone-number'];
        }
        return $isSuccess;
    }
}
