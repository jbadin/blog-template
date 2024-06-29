<div class="container">
    <h1>Create post</h1>
    <?php if (isset($errors['global'])) { ?>
        <div class="alert alert-danger" role="alert">
           <p><?= $errors['global'] ?></p>
        </div>
    <?php } ?>
    <?php if(isset($success)) { ?>
        <div class="alert alert-success" role="alert">
            <p>Your post has been created successfully.</p>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col">
            <form action="/create-post" method="POST" enctype="multipart/form-data">
                <div class="mb-2">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control <?= !isset($errors['title']) ?: 'is-invalid' ?>" id="title" name="title" placeholder="New crochet technique" value="<?= @$_POST['title'] ?>">
                    <p class="invalid-feedback"><?= @$errors['title'] ?></p>
                </div>

                <div class="mb-2">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select <?= !isset($errors['category']) ?: 'is-invalid' ?>" id="category" name="category">
                        <option selected disabled>Select a category</option>
                        <?php foreach ($categories as $c){ ?>
                            <option value="<?= $c->id ?>" <?= @$_POST['category'] == $c->id ? 'selected' : '' ?>><?= $c->name ?></option>
                        <?php } ?>
                    </select>
                    <p class="invalid-feedback"><?= @$errors['category'] ?></p>
                </div>

                <div class="mb-2">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control <?= !isset($errors['content']) ?: 'is-invalid' ?>" id="content" name="content" rows="3"><?= @$_POST['content'] ?></textarea>
                    <p class="invalid-feedback"><?= @$errors['content'] ?></p>
                </div>

                <div class="mb-2">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control <?= !isset($errors['image']) ?: 'is-invalid' ?>" id="image" name="image">
                    <p class="invalid-feedback"><?= @$errors['image'] ?></p>
                </div>

                <div class="mb-2">
                    <input type="submit" name="create" class="btn btn-success" value="Create post">
                </div>
            </form>
        </div>
    </div>
</div>

