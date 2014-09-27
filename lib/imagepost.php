<?php
  include_once(dirname(__FILE__)."/Db.php");
  $dbh = \Db::getInstance();

  if(isset($_FILES['image']['error']) && is_int($_FILES['image']['error'])) {
    try {
      switch ($_FILES['image']['error']) {
        case UPLOAD_ERR_OK: // OK
          break;
        case UPLOAD_ERR_NO_FILE:   // ファイル未選択
          throw new RuntimeException('ファイルが選択されていません');
        case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
        case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過
          throw new RuntimeException('ファイルサイズが大きすぎます');
        default:
          throw new RuntimeException('その他のエラーが発生しました');
      }

      if (!in_array(
        $type = @exif_imagetype($_FILES['image']['tmp_name']),
        array(
          IMAGETYPE_GIF,
          IMAGETYPE_JPEG,
          IMAGETYPE_PNG,
        ),
        true
      )) {
          throw new RuntimeException('画像形式が未対応です');
      }

      $filename = sha1($_FILES['image']['tmp_name'] . date( "Y/m/d (D) H:i:s", time() ) . rand());

      if (!move_uploaded_file(
        $_FILES['image']['tmp_name'],
        $path = sprintf('../images/%s%s',
              $filename,
              image_type_to_extension($type)
        )
      )) {
          throw new RuntimeException('ファイル保存時にエラーが発生しました');
      }

      chmod($path, 0644);
      $msg = array('green', 'ファイルは正常にアップロードされました');
      $exif = exif_read_data($path);
      $mapValue = getGPS ($exif);
      if($mapValue[0] == false || $mapValue[1] == false ) {
        $mapValue[0] = $_POST["lat"];
        $mapValue[1] = $_POST["long"];
      }

      /* DBに登録 */
      $sql = "INSERT INTO images (
        user_id, path, caption, geo_lat, geo_long, width, height, created_at, modifed_at
      ) VALUES (
        1001, :path, 'テスト', :geo_lat, :geo_long, :width, :height, null, now());";
      $stmt = $dbh -> prepare($sql);
      $stmt->bindParam(':path', $path);
      $stmt->bindParam(':geo_lat', $mapValue[0]);
      $stmt->bindParam(':geo_long', $mapValue[1]);
      $stmt->bindParam(':width', $exif['COMPUTED']['Width']);
      $stmt->bindParam(':height', $exif['COMPUTED']['Height']);
      $stmt->execute();

    } catch (RuntimeException $e) {
      $msg = array('red', $e->getMessage());
    }
    header("Location: /");
  }

  function getGPS ($exif) {
    if(empty($exif['GPSLatitude'][0]) === false) {
      $GPSLatitude0 = intval(str_replace('/1', '', $exif['GPSLatitude'][0]));
      $GPSLatitude1 = intval(str_replace('/1', "", $exif['GPSLatitude'][1])) / 60;
      $GPSLatitude2 = $exif['GPSLatitude'][2] / 100 / 60 / 60;
      $GPSLatitude = $GPSLatitude0 + $GPSLatitude1 + $GPSLatitude2;

      $GPSLongitude0 = intval(str_replace('/1', '', $exif['GPSLongitude'][0]));
      $GPSLongitude1 = intval(str_replace('/1', "", $exif['GPSLongitude'][1])) / 60;
      $GPSLongitude2 = $exif['GPSLongitude'][2] / 100 / 60 / 60;
      $GPSLongitude = $GPSLongitude0 + $GPSLongitude1 + $GPSLongitude2;
      $GPS[0] = $GPSLatitude;
      $GPS[1] = $GPSLongitude;

      return $GPS;
    }
    return false;
  }

?>
