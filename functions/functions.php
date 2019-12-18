<?php

include('phpmail.php');

/***************************** helper functions *********************************/

function clean($string)
{
    return htmlentities($string);
}

function redirect($location)
{
    return header("Location: {$location}");
}

function set_message($message)
{
    if (!empty($message)) {
        $_SESSION['message'] = $message;
    } else {
        $message = "";
    }
}

function display_message()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function token_generator()
{
    $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
    return $token;
}

function validation_errors($error)
{
    return "
            <div class='alert alert-danger alert-dismissible fade show'>
                {$error}
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
        ";
}

function email_exists($email)
{
    $sql = "SELECT id FROM users where email = '$email'";
    $result = query($sql);
    if (row_count($result) == 1) {
        return true;
    } else {
        return false;
    }
}

function send_email($email, $subject, $msg, $headers)
{
    return send_php_mail($email, $subject, $msg, $headers);
}


/***************************** register validation functions *********************************/
function validate_user_registration()
{

    $errors = [];

    $min = 3;
    $max = 30;

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $first_name = clean($_POST['first_name']);
        $last_name = clean($_POST['last_name']);
        $type = clean($_POST['type']);
        $gender = clean($_POST['gender']);
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $confirm_password = clean($_POST['confirm_password']);

        if (strlen($first_name) < $min) {
            $errors[] = "Your first name cannot be less than {$min} characters";
        }
        if (strlen($first_name) > $max) {
            $errors[] = "Your first name cannot be greater than {$max} characters";
        }

        if (strlen($last_name) < $min) {
            $errors[] = "Your last name cannot be less than {$min} characters";
        }
        if (strlen($last_name) > $max) {
            $errors[] = "Your last name cannot be greater than {$max} characters";
        }

        if (email_exists($email)) {
            $errors[] = "Sorry that email is already registered";
        }
        if ($type == 1) {
            if (strpos($email, "iitp.ac.in") === false) {
                $errors[] = "Professors have to enter their official IITP email address.";
            }
        }

        if ($password != $confirm_password) {
            $errors[] = "Your pasword fields do not match";
        }


        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo validation_errors($error);
            }
        } else {
            if (register_user($first_name, $last_name, $type, $gender, $email, $password)) {
                set_message("<p class='alert alert-success text-center'>Please check your email or spam folder for an activation link</p>");
                redirect("index.php");
            } else {
                set_message("<p class='bg-danger text-center'>Sorry, we cannot register the user!</p>");
                redirect("index.php");
            }
        }
    }
}


/***************************** register user function *********************************/
function register_user($first_name, $last_name, $type, $gender, $email, $password)
{
    $first_name = escape($first_name);
    $last_name = escape($last_name);
    $type = escape($type);
    $gender = escape($gender);
    $email = escape($email);
    $password = escape($password);
    $password = md5($password);
    $validation_code = md5($email . microtime());

    $subject = "Activate Account";
    $msg = "Please click the link below to activate your account
        http://localhost/InternManagerIITP/activate.php?email=$email&code=$validation_code
        ";
    $headers = "From: norreply@yourwebsite.com";
    if (send_email($email, $subject, $msg, $headers)) {
        $sql = "INSERT INTO users(first_name, last_name, type, gender, email, password, validation_code, active)";
        $sql .= "VALUES('$first_name', '$last_name', '$type', '$gender', '$email', '$password', '$validation_code', '0')";

        $result = query($sql);
        confirm($result);
        return true;
    } else {
        return false;
    }
}

/***************************** activate user function *********************************/
function activate_user()
{
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['email'])) {
            $email = escape($_GET['email']);
            $validation_code = escape($_GET['code']);
            $sql = "SELECT id, active FROM users WHERE email = '$email' AND validation_code = '$validation_code'";
            $result = query($sql);
            confirm($result);
            if (row_count($result) == 1) {
                $row = fetch_array($result);
                if ($row['active'] == 1) {
                    set_message("<p class='bg-warning'>Your account has already been activated.<p>");
                    redirect("login.php");
                } else {
                    $sql2 = "UPDATE users SET active = 1 WHERE email = '$email' AND validation_code = '$validation_code'";
                    $result2 = query($sql2);
                    confirm($result2);
                    set_message("<p class='alert alert-success'>Your account has been activated.<p>");
                    redirect("login.php");
                }
            } else {
                set_message("<p class='bg-danger'>Your account could not be activated.<p>");
                redirect("index.php");
            }
        }
    }
}

