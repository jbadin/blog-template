<?php
namespace Controllers;

class BaseController {

    public function cleanData($data) {
        $data = trim($data);
        $data = strip_tags($data);
        return $data;
    }
}