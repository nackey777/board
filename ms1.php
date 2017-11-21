<!--ログイン-->
<?php
  // セッション開始
  @session_start();
  // ログインしていれば掲示板に遷移
  if (isset($_SESSION['id'])) {
      header('Location: ms2.php');
      exit;
  }

?>

<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="ms.css">
  <title>ログインフォーム</title>
</head>
<body>
  <form action="ms1.php" method="post">
    <div>
    <h1>ログイン</h1>
    &emsp;&emsp;ID&emsp;&emsp;:<input type="text" name="lid" size="30" value="" /><br />
    <?php
      if(isset($_POST['login'])){
        $lid = $_POST['lid'];
        if('' == $lid){ echo "IDを入力してください。"; }
        else if(isset($_POST['login'])){
          if(!$DBid){ echo "ユーザーIDが間違っています。"; }
        }
      }
    ?><br />
    パスワード :<input type="text" name="lpass" size="30" value="" /><br />
    <?php
      if(isset($_POST['login'])){
        $lpass = $_POST['lpass'];
        if('' == $lpass){ echo "パスワードを入力してください。"; }
        else if(isset($_POST['login'])){
          if (!$DBpass){ echo "パスワードが間違っています。"; }
        }
      }
    ?>
    <br />
    <input type="submit" name="login" value="ログイン" /><br />
    <br />
    <input type="submit" name="new" value="新規登録" />
    </div>
  </form>
</body>
</html>

<?php
  //データベース接続
  $dsn ="mysql:host=localhost;dbname=dbname";
  $user = "user";
  $pass = "pass";
  $pdo = new PDO($dsn, $user, $pass);

  if(isset($_POST['new'])){
    header( "Location: ms3.php" ) ;
  }

  //未入力
  if('' == $lid){
    exit;
  }else if('' == $lpass){
    exit;
  }


  if(isset($_POST['login'])){
    $sql = "SELECT * FROM db1";
    $stmt = $pdo -> query($sql);

    foreach ($stmt as $row) {
      if( $lid == $row['id']){
        $DBid .= $row['id'];
        if( $lpass == $row['pass']){
          $DBpass .= $row['pass'];
          $_SESSION['id'] = $DBid;
          header( "Location: ms2.php" ) ;
        }
      }
    }

    //入力ミス
    if(!$DBid){
      exit;
    }else if(!$DBpass){
      exit;
    }

  }
?>
