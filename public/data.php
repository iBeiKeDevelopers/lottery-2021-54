<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_FILES["file"]["error"] > 0) {
        echo "错误：" . $_FILES["file"]["error"] . "<br>";
    } else {
        $file = file_get_contents($_FILES["file"]["tmp_name"]);
        if (!$file) {
            die('空文件');
        }
        $file = explode("\n", $file, -1);
        $data = array();
        foreach ($file as $i) {
            $i = str_replace("\r", '', $i);
            $i = explode(',', $i); // 防止多列
            $i = $i[0];
            if (strlen($i) == 11) array_push($data, $i);
        }
        $myfile = fopen("./data.json", "w") or die("Unable to open file!");
        fwrite($myfile, json_encode($data));
        fclose($myfile);
        echo 'OK';
    }
    die();
}
?>
<html>
<head>
  <meta charset="utf-8">
  <title>数据上传</title>
</head>
<body>
<form action="data.php" method="post" enctype="multipart/form-data">
  <label for="file">文件名：</label>
  <input type="file" name="file" id="file"><br>
  <input type="submit" name="submit" value="提交">
</form>
</body>
</html>
