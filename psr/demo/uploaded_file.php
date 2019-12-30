<?php
include __DIR__ . '/../../vendor/autoload.php';
if (isset($_FILES['file'])) {
    $uploadedFile = new \psr\test\http\message\LocalUploadedFile($_FILES['file']);
    echo "<div>size : {$uploadedFile->getSize()}</div>";
    echo "<div>clientFilename : {$uploadedFile->getClientFilename()}</div>";
    echo "<div>clientMediaType: {$uploadedFile->getClientMediaType()}</div>";
    echo "<div>error : {$uploadedFile->getError()}</div>";
    echo "<div>streamSize : {$uploadedFile->getStream()->getSize()}</div>";
    try {
        $uploadedFile->moveTo("D:/aa/{$uploadedFile->getClientFilename()}");
        echo "<div>move file success</div>";
    } catch (InvalidArgumentException $e) {
        echo "<div>move file failed : {$e->getMessage()}</div>";
    }
} else {
    echo 'no {file}';
}