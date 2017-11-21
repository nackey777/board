<!--画像表示判定-->

<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>画像表示</title>
<link rel="stylesheet" type="text/css" href="ms.css">
</HEAD>
<BODY>
  <FORM method="POST" action="ms11.php">
  <div>
    <?php
    	//データベース接続
    	$dsn ="mysql:host=localhost;dbname=dbname";
    	$user = "user";
    	$pass = "pass";
    	$pdo = new PDO($dsn, $user, $pass);

    	$id = $_POST['id'];
      //拡張子判定
      $sql = "SELECT * FROM db3 ORDER BY id";
      $stmt = $pdo -> query($sql);
      foreach ($stmt as $row) {
        if($row['id']==$id){
          $ext .= $row['ext'];
        }
      }


      if (count($_POST) > 0 && isset($_POST["submit"])){
        $id = $_POST["id"];
        if ($id==""){
          print("番号が入力されていません。<BR>\n");
        } else {
          if($ext == "jpg"){
            print("<img src=\ms12.php?id=" . $id . "\">");
          }
    			if($ext == "mp4"){
    				print("<video src=\"ms12.php?id=" . $id . "\">");
    			}
        }
    	}

    ?>
  <P>画像の表示</P>
  画像番号：<INPUT type="text" name="id" />
  <INPUT type="submit" name="submit" value="送信" />
  <BR><BR>
  </div>
  </FORM>
</BODY>
</HTML>
