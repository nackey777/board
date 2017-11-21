<!--編集-->
<?php
  @session_start();
  $cNum = $_SESSION['cNum'];
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>編集</title>
    <link rel="stylesheet" type="text/css" href="ms.css">
  </head>
  <body>
    <form action="ms9.php" method="post">
    <div>
      <input type="hidden" name="cNum" value="<?php echo $dNum; ?>" /><br />
      編集番号 : <?php echo 'No.'.$cNum; ?><br />

      <?php
        //データベース接続
        $dsn ="mysql:host=localhost;dbname=dbname";
        $user = "user";
        $pass = "pass";
        $pdo = new PDO($dsn, $user, $pass);

        $sql = "SELECT * FROM db2";
        $stmt = $pdo -> query($sql);
        foreach ($stmt as $row) {
          if( $cNum == $row['id'] ){
            $DBnum .= $row['id'];
            $DBid .= $row['name'];
            $DBcom .= $row['com'];
          }
        }
        echo "<br />id:".$DBid."<br />".$DBcom."<br />";
      ?>

      <br />
      この内容を編集してよろしければ、
      以下に編集内容とパスワードを入力してください。<br /><br />
      編集コメント:<br />
      <textarea name="comment" cols="30" rows="5"></textarea>
      <?php
        if (isset($_POST['submit'])){
          if($_POST['comment'] == ""){
            echo "編集コメントが入力されていません。";
          }
        }
      ?><br />
      パスワード :<br />
      <input type="text" name="dpass" size="30" value="" /><br />
      <input type="submit" name="submit" value="編集" /><br /><br />
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
            $sql = "update db2 set com=:com where id=:id";
            $stmt = $pdo -> prepare($sql);
            $params = array(':com'=>$_POST['comment'], ':id'=>$cNum);
            $stmt -> execute($params);
            session_start();
            unset($_SESSION['cNum']);
            header( "Location: ms10.php");
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
