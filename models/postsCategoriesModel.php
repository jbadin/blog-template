<?php
namespace Models;
use PDO;
require_once 'models/baseModel.php';
class PostsCategories extends BaseModel {
    public int $id;
    public string $name;

    public function __construct() {
        $this->connectDb();
    }

    /**
     * Check if the category exists in the database
     * @param int $id
     * @return int
     */
    public function exists(int $id){
        $sql = 'SELECT COUNT(*) FROM ' . $this->prefix . 'postscategories WHERE id = :id';
        $req = $this->pdo->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchColumn();
    }

    /**
     * Get the list of categories
     * @return array
     */
    public function getList(){
        $sql = 'SELECT `id`,`name` FROM ' . $this->prefix . 'postscategories';
        $req = $this->pdo->query($sql);
        return $req->fetchAll(PDO::FETCH_OBJ);
    }
    
}
