<?php
require_once __DIR__ . '/../../vendor/autoload.php';


/**
 * @throws \PhpOffice\PhpWord\Exception\CopyFileException
 * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
 */
function testTemplateDoc()
{
    $file = __DIR__ . '/doc/test.doc';
    $saveFile = __DIR__ . '/doc/testSave.doc';
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($file);

    # 设置变量值
//    $templateProcessor->setValue('username', '方思');
//    $templateProcessor->setValue('relation', '大哥');
    # 或者
    $templateProcessor->setValues([
        'username' => '方思',
        'relation' => '大哥'
    ]);


    # 设置图片
    $image = __DIR__ . '/image/test.png';
    $templateProcessor->setImageValue('test_image', $image);
    $templateProcessor->setImageValue('test_image1', [
        'path' => $image,
        # cm, mm, in, pt, pc, px, %, em, ex。
        # default : px
        'width' => '200px',
        'height' => 200,
        # false, - or f
        'ratio' => false
    ]);
    $templateProcessor->setImageValue('test_image2', $image);
    $templateProcessor->setImageValue('test_image3', $image);

    # 操作块
    $templateProcessor->cloneBlock('test_block', 0, true, false, [
        ['name' => '孙俊', 'phone' => '110'],
        ['name' => '张青', 'phone' => '120'],
        ['name' => '方思', 'phone' => '119'],
    ]);

    # 保存文件
    $templateProcessor->saveAs($saveFile);
}

testTemplateDoc();
echo 'success';