<?php
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class TokenController {
    private $app;
    private $db;
    private $redirectTo;

    public function __construct(Container $app) {
        $this->app = $app;
        $this->db = $app['db'];
        $this->redirectTo = $app['redirectTo'];
    }

    //
    public function index(Request $request, Response $response) {
        
        $array = ['token' => $this->createToken()];

        return $this->app->view->render($response, 'index', $array);
    }

    public function isVerified(Request $request, Response $response, array $args) {
        $token = $args['token'];

        $res = $this->db->prepare("select status from tokens where token = :tok");
        $res->bindParam(":tok", $token);
        $res->execute();
        $status = $res->fetch()['status'];

        $array = [ 'status' => 'verified'];
        if($status != "verified") {
            $array['status'] = 'notverified';
        }

        return $response->withJson($array);
        
    }

    public function verify(Request $request, Response $response, array $args) {
        $token = $args['token'];

        $res = $this->db->prepare("select status from tokens where token = :tok");
        $res->bindParam(":tok", $token);
        $res->execute();
        $status = $res->fetch()['status'];

        $redirect = $this->redirectTo['error'];
        if($status != "verified" && $status != "") {
            $res = $this->db->prepare("update tokens set status = 'verified' where token = :tok");
            $res->bindParam(":tok", $token);
            $res->execute();
            $redirect = $this->redirectTo['success'] . "?token=" . $token;
        }
        return $response->withRedirect($redirect);
    }
    
    private function createToken() {
        $tok = sha1(uniqid(rand(), true));

        $res = $this->db->prepare("insert into tokens(token) values(:tok)");
        $res->bindParam(":tok", $tok);
        $res->execute();

        return $tok;
    }
}