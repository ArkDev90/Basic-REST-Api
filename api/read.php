<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//initializing api
include_once('../core/initialize.php');

//instantiate post

$post = new Post($db);

//blog post query
$result = $post->read();
//get row count
$num = $result->rowCount();

if($num > 0)
{
    $post_arr = array();
    $post_arr['data'] = array();


    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
         extract($row);
         $post_item = array(
             'id' => $track_no,
             'title' => $title,
             'subject' => html_entity_decode($subject),
             'category' => $category,
             'status' => $status,
             'date' => $date
         );
         array_push($post_arr['data'], $post_item);
    }

    //convert to JSON and output
    echo json_encode($post_arr);
}
else
{
    echo json_encode(array('message' => 'No post found'));
}




