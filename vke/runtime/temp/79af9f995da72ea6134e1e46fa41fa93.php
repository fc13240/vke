<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"E:\phpStudy\PHPTutorial\WWW\vke\public/../application/admin\view\test\ajaxReturn.html";i:1512107821;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
</body>
<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script>
    $.ajax({
        url:'http://192.168.1.101/manager/Rule/doAdduser',
        type:'post',
        dataType:'json',
        data:{group_id:1,admin_id:3},
        success:function(data){
            console.log(data);
        }
    });
</script>
</html>