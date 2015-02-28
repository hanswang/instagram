<?php

function callApi($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    $header = array('Accept: application/json', 'X-Target-URI: https://api.instagram.com');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_TIMEOUT, 90);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $jsonData = curl_exec($ch);
    curl_close($ch);

    return json_decode($jsonData, true);
}

function loadApiCalls($keyword, $token, $min_id = false) {
    // user search
    $url = "https://api.instagram.com/v1/users/search?q=" . $keyword . "&count=10&access_token=" . $token;

    $res = callApi($url);

    $users = array();

    if (!empty($res['data'])){
        // parse user data
        $users = $res['data'];
    }

    // tag search - step 1
    $url = "https://api.instagram.com/v1/tags/search?q=" . $keyword . "&access_token=" . $token;

    $res = callApi($url);

    $firstTag = '';

    if (!empty($res['data'])) {
        // get first tag out of many
        $firstTag = $res['data'][0]['name'];
    }
    // tag search - step 2
    $url = "https://api.instagram.com/v1/tags/". $firstTag ."/media/recent?count=10" . ($min_id ? "&min_tag_id=" .$min_id : "") . "&access_token=" . $token;

    $res = callApi($url);

    $medias = array();

    if (!empty($res['data'])) {
        $medias = $res['data'];
    }

    return array('user' => $users, 'media' => $medias);
}