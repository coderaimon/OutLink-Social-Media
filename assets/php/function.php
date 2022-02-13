<?php
// This is use for show pages by data
require_once 'config.php';
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Database is not connected");


// chek email verification 
function emailVerified($email)
{
    global $db;
    $query = "UPDATE users SET ac_status = 1 WHERE email='$email'";
    return mysqli_query($db, $query);
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
    $phone = mysqli_real_escape_string($db, $data['phone']);
    $username = mysqli_real_escape_string($db, $data['username']);
    $password = mysqli_real_escape_string($db, $data['password']);
    $password = md5($password);

    $query = "INSERT INTO users(first_name,last_name,email,phone,username,password)";
    $query .= "VALUES ('$first_name','$last_name','$email','$phone','$username','$password')";
    return mysqli_query($db, $query);
};

// show errors in sign up page
function showError()
{
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        if (isset($error['messege'])) {
?>
            <p class="error"><?= $error['messege'] ?></p>
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
}

// forget password reset data
function resetpass($email, $password)
{
    global $db;
    $password = md5($password);
    $query = "UPDATE users SET password='$password' WHERE email='$email'";
    return mysqli_query($db, $query);
}

// validate post image reqirements
function valpost($image_data)
{
    $response = array();
    $response['status'] = true;

    if (!$image_data['name']) {
        $response['messege'] = 'Select a image!';
        $response['status'] = false;
    }

    if ($image_data['name']) {
        $img = $image_data['name'];
        $type = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        $size = $image_data['size'] / 2000;

        if ($type != 'jpg' && $type != 'jpeg' && $type != 'png') {
            $response['messege'] = 'File formate sould be PNG,JPG or JPEG';
            $response['status'] = false;
        }
        if ($size > 1000) {
            $response['messege'] = 'Upload image less than 1mb';
            $response['status'] = false;
        }
    }

    return $response;
};

// validate update profile submission
function valupdateform($form_data, $image_data)
{
    $response = array();
    $response['status'] = true;

    if (!$form_data['last_name']) {
        $response['messege'] = "last name field is blank!";
        $response['status'] = false;
    }

    if (!$form_data['first_name']) {
        $response['messege'] = "first name field is blank!";
        $response['status'] = false;
    }

    if ($image_data['name']) {
        $img = $image_data['name'];
        $type = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        $size = $image_data['size'] / 1000;

        if ($type != 'jpg' && $type != 'jpeg' && $type != 'png') {
            $response['messege'] = 'File formate sould be PNG,JPG or JPEG';
            $response['status'] = false;
        }
        if ($size > 1000) {
            $response['messege'] = 'Upload image less than 1mb';
            $response['status'] = false;
        }
    }

    return $response;
};

// update profile
function updateprofile($data, $image_data)
{
    global $db;
    $first_name = mysqli_real_escape_string($db, $data['first_name']);
    $last_name = mysqli_real_escape_string($db, $data['last_name']);
    $gender = $data['gender'];
    $password = mysqli_real_escape_string($db, $data['new_pass']);

    if (!$data['gender']) {
        $gender = $_SESSION['user_id']['gender'];
    } else {
        $_SESSION['user_id']['gender'] = $gender;
    }

    if (!$data['new_pass']) {
        $password = $_SESSION['user_id']['password'];
    } else {
        $password = md5($password);
        $_SESSION['user_id']['password'] = $password;
    }

    $profile_pic = '';
    if ($image_data['name']) {
        $img_name = time() . basename($image_data['name']);
        $img_dir = "../img/pp/$img_name";
        move_uploaded_file($image_data['tmp_name'], $img_dir);
        $profile_pic = ", profile_pic='$img_name'";
    }


    $query = "UPDATE users SET first_name='$first_name', last_name='$last_name', gender=$gender,password='$password' $profile_pic WHERE id=" . $_SESSION['user_id']['id'];
    return mysqli_query($db, $query);
}

function getUserpass($data)
{
    global $db;
    $response = array();
    $response['status'] = true;
    $user_id = $_SESSION['user_id']['id'];
    $query = "SELECT * FROM users WHERE id = '$user_id'";
    $run = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($run);
    $pass = md5($user['password']);
    if ($data['id'] == $pass) {
        $response['status'] = true;
    } else {
        $response['messege'] = "Password is wrong";
        $response['status'] = false;
    }
    return $response;
}

// addpost to profile
function createPost($caption, $image_data)
{
    global $db;
    $user_id = $_SESSION['user_id']['id'];
    $post_caption = mysqli_real_escape_string($db, $caption['post_caption']);
    $img_name = time() . basename($image_data['name']);
    $img_dir = "../img/post_pic/$img_name";
    move_uploaded_file($image_data['tmp_name'], $img_dir);
    $query = "INSERT INTO posts (user_id,post_text,post_img) VALUES ($user_id,'$post_caption','$img_name')";
    return mysqli_query($db, $query);
}

// get post data 
function getpost()
{
    global $db;
    $query = "SELECT posts.id,posts.user_id,posts.post_img,posts.post_text,posts.created_at,users.first_name,users.last_name,users.username,users.profile_pic,users.badge FROM posts JOIN users ON users.id=posts.user_id ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
};

// get user post 
function updatepost($post_id, $text)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "UPDATE posts set post_text='$text' WHERE id=$post_id && user_id=$current_user";
    return mysqli_query($db, $query);
}

