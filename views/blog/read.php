<div class="container mt-2">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="mb-4">
                    <img src="../<?= $post->image ?>" class="img-fluid" alt="Post Image">
                </div>
                <h1 class="mb-3"><?= $post->title ?></h1>
                <p><strong>Author: </strong><?= $post->author ?></p>
                <p><strong>Category: </strong><?= $post->category ?></p>
                <p><strong>Publication Date: </strong><?= $post->publicationDate ?></p>
                <p>
                    <?= $post->content ?>
                </p>
            </div>
        </div>
    </div>