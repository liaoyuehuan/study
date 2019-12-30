<html>
<body>
<form action="../server_request.php?version=2" method="post" enctype="multipart/form-data">
    <div>
        <input name="username" type="text" value="xiaoliao"/>
    </div>
    <div>
        <input name="file" type="file" value="选择文件">
    </div>
    <div>
        <input name="file2[]" type="file" value="选择文件">
    </div>
    <div>
        <input type="submit" value="提交">
    </div>
</form>
</body>
</html>