// for get user details/ username or id
function getuserprofile($username)
{
    global $db;
    $query = "SELECT * FROM users WHERE username = '$username'";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run);
};

// notification insertion
function addnot($user_id, $not_msg)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "INSERT INTO notify(user_id,sub_id,nt_text) VALUES($user_id,$current_user,'$not_msg')";
    return mysqli_query($db, $query);
}

// User post by id 
function userPosts($user_id)
{
    global $db;
    $query = "SELECT * FROM posts WHERE user_id=$user_id ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

// delete post from curren user profile
function deluserpost($post_id, $user_id)
{
    global $db;
    $query = "DELETE FROM posts WHERE id=$post_id && user_id=$user_id";
    return mysqli_query($db, $query);
}

// follow suggestion data 
function followsug()
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "SELECT * FROM users WHERE id!=$current_user";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

// filter followers
function frfilfol()
{
    $list = followsug();
    $fil_list = array();
    foreach ($list as $user) {
        if (!blockeduserstatus($user['id']) && $user['ac_status'] != 2 && !folstatus($user['id'])) {
            $fil_list[] = $user;
        }
    }
    return $fil_list;
}

// filter followers
function filfollowers()
{
    $list = followsug();
    $fil_list = array();
    foreach ($list as $user) {
        if (!blockeduserstatus($user['id']) && $user['ac_status'] != 2 && !folstatus($user['id']) && count($fil_list) < 5) {
            $fil_list[] = $user;
        }
    }
    return $fil_list;
}

// get follow status by user id 
function folstatus($user_id)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "SELECT count(*) as row FROM follow WHERE follower_id=$current_user && user_id=$user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

// follow user 
function follow($user_id)
{
    global $db;
    $follower = $_SESSION['user_id']['id'];
    $query = "INSERT INTO follow(follower_id,user_id) VALUES($follower,$user_id)";
    return mysqli_query($db, $query);
}

// follow user 
function unfollow($user_id)
{
    global $db;
    $follower = $_SESSION['user_id']['id'];
    $query = "DELETE FROM follow WHERE follower_id=$follower && user_id=$user_id";
    return mysqli_query($db, $query);
}

// filter followers posts 
function followerpost()
{
    $list = getpost();
    $fil_list = array();
    foreach ($list as $post) {
        if (folstatus($post['user_id']) || $post['user_id'] == $_SESSION['user_id']['id']) {
            $fil_list[] = $post;
        }
    }
    return $fil_list;
}

// follower data 
function follower($user_id)
{
    global $db;
    $query = "SELECT count(*) as row FROM follow WHERE user_id = $user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

// following data 
function following($user_id)
{
    global $db;
    $query = "SELECT count(*) as row FROM follow WHERE follower_id = $user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

// get user followers data 
function getfollowers($user_id)
{
    global $db;
    $query = "SELECT * FROM follow WHERE user_id=$user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

// get following users 
function getfollowing($user_id)
{
    global $db;
    $query = "SELECT * FROM follow WHERE follower_id=$user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

// get likes 
function getlikes($post_id)
{
    global $db;
    $query = "SELECT count(*) as row FROM react WHERE post_id=$post_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}
// like user post 
function like($post_id)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "INSERT INTO react(user_id,post_id) VALUES($current_user,$post_id)";
    return mysqli_query($db, $query);
}

// unlike post 
function unlike($post_id)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "DELETE FROM react WHERE user_id=$current_user && post_id=$post_id";
    return mysqli_query($db, $query);
}

// get react status by user id 
function likestatus($post_id)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "SELECT count(*) as row FROM react WHERE user_id=$current_user && post_id=$post_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

// get notification messeges 
function getnotif($user_id)
{
    global $db;
    $query = "SELECT * FROM notify WHERE user_id=$user_id ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

// get notifications as row 
function getnotifcount($user_id)
{
    global $db;
    $query = "SELECT count(*) as row FROM notify WHERE user_id=$user_id && status!=1";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

// delete notification
function delnotif($user_id)
{
    global $db;
    $query = "DELETE FROM notify WHERE user_id=$user_id";
    return mysqli_query($db, $query);
}

// visited link 
function vitnot($not_id)
{
    global $db;
    $query = "UPDATE notify set status=1 WHERE id=$not_id";
    return mysqli_query($db, $query);
}

// search friends by keyword
function searchfr($keyword)
{
    global $db;
    // $current_user = $_SESSION['user_id']['id'];
    $query = "SELECT * FROM users WHERE first_name LIKE '%$keyword%' || last_name LIKE '%$keyword%'";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

// add comment
function addcomment($post_id, $text)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "INSERT INTO comment(user_id,post_id,comment) VALUES($current_user,$post_id,'$text')";
    return mysqli_query($db, $query);
}

// delete comment 
function delcom($post_id)
{
    global $db;
    $query = "DELETE FROM comment WHERE post_id=$post_id";
    return mysqli_query($db, $query);
}

// get comments
function getcomments($post_id)
{
    global $db;
    $query = "SELECT * FROM comment WHERE post_id=$post_id ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

// realtime chatting user to user 
// all uniqe ids of chats 
function activeUserid()
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "SELECT sender,reciver FROM chat WHERE sender=$current_user || reciver=$current_user ORDER by id DESC";
    $run = mysqli_query($db, $query);
    $data = mysqli_fetch_all($run, true);
    $allid = array();
    foreach ($data as $chat) {
        if ($chat['sender'] != $current_user && !in_array($chat['sender'], $allid)) {
            $allid[] = $chat['sender'];
        }

        if ($chat['reciver'] != $current_user && !in_array($chat['reciver'], $allid)) {
            $allid[] = $chat['reciver'];
        }
    }
    return $allid;
}

// get user all chat messeges
function getChats($user_id)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "SELECT * FROM chat WHERE (sender=$current_user && reciver=$user_id) || (sender=$user_id && reciver=$current_user) ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

function getUsermsg($user_id)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "SELECT * FROM chat WHERE (sender=$current_user && reciver=$user_id) || (sender=$user_id && reciver=$current_user)";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

function getAllmsg()
{
    $active_chat_id = activeUserid();
    $conversation = array();
    foreach ($active_chat_id as $index => $id) {
        $conversation[$index]['user_id'] = $id;
        $conversation[$index]['messege'] = getChats($id);
    }
    return $conversation;
}

// update messege read status 
function msgSeen($user_id)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "UPDATE chat set read_status = 1 WHERE sender=$user_id && reciver=$current_user";
    return mysqli_query($db, $query);
}

// for send messege to a user 
function sendmsg($reciver, $msg)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "INSERT INTO chat(sender,reciver,msg) VALUES($current_user,$reciver,'$msg')";
    return mysqli_query($db, $query);
}

// get messege notfication
function unreadmsg()
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "SELECT count(*) as row FROM chat WHERE reciver=$current_user && read_status=0";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

// end of realtime chatting system 

// for block a user 
function blockuser($user_id)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "INSERT INTO blocklist(user_id,block_user) VALUES($current_user,$user_id)";
    return mysqli_query($db, $query);
}

// get block status 
function blockeduserstatus($user_id)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "SELECT * FROM blocklist WHERE (user_id=$current_user && block_user=$user_id) || (user_id=$user_id && block_user=$current_user)";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run);
}
// unblock user 
function unblockuser($user_id)
{
    global $db;
    $current_user = $_SESSION['user_id']['id'];
    $query = "DELETE FROM blocklist WHERE user_id=$current_user && block_user=$user_id";
    return mysqli_query($db, $query);
}

// for get page by passing flag in social net
function getPage($page, $data = "")
{
    include("assets/pages/$page.php");
}

// get page in admin panel 
function getadpage($page, $data = "")
{
    include("pages/$page.php");
}

// for admin panel 
function getadmin($user_id)
{
    global $db;
    $query = "SELECT * FROM admin WHERE user_id=$user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

// total counts
function totaldatacount($table)
{
    global $db;
    $query = "SELECT count(*) as row FROM $table";
    $run = mysqli_query($db,$query);
    return mysqli_fetch_assoc($run)['row'];
}

// get all users data 
function getallusers(){
    global $db;
    $query = "SELECT * FROM users ORDER BY id DESC";
    $run = mysqli_query($db,$query);
    return mysqli_fetch_all($run,true);
}

// set blue badge status ny admin 
function setbadgebyadmin($user_id,$value){
    global $db;
    $query = "UPDATE users set badge=$value WHERE id=$user_id";
    return mysqli_query($db,$query);
}

function banbyadmin($user_id,$value){
    global $db;
    $query = "UPDATE users set ac_status=$value WHERE id=$user_id";
    return mysqli_query($db,$query);
}