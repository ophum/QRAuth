<?php

$config = [
    'settings' => [
        'displayErrorDetails' => true,
        'renderer' => [
            'blade_template_path' => __DIR__ . '/views',
            'blade_cache_path' => __DIR__ . '/cache',
        ],
		'db' => [
            'dsn' => 'sqlite:database.sqlite',
            'user' => '',
            'password' => '',
		],
    ],
];


$app = new \Slim\App($config);

$container = $app->getContainer();

$container['view'] = function($container) {
    return new \Slim\Views\Blade(
        $container['settings']['renderer']['blade_template_path'],
        $container['settings']['renderer']['blade_cache_path']
    );
};

$container['db'] = function($container) {
	$db = $container['settings']['db'];
	$pdo = new PDO($db['dsn'], $db['user'], $db['password']);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	return $pdo;	
};

$app->get('/', TokenController::class.":index");
$app->get('/isverified/{token}', TokenController::class.":isVerified");


$app->run();
