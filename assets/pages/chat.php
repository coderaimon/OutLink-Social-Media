<?php
global $user;
?>
<div class="chat-wrap">
    <div class="chats">
        <div class="chat-header">
            <div class="cht">
                <a href="?"><i class="fas fa-home"></i></a>
                <span>OutLink</span>
                <a href="?editprofile"><i class="fas fa-edit"></i></a>
            </div>
            <form class="chb">
                <input type="search" name="search" placeholder="Search chats...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="chat-body">
            <!-- chat list -->
            <?php

            $chats = getAllmsg();
            foreach ($chats as $chat) {
                $cub = '';
                if (isset($_GET['cum'])) {
                    msgSeen($_GET['cum']);
                    if ($_GET['cum'] === $chat['user_id']) {
                        $cub = 'um-active';
                    } else {
                        $cub = '';
                    }
                }
                $ch_user = getuser($chat['user_id']);
            ?>
                <a href="?chats&cum=<?= $chat['user_id'] ?>" class="cb-chat <?= isset($_GET['cum']) ? $cub : '' ?>">
                    <div class="cbc-pp">
                        <img src="assets/img/pp/<?= $ch_user['profile_pic'] ?>" alt="user..">
                    </div>
                    <div class="cbc-user">
                        <span class="text-truncate"><?= $ch_user['first_name'] ?> <?= $ch_user['last_name'] ?> <?= $ch_user['badge'] == 1 ? '<i class="fas fa-check-circle"></i>' : '' ?></span>
                        <?php
                        if ($chat['messege'][0]['sender'] == $user['id']) {
                            $remsgstat = "text-muted";
                        } elseif ($chat['messege'][0]['read_status'] == 0 && $chat['messege'][0]['sender'] != $user['id']) {
                            $remsgstat = "fw-bold";
                        } else {
                            $remsgstat = "text-muted";
                        }
                        ?>
                        <small class="<?= $remsgstat ?> text-truncate"><?= $chat['messege'][0]['msg'] ?></small>
                    </div>
                </a>
            <?php
            }
            ?>

        </div>
    </div>
    <div class="messeges <?= isset($_GET['cum']) ? 'msgactive' : '' ?>">
        <?php
        if (isset($_GET['cum'])) {
            $chat_user = getuser($_GET['cum']);
            if(blockeduserstatus($chat_user['id'])){
                $bl_by_user = 'd-none';
            }else{
                $bl_by_user = '';
            }
        ?>
            <div class="msg-header">
                <div class="msg-user">
                    <a href="?chats"><i class="fas fa-arrow-left"></i></a>
                    <div class="mu-pp">
                        <img src="assets/img/pp/<?= $chat_user['profile_pic'] ?>" alt="user...">
                    </div>
                    <div class="mu-cd">
                        <span class="text-truncate"><?= $chat_user['first_name'] ?> <?= $chat_user['last_name'] ?></span>
                        <small class="text-truncate">@<?= $chat_user['username'] ?></small>
                    </div>
                </div>
                <div class="msg-menu <?=$bl_by_user?>">
                    <i class="fas fa-phone"></i>
                    <i class="fas fa-video"></i>
                    <i class="fas fa-info-circle"></i>
                </div>
            </div>
            <div class="msg-body">
                <?php
                $ch_msg = getUsermsg($_GET['cum']);
                foreach ($ch_msg as $cm) { 
                    if ($cm['reciver'] == $_GET['cum']) {
                        $ch_box = 'curuser-msg';
                    } else {
                        $ch_box = 'user-msg';
                    }
                ?>
                    <div class="<?= $ch_box ?>">
                        <div>
                            <span><?= $cm['msg'] ?></span>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="msg-footer <?=$bl_by_user?>">
                <i class="fas fa-plus-circle"></i>
                <i class="fas fa-image"></i>
                <form class="input-group mb-3" method="post" action="assets/php/action.php?sendmsg&reuser=<?= $_GET['cum'] ?>">
                    <textarea type="text" id="usermsg" onchange="tempdata('usermsg')" name="msg_text" class="form-control" placeholder="Aa" rows="1" style="resize: none;" required></textarea>
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2">Send</button>
                </form>
            </div>
        <?php
        } else {
        ?>
            <div style="
   font-size: 3rem;
   font-weight: 700;
   width: 60rem;
   height: 100vh;
   display: flex;
   justify-content: center;
   align-items: center;
">Choose someone to chat.....</div>
        <?php
        }
        ?>

    </div>
</div>


<?php
if (isset($_GET['cum'])) {
?>
    <script>
        // for set width height automate in messege
        const deviceWidth = window.screen.width;
        const deviceHeight = window.screen.height;

        if (deviceWidth < 601) {
            document
                .querySelector(".messeges").setAttribute("style", `width:${deviceWidth / 16}rem;height:${deviceHeight}px;`);
            document
                .querySelector(".msg-body")
                .setAttribute("style", "height:" + (deviceHeight - 130) + "px");
        } else if (deviceWidth > 600 && deviceWidth < 900) {
            document.querySelector(".msg-body").setAttribute("style", `height:${deviceHeight - 130}px`);
        } else if (deviceWidth > 900) {
            document.querySelector(".messeges").setAttribute("style", `width:${deviceWidth - 336}px`);
            document.querySelector(".msg-body").setAttribute("style", `height:${deviceHeight - 130}px`);
        };
    </script>

<?php
}
?>