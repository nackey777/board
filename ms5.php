<html>
<head>
  <meta charset="utf-8">
  <title>本登録</title>
</head>
<body>
  <form action="ms5.php" method="post">
      <?php
        //データベース接続
        $dsn ='mysql:host=localhost;dbname=dbname';
        $user = 'user';
        $pas = 'pass';
        $pdo = new PDO($dsn, $user, $pas);

        if(empty($_GET)){
          exit("不正アクセスです。");
        } else {
          $gtoken = $_GET['token'];
          $sql = "SELECT * FROM db4";
          $stmt = $pdo -> query($sql);
          foreach ($stmt as $row) {
            if($gtoken == $row['token']){
              if($row['flag']==0){
                $date = $row['date'];
                $now = strtotime("now");
                $time = time_diff($date,$now);
                if(!$time==0){
                  exit("24時間を超えました。\n再度、仮登録をお願いします。");
                }else{
                  $id = $row['id'];
                  $ins = $sql = "UPDATE db4 SET flag=:flag WHERE id=:id";
                  $stmt = $pdo -> prepare($sql);
                  $params = array(':flag'=>1, ':id'=>$id);
                  $stmt -> execute($params);
                  $url = "ms6.php"."?token=".$gtoken;
                  header('Location:'.$url);
                }
              }
            }
          }

        }
      ?>
  </form>
</body>
</html>

<?php
  //時間差
  function time_diff($time_from, $time_to) {
        // 日時差を秒数で取得
        $dif = $time_to - $time_from - 32400;
        // 時間単位の差
        $dif_time = date("H:i:s", $dif);
        // 日付単位の差
        $dif_days = (strtotime(date("Y-m-d", $dif)) - strtotime("1970-01-01")) / 86400;
        //return "{$dif_days}days {$dif_time}";
        return "{$dif_days}";
  }
?>
