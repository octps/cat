<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>cat</title>
  <!-- <link href="css/base.css" rel="stylesheet"> -->
  <meta name="keywords" content="">
  <meta name="description" content="">
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="js/cat.js"></script>

</head>
<body onload="initialize()">

<header>
cat
</header>
<div class="body">

    <form id="imageform" action="/lib/imagepost.php" method="post" enctype="multipart/form-data" onsubmit="geoPost(); return false;">
        <input name="title" type="text" value="">
        <input type="file" name="image" accept="image/*">
        <input type="hidden" name="lat" value="">
        <input type="hiddne" name="long" value="">
        <!-- <input name="image" type="file" value=""> -->
        <input type="submit" value="送信">
    </form>
    <div id="map_canvas" style="width : 500px; height : 500px;">
    </div>
</div>
<footer class="container">
    footer
</footer>
</body>
</html>