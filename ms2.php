<!--掲示板-->
<?php
  // セッション開始
  @session_start();
  // ログインしていれば掲示板に遷移
  if (!isset($_SESSION['id'])) {
      header('Location: ms1.php');
      exit;
  }

?>


<html>
<head>
  <meta charset="utf-8">
  <title>掲示板</title>
  <link rel="stylesheet" type="text/css" href="ms.css">
</head>
<body>
  <form action="ms2.php" method="post">
    <div>
      <?php
        echo "こんにちは ".$_SESSION['id']." さん    ";
      ?>  &emsp;&emsp;
      <input type="submit" name="logout" value="ログアウト" />
    </div>
    <div>
    コメント<br />
    <textarea name="comment" cols="30" rows="5"></textarea><br />
    <?php
      if (isset($_POST['submit'])){
        if($_POST['comment'] == ""){
          echo "コメントが入力されていません。";
        }
      }
    ?><br />
    <input type="submit" name="submit" value="送信" />
    <br /><br />


    削除番号 :
    <input type="text" name="dNum" size="30" value="" />
    <input type="submit" name="delete" value="削除" />
    <?php
      if (isset($_POST['delete'])){
        if($_POST['dNum'] == ""){
          echo "<br />"."削除番号が入力されていません。";
        } else {
          $_SESSION['dNum'] = $_POST['dNum'];
          header( "Location: ms7.php");
        }
      }
    ?>
    <br /><br />

    編集番号 :
    <input type="text" name="cNum" size="30" value="" />
    <input type="submit" name="change" value="編集" />
    <?php
      if (isset($_POST['change'])){
        if($_POST['cNum'] == ""){
          echo "<br />"."編集番号が入力されていません。";
        } else {
          $_SESSION['cNum'] = $_POST['cNum'];
          header( "Location: ms9.php");
        }
      }
    ?>
    <br /><br />

    画像(jpgのみ)・動画(mp4のみ)<br />
    <INPUT type="hidden" name="MAX_FILE_SIZE" value="65536">
    <input type="file" name="upfile" size="30" value="" />
    <input type="submit" name="upload" value="アップロード" />
    <br /><br />

    投稿された画像を見る場合、以下のボタンを押してください。<br />
    <input type="submit" name="video" value="画像・動画を見る" />
    <?php
      if (isset($_POST['video'])){
          header( "Location: ms11.php");
      }
    ?><br /><br />
  </div>
  </form>
</body>
</html>


<!--投稿内容の表示-->
<div>
  <?php
    //データベース接続
    $dsn ="mysql:host=localhost;dbname=dbname";
    $user = "user";
    $pass = "pass";
    $pdo = new PDO($dsn, $user, $pass);

    if (isset($_POST['submit'])){
      header( "Location: ms2.php");
    } else {
      $sql = "SELECT * FROM db2 ORDER BY id DESC";
      $stmt = $pdo -> query($sql);
      foreach ($stmt as $row) {
        echo 'No.'.$row['id'].'   name:'.$row['name'].'<br>'.$row['com'];
        echo '<br>';
      }
    }

  ?>
</div>


<!--送信-->
<?PHP
  if(isset($_POST['submit'])){
    if($_POST['comment'] != ""){
      $cid = $_SESSION['id'];
      $com = $_POST['comment'];

      try{
        $ins = "INSERT INTO db2 (name,com) VALUES(:name,:com)";
        $stmt = $pdo -> prepare($ins);

        $array = array($cid=>$com);
        foreach( $array as $key=>$val ) {
          $stmt->execute( array(':name'=>$key, ':com'=>$val));
        }

      } catch (PDOException $e){
        print('Error:'.$e->getMessage());
        $errors['error'] = "データベース接続失敗しました。";
      }
    }
  }
?>

<!--画像動画アップロード-->
<?php
  if(isset($_POST['upload'])){
    $upfile = $_FILES["upfile"]["tmp_name"];
    $imgdat = file_get_contents($upfile);
    $imgdat = base64_encode($imgdat);
      if ($upfile==""){
        print("ファイルのアップロードができませんでした。<br />");
      }

    //拡張子判断
    $arr = explode('.',$_FILES['upfile']['name']);
    $ext = end($arr);

    //画像
    if($ext == "jpg"){
      //画像データを入れる
      $sql = "INSERT INTO db3 (img,ext) VALUES (:img,:ext)";
      $stmt2 = $pdo -> prepare($sql);
      $stmt->execute( array(':img'=>$imgdat,':ext'=>$ext) );
      echo "<br />"."アップロードが完了しました。";
    }

    //動画
    if ($ext == "mp4") {
      $sql2 = "INSERT INTO db3 (video,ext) VALUES (:video,:ext)";
      $stmt3 = $pdo -> prepare($sql2);
      $stmt3->execute( array(':video'=>$imgdat,':ext'=>$ext) );
      echo "<br />"."アップロードが完了しました。";
    }


  }
?>


<!--ログアウト-->
<?php
  if (isset($_POST['logout'])){
    session_start();
    unset($_SESSION['id']);
    header( "Location: ms1.php");
  }
?>
