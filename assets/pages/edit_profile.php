<?php global $user; ?>

<div class="container col-9 rounded-0 d-flex justify-content-between">
    <div class="col-12 bg-white border rounded p-4 my-2 shadow-sm">
        <?php
        if (isset($_GET['success'])) {
        ?>
            <p style="color:green;text-align:center">Your profile is updated!</p>
        <?php
        } elseif (isset($_GET['error'])) {
        ?>
            <p style="color:red;text-align:center">Server isn't responding!</p>
        <?php
        }

        ?>
        <form method="post" action="assets/php/action.php?updateprofile" enctype="multipart/form-data">
            <h1 class="h5 mb-3 fw-normal">Edit Profile</h1>
            <div class="form-floating mt-1 col-6">
                <img src="assets/img/pp/<?= $user['profile_pic'] ?>" class="img-thumbnail my-3" style="height:150px;" alt="...">
                <div class="mb-3" style="width: 15rem">
                    <label for="formFile" class="form-label">Change Profile Picture</label>
                    <input class="form-control" name="profile_pic" type="file" id="formFile">
                </div>
            </div>
            <div class="d-flex">
                <div class="form-floating mt-1 col-6 ">
                    <input type="text" value="<?= $user['first_name'] ?>" name="first_name" class="form-control rounded-0" placeholder="First name">
                    <label for="floatingInput">first name</label>
                </div>
                <div class="form-floating mt-1 col-6">
                    <input type="text" value="<?= $user['last_name'] ?>" name="last_name" class="form-control rounded-0" placeholder="Last name">
                    <label for="floatingInput">last name</label>
                </div>
            </div>
            <div class="d-flex gap-3 my-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="1" <?= $user['gender'] == 1 && $user['gender'] != null ? 'checked' : '' ?> <?= $user['gender'] != null ? 'disabled' : '' ?>>
                    <label class="form-check-label" for="exampleRadios1">
                        Male
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios3" value="2" <?= $user['gender'] == 2 && $user['gender'] != null ? 'checked' : '' ?> <?= $user['gender'] != null ? 'disabled' : '' ?>>
                    <label class="form-check-label" for="exampleRadios3">
                        Female
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="3" <?= $user['gender'] == 3 && $user['gender'] != null ? 'checked' : '' ?> <?= $user['gender'] != null ? 'disabled' : '' ?>>
                    <label class="form-check-label" for="exampleRadios2">
                        Other
                    </label>
                </div>
            </div>
            <div class="form-floating mt-1">
                <input type="email" value="<?= $user['email'] ?>" class="form-control rounded-0" placeholder="Email" disabled>
                <label for="floatingInput">email</label>
            </div>
            <div class="form-floating mt-1">
                <input type="email" value="<?= $user['phone'] ?>" class="form-control rounded-0" placeholder="Email" disabled>
                <label for="floatingInput">Phone</label>
            </div>
            <div class="form-floating mt-1">
                <input type="text" value="<?= $user['username'] ?>" class="form-control rounded-0" placeholder="username" disabled>
                <label for="floatingInput">username</label>
            </div>
            <div class="form-floating mt-1">
                <input type="password" name="new_pass" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">New password</label>
            </div>
            <?= showError() ?>
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit">Update Profile</button>
            </div>

        </form>
    </div>

</div>