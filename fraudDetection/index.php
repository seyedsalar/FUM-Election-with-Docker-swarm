<?php
use \Psr\Http\Message\ServerRequestInterface as Request;

use \Psr\Http\Message\ResponseInterface as Response;


require_once('main.php');
require_once '../vendor/autoload.php';



$app = new \Slim\App;
$app->delete('/books/{id}', function (Request $request,Response $response,array $args) {

   // echo $bookId = $args['id'];



});

$app->get('/permissible', function (Request $request, Response $response, array $args) {
    $params = $request->getQueryParams();
    $studentId = $params["studentId"];
    $electionId = $params["electionId"];
    $db = Db::getInstance();
    $record = $db->first("SELECT * FROM fruad_detection WHERE Election_id = '$electionId' AND Student_id = '$studentId'");
    if($record == null){
/*
        $db->insert("INSERT INTO fruad_detection(Election_id,Student_id) VALUES
(  :Election_id,  :Student_id)", array(
            'Election_id'     => $electionId,
            'Student_id'     => $studentId
        ));*/
        $status = array('successful' => true);
        $response = $response->withJson($status,200);
    }else{
        $status = array('successful' => false , 'reason' => "شما قبلا در این انتخابات شرکت کرده‌اید" );
        $response = $response->withJson($status,400);
    }


    return $response;
});

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {

    $name = $args['name'];

    $response->getBody()->write("habibi, $name");

    return $response;

});



$app->post('/books', function (Request $request,Response $response,array $args) {

    $name = $request->getAttribute('name');

    $response->getBody()->write("Hello, $name  with ");

    return $response;

});

$app->run();
