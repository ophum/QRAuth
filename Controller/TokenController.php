<?php
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class TokenController {
    private $app;
    private $db;

    public function __construct(Container $app) {
        $this->app = $app;
        $this->db = $app['db'];
    }

    //
    public function index(Request $request, Response $response) {
        
        $array = ['token' => $this->createToken()];

        return $this->app->view->render($response, 'index', $array);
    }


    private function createToken() {
        $tok = sha1(uniqid(rand(), true));

        $res = $this->db->prepare("insert into tokens(token) values(:tok)");
        $res->bindParam(":tok", $tok);
        $res->execute();

        return $tok;
    }
}