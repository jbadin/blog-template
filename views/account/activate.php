<div class="container">
    <h1>Account activation</h1>
    <div class="row">
        <div class="col">
            <?php if(isset($success)) { ?>
                <div class="alert alert-success" role="alert">
                    <p>Your account has been activated. You can now <a href="/login">login</a>.</p>
                </div>
            <?php } ?>
            <?php if(isset($errors)) { ?>
                <div class="alert alert-danger" role="alert">
                    <p><?php echo $errors['activationKey']; ?></p>  
                </div>
            <?php } ?>
        </div>
    </div>
</div>