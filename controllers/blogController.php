<?php

namespace Controllers;

use Models\PostsCategories;
use Models\Posts;

require_once 'controllers/baseController.php';
require_once 'models/postsCategoriesModel.php';
require_once 'models/postsModel.php';

class Blog extends BaseController
{


    private array $errors = [
        'title' => [
            'required' => 'Title is required',
            'minlength' => 'Title must be at least 5 characters long',
            'maxlength' => 'Title must be less than 100 characters long',
            'invalid' => 'Title must contain only letters, numbers, underscores, dots, commas, exclamation marks, question marks, single quotes, and hyphens',
            'exists' => 'Title already exists'
        ],
        'category' => [
            'required' => 'Category is required',
            'invalid' => 'Category is invalid. Please select one in the list below.'
        ],
        'content' => [
            'required' => 'Content is required',
            'minlength' => 'Content must be at least 50 character long',
            'maxlength' => 'Content must be less than 5000 characters long',
            'invalid' => 'The content must contain only letters, numbers, underscores, dots, commas, exclamation marks, question marks, single quotes, and hyphens'
        ],
        'image' => [
            'required' => 'Image is required',
            'weigth' => 'The image must be less than 2MB',
            'type' => 'The image must be a jpg, jpeg, gif or png file',
            'invalid' => 'The image is invalid. Please try again later.'
        ],
        'global' => 'An error occured. Please try again later.',
    ];

    private array $regex = [
        'title' => '/^[A-Za-z0-9 .,!?\'-]{5,100}$/',
        'category' => '/^[0-9]+$/',
        'content' => '/^[A-Za-z0-9 .,!?\'"()\-:;\n\r]{50,5000}$/',
    ];

    public function create()
    {
        $errors = [];

        if (!isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        try {
            $postCategories = new PostsCategories();
            $categories = $postCategories->getList();
        } catch (\Exception $e) {
            $errors['global'] = $this->errors['global'];
        }

        if (isset($_POST['create'])) {
            $post = new Posts();

            foreach ($_POST as $key => $value) {
                $$key = $this->cleanData($value);
            }

            if (!empty($title)) {
                if (strlen($title) < 5) {
                    $errors['title'] = $this->errors['title']['minlength'];
                } elseif (strlen($title) > 100) {
                    $errors['title'] = $this->errors['title']['maxlength'];
                } elseif (!preg_match($this->regex['title'], $title)) {
                    $errors['title'] = $this->errors['title']['invalid'];
                }
            } else {
                $errors['title'] = $this->errors['title']['required'];
            }

            if (!empty($category)) {
                if (!preg_match($this->regex['category'], $category)) {
                    $errors['category'] = $this->errors['category']['invalid'];
                } else if (!$postCategories->exists($category)) {
                    $errors['category'] = $this->errors['category']['invalid'];
                }
            } else {
                $errors['category'] = $this->errors['category']['required'];
            }

            if (!empty($content)) {
                if (strlen($content) < 50) {
                    $errors['content'] = $this->errors['content']['minlength'];
                } elseif (strlen($content) > 5000) {
                    $errors['content'] = $this->errors['content']['maxlength'];
                } elseif (!preg_match($this->regex['content'], $content)) {
                    $errors['content'] = $this->errors['content']['invalid'];
                }
            } else {
                $errors['content'] = $this->errors['content']['required'];
            }

            if ($_FILES['image']['error'] != 4) {
                $authorizedExtensions = ['jpg' => 'image/jpg', 'jpeg' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png'];
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $type = mime_content_type($_FILES['image']['tmp_name']);
                if (!array_key_exists($extension, $authorizedExtensions) || $type != $authorizedExtensions[$extension]) {
                    $errors['image'] = $this->errors['image']['type'];
                } else {
                    if ($_FILES['image']['size'] > 2097152 || $_FILES['image']['error'] == 1 || $_FILES['image']['error'] == 2) {
                        $errors['image'] = $this->errors['image']['weigth'];
                    } else if ($_FILES['image']['error'] != 0) {
                        $errors['image'] = $this->errors['image']['invalid'];
                    } else {
                        $imageName = uniqid() . '.' . $extension;
                        while (file_exists('/assets/img/blog/posts/' . $imageName)) {
                            $imageName = uniqid() . '.' . $extension;
                        }
                        $path = 'assets/img/blog/posts/' . $imageName;
                    }
                }
            } else {
                $errors['image'] = $this->errors['image']['required'];
            }

            if (count($errors) == 0) {
                $post->title = $title;
                $post->content = $content;
                $post->image = $path;
                $post->id_postsCategories = $category;
                $post->id_users = $_SESSION['user']['id'];

                try {
                    $success = false;
                    if(move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
                        if ($post->create()) {
                            $success = true;
                        } else {
                            unlink($path);
                        }
                    }
                } catch (\Exception $e) {
                    unlink($path);
                    $errors['global'] = $this->errors['global'];
                }
            }
        }

        require_once 'views/parts/header.php';
        require_once 'views/blog/create.php';
        require_once 'views/parts/footer.php';
    }

    public function update()
    {
        require_once 'views/parts/header.php';
        require_once 'views/blog/update.php';
        require_once 'views/parts/footer.php';
    }

    public function updateImage()
    {
        require_once 'views/parts/header.php';
        require_once 'views/blog/update.php';
        require_once 'views/parts/footer.php';
    }

    public function delete()
    {
        require_once 'views/parts/header.php';
        require_once 'views/blog/update.php';
        require_once 'views/parts/footer.php';
    }

    public function list()
    {
        $post = new Posts();
        try{
            $postsList = $post->getList();
        } catch (\Exception $e) {
            $errors['global'] = $this->errors['global'];
        }
        require_once 'views/parts/header.php';
        require_once 'views/blog/list.php';
        require_once 'views/parts/footer.php';
    }

    public function read(array $args = [])
    {
        $post = new Posts();
        try{
            $post->id = $args[0];
            $post = $post->getById();
            
        } catch (\Exception $e) {
            $errors['global'] = $this->errors['global'];
        }
        require_once 'views/parts/header.php';
        require_once 'views/blog/read.php';
        require_once 'views/parts/footer.php';
    }
}
