<!doctype html>
<html>
<head>
<title>Grep Me!</title>
<link href="media/modern.css" rel="stylesheet">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){				
                $("#text").ajaxStart(function(e) {
                  $(this).addClass('autocomplete-loading');
                });
                $("#text").ajaxStop(function(e) {
                  $(this).removeClass('autocomplete-loading');
                });               
                $("#go").click(function(){
                   var textarea = $("#text").val();
                   var RegBox 	= $("#cheker_i").prop("checked");
                   var iBox 	= $("#cheker_reg").prop("checked");
                   $("#result").empty();
                   
                   $.ajax({
					    type: "POST",
					    url: "libs/ajax.php",
					    data: {znach: textarea, box_reg: RegBox, box_i: iBox},
					    success: function(data) {
					        $("#result").append(data).hide().show("slow");
					    }
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
    <div style="margin-top: 100px; border: 2px solid grey; border-radius: 15px; width: 900px; padding-top: 9px;">
        <form method="post" action="" class="input-control text">
            <input type="checkbox" id="cheker_reg" name="box_reg">
            <lable>-E</lable>
            <input type="checkbox" id="cheker_i" name="box_i">
            <lable>-i</lable>
            <input type="text" id="text" name="znach" size="95">
            <input id="go" type="submit" value="grep">
        </form>
        <span class="load"></span>
        <div style="width: 880px; height: 500px; display: block; overflow: scroll !important;" id="result"></div>
    </div>
</center>
</body>
</html>