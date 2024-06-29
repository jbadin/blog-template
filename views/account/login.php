<div class="container">
    <h1>Login</h1>
    <?php if (isset($errors['global'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $errors['global'] ?>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col">
            <form action="/login" method="POST">
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
                    <input type="submit" name="submit" class="btn btn-success" value="Login">
                </div>
            </form>
        </div>
    </div>
</div>