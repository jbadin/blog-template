<?php 
class Router {
    private array $routes = [];

    /**
     * Add a route to the router in adding it to the routes array
     */
    public function addRoute(string $path, string $controller, string $method) {
        $this->routes[$path] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    /**
     * Dispatch the router
     */
    public function dispatch(){
        // get the requested path
        $path = $_SERVER['REQUEST_URI'];
        $pathParts = explode('/', $path);
        $link = '/' . $pathParts[1];

        foreach($pathParts as $key => $arg){
            if($key > 1){
                $args[] = $arg;
            }
        }
       
        // if the path is in the routes array, get the controller and the method
        if(array_key_exists($link, $this->routes)){
            $controller = $this->routes[$link]['controller'];
            $method = $this->routes[$link]['method'];

            require_once 'controllers/' . $controller . 'Controller.php';
            $controller = 'Controllers\\' . $controller;
            $controller = new $controller();
            if(isset($args)){
                $controller->$method($args);
            } else {
                $controller->$method();
            }
        } else {
            $controller = 'errorController';
            $method = 'error404';
        }
    }
}