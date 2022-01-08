<?php
// This is use for show pages by data
require_once 'config.php';
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Database is not connected");


// chek email verification 
function emailVerified($email){
    global $db;
    $query = "UPDATE users SET ac_status = 1 WHERE email='$email'";
    return mysqli_query($db,$query);
}

// cheking user is user exist?
function chekuser($login_data)
{
    global $db;
    $loguser = $login_data['loguser'];
    $password = md5($login_data['password']);
    $query = "SELECT * FROM users WHERE (email = '$loguser' || username = '$loguser') && password = '$password'";
    $run = mysqli_query($db, $query);
    $data['user'] = mysqli_fetch_assoc($run) ?? array();
    if (count($data['user']) > 0) {
        $data['status'] = true;
    } else {
        $data['status'] = false;
    }

    return $data;
};

// for login form validate
function loginform($form_data)
{
    $response = array();
    $response['status'] = true;
    $blank = false;

    if (!$form_data['password']) {
        $response['messege'] = "The password field is blank!";
        $response['status'] = false;
        $blank = true;
    }

    if (!$form_data['loguser']) {
        $response['messege'] = "Enter your email/password!";
        $response['status'] = false;
        $blank = true;
    }

    if (!$blank && !chekuser($form_data)['status']) {
        $response['messege'] = "User doesn't exist!";
        $response['status'] = false;
    } else {
        $response['user'] = chekuser($form_data)['user'];
    }

    return $response;
};

// for cheking already registered email
function alEmailReg($email)
{
    global $db;
    $query = "SELECT count(*) as row FROM users WHERE email = '$email'";
    $run = mysqli_query($db, $query);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['row'];
};

// for cheking already registered email
function aluserReg($username)
{
    global $db;
    $query = "SELECT count(*) as row FROM users WHERE username = '$username'";
    $run = mysqli_query($db, $query);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['row'];
};


// for validating sign up form 
function signupform($form_data)
{
    $response = array();
    $response['status'] = true;

    if (!$form_data['password']) {
        $response['messege'] = "Choose a password!";
        $response['status'] = false;
    }

    if (!$form_data['username']) {
        $response['messege'] = "Choose a user name!";
        $response['status'] = false;
    }

    if (!$form_data['phone']) {
        $response['messege'] = "Phone number is reqired!";
        $response['status'] = false;
    }

    if (!$form_data['email']) {
        $response['messege'] = "email is reqired!";
        $response['status'] = false;
    }

    if (!$form_data['last_name']) {
        $response['messege'] = "last name is reqired!";
        $response['status'] = false;
    }

    if (!$form_data['first_name']) {
        $response['messege'] = "first name is reqired!";
        $response['status'] = false;
    }

    if (alEmailReg($form_data['email'])) {
        $response['messege'] = "this email id is already registered!";
        $response['status'] = false;
    }

    if (aluserReg($form_data['username'])) {
        $response['messege'] = "this username is already taken!";
        $response['status'] = false;
    }

    return $response;
};

// create a new user account 
function signup($data)
{
    global $db;
    $first_name = mysqli_real_escape_string($db, $data['first_name']);
    $last_name = mysqli_real_escape_string($db, $data['last_name']);
    $email = mysqli_real_escape_string($db, $data['email']);
    $phone = $data['phone'];
    $username = mysqli_real_escape_string($db, $data['username']);
    $password = mysqli_real_escape_string($db, $data['password']);
    $password = md5($password);

    $query = "INSERT INTO users(first_name,last_name,email,phone,username,password)";
    $query .= "VALUES ('$first_name','$last_name','$email',$phone,'$username','$password')";
    return mysqli_query($db, $query);
};

// show errors in sign up page
function showError()
{
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        if (isset($error['messege'])) {
?>
            <h5 class="error"><?= $error['messege'] ?></h5>
<?php
        }
    };
};

// save prev form data
function showformdata($field)
{
    if (isset($_SESSION['formdata'])) {
        $formdata = $_SESSION['formdata'];
        return $formdata[$field];
    }
};

// for get user details/ data
function getuser($user_id)
{
    global $db;

    $query = "SELECT * FROM users WHERE id = $user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run);
};

// forget password reset data
function resetpass($email,$password){
    global $db;
    $password = md5($password);
    $query = "UPDATE users SET password='$password' WHERE email='$email'";
    return mysqli_query($db,$query);
}

// for get page by pass flag 
function getPage($page, $data = "")
{
    include("assets/pages/$page.php");
}
