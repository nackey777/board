<?php
  //画像取得
  //データベース接続
  $dsn ="mysql:host=localhost;dbname=dbname";
  $user = "user";
  $pass = "pass";
  $pdo = new PDO($dsn, $user, $pass);

  // クエリの取得
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  } else {
    echo "not id.";
  }

  //拡張子判定
  $sql = "SELECT * FROM ms382 ORDER BY id";
  $stmt = $pdo -> query($sql);
  foreach ($stmt as $row) {
    if($row['id']==$id){
      $ext .= $row['ext'];
    }
  }


  // 画像データ取得
  if($ext == "jpg"){
    $sql2 = "SELECT img FROM db3 WHERE id = '" . $id."'";
    $re = $pdo -> query($sql2);
    foreach ($re as $row) {
      header("Content-Type: image/jpeg");
      //echo $row['img'];
      echo base64_decode($row['img']);
    }
  }

  //動画データ取得
  if ($ext == "mp4") {
    $sql3 = "SELECT video FROM db3 WHERE id = '" . $id."'";
    $ree = $pdo -> query($sql3);
    foreach ($ree as $row) {
      header("Content-Type: video/mp4");
      echo $row['video'];
    }
  }
?>
