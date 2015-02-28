<?php
require_once "./util.php";

global $_POST;

$keyword = trim($_POST['q']);
$token = trim($_POST['token']);
$min_id = trim($_POST['m']);

$data = loadApiCalls($keyword, $token, $min_id);
$users = $data['user'];
$medias = $data['media'];

if (empty($users) && empty($medias)) {
    echo json_encode(array('status' => 'empty'));
} else {
    echo json_encode($data);
}
