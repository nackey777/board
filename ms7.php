<!--削除-->
<?php
  @session_start();
  $dNum = $_SESSION['dNum'];
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>削除</title>
    <link rel="stylesheet" type="text/css" href="ms.css">
  </head>
  <body>
    <form action="ms7.php" method="post">
    <div>
      <input type="hidden" name="dNum" value="<?php echo $dNum; ?>" /><br />
      削除番号 : <?php echo 'No.'.$dNum; ?><br />

      <?php
        //データベース接続
        $dsn ="mysql:host=localhost;dbname=dbname";
        $user = "user";
        $pass = "pass";
        $pdo = new PDO($dsn, $user, $pass);

        $sql = "SELECT * FROM db2";
        $stmt = $pdo -> query($sql);
        foreach ($stmt as $row) {
          if( $dNum == $row['id'] ){
            $DBnum .= $row['id'];
            $DBid .= $row['name'];
            $DBcom .= $row['com'];
          }
        }
        echo "<br />id:".$DBid."<br />".$DBcom."<br />";
      ?>

      <br />
      この内容を削除してよろしければ、
      以下にパスワードを入力してください。
      <br />
      パスワード :<br />
      <input type="text" name="dpass" size="30" value="" /><br />
      <input type="submit" name="submit" value="削除" /><br /><br />
      <input type="submit" name="back" value="戻る" />
      <?php
        $dp = 1;

        if(isset($_POST['submit'])) {
          if($_POST['dpass']==""){
            exit ("パスワードが入力されていません。");
          }

          $sql = "SELECT * FROM db5";
          $stmt = $pdo -> query($sql);
          foreach ($stmt as $row) {
            if( $_POST['dpass'] == $row['pass'] ){
              $dp = 2;
            }
          }

          if($dp == 1) {
            exit("パスワードが違います。");
          }
          if($dp == 2) {
            $sql = "delete from db2 where id=:id";
            $stmt = $pdo -> prepare($sql);
            $params = array(':id'=>$dNum);
            $stmt -> execute($params);
            session_start();
            unset($_SESSION['dNum']);
            header( "Location: ms8.php");
          }
        }
      ?>
    </div>
    </form>
  </body>
</html>



<?php
  if(isset($_POST['back'])){
    header( "Location: ms2.php");
  }
?>
