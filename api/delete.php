<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//initializing api
include_once('../core/initialize.php');

//instantiate post

$post = new Post($db);

//get raw posted data
$data =  json_decode(file_get_contents("php://input"));

$post->id_no = $data->id_no;


//create post
if($post->delete())
{
    echo json_encode(
        array('message' => 'Post Deleted')
    );
}
else{
    echo json_encode(
        array('message' => 'Post Not Deleted')
    );
}






