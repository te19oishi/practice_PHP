<html>
<head><title>kadai3</title></head>
<body>

<form action="./kadai3.php" method="post">
件名: <input type="text" size="20" name="subject"><br />
名前: <input type="text" size="20" name="name"><br />
本文: <br />

<textarea rows="5" cols="70" name="main"></textarea><br />
<input type="submit" value="OK">
</form>
<?php
// $debug_flag = 0; //デバッグ用
// if ($debug_flag) { echo "デバッグモードです<br />\n"; }

mb_language("Japanese"); // 言語指定
mb_internal_encoding("UTF-8"); // 文字コード指定
$mailto = "te19oishi@g.kumamoto-nct.ac.jp"; // (宛先、各自自分のアドレス)
$mailfrom = $_POST['name'];//"te19oishi@g.kumamoto-nct.ac.jp"; // (送信元、各自自分のアドレス)
if (count($_POST) == 0) {
  echo "すべてのフィールドに入力してください。<br />\n";
}
if (!(count($_POST) == 0)){
//   if ($debug_flag) {
//   echo "件名: " . $_POST['subject'] . "<br />\n";
//   echo "本文: " . $_POST['main'] . "<br />\n";
/*}else if */if($_POST['subject']&&$_POST['name']&&$_POST['main']){
$write_data=$_POST['subject'] .",".$_POST['name'] .",".$_POST['main'] ."\n";
if(file_exists("./boarddata.txt")&&(mb_send_mail($mailto, $_POST['subject'], $_POST['main'], "From: $mailfrom"))){
  $filepointer=fopen("./boarddata.txt","a");
  fwrite($filepointer,$write_data);
  fclose($filepointer);
  echo("<hr><p>メール送信に成功しました!</p><hr>");
}else{
  echo 'error';
}
  } else { echo("<hr>件名、名前、本文は必ず入力してください。<hr>"); }
}
if(file_exists ("./boarddata.txt")) {
    $filepointer=fopen("./boarddata.txt", "r");
    while(!feof ($filepointer) ) {
    $aline = fgets($filepointer);
      $aline = preg_replace("/(\r?\n)+$/","",$aline);
        // 「正規表現」を使って、マッチする文字列を置換している
        // "/(\r?\n)+$/" にマッチする \r\n を "" に置換している
        // 改行コードは3種類あるので、すべて当てはまるような正規表現にしている
        // （Windows: CR+LF（\r\n）、昔のMac：CR（\r）、Unix/Linux：LF（\n）
      if($aline==null) continue;
    
    $list = explode(",", $aline);
    echo "<p>件名:$list[0]<br>記入者:$list[1]<br>本文:$list[2]</p><hr>";
    }
    fclose ($filepointer) ;
    }
    else { echo "error. "; }

  ?>
  
</body>
</html>