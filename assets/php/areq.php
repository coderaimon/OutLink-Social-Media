<?php
require_once "function.php";

// follow friends suggestion list
if (isset($_GET['follow'])) {
    $user_id = $_POST['user_id'];
    $user_data = $_SESSION['user_id'];

    if (follow($user_id)) {
        $response['status'] = true;
        $msg = $user_data['first_name'] . ' ' . $user_data['last_name'] . ' followed you.';
        addnot($user_id, $msg, $user_data['username'], $user_data['profile_pic']);
    } else {
        $response['status'] = false;
    }

    echo json_encode($response);
}

// unfollow friends suggestion list
if (isset($_GET['unfollow'])) {
    $user_id = $_POST['user_id'];
    if (unfollow($user_id)) {
        $response['status'] = true;
        delnotif($user_id);
    } else {
        $response['status'] = false;
    }

    echo json_encode($response);
}

// unlike button 
if (isset($_GET['unlike'])) {
    $post_id = $_POST['post_id'];

    if (likestatus($post_id)) {
        if (unlike($post_id)) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }
    }
    echo json_encode($response);
}

// like button 
if (isset($_GET['like'])) {
    $post_id = $_POST['post_id'];
    if (!likestatus($post_id)) {
        if (like($post_id)) {
            $response['status'] = true;
            $user_data = $_SESSION['user_id'];
            if ($user_data['id'] != $_POST['user_id']) {
                $msg = $user_data['first_name'] . ' ' . $user_data['last_name'] . ' liked your post.';
                addnot($_POST['user_id'], $msg, $user_data['username'], $user_data['profile_pic']);
            }
        } else {
            $response['status'] = false;
        }
        echo json_encode($response);
    }
}

if (isset($_GET['unblock'])) {
    $user_id = $_POST['user_id'];
    if (unblockuser($user_id)) {
        $response['status'] = true;
    } else {
        $response['status'] = false;
    }
    echo json_encode($response);
}
