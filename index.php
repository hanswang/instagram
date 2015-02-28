<?php

if (isset($_GET['code']) && strlen($_GET['code']) >= 30) {
    // curl post
    $url = 'https://api.instagram.com/oauth/access_token';

    $params = array(
        'client_id' => 'd83b7590410e48a49922d0ad9204ce07',
        'client_secret'   => 'f9431795d8804fe0b162a5bafb807952',
        'grant_type'  => 'authorization_code',
        'redirect_uri' => 'http://debug.hanswang.info/instagram/',
        'code' => $_GET['code']
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    $result = explode("\n\r", $data);
    $resp = json_decode($result[2], true);

    if (isset($resp['code']) && $resp['code'] == 400) {
        HEADER("location: landing.php");
        exit();
    }

    $token = $resp['access_token'];

} else {
    HEADER("location: landing.php");
    exit();
}


?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Instagram Search - Hans Wang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Instagram search.">
    <meta name="author" content="Hans Wang">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <div class="hero-unit">
            <p>This is a demo search, type the search query in the search box below, and HIT "Query" to start!</p>
            <p>
                <form class="form-search" action="./search.php" method="post">
                    <div class="input-append">
                        <input type="text" name="q" class="span6 search-query" style="height:44px;">
                        <input type="hidden" name="token" value="<?php echo $token;?>">
                        <button type="submit" class="btn btn-primary btn-large">Query »</button>
                    </div>
                </form>
            </p>
        </div>

        <hr>
        <footer>
            <p>Demo footer</p>
        </footer>
    </div> <!-- /container -->

    <script src="js/jquery-1.8.0.min.js"></script>
    <script src="js/bootstrap.js"></script>
  
</body>
</html>
