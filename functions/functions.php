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
        http://localhost/InternManagerIITP/activate.php?email=$email&code=$validation_code&type=$type
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
            $sql = "SELECT id,type,active FROM users WHERE email = '$email' AND validation_code = '$validation_code'";
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
                    $id = $row['id'];
                    if ($row['type'] == 1) {
                        $sql3 = "INSERT INTO professors (`id`,`phase`) VALUES ($id,'1')";
                        $result3 = query($sql3);
                        confirm($result3);
                    }
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
function add_student($email)
{
    $query = "SELECT * FROM users WHERE email ='$email'";
    $result = query($query);
    confirm($result);
    $row = fetch_array($result);
    $id = $row['id'];
    $email = $row['email'];
    $first_name  = $row['first_name'];
    $last_name = $row['last_name'];
    $gender = $row['gender'];
    $password = $row['password'];
    $query = "INSERT INTO students (`id`,`email`,`first_name`,`last_name`,`password`,`Gender`) VALUES ('$id','$email','$first_name','$last_name','$password','$gender');";
    $result = query($query);
    confirm($result);
}
function checkProjectStatus($email)
{
    $query = "SELECT projectSelected FROM students WHERE email = '$email'";
    $result = query($query);
    confirm($result);
    $row = fetch_array($result);
    if ($row['projectSelected'] == 0)
        return false;
    return true;
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
function getProjectCount($email)
{
    $query = "SELECT projectSelected FROM `students` WHERE email = '$email'";
    $res = query($query);
    confirm($res);
    $row = fetch_array($res);
    return $row['projectSelected'];
}
function getProjectName($id)
{
    $query = "SELECT title FROM projects WHERE id = '$id'";
    $res = query($query);
    confirm($res);
    $row = fetch_array($res);
    return $row['title'];
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
                $_SESSION['id'] = $row['id'];
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
// For adding the college of the student
function setCollegeName($email, $name)
{
    $query = "UPDATE students SET college = '$name' WHERE email = '$email';";
    $result = query($query);
    confirm($result);
}
function setDescription($email, $description)
{
    $query = "UPDATE students SET description = '$description' WHERE email = '$email';";
    $result = query($query);
    confirm($result);
}
function getAllProfProjects($email)
{
    $query = "SELECT * FROM `students` WHERE email = '$email'";
    $res = query($query);
    confirm($res);
    $row = fetch_array($res);
    $project1_id = $row['project1_id'];
    $project2_id = $row['project2_id'];
    $project3_id = $row['project3_id'];
    $project4_id = $row['project4_id'];
    $query  = "SELECT * FROM `projects`  WHERE id != '$project1_id' AND  id != '$project2_id' AND id != '$project3_id' AND id != '$project4_id'";
    $res = query($query);
    confirm($res);
    $data = array();
    while ($row = mysqli_fetch_array($res)) {
        $data[] = $row;
    }
    mysqli_free_result($res);
    return $data;
}
function getParticularProfProjects($id, $phase)
{
    $query  = "SELECT project_id FROM prefrence_$phase WHERE prof_id = '$id'";
    $res = query($query);
    confirm($res);
    $data = array();
    while ($row = mysqli_fetch_array($res)) {
        $data[] = $row;
    }
    mysqli_free_result($res);
    return $data;
}
function getRegisteredStudents($id)
{
    $query = "SELECT * FROM `students` WHERE project1_id = '$id' OR project2_id = '$id' OR project3_id = '$id' OR project4_id = '$id'";
    $res = query($query);
    confirm($res);
    $data = array();
    while ($row = mysqli_fetch_array($res)) {
        $data[] = $row;
    }
    mysqli_free_result($res);
    return $data;
}

function getDepartments()
{
    $query = "SELECT * FROM departments";
    $res = query($query);
    confirm($res);
    while ($row = mysqli_fetch_array($res)) {
        $data[] = $row;
    }
    mysqli_free_result($res);
    return $data;
}

function insertInPrefrences($count, $student_id, $project_id)
{
    $query = "SELECT prof_id FROM projects WHERE id = '$project_id'";
    $res = query($query);
    confirm($res);
    $row = fetch_array($res);
    $prof_id = $row['prof_id'];
    // print_r($student_id);
    // print_r($project_id);
    $query = "INSERT INTO `prefrence_$count` (`project_id`,`student_id`,`prof_id`) VALUES ('$project_id','$student_id','$prof_id')";
    $res = query($query);
    confirm($res);
    return;
}

function getProfPhase($id)
{
    var_dump($id);
    $query =  "SELECT phase FROM professors WHERE id = '$id'";
    $res = query($query);
    confirm($res);
    $row = fetch_array($res);
    return $row['phase'];
}
function getProjectTitle($id)
{
    $query  = "SELECT title FROM projects WHERE id = '$id'";
    $res = query($query);
    confirm($res);
    $row = fetch_array($res);
    return $row['title'];
}

function getStudentsInPhase($id, $phase, $proj_id)
{
    $query = "SELECT id,first_name, last_name FROM students AS s , prefrence_$phase AS p WHERE p.prof_id = '$id' AND p.project_id='$proj_id' AND p.student_id = s.id";
    $res = query($query);
    confirm($res);
    $data = array();
    while ($row = mysqli_fetch_array($res)) {
        $data[] = $row;
    }
    mysqli_free_result($res);
    return $data;
}

function updatePhase($id)
{
    $format = "d/m/Y H:i:s";
    $date1 = date($format, strtotime("2020-03-14 12:55:00", time()));
    $date2 = date($format, strtotime("2020-03-15 17:55:00", time()));
    $date3 = date($format, strtotime("2020-03-16 06:08:00", time()));
    $date4 = date($format, strtotime("2020-03-17 06:10:50", time()));
    $curDate = date($format, strtotime("now"));
    $query = "UPDATE professors SET phase=1 WHERE id = '$id'";
    // var_dump($curDate, $date1);
    // var_dump($curDate > $date1 && $curDate < $date2);
    if ($curDate > $date1 && $curDate < $date2) {
        $query = "UPDATE professors SET phase = 2 WHERE id ='$id'";
    } else if ($curDate > $date2 && $curDate < $date3) {
        $query = "UPDATE professors SET phase = 3 WHERE id ='$id'";
    } else if ($curDate > $date3 && $curDate < $date4) {
        $query = "UPDATE professors SET phase = 4 WHERE id ='$id'";
    } else if ($curDate > $date1) {
        $query = "UPDATE professors SET phase = 0 WHERE id ='$id'";
    }
    $res = query($query);
    confirm($res);
}

// function getResume($email)
// {
//     $query = "SELECT resumeName FROM students WHERE id = '$student_id'";
//     $res = query($query);
//     $obj = mysqli_fetch_array($res);
//     $resume_name = $obj["resumeName"];
//     echo $resume_name;
//     return $resume_name;
// }