/***************************** login validation functions *********************************/
function validate_user_login()
{
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $remember = isset($_POST['remember']);

        if (strlen($email) < 5) {
            $errors[] = "Your email cannot be less than 5 characters";
        }


        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo validation_errors($error);
            }
        } else {
            if (login_user($email, $password, $remember)) {
                if ($_SESSION['type'] == 1) {
                    redirect("prof_profile.php");
                } else {
                    redirect("stud_profile.php");
                }
            }
        }
    }
}

/***************************** login user function *********************************/
function login_user($email, $password, $remember)
{
    $email = escape($email);
    $password = escape($password);

    $sql = "SELECT password, active, type, id FROM users WHERE email = '$email'";
    $result = query($sql);
    confirm($result);

    if (row_count($result) == 1) {
        $row = fetch_array($result);
        $db_password = $row['password'];
        if (md5($password) == $db_password) {
            if ($row['active'] == 1) {
                if ($remember == "on") {
                    setcookie('email', $email, time() + 86400);
                }
                $_SESSION['email'] = $email;
                $_SESSION['type'] = $row['type'];
                return true;
            } else {
                $link = "functions/resend_activation_link.php?email=$email";
                echo validation_errors("Your account has not been activated! Please check you mail to activate your account.<br ><a href='$link'>Click here to resend activation link</a>");
                return false;
            }
        } else {
            echo validation_errors("Your credentials are not correct!");
            return false;
        }
    } else {
        echo validation_errors("Your credentials are not correct!");
        return false;
    }
}

/***************************** login user function *********************************/
function logged_in()
{
    if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
        return true;
    } else {
        return false;
    }
}

/***************************** recover password function *********************************/
function recover_password()
{
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
            $email = clean($_POST['email']);
            if (email_exists($email)) {
                $email = escape($email);
                $validation_code = md5(uniqid($email, true));

                $subject = "Please reset your password";
                $msg = "Here is your password reset code <b>$validation_code</b>
                    Click here to reset your password http://localhost/intern-manager/code.php?email=$email&code=$validation_code
                    ";
                $headers = "From: noreply@yourwebsite.com";
                if (send_email($email, $subject, $msg, $headers)) {
                    setcookie('temp_access_code', $validation_code, time() + 900);
                    $sql = "UPDATE users SET validation_code = '$validation_code' WHERE email = '$email'";
                    $result = query($sql);
                    confirm($result);

                    set_message("<p class='alert alert-success'>Please check your email or spam folder for a password reset code<p>");
                    redirect("index.php");
                } else {
                    echo validation_errors("Mail could not be sent to your registered email");
                }
            } else {
                echo validation_errors("This email does not exist");
            }
        } else {
            redirect("index.php");
        }
    }
}

/***************************** forgot password code validation function *********************************/
function validate_code()
{
    if (isset($_COOKIE['temp_access_code'])) {
        if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['email']) && isset($_GET['code'])) {
        } else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['code'])) {
            $validation_code = clean($_POST['code']);
            $validation_code = escape($validation_code);
            $email = $_GET['email'];
            $email = clean($email);
            $email = escape($email);
            $sql = "SELECT id FROM users WHERE validation_code = '$validation_code' AND email = '$email'";
            $result = query($sql);
            confirm($result);
            if (row_count($result) == 1) {
                setcookie('temp_access_code', $validation_code, time() + 900);
                redirect("reset.php?email=$email&code=$validation_code");
            } else {
                echo validation_errors("Sorry wrong validation code");
            }
        } else {
            redirect("index.php");
        }
    } else {
        set_message("<p class='alert alert-danger'>Sorry your validation cookie has expired<p>");
        redirect("recover.php");
    }
}

/***************************** password reset function *********************************/
function password_reset()
{
    if (isset($_COOKIE['temp_access_code'])) {
        if (isset($_GET['email']) && isset($_GET['code'])) {

            if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $password = clean($password);
                $confirm_password = clean($confirm_password);
                if ($password == $confirm_password) {
                    $email = $_GET['email'];
                    $email = clean($email);
                    $email = escape($email);
                    $password = md5($password);
                    $password = escape($password);
                    $sql = "UPDATE users SET password = '$password' WHERE email = '$email'";
                    $result = query($sql);
                    confirm($result);
                    set_message("<p class='alert alert-success'>Your password has been updated<p>");
                    redirect("login.php");
                } else {
                    echo validation_errors("Passwords do not match!");
                }
            }
        } else {
            redirect("index.php");
        }
    } else {
        set_message("<p class='alert alert-danger'>Sorry your validation cookie has expired<p>");
        redirect("recover.php");
    }
}
/**********************************add project*************************/
function add_project($email, $title, $description)
{
    $sql = "INSERT INTO projects(prof_email,title,description)";
    $sql .= "VALUES('$email', '$title', '$description')";
    $result = query($sql);
    confirm($result);
    return;
}
