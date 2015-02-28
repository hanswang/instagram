<?php
require_once "./util.php";
global $_POST;

$keyword = trim($_POST['q']);
$token = trim($_POST['token']);

$data = loadApiCalls($keyword, $token);
$users = $data['user'];
$medias = $data['media'];

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Search Result Listing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <hr>
        <div id="item" class="row">
        </div>

        <footer>
            <p>Hans Wang Demo 2015</p>
        </footer>

    </div> <!-- /container -->

    <script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/underscore-min.js"></script>
    <script type="text/javascript">
        var users = <?php echo json_encode($users, JSON_HEX_APOS);?>;
        var medias = <?php echo json_encode($medias, JSON_HEX_APOS);?>;
        var keyword = '<?php echo $keyword; ?>';
        var token = '<?php echo $token; ?>';
    </script>
    <script type="text/javascript" src="js/result-rotator.js"></script>
</body>
</html>
