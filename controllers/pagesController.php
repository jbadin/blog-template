<?php
namespace Controllers;

require_once 'controllers/baseController.php';

class Pages extends BaseController {
    public function home() {
        require_once 'views/parts/header.php';
        require_once 'views/pages/home.php';
        require_once 'views/parts/footer.php';
    }

    public function about(){
        require_once 'views/parts/header.php';
        require_once 'views/pages/about.php';
        require_once 'views/parts/footer.php';
    }

    public function contact(){
        require_once 'views/parts/header.php';
        require_once 'views/pages/contact.php';
        require_once 'views/parts/footer.php';
    }
}