<?php

global $profile;
global $user_post;
global $user;

?>

<div class="container col-9 rounded-0">
    <div class="col-12 rounded p-4 mt-4 d-flex gap-5 profile-wrap">
        <div class="profile-pp col-4 d-flex justify-content-end align-items-start">
            <div class="ppuswrap img-thumbnail rounded-circle" style="height: 150px;width: 160px;">
                <img src="assets/img/pp/<?= $profile['profile_pic'] ?>" style="width: 100%;" />
            </div>
        </div>
        <div class="col-8 dpp-col">
            <div class="d-flex flex-column">
                <div class="d-flex gap-5 align-items-center pp-us-config">
                    <span style="font-size: x-large"><?= $profile['first_name'] ?> <?= $profile['last_name'] ?> <?= $profile['badge'] == 1 ? '<i class="fas fa-check-circle" style="font-size: 18px;"></i>' : '' ?></span>
                    <?php
                    if ($user['id'] != $profile['id'] && !blockeduserstatus($profile['id']) && $profile['ac_status'] != 2) {
                    ?>
                        <div class="dropdown">
                            <a type="button" id="ppddr" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: xx-large">
                                <i class="fas fa-ellipsis-h text-black"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="ppddr">
                                <li>
                                    <a class="dropdown-item" href="#"><i class="fas fa-exclamation-triangle"></i> Report
                                        this profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="assets/php/action.php?block&bu=<?= $profile['username'] ?>&bid=<?= $profile['id'] ?>"><i class="far fa-times-circle"></i> Block</a>
                                </li>
                            </ul>
                        </div>
                    <?php
                    }

                    ?>

                </div>
                <span style="font-size: larger" class="text-secondary">@<?= $profile['username'] ?></span>
                <?php
                if (blockeduserstatus($profile['id']) && $profile['ac_status'] != 2) {
                    $block_status = blockeduserstatus($profile['id']);
                    if ($profile['id'] == $block_status['user_id']) {
                        $bl_result = '<div class="d-flex text-danger align-items-center my-3"><i class="fas fa-exclamation-triangle me-1"></i>He has blocked you.. :)</div>';
                    } else {
                        $bl_result = '<div class="d-flex text-danger align-items-center my-3"><button class="btn btn-danger unblock" data-user-id="' . $profile['id'] . '">Unblock</button></div>';
                    }
                    echo $bl_result;
                } elseif ($profile['ac_status'] == 2) {
                    echo '<div class="d-flex text-danger align-items-center my-3"><i class="fas fa-exclamation-triangle me-1"></i>This user was banned.. :)</div>';
                } else {
                    if ($user['id'] != $profile['id']) {
                        $profbtn = '<a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#sendmsg"><i class="fab fa-facebook-messenger"></i> Messege</a>';
                    } else {
                        $profbtn = '<a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addpost"><i class="fas fa-edit"></i> Post</a>';
                    }
                ?>
                    <div class="pp-btn-grp d-flex gap-2 align-items-center my-3">
                        <?= $profbtn ?>
                        <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#followers"><i class="fas fa-users"></i> <?= $profile['follower'] ?> Followers</a>
                        <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#following"><i class="fas fa-user"></i> <?= $profile['following'] ?> Following</a>
                    </div>
                    <?php
                    if ($user['id'] != $profile['id']) {
                    ?>
                        <div class="d-flex gap-2 align-items-center my-1">
                            <?php
                            if (folstatus($profile['id'])) {
                            ?>
                                <button class="btn btn-sm btn-danger unfolbtn" data-user-id="<?= $profile['id'] ?>">Unfollow</button>
                            <?php
                            } else {
                            ?>
                                <button class="btn btn-sm btn-primary folbtn" data-user-id="<?= $profile['id'] ?>">Follow</button>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <h3 class="border-bottom">Posts</h3>
    <div class="posts profile-post-wrap">
        <!-- initial post -->
        <?php
        showError();
        if (!blockeduserstatus($profile['id']) && $profile['ac_status'] != 2) {
            foreach ($user_post as $post) {
                $likes = getlikes($post['id']);
                $comments = getcomments($post['id']);
                $puser = getuser($post['user_id'])
        ?>
                <div class="post" id="post<?= $post['id'] ?>">
                    <!-- post header -->
                    <div class="post-header">
                        <span><a href="?user=<?= $puser['username'] ?>"><img src="assets/img/pp/<?= $puser['profile_pic'] ?>"></a><?= $puser['first_name'] ?> <?= $puser['last_name'] ?><?= $puser['badge'] == 1 ? '<i class="fas fa-check-circle"></i>' : '' ?></span>
                        <div class="dropdown">
                            <i class="fas fa-ellipsis-h dropdown-toggle" id="pdd<?= $post['id'] ?>" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <ul class="dropdown-menu" aria-labelledby="pdd<?= $post['id'] ?>">
                                <?php
                                if ($user['id'] == $post['user_id']) {
                                ?>
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ep<?= $post['id'] ?>"><i class="fas fa-pen-square"></i> Edit this post</a></li>
                                    <li><a class="dropdown-item" href="assets/php/action.php?pdl=<?= $post['id'] ?>&&pu=<?= $post['user_id'] ?>"><i class="fas fa-trash-alt"></i> Delete this post</a></li>
                                <?php
                                } else {
                                ?>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-exclamation-triangle"></i> Report this post </a></li>
                                    <li><a class="dropdown-item" href="assets/php/action.php?block&bu=<?= $profile['username'] ?>&bid=<?= $profile['id'] ?>"><i class="fas fa-ban"></i> Block user!</a></li>
                                <?php
                                }

                                ?>
                            </ul>
                            <!-- edit post modal  -->
                            <div class="modal fade" id="ep<?= $post['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form class="modal-content" method="post" action="assets/php/action.php?updatepost&pid=<?=$post['id']?>&u=<?= $profile['username'] ?>">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Edit post..</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <span class="fw-300"><?=$post['post_text']?></span>
                                            <textarea class="form-control" name="uptext" placeholder="Caption" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-secondary">Update this post</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end of edit post modal  -->
                        </div>
                    </div>
                    <!-- post body -->
                    <div class="post-body">
                        <div class="ptext text-truncate text-inline" onclick="tsrink('pt<?= $post['id'] ?>')" id="pt<?= $post['id'] ?>">
                            <?= $post['post_text'] ?>
                        </div>
                        <div class="post_atc">
                            <img src="assets/img/post_pic/<?= $post['post_img'] ?>" data-bs-toggle="modal" data-bs-target="#img<?= $post['id'] ?>">
                            <!-- Modal -->
                            <div class="modal fade" id="img<?= $post['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-body bg-black">
                                            <button type="button" class="btn-close bg-light d-block ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                            <div class="imd-bd py-3">
                                                <img class="impnew" src="assets/img/post_pic/<?= $post['post_img'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- post footer -->
                    <div class="post-footer">
                        <span>
                            <?php
                            if (likestatus($post['id'])) {
                                $react = "fas fa-heart unlike";
                            } else {
                                $react = "far fa-heart like";
                            }
                            ?>
                            <i class="<?= $react ?>" data-post-id="<?= $post['id'] ?>" data-user-id="<?= $post['user_id'] ?>"></i>
                        </span>
                        <i class="far fa-comment-dots" data-bs-toggle="modal" data-bs-target="#showComments"></i>
                        <!-- show comments -->
                        <div class="modal fade" id="showComments" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Comments</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body d-grid" style="row-gap: 1rem;">
                                        <?php
                                        if (count($comments) < 1) {
                                            echo '<h5 class="text-muted text-center">Currently no comments in this post :)</h5>';
                                        }
                                        foreach ($comments as $com) {
                                            $csub = getuser($com['user_id']);
                                        ?>
                                            <div class="comment">
                                                <a class="com-pp">
                                                    <img class="w-100" src="assets/img/pp/<?= $csub['profile_pic'] ?>">
                                                </a>
                                                <div class="d-flex">
                                                    <div class="com-text">
                                                        <span><?= $csub['first_name'] ?> <?= $csub['last_name'] ?><?= $csub['badge'] == 1 ? '<i class="fas fa-check-circle" style="font-size:16px;"></i>' : '' ?></span>
                                                        <small><?= $com['comment'] ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                    <div class="modal-footer">
                                        <form class="input-group mb-3" method="post" action="assets/php/action.php?comment&po_id=<?= $post['id'] ?>&u=<?= $puser['username'] ?>">
                                            <input type="text" name="com_text" class="form-control" placeholder="Say something..." aria-label="Recipient's username" aria-describedby="button-addon2">
                                            <button class="btn btn-primary" type="submit" id="button-addon2">Button</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- share option -->
                        <i class="fas fa-share-alt"></i>

                        <!-- likes and comments count -->
                        <?php
                        if ($likes > 1000) {
                            $likescount = $likes / 1000;
                            $likescount = $likescount . 'k';
                        }

                        if (count($comments) > 1000) {
                            $cmc = count($comments) / 1000;
                            $cmc = $cmc . 'k';
                        } else {
                            $cmc = count($comments);
                        }
                        ?>
                        <span><?= $likes ?> like <?= $cmc ?> comment</span>
                    </div>
                    <form class="input-group mb-3" method="post" action="assets/php/action.php?comment&po_id=<?= $post['id'] ?>&u=<?= $puser['username'] ?>">
                        <input type="text" name="com_text" class="form-control" placeholder="Say something..." aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-primary" type="submit" id="button-addon2">Button</button>
                    </form>
                </div>
        <?php
            }
        } elseif ($profile['ac_status'] == 2) {
            echo '<div class="text-danger d-flex justify-content-center py-3"><h5>Sorry! you are not able to see posts!</h5></div>';
        } else {
            echo '<div class="text-danger d-flex justify-content-center py-3"><h5>Sorry! you are not able to see posts!</h5></div>';
        }
        ?>

    </div>
</div>

<!-- for seeing people who following current user -->

<div class="modal fade" id="followers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Followers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                $getfdata = getfollowers($profile['id']);
                if (count($getfdata) < 1) {
                    echo '<h5 class="text-center text-muted">No followers yet.. :)</h5>';
                }
                foreach ($getfdata as $followers) {
                    $fr_data = getuser($followers['follower_id']);
                ?>
                    <div class="f-user">
                        <a href="?user=<?= $fr_data['username'] ?>" class="f-user-img">
                            <img src="assets/img/pp/<?= $fr_data['profile_pic'] ?>">
                        </a>
                        <div class="user-dt">
                            <span><?= $fr_data['first_name'] ?> <?= $fr_data['last_name'] ?> <?= $fr_data['badge'] == 1 ? '<i class="fas fa-check-circle"></i>' : '' ?></span>
                            <span class="text-muted">@<?= $fr_data['username'] ?></span>
                        </div>
                        <?php
                        if ($followers['follower_id'] != $user['id']) {
                            if (folstatus($followers['follower_id'])) {
                                $fsbtn = '<button class="btn btn-sm btn-danger unfolbtn" data-user-id="' . $followers['follower_id'] . '">Unfollow</button>';
                            } else {
                                $fsbtn = '<button class="btn btn-sm btn-primary folbtn" data-user-id="' . $followers['follower_id'] . '">Follow</button>';
                            }
                            echo $fsbtn;
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- for seeing people followed by current user -->
<div class="modal fade" id="following" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Following</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                $getfidata = getfollowing($profile['id']);
                if (count($getfidata) < 1) {
                    echo '<h5 class="text-center text-muted">He/She isn`t following anyone :)</h5>';
                }
                foreach ($getfidata as $users) {
                    $fr_data = getuser($users['user_id']);
                ?>
                    <div class="f-user">
                        <a href="?user=<?= $fr_data['username'] ?>" class="f-user-img">
                            <img src="assets/img/pp/<?= $fr_data['profile_pic'] ?>">
                        </a>
                        <div class="user-dt">
                            <span><?= $fr_data['first_name'] ?> <?= $fr_data['last_name'] ?> <?= $fr_data['badge'] == 1 ? '<i class="fas fa-check-circle"></i>' : '' ?></span>
                            <span class="text-muted">@<?= $fr_data['username'] ?></span>
                        </div>
                        <?php
                        if ($users['user_id'] != $user['id']) {
                            if (folstatus($users['user_id'])) {
                                $fsbtn = '<button class="btn btn-sm btn-danger unfolbtn" data-user-id="' . $users['user_id'] . '">Unfollow</button>';
                            } else {
                                $fsbtn = '<button class="btn btn-sm btn-primary folbtn" data-user-id="' . $users['user_id'] . '">Follow</button>';
                            }
                            echo $fsbtn;
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>