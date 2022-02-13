<?php
require_once 'function.php';
require_once 'send_email.php';

// for signup or create user managment
if (isset($_GET['signup'])) {
    $response = signupform($_POST);

    if ($response['status']) {

        if (signup($_POST)) {
            header("location:../../?login&signupsuccess");
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
if (isset($_GET['verifycode'])) {
    $user_code = $_POST['code'];
    $code = $_SESSION['fp_code'];
    if ($user_code == $code) {
        $_SESSION['temp_auth'] = true;
        header("location:../../?forgot_pass");
    } else {
        $response = 'Incorrect verification code!';
        if (!$_POST['code']) {
            $response = "Enter the 5digit reset code!";
            header("location:../../?forgot_pass");
        }
        header("location:../../?forgot_pass");
    }
}

// Finally reset, change as new password
if (isset($_GET['cngpass'])) {
    if (!$_POST['new_pass']) {
        $response['messege'] = "enter your new password!";
        $_SESSION['error'] = $response;
        header("location:../../?forgot_pass");
    } else {
        resetpass($_SESSION['fp_email'], $_POST['new_pass']);
        header("location:../../");
        send_email($_SESSION['fp_email'], "Password reseted", "Your password was changed");
    }
}

// edit profile
if (isset($_GET['updateprofile'])) {
    $response = valupdateform($_POST, $_FILES['profile_pic']);
    if ($response['status']) {
        if (updateprofile($_POST, $_FILES['profile_pic'])) {
            header("location:../../?editprofile&success");
        } else {
            header("location:../../?editprofile&error");
        }
    } else {
        $_SESSION['error'] = $response;
        header("location:../../?editprofile");
    }
}

// Add post 
if (isset($_GET['addpost'])) {
    $response = valpost($_FILES['post_img']);

    if ($response['status']) {
        if (createPost($_POST, $_FILES['post_img'])) {
            header("location:../../");
        } else {
            echo "<script>alert('Server error')</script>";
        }
    } else {
        $_SESSION['error'] = $response;
        header("location:../../");
    }
}

// for deleting post 
if (isset($_GET['pdl'])) {
    if ($_SESSION['user_id']['id'] == $_GET['pu']) {
        if (deluserpost($_GET['pdl'], $_GET['pu']) && delcom($_GET['pdl'])) {
            header("location:../../");
        }else{
            ?>
            <script>alert("You can't delete this post!")</script>
            <?php
            header("location:../../");
        }
    }
}

// add comment
if(isset($_GET['comment'])){
    if(addcomment($_GET['po_id'], $_POST['com_text'])){
        header("location:../../?user=".$_GET['u']."&#post".$_GET['po_id']);
    }
}

// send messeges
if(isset($_GET['sendmsg'])){
    if(sendmsg($_GET['reuser'],$_POST['msg_text'])){
        header("location:../../?chats&cum=".$_GET['reuser']);
    }else{
        echo "<script>alert('something went wrong')</script>";
        header("location:../../");
    }
}

// bloking a user
if(isset($_GET['block'])){
    if(blockuser($_GET['bid'])){
        unfollow($_GET['bid']);
        echo "<script>console.log(true)</script>";
        header("location:../../?user=".$_GET['bu']);
    }else{
        echo "<script>alert('something went wrong')</script>";
        header("location:../../?failed&user=".$_GET['bu']);
    }
}

// for updating users post 
if(isset($_GET['updatepost'])){
    if(updatepost($_GET['pid'],$_POST['uptext'])){
        header("location:../../?user=".$_GET['u']);
    }else{
        header("location:../../?user=".$_GET['u']);
        echo "<script>alert('somthing went wrong...')</script>";
    }
}


// admin login to Dashboard authontication
if(isset($_GET['adlogin'])){
    $user = $_SESSION['user_id'];
    $up_em_us = $_POST['aduserkey'];
    $up_pass = $_POST['ad_pass'];
    $up_pass = md5($up_pass);
    $admin = getadmin($user['id']);
    $user_pass = $user['password'];
    if (($up_em_us == $user['username'] || $up_em_us == $user['email']) && $up_pass == $user_pass) {
        $_SESSION['ad_auth'] = true;
        header("location:../../admin/");
    } else {
        header("location:../../admin/?autherror");
    }

}

// set badge status by admin 
if(isset($_GET['bluever'])){
    setbadgebyadmin($_GET['u'],1);
    header("location:../../admin");
}

if(isset($_GET['blueunver'])){
    setbadgebyadmin($_GET['u'],0);
    header("location:../../admin");
}

// ban unban user by admin 
if(isset($_GET['banuser'])){
    banbyadmin($_GET['u'],2);
    header("location:../../admin");
}

if(isset($_GET['unbanuser'])){
    banbyadmin($_GET['u'],1);
    header("location:../../admin");
}

// see activity of a user
if(isset($_GET['seeactivity'])){
    $user = getuser($_GET['u']);
    $_SESSION['Auth'] = true;
    $_SESSION['user_id'] = $user;
    header("location:../../");
}
