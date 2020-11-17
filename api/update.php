<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//initializing api
include_once('../core/initialize.php');

//instantiate post

$post = new Post($db);

//get raw posted data
$data =  json_decode(file_get_contents("php://input"));

$post->id_no = $data->id_no;
$post->title_str = $data->title;
$post->body_str = $data->body;
$post->author_str = $data->author;
$post->category_id = $data->category_id;

//create post
if($post->update())
{
    echo json_encode(
        array('message' => 'Post Updated')
    );
}
else{
    echo json_encode(
        array('message' => 'Post Not Updated')
    );
}






