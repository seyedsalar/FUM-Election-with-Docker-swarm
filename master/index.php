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
        $db->insert("INSERT INTO fruad_detection(Election_id,Student_id) VALUES
(  :Election_id,  :Student_id)", array(
            'Election_id'     => $electionId,
            'Student_id'     => $studentId
        ));
        $status = array('successful' => true);
        $response = $response->withJson($status,200);
    }else{
        $status = array('successful' => false , 'reason' => "شما قبلا در این انتخابات شرکت کرده‌اید" );
        $response = $response->withJson($status,400);
    }


    return $response;
});

$app->get('/vote', function($request, $response, $args) {
    $body = $request->getQueryParams();
    $studentId = $body['studentId'];
    $token = $body['token'];
    $subElectionId = $body['subElectionId'];
    if (is_authenticated($studentId,$token)){

        $db = Db::getInstance();
        $record = $db->query("SELECT count,election_id FROM sub_election where Id = '$subElectionId'");

        $data = url_get_contents2('http://172.17.0.1:8089/slim/public/permissible?studentId='.$studentId.'&electionId='.$record[0]['election_id']);
        $permissible = json_decode($data, true);
        if($permissible['successful']){
            $number = $record[0]['count'] + 1;
            $db->modify("UPDATE sub_election SET count = :count WHERE Id = '$subElectionId'",
                array(
                    'count'     => $number
                ));
		$db->insert("INSERT INTO fruad_detection(Election_id,Student_id) VALUES
(  :Election_id,  :Student_id)", array(
            'Election_id'     => $record[0]['election_id'],
            'Student_id'     => $studentId
        ));
            $status = array('successful' => true , 'result' =>'انتخاب شما با موفقیت انجام شد');
            $response = $response->withJson($status,200);
        }else{
            $status = array('successful' => false , 'reason' => "شما قبلا در این انتخابات شرکت کرده اید" );
            $response = $response->withJson($status,400);
        }

    }else{
        $status = array('successful' => false , 'reason' => "لطفا مجددا وارد شوید" );
        $response = $response->withJson($status,400);
    }
    return $response;
});

$app->get('/subElectionList', function (Request $request, Response $response, array $args) {
    $params = $request->getQueryParams();
    $studentId = $params["studentId"];
    $token = $params["token"];
    $electionId = $params["electionId"];
    if (is_authenticated($studentId,$token)){
        $subElectionList = array();
        $db = Db::getInstance();
        $records = $db->query("SELECT * FROM sub_election where election_id = '$electionId'");
        foreach ($records as $record){
            $innerElectionList = array(
                'name' => $record['name'],
                'Id' => $record['Id']
            );
            array_push($subElectionList, $innerElectionList);
        }
        $status = array('successful' => true , 'result' =>$subElectionList );
        $response = $response->withJson($status,200);
    }else{
        $status = array('successful' => false , 'reason' => "لطفا مجددا وارد شوید" );
        $response = $response->withJson($status,400);
    }

    return $response;
});

$app->get('/electionList', function (Request $request, Response $response, array $args) {
    $params = $request->getQueryParams();
    $studentId = $params["studentId"];
    $token = $params["token"];
    if (is_authenticated($studentId,$token)){
        $electionList = array();
        $db = Db::getInstance();
        $records = $db->query("SELECT * FROM election");
        foreach ($records as $record){
            $innerElectionList = array(
                'Id' => $record['Id'],
                'Election_name' => $record['Election_name']
            );
            array_push($electionList, $innerElectionList);
        }
        $status = array('successful' => true , 'result' =>$electionList );
        $response = $response->withJson($status,200);
    }else{
        $status = array('successful' => false , 'reason' => "لطفا مجددا وارد شوید" );
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
