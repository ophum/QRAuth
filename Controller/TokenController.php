<?php
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class TokenController {
    private $app;

    public function __construct(Container $app) {
        $this->app = $app;
    }

    //
    public function index(Request $request, Response $response) {
        
        $array = ['token' => "12345567"];

        return $this->app->view->render($response, 'index', $array);
    }
}