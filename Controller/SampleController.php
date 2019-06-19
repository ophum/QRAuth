<?php
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class SampleController {
    public function index(Request $request, Response $response, array $args) {
        $token = $request->getQueryParams()['token'];
        $response->getBody()->write("$token is SUCCESS!!!!");
        return $response;
    }

    public function error(Request $requset, Response $response) {
        $response->getBody()->write("ERROR!!!!");
        return $response;
    }
}