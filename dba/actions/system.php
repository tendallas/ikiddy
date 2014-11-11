
<html>
<head>
<title>Terminal</title>
<link href="media/modern.css" rel="stylesheet">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.load').ajaxStart(function(e) {
                  $(this).addClass('autocomplete-loading');
                });
                $('.load').ajaxStop(function(e) {
                   $(this).removeClass('autocomplete-loading');
                });               
                $("#go").click(function(){
                   var textarea = $("#text").val();
                   $("#result").empty();
                    $.post("libs/ajax.php", {system: textarea}, function(data){
                       $("#result").append(data).show("slow"); 
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
<center>
    <div style="margin-top: 100px; border: 1px solid; width: 500px; padding-top: 9px;">
        <form method="post" action="" class="input-control text">
            <input type="text" id="text" name="system" size="40">
            <input id="go" type="submit" value=" Выполнить ">
        </form>
        <span class="load"></span>
        <div style="display: none; width: 480px; height: 500px; display: block; overflow: scroll;" id="result"></div>
    </div>
</center>
</body>
</html>