    <div class="container">
        <div class="row">
           <?php foreach ($postsList as $p) { ?>  
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <img src="<?= $p->image ?>" class="card-img-top" alt="Post Image">
                    <div class="card-body">
                        <p class="card-title"><?= $p->title ?></p>
                        <p class="card-text"><strong>Author:</strong> <?= $p->author ?></p>
                        <p class="card-text"><strong>Category:</strong> <?= $p->category ?></p>
                        <p class="card-text"><strong>Publication Date:</strong> <?= $p->publicationDate ?></p>
                        <p class="card-text">This is a brief excerpt of the post content. This gives readers an idea of what the post is about.</p>
                    </div>
                    <div class="card-footer">
                        <a href="/read/<?= $p->id ?>" class="btn btn-primary">Read more</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>