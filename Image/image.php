<?php

function imageBasic()
{
    $pngFile = __DIR__ . '/images/1.png.tmp';
    $pngData = file_get_contents($pngFile);
    //getimagesize($pngFile) =  getimagesizefromstring($pngData)
    /**
     *
     */
    $imageInfo = getimagesize($pngFile);
    [
        0 => 447, //width,
        1 => 646, //height
        2 => 3, // image type 不受文件后缀影响
        3 => 'width="447" height="646"',//
        'bits' => 8,// 图像每种颜色的位数
        'mime' => 'iamge/png', //图像的mime信息
        'channels' => 3 // jpg,gif有 ，3 => RGB picture ,4 => CMYK picture  GIF always uses 3 channels per pixel,
    ];

    $extension = image_type_to_extension(IMAGETYPE_GIF);
    //1 => .gif , 2 => jpg ,3 => png ...
    $mime_type = image_type_to_mime_type(IMAGETYPE_GIF);
    //image/gif,  image/png ...

    /**
     * exif
     */

    $image_type = exif_imagetype($pngFile); //需要打开 exif 扩展
    // 1   image type

    $thumb_nail = exif_thumbnail($pngFile); //tiff, jpg或jpeg 获取缩略图
    if ($thumb_nail) {
        file_put_contents(__DIR__ . '/images/thumb.' . $extension, $thumb_nail);
    }
}

function createImage()
{
    # 以像素的的尺寸， 新建一个真彩色图像
    $resource = imagecreatetruecolor(100, 100);

    # 设置图片的颜色（背景），返回RGB颜色
    $rgb = imagecolorallocate($resource, 0xFF, 0xFF, 0xFF);

    # 设置文字颜色（蓝色）
    $textColor = imagecolorallocate($resource, 0, 0, 255);

    # 水平的画一行文字
    # $fond ： 1,2,3,4，5是内置字体
    $success = imagestring($resource, 1, 10, 10,'hello word' ,$textColor);

    # 裁剪
    # $resource = imagecrop($resource, ['x' => 0, 'y' => 0, 'width' => 50, 'height' => 50]);

    # 缩放
//    $resource = imagescale($resource,50);

    # 将图片输出到文件或浏览器（$filename = null时，输出到浏览器）
    # $quality : 压缩水平：0(无压缩) - 9
    $success = imagepng($resource,__DIR__.'/out_images/test.png',5);

    # 释放与 image 关联的内存
    $success = imagedestroy($resource);

    echo  "success";
}
imageBasic();