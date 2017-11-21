<html>
<head>
  <meta charset="utf-8">
  <title>登録</title>
  <link rel="stylesheet" type="text/css" href="ms.css">
</head>
<body>
  <form action="ms6.php" method="post">
  <div>
    ユーザー情報を登録してください。<br /><br />
    &emsp;&emsp;ID&emsp;&emsp; :
    <input type="text" name="name" size="30" value="" /><br />
    パスワード :
    <input type="text" name="pass" size="30" value="" /><br />
    <br />
    <input type="submit" name="submit" value="登録" />
  </div>
  </form>
</body>
</html>


<?php
  //データベース接続
  $dsn ='mysql:host=localhost;dbname=dbname';
  $user = 'user';
  $pas = 'pass';
  $pdo = new PDO($dsn, $user, $pas);

  //未入力処理
  if (isset($_POST['submit'])){
    if( $_POST['name']=="" ) {
      echo "名前が入力されていません。";
      exit();
    }
    if( $_POST['pass']=="" ) {
      echo "パスワードが入力されていません。";
      exit();
    }
  }

  $gtoken = $_GET['token'];
  $name = $_POST['name'];
  $pass = $_POST['pass'];

  //ユーザー情報書き込み
  if (isset($_POST['submit'])){
    $ins = "INSERT INTO db5 (name,pass) VALUES(:name,:pass)";
    $stmt = $pdo -> prepare($ins);
    $stmt->execute( array(':name'=>$name, ':pass'=>$pass) );

    @session_start();
    $_SESSION['id'] = $name;
    header('Location: ms2.php');
  }

?>
