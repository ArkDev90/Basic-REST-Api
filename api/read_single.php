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

$post->id = isset($_GET['id']) ? $_GET['id'] : die();

$post->readOne();

$post_arr = array(
    'id'=>$post->id_no,
    'title'=>$post->title_str,
    'body'=>$post->body_str,
    'author'=>$post->author_str,
    'category_id'=>$post->category_id,
    'category_name'=>$post->category_name_str
);

print_r(json_encode($post_arr));



