<div class="container">
    <h1><?= $user->username ?>'s profile</h1>
    <div class="row">
        <div class="col">
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $user->id) { ?>
                <p>Lastname : <?= $user->lastname ?></p>
                <p>Firstname : <?= $user->firstname ?></p>
                <p>Email : <?= $user->email ?></p>
            <?php } ?>
            <p>Location : <?= $user->locationName ?></p>
            <p>Registered since : <?= $user->registrationDate ?></p>
        </div>
    </div>
</div>