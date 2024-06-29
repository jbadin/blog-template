<?php

namespace Models;

use PDO;

require_once 'models/baseModel.php';
class Posts extends BaseModel
{
    public int $id;
    public string $title;
    public string $content;
    public string $image;
    public string $publicationDate;
    public int $id_postsCategories;
    public int $id_users;

    public function __construct()
    {
        $this->connectDb();
    }

    /**
     * Create a post
     * @return bool
     */
    public function create()
    {
        $sql = 'INSERT INTO ' . $this->prefix . 'posts (`title`, `content`, `image`, `publicationDate`, `id_postsCategories`, `id_users`) VALUES (:title, :content, :image, NOW(), :id_postsCategories, :id_users)';
        $req = $this->pdo->prepare($sql);
        $req->bindValue(':title', $this->title, PDO::PARAM_STR);
        $req->bindValue(':content', $this->content, PDO::PARAM_STR);
        $req->bindValue(':id_postsCategories', $this->id_postsCategories, PDO::PARAM_INT);
        $req->bindValue(':id_users', $this->id_users, PDO::PARAM_INT);
        $req->bindValue(':image', $this->image, PDO::PARAM_STR);
        return $req->execute();
    }

    /**
     * Get a post by its id
     * @param int $id
     * @return object
     */
    public function getById() {
        $sql = 'SELECT `p`.`id`,`title`,`content`,`image`,`publicationDate`, `pc`.`name` AS `category`, `u`.`username` AS `author`
        FROM `p79k8_posts` AS `p`
        INNER JOIN `p79k8_postscategories` AS `pc` ON `p`.`id_postsCategories` = `pc`.`id`
        INNER JOIN `p79k8_users` AS `u` ON `p`.`id_users` = `u`.`id`
        WHERE `p`.`id` = :id';
        $req = $this->pdo->prepare($sql);
        $req->bindValue(':id', $this->id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Get the list of posts
     * @return array
     */
    public function getList()
    {
        $sql = 'SELECT `p`.`id`,`title`,`content`,`image`,`publicationDate`, `pc`.`name` AS `category`, `u`.`username` AS `author`
        FROM `p79k8_posts` AS `p`
        INNER JOIN `p79k8_postscategories` AS `pc` ON `p`.`id_postsCategories` = `pc`.`id`
        INNER JOIN `p79k8_users` AS `u` ON `p`.`id_users` = `u`.`id`';
        $req = $this->pdo->query($sql);
        return $req->fetchAll(PDO::FETCH_OBJ);
    }
}
