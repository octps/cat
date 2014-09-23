<?php
    require("lib/root.php");
?>

<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>cat</title>
  <!-- <link href="css/base.css" rel="stylesheet"> -->
  <meta name="keywords" content="">
  <meta name="description" content="">
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
  <script type="text/javascript">
    function initialize() {

        navigator.geolocation.getCurrentPosition(
          function(position){
            myPosition = {
              latitude : position.coords.latitude,
              longitude : position.coords.longitude
            };
            window.drawMap(myPosition);
          }
        );

        window.drawMap = function (myPosition) {
          //現在地
          var latlng = new google.maps.LatLng(myPosition.latitude, myPosition.longitude); 
          var myOptions = { 
            zoom: 14,
            center: latlng, 
            mapTypeId: google.maps.MapTypeId.SATELLITE
          }; 
          var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
          var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: '現在地'
            });
          //現在地

          <? foreach($images as $iamge): ?>
            var myLatlng = new google.maps.LatLng(<?= $iamge->geo_lat ?>, <?= $iamge->geo_long ?>);

            var iconSize = 80;

            var icon = new google.maps.MarkerImage('<?= $iamge->path ?>',
              new google.maps.Size(iconSize,iconSize),
              new google.maps.Point(0,0),
              new google.maps.Point(19,51),
              new google.maps.Size(iconSize,iconSize)
            );
            var marker1 = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: icon
            });
          <? endforeach ?>


        }

    }

  </script>

</head>
<body onload="initialize()">

<header>
cat
</header>
<div class="body">
    <form action="/" method="post" enctype="multipart/form-data">
        <input name="title" type="text" value="">
        <input name="image" type="file" value="">
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