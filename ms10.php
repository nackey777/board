<!--編集完了-->
<html>
<head>
  <meta charset="utf-8">
  <title>編集完了</title>
  <link rel="stylesheet" type="text/css" href="ms.css">
</head>
<body>
  <form action="ms10.php" method="post">
  <div>
    編集が完了しました。<br />
    <input type="submit" name="back" value="戻る" /><br /><br />
    <?php
      //データベース接続
      $dsn ="mysql:host=localhost;dbname=dbname";
      $user = "user";
      $pass = "pass";
      $pdo = new PDO($dsn, $user, $pass);

      $sql = "SELECT * FROM db2 ORDER BY id";
      $stmt = $pdo -> query($sql);
      foreach ($stmt as $row) {
        echo 'No.'.$row['id'].'   name:'.$row['name'].'<br>'.$row['com'];
        echo '<br>';
      }
    ?>
    <input type="submit" name="back" value="戻る" />
  </div>
  </form>
</body>
</html>


<?php
  if(isset($_POST['back'])){
    header( "Location: ms2.php");
  }
?>
