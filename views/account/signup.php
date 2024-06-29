<div class="container">
    <h1>Sign up</h1>
    <?php if (isset($errors['global'])) { ?>
        <div class="alert alert-danger" role="alert">
           <p><?= $errors['global'] ?></p>
        </div>
    <?php } ?>
    <?php if(isset($success)) { ?>
        <div class="alert alert-success" role="alert">
            <p>Your account has been created successfully. Please, check your e-mail to activate your account.</p>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col">
            <form action="/signup" method="POST">
                <div class="mb-2">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control <?= !isset($errors['username']) ?: 'is-invalid' ?>" id="username" name="username" placeholder="ex: johndoe123" value="<?= @$_POST['username'] ?>">
                    <p class="invalid-feedback"><?= @$errors['username'] ?></p>
                </div>
                <div class="mb-2">
                    <label for="lastname" class="form-label">Lastname</label>
                    <input type="text" class="form-control <?= !isset($errors['lastname']) ?: 'is-invalid' ?>" id="lastname" name="lastname" placeholder="ex: DOE" value="<?= @$_POST['lastname'] ?>">
                    <p class="invalid-feedback"><?= @$errors['lastname'] ?></p>
                </div>
                <div class="mb-2">
                    <label for="firstname" class="form-label">Firstname</label>
                    <input type="text" class="form-control <?= !isset($errors['firstname']) ?: 'is-invalid' ?>" id="firstname" name="firstname" placeholder="ex: John" value="<?= @$_POST['firstname'] ?>">
                    <p class="invalid-feedback"><?= @$errors['firstname'] ?></p>
                </div>
                <div class="mb-2">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control <?= !isset($errors['email']) ?: 'is-invalid' ?>" id="email" name="email" placeholder="ex:john.doe@mail.com" value="<?= @$_POST['email'] ?>">
                    <p class="invalid-feedback"><?= @$errors['email'] ?></p>
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control <?= !isset($errors['password']) ?: 'is-invalid' ?>" id="password" name="password" placeholder="ex: Qwerty1234!">
                    <p class="invalid-feedback"><?= @$errors['password'] ?></p>
                </div>
                <div class="mb-2">
                    <label for="passwordConfirm" class="form-label">Confirm password</label>
                    <input type="password" class="form-control <?= !isset($errors['passwordConfirm']) ?: 'is-invalid' ?>" id="passwordConfirm" name="passwordConfirm" placeholder="ex: Qwerty1234!">
                    <p class="invalid-feedback"><?= @$errors['passwordConfirm'] ?></p>
                </div>
                <div class="mb-2">
                    <label for="locationName" class="form-label">Location</label>
                    <input type="text" class="form-control <?= !isset($errors['locationName']) ?: 'is-invalid' ?>" id="locationName" name="locationName" placeholder="ex: London" value="<?= @$_POST['locationName'] ?>">
                    <div class="mt-2" id="suggestions"></div>
                    <p class="invalid-feedback"><?= @$errors['locationName'] ?></p>
                </div>
                <div class="mb-2">
                    <input type="submit" name="submit" class="btn btn-success" value="Sign up">
                </div>
            </form>
        </div>
    </div>
</div>