<html>
    <head>
        <title>Change RobotS</title>
        <link href="media/modern.css" rel="stylesheet">
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#sub").click(function(){
                   var textarea = $("#robot").val();
                   $("#result").empty();
                    $.post("libs/ajax.php", {text: textarea}, function(data){
                       $("#result").append(data);
                    }); 
                   return false;
                });
            });
        </script>
    </head>
    <body>
<?php require 'libs/links.php'; 
echo links();
?>
<table width=100%>
    <tr>
<td width=50%>
<?php
$file=$_SERVER['DOCUMENT_ROOT'].'/robots.txt';
if(!file_exists($file)){
    $fp = fopen($file, 'w');
    fwrite($fp, '');
    fclose ($fp);
}
?>
<span id="result"></span>
  <form action="" method="post" class="input-control textarea">
    <p><b>Изменить роботс:</b></p>
    <p><textarea  id="robot" rows="20" cols="60" name="text"><?=file_get_contents($file)?></textarea></p>
    <p><input id="sub" name="rewrite" type="submit" value=" Перезаписать "></p>
  </form>
</td>
</tr>
</table>
</body>
</html>