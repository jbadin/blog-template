<?php
namespace Models;
use PDO;
require_once 'models/baseModel.php';
class Users extends BaseModel {
    public int $id;
    public string $username;
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $password;
    public string $locationName;
    public string $registrationDate;
    public string $activationKey;
    public string $activationDate;
    public int $is_author;
    public int $id_usersroles;

    public function __construct() {
        $this->connectDb();
    }

    //Exists methods

    // /**
    //  * Check if the activation key exists in the database
    //  * @param string $activationKey
    //  * @return bool
    //  */
    // public function activationKeyExists(){
    //     $sql = 'SELECT COUNT(*) FROM ' . $this->prefix . 'users WHERE activationKey = :activationKey';
    //     $req = $this->pdo->prepare($sql);
    //     $req->bindValue(':activationKey', $this->activationKey, PDO::PARAM_STR);
    //     if($req->execute()) {
    //         return $req->fetchColumn();
    //     } else {
    //         return false;
    //     }
    // }
    
    /**
     * Check if the email exists in the database
     * @param string $email
     * @return bool
     */
    public function emailExists($email) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->prefix . 'users WHERE email = :email';
        $req = $this->pdo->prepare($sql);
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        if($req->execute()) {
            return $req->fetchColumn();
        } else {
            return false;
        }
    }

    /**
     * Check if the username exists in the database
     * @param string $username
     * @return bool
     */
    public function usernameExists($username) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->prefix . 'users WHERE username = :username';
        $req = $this->pdo->prepare($sql);
        $req->bindValue(':username', $username, PDO::PARAM_STR);
        if($req->execute()) {
            return $req->fetchColumn();
        } else {
            return false;
        }
    }

    // //Other methods

    // /**
    //  * Activate the user account
    //  * @param string $activationKey
    //  * @return bool
    //  */
    // public function activate() {
    //     $sql = 'UPDATE ' . $this->prefix . 'users SET activationDate = NOW() WHERE activationKey = :activationKey';
    //     $req = $this->pdo->prepare($sql);
    //     $req->bindValue(':activationKey', $this->activationKey, PDO::PARAM_STR);
    //     return $req->execute();
    // }

    /**
     * Create a new user in the database
     * @param string $username
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     * @param string $locationName
     * @return bool
     */
    public function create() {
        $sql = 'INSERT INTO  ' . $this->prefix . 'users (username, firstname, lastname, email, password, locationName, registrationDate, is_author, id_usersroles) VALUES (:username, :firstname, :lastname, :email, :password, :locationName, NOW(), 0, 1);';
        $req = $this->pdo->prepare($sql);
        $req->bindValue(':username', $this->username, PDO::PARAM_STR);
        $req->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $req->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $req->bindValue(':email', $this->email, PDO::PARAM_STR);
        $req->bindValue(':password', $this->password, PDO::PARAM_STR);
        $req->bindValue(':locationName', $this->locationName, PDO::PARAM_STR);
        return $req->execute();
    }

    /**
     * Get the user's information
     * @return bool
     */
    public function get() {
        $sql = 'SELECT id, username, firstname, lastname, email, locationName, registrationDate, is_author, id_usersroles FROM ' . $this->prefix . 'users WHERE id = :id';
        $req = $this->pdo->prepare($sql);
        $req->bindValue(':id', $this->id, PDO::PARAM_INT);
        if($req->execute()) {
            $result = $req->fetch(PDO::FETCH_OBJ);
            $this->username = $result->username;
            $this->firstname = $result->firstname;
            $this->lastname = $result->lastname;
            $this->email = $result->email;
            $this->locationName = $result->locationName;
            $this->registrationDate = $result->registrationDate;
            $this->is_author = $result->is_author;
            $this->id_usersroles = $result->id_usersroles;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the user's password hash
     * @param string $email
     * @return string
     */
    public function getPasswordHash($email) {
        $sql = 'SELECT password FROM ' . $this->prefix . 'users WHERE email = :email';
        $req = $this->pdo->prepare($sql);
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        if($req->execute()) {
            return $req->fetchColumn();
        } else {
            return false;
        }
    }

    public function login() {
        $sql = 'SELECT id, username, is_author, id_usersroles FROM ' . $this->prefix . 'users WHERE email = :email';
        $req = $this->pdo->prepare($sql);
        $req->bindValue(':email', $this->email, PDO::PARAM_STR);
        if($req->execute()) {
            return $req->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}
