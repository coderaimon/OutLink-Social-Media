<?php

global $user;
global $posts;
global $fsug;

?>

<!-- body post recomandetion -->
<section class="mt-3">
    <div class="container body-wrap">
        <!-- news feed -->
        <div class="news">
            <!-- friends posts -->
            <div class="posts">
                <!-- initial post -->
                <?php
                showError();
                if (count($posts) < 1) {
                    echo "Follow someone to see posts! <a href='?fr_sug'>See suggestions</a>";
                }
                foreach ($posts as $post) {
                    $likes = getlikes($post['id']);
                    $comments = getcomments($post['id']);
                ?>
                    <div class="post" id="post<?= $post['id'] ?>">
                        <!-- post header -->
                        <div class="post-header">
                            <span><a href="?user=<?= $post['username'] ?>"><img src="assets/img/pp/<?= $post['profile_pic'] ?>"></a><?= $post['first_name'] ?> <?= $post['last_name'] ?><?= $post['badge'] == 1 ? '<i class="fas fa-check-circle"></i>' : '' ?></span>
                            <div class="dropdown">
                                <i class="fas fa-ellipsis-h dropdown-toggle" id="pdd<?= $post['id'] ?>" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu" aria-labelledby="pdd<?= $post['id'] ?>">
                                    <?php
                                    if ($user['id'] == $post['user_id']) {
                                    ?>
                                        <li><a class="dropdown-item" href="assets/php/action.php?pdl=<?= $post['id'] ?>&&pu=<?= $post['user_id'] ?>"><i class="fas fa-trash-alt"></i> Delete this post</a></li>
                                    <?php
                                    } else {
                                    ?>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-exclamation-triangle"></i> Report this post </a></li>
                                        <li><a class="dropdown-item" href="assets/php/action.php?block&bu=<?= $post['username'] ?>&bid=<?= $post['user_id'] ?>"><i class="fas fa-ban"></i> Block user!</a></li>
                                    <?php
                                    }

                                    ?>
                                </ul>
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
                                            <form class="input-group mb-3" method="post" action="assets/php/action.php?comment&po_id=<?= $post['id'] ?>">
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
                        <form class="input-group mb-3" method="post" action="assets/php/action.php?comment&po_id=<?= $post['id'] ?>">
                            <input type="text" name="com_text" class="form-control" placeholder="Say something..." aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="submit" id="button-addon2">Button</button>
                        </form>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
        <!-- side bar -->
        <div class="side-nav">
            <!-- initial profile -->
            <div class="uprofile mt-4">
                <div class="cr_user">
                    <img src="assets/img/pp/<?= $user['profile_pic'] ?>">
                </div>
                <div>
                    <span><?= $user['first_name'] ?> <?= $user['last_name'] ?> <?= $user['badge'] == 1 ? '<i class="fas fa-check-circle"></i>' : '' ?> </span>
                    <small>@<?= $user['username'] ?></small>
                </div>
            </div>
            <!-- suggested people -->
            <h5 class="mt-3">You can follow them.</h5>
            <div class="sug-pro">
                <?php
                foreach ($fsug as $users) {
                ?>
                    <div class="suggested">
                        <div class="sugp_img">
                            <a href="?user=<?= $users['username'] ?>"><img src="assets/img/pp/<?= $users['profile_pic'] ?>"></a>
                        </div>
                        <div>
                            <span><?= $users['first_name'] ?> <?= $users['last_name'] ?> <?= $users['badge'] == 1 ? '<i class="fas fa-check-circle"></i>' : '' ?></span>
                            <small>@<?= $users['username'] ?></small>
                        </div>
                        <button class="btn btn-primary folbtn" data-user-id="<?= $users['id'] ?>">Follow</button>
                    </div>
                <?php
                }
                if (count($fsug) < 1) {
                    echo "No user suggestions";
                }
                ?>

            </div>
        </div>
    </div>
</section>
<!-- end of body -->