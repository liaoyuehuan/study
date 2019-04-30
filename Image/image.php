<?php
$pngFile = __DIR__.'/images/no_img.doc';
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

$thumb_nail =  exif_thumbnail($pngFile); //tiff, jpg或jpeg 获取缩略图
if ($thumb_nail){
    file_put_contents(__DIR__.'/images/thumb.'.$extension,$thumb_nail);
}