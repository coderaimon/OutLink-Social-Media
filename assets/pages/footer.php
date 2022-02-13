<!-- add post -->
<div class="modal fade" id="addpost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="assets/php/action.php?addpost" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" class="w-50 d-block m-auto" id="pre_img" style="display: none">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Choose a picture to post.</label>
                    <input class="form-control" name="post_img" type="file" id="post_img">
                </div>
                <div class="form-floating">
                    <textarea class="form-control" name="post_caption" placeholder="Add caption here:)" id="floatingTextarea2" style="height: 80px"></textarea>
                    <label for="floatingTextarea2">Write a caption!</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Post</button>
            </div>
        </form>
    </div>
</div>

<!-- for notification offcanvas -->
<?php
if (isset($_SESSION['Auth'])) {
    $notification = getnotif($_SESSION['user_id']['id']);
?>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="notify" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Notification</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="notify-wrap">
                <?php
                foreach ($notification as $notif) {
                    $sub_data = getuser($notif['sub_id']);
                ?>
                    <a href="?user=<?= $sub_data['username'] ?>&vnt=<?= $notif['id'] ?>" class="notify">
                        <div class="nt-pp">
                            <img src="assets/img/pp/<?= $sub_data['profile_pic'] ?>">
                        </div>
                        <div class="ntc"><?= $notif['nt_text'] ?></div>
                        <span><?= $notif['status'] == 0 ? '<i class="fas fa-circle"></i>' : '' ?></span>
                    </a>
                <?php
                }
                ?>

            </div>
        </div>
    </div>
<?php
}
?>

<!-- send messege from profile  -->
<?php
if (isset($_GET['user'])) {
    $user = getuserprofile($_GET['user']);
?>
    <div class="modal fade" id="sendmsg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="assets/php/action.php?sendmsg&reuser=<?= $user['id'] ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?=$user['first_name']?> <?=$user['last_name']?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <textarea name="msg_text" class="form-control" placeholder="Write your messege...." id="floatingTextarea2" style="height: 100px" required></textarea>
                        <label for="floatingTextarea2">Write your messege....</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
<?php
}
?>



<!-- custom javascript file -->
<script>
    function winloaded() {
        let sub = document.getElementById("loader");
        sub.style.display = "none";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/setting.js?v=<?= time() ?>"></script>

</body>

</html>