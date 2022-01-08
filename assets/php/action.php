<?php
require_once 'function.php';
require_once 'send_email.php';

// for signup or create user managment
if (isset($_GET['signup'])) {
    $response = signupform($_POST);

    if ($response['status']) {

        if (signup($_POST)) {
            header("location:../../?login");
        } else {
            echo "<script>alert('Sign up not compeleted')</script>";
        };
    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;
        header("location:../../?signup");
    };
};

// for user login in to account manage system 
if (isset($_GET['login'])) {

    $response = loginform($_POST);

    if ($response['status']) {
        $_SESSION['Auth'] = true;
        $_SESSION['user_id'] = $response['user'];
        // send verification code 
        if ($response['user']['ac_status'] == 0) {
            $_SESSION['code'] = $code = rand(111111, 999999);
            $reciver = $response['user']['email'];
            $subject = 'Verify your email account';
            $messege = "Your email verification code is : <b>$code</b>";
            send_email($reciver, $subject, $messege);
        }

        header("location:../../");
    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;
        header("location:../../?login");
    }
}

// for resend email verification code
if (isset($_GET['resend_code'])) {
    $_SESSION['code'] = $code = rand(111111, 999999);
    $reciver = $_SESSION['user_id']['email'];
    $subject = 'Verify your email account';
    $messege = "Your email verification code is : <b>$code</b>";
    send_email($reciver, $subject, $messege);
    header("location:../../?sended");
}

// email verification code chek
if (isset($_GET['verify_email'])) {
    $incode = $_POST['code'];
    $orcode = $_SESSION['code'];
    if ($incode == $orcode) {
        if (emailVerified($_SESSION['user_id']['email'])) {
            header("location:../../");
        } else {
            echo "Server error we will fixed it soon! :)";
        }
    } else {
        $response['messege'] = 'Incorrect verification code!';
        if (!$_POST['code']) {
            $response['messege'] = 'Enter your 6digit code!';
        }
        $_SESSION['error'] = $response;
        header("location:../../");
    }
}

// forgot password get info
if (isset($_GET['forgot_pass'])) {
    if (!isset($_POST['email'])) {
        $response['messege'] = "Enter your email id!";
        $response['status'] = false;
        $_SESSION['error'] = $response;
        header("location:../../?forgot_pass");
        
    } elseif (!alEmailReg($_POST['email'])) {
        $response['messege'] = "User doesn't exist!";
        $response['status'] = false;
        $_SESSION['error'] = $response;
        header("location:../../?forgot_pass");

    } else {
        $_SESSION['fp_email'] = $_POST['email'];
        $_SESSION['fp_code'] = $code = rand(11111, 99999);
        $reciver = $_POST['email'];
        $subject = 'Verify your email account';
        $messege = "Your forgot password request email verification code is : <b>$code</b>";
        send_email($reciver, $subject, $messege);
        header("location:../../?forgot_pass");
    }
}

// forgot password verify code
if(isset($_GET['verifycode'])){
    $user_code = $_POST['code'];
    $code = $_SESSION['fp_code'];
    if($user_code == $code){
        $_SESSION['temp_auth'] = true;
        header("location:../../?forgot_pass");
    }else{
        $response = 'Incorrect verification code!';
        if(!$_POST['code']){
            $response = "Enter the 5digit reset code!";
            header("location:../../?forgot_pass");
        }
        header("location:../../?forgot_pass");
    }
}

// Finally reset, change as new password
if(isset($_GET['cngpass'])){
    if(!$_POST['new_pass']){
        $response['messege'] = "enter your new password!";
        $_SESSION['error'] = $response;
        header("location:../../?forgot_pass");
    }else{
        resetpass($_SESSION['fp_email'], $_POST['new_pass']);
        header("location:../../");
        send_email($_SESSION['fp_email'],"Password reseted","Your password was changed");
    }
}





// log out from social media 
if (isset($_GET['logout'])) {
    session_destroy();
    header("location:../../");
}