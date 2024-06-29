<?php

namespace Controllers;

use Models\Users;

require_once 'models/usersModel.php';
require_once 'controllers/baseController.php';

class Account extends BaseController
{
    //Attributes
    private array $errors = [
        'username' => [
            'required' => 'Username is required',
            'minlength' => 'Username must be at least 3 characters long',
            'maxlength' => 'Username must be less than 20 characters long',
            'invalid' => 'Username must contain only letters, numbers and underscores',
            'exists' => 'Username already exists'
        ],
        'firstname' => [
            'required' => 'Firstname is required',
            'minlength' => 'Firstname must be at least 1 character long',
            'maxlength' => 'Firstname must be less than 30 characters long',
            'invalid' => 'Firstname must contain only letters, numbers and underscores'
        ],
        'lastname' => [
            'required' => 'Lastname is required',
            'minlength' => 'Lastname must be at least 1 character long',
            'maxlength' => 'Lastname must be less than 30 characters long',
            'invalid' => 'Lastname must contain only letters, numbers and underscores'
        ],
        'email' => [
            'required' => 'E-mail is required',
            'minlength' => 'E-mail must be at least 3 characters long',
            'maxlength' => 'E-mail must be less than 50 characters long',
            'invalid' => 'E-mail must be a valid e-mail address',
            'exists' => 'E-mail already exists',
        ],
        'password' => [
            'required' => 'Password is required',
            'minlength' => 'Password must be at least 8 characters long',
            'invalid' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character',
        ],
        'passwordConfirm' => [
            'required' => 'Password confirmation is required',
            'invalid' => 'Password confirmation must be the same as password',
            'different' => 'Password confirmation must be different from password'
        ],
        'locationName' => [
            'required' => 'Location is required',
            'minlength' => 'Location must be at least 3 characters long',
            'maxlength' => 'Location must be less than 50 characters long',
            'invalid' => 'Location must contain only letters, numbers and underscores'
        ],
        'activationKey' => [
            'required' => 'Activation key is required',
            'invalid' => 'Activation key must be valid',
            'sending' => 'An error occured while sending the activation e-mail. Please <a href="/contact">contact us</a>.',
        ],
        'global' => 'An error occured. Please try again later.',
        'login' => 'Invalid e-mail or password'
    ];
    private array $regex = [
        'username' => '/^[a-zA-Z0-9_]{3,20}$/',
        'firstname' => '/^[a-zA-Z0-9_]{1,30}$/',
        'lastname' => '/^[a-zA-Z0-9_]{1,30}$/',
        'password' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+]).{8,}$/',
        'locationName' => '/^[a-zA-Z0-9_]{3,50}$/',
        'activationKey' => '/^[a-f0-9]{32}$/'
    ];

    //Methods
    public function account()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $user = new Users();
        $user->id = $_SESSION['user']['id'];
        $user->get();

        require_once 'views/parts/header.php';
        require_once 'views/account/account.php';
        require_once 'views/parts/footer.php';
    }

    public function activate()
    {
        if (!empty($_GET['key'])) {
            $key = $this->cleanData($_GET['key']);
            if (!preg_match($this->regex['activationKey'], $key)) {
                $errors['activationKey'] = $this->errors['activationKey']['invalid'];
            } else {
                $user = new Users();
                $user->activationKey = $key;
                try {
                    if ($user->activationKeyExists()) {
                        $user->activate();
                        $success = true;
                    } else {
                        $errors['activationKey'] = $this->errors['activationKey']['invalid'];
                    }
                } catch (\Exception $e) {
                    $errors['activationKey'] = 'An error occured while activating your account. Please try again later.';
                }
            }
        } else {
            $errors['activationKey'] = $this->errors['activationKey']['required'];
        }

        require_once 'views/parts/header.php';
        require_once 'views/account/activate.php';
        require_once 'views/parts/footer.php';
    }

    private function generateActivationKey()
    {
        return bin2hex(random_bytes(16));
    }

    public function login()
    {
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        if (isset($_POST['submit'])) {
            $user = new Users();

            foreach ($_POST as $key => $value) {
                $$key = $this->cleanData($value);
            }

            if (!empty($email)) {
                if (!empty($password)) {
                    try {
                        if (!$user->emailExists($email)) {
                            $errors['email'] = $errors['password'] = $this->errors['login'];
                        } else {
                            $passwordHash = $user->getPasswordHash($email);
                            if (!password_verify($password, $passwordHash)) {
                                $errors['email'] = $errors['password'] = $this->errors['login'];
                            } else {
                                $user->email = $email;
                                $_SESSION['user'] = $user->login();
                                header('Location: /');
                                exit;
                            }
                        }
                    } catch (\Exception $e) {
                        $errors['email'] = $error['password'] = $this->errors['global'];
                    }
                } else {
                    $errors['password'] = $this->errors['password']['required'];
                }
            } else {
                $errors['email'] = $this->errors['email']['required'];
            }
        }

        require_once 'views/parts/header.php';
        require_once 'views/account/login.php';
        require_once 'views/parts/footer.php';
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: /');
        exit;
    }

    public function signup()
    {
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        $user = new Users();
        $errors = [];

        if (isset($_POST['submit'])) {
            foreach ($_POST as $key => $value) {
                $$key = $this->cleanData($value);
            }

            if (!empty($username)) {
                try {
                    if (strlen($username) < 3) {
                        $errors['username'] = $this->errors['username']['minlength'];
                    } elseif (strlen($username) > 20) {
                        $errors['username'] = $this->errors['username']['maxlength'];
                    } elseif (!preg_match($this->regex['username'], $username)) {
                        $errors['username'] = $this->errors['username']['invalid'];
                    } elseif ($user->usernameExists($username)) {
                        $errors['username'] = $this->errors['username']['exists'];
                    }
                } catch (\Exception $e) {
                    $errors['username'] = $this->errors['global'];;
                }
            } else {
                $errors['username'] = $this->errors['username']['required'];
            }

            if (!empty($firstname)) {
                if (strlen($firstname) < 1) {
                    $errors['firstname'] = $this->errors['firstname']['minlength'];
                } elseif (strlen($firstname) > 30) {
                    $errors['firstname'] = $this->errors['firstname']['maxlength'];
                } elseif (!preg_match($this->regex['firstname'], $firstname)) {
                    $errors['firstname'] = $this->errors['firstname']['invalid'];
                }
            } else {
                $errors['firstname'] = $this->errors['firstname']['required'];
            }

            if (!empty($lastname)) {
                if (strlen($lastname) < 1) {
                    $errors['lastname'] = $this->errors['lastname']['minlength'];
                } elseif (strlen($lastname) > 30) {
                    $errors['lastname'] = $this->errors['lastname']['maxlength'];
                } elseif (!preg_match($this->regex['lastname'], $lastname)) {
                    $errors['lastname'] = $this->errors['lastname']['invalid'];
                }
            } else {
                $errors['lastname'] = $this->errors['lastname']['required'];
            }

            if (!empty($email)) {
                try {
                    if (strlen($email) < 3) {
                        $errors['email'] = $this->errors['email']['minlength'];
                    } elseif (strlen($email) > 50) {
                        $errors['email'] = $this->errors['email']['maxlength'];
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors['email'] = $this->errors['email']['invalid'];
                    } elseif ($user->emailExists($email)) {
                        $errors['email'] = $this->errors['email']['exists'];
                    }
                } catch (\Exception $e) {
                    $errors['email'] = $this->errors['global'];;
                }
            } else {
                $errors['email'] = $this->errors['email']['required'];
            }

            if (!empty($password)) {
                if (strlen($password) < 8) {
                    $errors['password'] = $this->errors['password']['minlength'];
                } elseif (!preg_match($this->regex['password'], $password)) {
                    $errors['password'] = $this->errors['password']['invalid'];
                }
            } else {
                $errors['password'] = $this->errors['password']['required'];
            }

            if (!empty($passwordConfirm)) {
                if ($passwordConfirm !== $password) {
                    $errors['passwordConfirm'] = $this->errors['passwordConfirm']['invalid'];
                }
            } else {
                $errors['passwordConfirm'] = $this->errors['passwordConfirm']['required'];
            }

            if (!empty($locationName)) {
                if (strlen($locationName) < 3) {
                    $errors['locationName'] = $this->errors['locationName']['minlength'];
                } elseif (strlen($locationName) > 50) {
                    $errors['locationName'] = $this->errors['locationName']['maxlength'];
                } elseif (!preg_match($this->regex['locationName'], $locationName)) {
                    $errors['locationName'] = $this->errors['locationName']['invalid'];
                }
            } else {
                $errors['locationName'] = $this->errors['locationName']['required'];
            }




            if (count($errors) == 0) {
                $user->username = $username;
                $user->firstname = ucwords($firstname);
                $user->lastname = strtoupper($lastname);
                $user->email = strtolower($email);
                $user->password = password_hash($password, PASSWORD_DEFAULT);
                $user->locationName = strtoupper($locationName);
                $user->activationKey = $this->generateActivationKey();

                try {
                    if ($user->create()) {
                        $success = true;
                        // $to      = $user->email;
                        // $subject = 'Account activation';
                        // $message = 'Please click on the following link to activate your account: http://blog-exemple.johanne-badin.fr/activate?key=' . $user->activationKey;
                        // $headers = 'From: no-reply@blog.com';
                        // if (!mail($to, $subject, $message, $headers)) {
                        //     $sucess = false;
                        //     $errors['global'] = $this->errors['activationKey']['sending'];
                        // }
                    }
                } catch (\Exception $e) {
                    $errors['global'] = $this->errors['global'];
                }

            }
        }

        require_once 'views/parts/header.php';
        require_once 'views/account/signup.php';
        require_once 'views/parts/footer.php';
    }
}
