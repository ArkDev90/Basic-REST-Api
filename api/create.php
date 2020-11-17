<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//initializing api
include_once('../core/initialize.php');

//instantiate post

$post = new Post($db);

//get raw posted data
$data =  json_decode(file_get_contents("php://input"));

$post->title_str = $data->title;
$post->body_str = $data->body;
$post->author_str = $data->author;
$post->category_id = $data->category_id;


$sql = "select group_id from tbl_accounts inner join tbl_indi_grouping on  tbl_accounts.id_no = tbl_indi_grouping.account_id where individual_id = $icurrentindiid";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);
if ($count > 1) {
    $nocount = 0;
    while ($row = mysqli_fetch_array($result)) {
        $nocount += 1;
        if ($nocount == $count) {
            $gsearchstr .= " individual_id = ".$row['group_id'];
        } else {
            $gsearchstr .= " individual_id = ".$row['group_id']." or ";
        }
    }
} else {
    while ($row = mysqli_fetch_array($result)) {
        $gsearchstr = " individual_id = ".$row['group_id'];
    }
}

echo(mysqli_error($conn));

$sql = "select id_no, history_type, track_no, date, subject, deadline, GROUP_CONCAT(CONCAT('<b class=\'green-theme\'>',individual,'</b>') SEPARATOR ' and ') as individual, GROUP_CONCAT(CONCAT('<b>',indigroup,'</b>') SEPARATOR ' and ') as indigroup, agency, uploader, remarks, file_id from (SELECT tbl_file_group.id_no, tbl_file_group.deadline, tbl_history.type as history_type, tbl_file_group.track_no, tbl_history.date, tbl_file_group.subject,  IFNULL(tbl_individual.name, 'Everyone') as individual, IFNULL(tbl_indi_group.initials, 'None') as indigroup, tbl_agencies.agency_name as agency, tbl_uploader.name as uploader, remarks, tbl_history.file_id  FROM tbl_history inner join tbl_file_group on tbl_file_group.id_no = tbl_history.file_group_id left join tbl_individual on tbl_history.individual_id = tbl_individual.id_no left join tbl_indi_group on tbl_history.individual_id = tbl_indi_group.id_no left join tbl_agencies on tbl_individual.agency_id = tbl_agencies.id_no inner join tbl_individual as tbl_uploader on tbl_history.uploader_id = tbl_uploader.id_no where  (individual_id = $icurrentindiid or individual_id = 0 or uploader_id = $icurrentindiid or ((tbl_history.type = 9 or tbl_history.type = 10) and ($gsearchstr)) ) and tbl_file_group.status <> -1 and tbl_history.status <> -1 order by tbl_history.id_no desc,type desc, date desc) as tbl_main group by remarks,date order by date desc limit 30";
$result = mysqli_query($conn, $sql);




//create post
if($post->create())
{
    echo json_encode(
        array('message' => 'Post Created')
    );
}
else{
    echo json_encode(
        array('message' => 'Post Not Created')
    );
}






