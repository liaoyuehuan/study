<?php

class TestFFunction
{
    private $file = __DIR__ . '/files/function.txt';

    private $fp;

    public function __construct()
    {
        $this->fp = fopen($this->file, 'w+');
    }

    public function testStat()
    {
        [
            'size' => 2, # 文件大小
            'atime' => 1576245669, # 访问时间戳
            'ctime' => 1576246191, # 创建时间戳
            'mtime' => 1576244990, # 修改时间戳
        ];
        return fstat($this->fp);
    }

    public function testWrite()
    {
        $len = fwrite($this->fp, 'aa');
        return $len;
    }

    public function clearStatCache()
    {
        // 受影响的函数包括 stat()， lstat()， file_exists()， is_writable()， is_readable()， is_executable()， is_file()， is_dir()， is_link()， filectime()， fileatime()， filemtime()， fileinode()， filegroup()， fileowner()， filesize()， filetype() 和 fileperms()。
        var_dump(filesize($this->file)); // 如果此时文件大小是2，返回2
        sleep(5);
        var_dump(filesize($this->file)); // 人工对当前文件增加内容，返回2
        sleep(5);
        # clear_realpath_cache : 是否清除真实路径缓存
        # filename : 清除文件名指定的文件的真实路径缓存。只在 clear_realpath_cache =  TRUE 时启用
        clearstatcache(false, null);
        var_dump(filesize($this->file));// 返回增加内容后文件的大小，返回8
    }

    public function testIsUploadFile()
    {
        # 为了能使 is_uploaded_file() 函数正常工作，必段指定类似于 $_FILES['userfile']['tmp_name'] 的变量
        # 如果 filename 所给出的文件是通过 HTTP POST 上传的则返回 TRUE。
        # 这可以用来确保y用户恶意的用脚本去访问本不能访问的文件。如/etc/passwd
        return is_uploaded_file($this->file);
    }

    public function testTruncate()
    {
        return ftruncate($this->fp, 200); // 文件大小直接变成 100
        # return ftruncate($this->fp,5); // 文件大小直接变成 5，文件内容大于 5 会被截取
    }

    public function testFileType()
    {
        return filetype($this->file);
    }

    public function testBuffer()
    {
        $res = stream_set_write_buffer($this->fp, 100);
        if ($res !== 0) {
            echo 'changing the buffering failed' . PHP_EOL;
        }
    }

    public function testDiskFree()
    {
        # 返回目录的剩余空间的总大小：60GB
        # 以下的值一样
//        $bytes = disk_free_space('D:/');
        $bytes = disk_free_space('D:/360Downloads');
        return bcdiv($bytes, 1024 * 1024, 1) . 'MB';
    }

    public function testFiskTotal(){
        # 返回目录的空间的总大小：200Gb
        $bytes = disk_total_space('D:/');
        return bcdiv($bytes, 1024 * 1024, 1) . 'MB';
    }
}

$obj = new TestFFunction();
$res = $obj->testFiskTotal();
var_dump($res);