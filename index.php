<?php
    require("lib/root.php");
?>

<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>cat</title>
  <link href="css/base.css" rel="stylesheet">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>

  <script type="text/javascript">
    function initialize() { 
        var latlng = new google.maps.LatLng(<?= $mapValue[0] ?>, <?= $mapValue[1] ?>); 
        var myOptions = { 
          zoom: 18,
          center: latlng, 
          mapTypeId: google.maps.MapTypeId.SATELLITE
        }; 
        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); 

        var myLatlng = new google.maps.LatLng(<?= $mapValue[0] ?>, <?= $mapValue[1] ?>);
        var icon = new google.maps.MarkerImage('<?= $path ?>',
          new google.maps.Size(73,51),
          new google.maps.Point(0,0),
          new google.maps.Point(19,51)
        );
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            icon: icon
        });

    }


    // google.maps.event.addDomListener(window, 'load', function() {
    //   var map = document.getElementById("gmap");
    //   var options = {
    //     zoom: 18,
    //     center: new google.maps.LatLng(<?= $mapValue[0] ?>, <?= $mapValue[1] ?>),
        
    //     mapTypeId: google.maps.MapTypeId.SATELLITE
    //   };
    //   new google.maps.Map(map, options);
    // });
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