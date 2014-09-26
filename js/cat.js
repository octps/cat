function initialize() {

    navigator.geolocation.getCurrentPosition(
      function(position){
        myPosition = {
          latitude : position.coords.latitude,
          longitude : position.coords.longitude
        };
        window.myMapPosition(myPosition);
      }
    );

    window.myMapPosition = function(myPosition) {

      //現在地
      var latlng = new google.maps.LatLng(myPosition.latitude, myPosition.longitude); 
      var myOptions = { 
        zoom: 14,
        center: latlng, 
        mapTypeId: google.maps.MapTypeId.SATELLITE
      }; 
      window.map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
      var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: '現在地'
        });
      window.drawPosting();
    }
      //現在地

    window.drawPosting = function() {
      $.ajax({
        url: './lib/root.php',
        dataType: "json",
        cache: false,
        success: function(data){
            window.drowingPoting(data);
          },
        error: function(xhr, textStatus, errorThrown){
              console.log("error");
              console.log(errorThrown);
          }
        });
    }


    window.drowingPoting = function(postings) {
      var marker = new Array();
      // var href = new Array();
      for (var i = 0; i < postings.length; i++) {

        var myLatlng = new google.maps.LatLng(postings[i]['geo_lat'], postings[i]['geo_long']);
        var iconSize = 80;
        var scaleLong = postings[i]['width'];
        if (postings[i]['height'] > postings[i]['width']) {
          var scaleLong = postings[i]['height'];
        }
        var scale = iconSize / scaleLong;
        var iconHeight = postings[i]['height'] * scale;
        var iconWidth = postings[i]['width'] * scale;

        var icon = new google.maps.MarkerImage(postings[i]['path'],
          new google.maps.Size(iconSize,iconSize),
          new google.maps.Point(0,0),
          new google.maps.Point(19,51),
          new google.maps.Size(iconWidth, iconHeight)
        );
        marker.push(new google.maps.Marker({
            position: myLatlng,
            map: window.map,
            icon: icon
        }));
        var contentString = "<a href='http://google.co.jp/?test=" + i + "'>テスト1</a>";
        var infowindow = new google.maps.InfoWindow({
            content: contentString1
        });
        google.maps.event.addListener(marker[i], 'click', function() {
              infowindow.open(map,marker[i]);
        });
      }
    }


}
