<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//initializing api
include_once('../core/initialize.php');

//instantiate post

$category = new Category($db);

//blog post query
$result = $category->read();
//get row count
$num = $result->rowCount();

if($num > 0)
{
    $category_arr = array();
    $category_arr['data'] = array();


    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
         extract($row);
         $post_item = array(
             'id' => $id_no,
             'title' => $name_str,
             'subject' => $create_at,
             'status' => $status,
         );
         array_push($category_arr['data'], $post_item);
    }

    //convert to JSON and output
    echo json_encode($category_arr);
}
else
{
    echo json_encode(array('message' => 'No post found'));
}




