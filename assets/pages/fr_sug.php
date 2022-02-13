<?php
global $frsug;
global $searchr;
global $user;
?>

<div class="container">

    <form class="input-group search-fr-bar">
        <input type="text" class="form-control" name="search" placeholder="Find someone..">
        <button class="btn btn-outline-primary" type="submit">Search</button>
    </form>

    <div class="fr_sug_wrap">
        <?php
        if (isset($_GET['search'])) {
            foreach ($searchr as $users) {
                // $profile = getuserprofile($users['username']);
                $folstat = folstatus($users['id']);
                
                if(blockeduserstatus($users['id'])){
                    $bl_dis = "d-none";
                }elseif($users['ac_status'] == 2){
                    $bl_dis = "d-none";
                }else{
                    $bl_dis = "";
                }

        ?>
                <div class="suggested">
                    <div class="sugp_img">
                        <a href="?user=<?= $users['username'] ?>"><img src="assets/img/pp/<?= $users['profile_pic'] ?>"></a>
                    </div>
                    <div>
                        <span><?= $users['first_name'] ?> <?= $users['last_name'] ?> <?= $users['badge'] == 1 ? '<i class="fas fa-check-circle"></i>' : '' ?></span>
                        <small>@<?= $users['username'] ?></small>
                    </div>
                    <?php
                    if ($user['id'] != $users['id']) {
                    ?>
                        <?php
                        if ($folstat == 1) {
                        ?>
                            <button class="btn btn-danger unfolbtn <?=$bl_dis?>" data-user-id="<?= $users['id'] ?>">Unfollow</button>
                        <?php
                        } else {
                        ?>
                            <button class="btn btn-primary folbtn <?=$bl_dis?>" data-user-id="<?= $users['id'] ?>">Follow</button>
                        <?php
                        }
                        ?>
                    <?php
                    }

                    ?>

                </div>
            <?php
            }
        } else {
            foreach ($frsug as $users) {
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
        }
        ?>

    </div>
</div>