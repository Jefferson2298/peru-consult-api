<?php

use Peru\Reniec\Dni;
use Peru\Sunat\Ruc;
use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->group('/api', function () {
    /**@var $this Slim\App */
    $this->get('/ruc/{ruc:\d{11}}', function (Request $request, Response $response, array $args) {
        $ruc = $args['ruc'];
        /**@var $service Ruc */
        $service = $this->get(Ruc::class);
        $company = $service->get($ruc);
        if ($company === false) {
            $this->logger->error($service->getError());
            $response->getBody()->write($service->getError());
            return $response->withStatus(500);
        }

        return $response->withJson(get_object_vars($company));
    });

    $this->get('/dni/{dni:\d{8}}', function (Request $request, Response $response, array $args) {
        $dni = $args['dni'];
        /**@var $service Dni */
        $service = $this->get(Dni::class);
        $person = $service->get($dni);
        if ($person === false) {
            $this->logger->error($service->getError());
            $response->getBody()->write($service->getError());
            return $response->withStatus(500);
        }

        return $response->withJson(get_object_vars($person));
    });
});
$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    return $this->renderer->render($response, 'index.phtml', $args);
});
