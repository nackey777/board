<html>
<head>
  <meta charset="utf-8">
  <title>新規登録</title>
  <link rel="stylesheet" type="text/css" href="ms.css">
</head>
<body>
  <form action="ms3.php" method="post">
    <div>
    <h1>新規登録</h1>
    メールを送信します。<br />
    以下にメールアドレスを入力してください。<br /><br />

    メールアドレス :
    <input type="text" name="mail" size="30" value="" /><br />
    <?php
      if (isset($_POST['submit'])){
        if($_POST['mail'] == ""){
          echo "メールアドレスが入力されていません。";
        }
      }
    ?>
    <br />
    <input type="submit" name="submit" value="登録" />

    if(isset($_POST['submit'])){
      if($_POST['mail'] !== ""){
        echo "仮登録が完了しました。<br />
        本登録のメールを送信しました。<br />
        24時間以内にメールに記載されたURLからご登録下さい。";
      }
    }
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

if(isset($_POST['submit'])){
  if($_POST['mail'] !== ""){
    try{
      //入力値
      $mail = $_POST['mail'];
      $token = uniqid(rand(),1);
      $date = strtotime("now");

      //DBへ登録
      $ins = "INSERT INTO db4 (mail,token,date) VALUES(:mail,:token,:date)";
      $stmt = $pdo -> prepare($ins);
      $stmt->execute( array(':mail'=>$mail, ':token'=$token, ':date'=>$date) );

      //メール送信
      mb_language("Japanese");
      mb_internal_encoding("UTF-8");
      $url = "ms5.php"."?token=".$token;
      $to      = $mail;
      $subject = 'ユーザー登録';
      $message =
      '仮登録ありがとうございます！'. "\r\n".
      '24時間以内に下記のURLから本登録をお願いします。'. "\r\n"."\r\n".$url;
      $header="From: " .mb_encode_mimeheader("掲示板");

      if(isset($_POST['submit'])){
        mb_send_mail($to, $subject, $message, $header);
        echo "送信しました。";
      }

    } catch (PDOException $e){
        print('Error:'.$e->getMessage());
        $errors['error'] = "データベース接続失敗しました。";
    }

  }
}
?>
