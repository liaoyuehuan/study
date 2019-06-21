<?php

$html = '<body><kk><div style="width: 100px;" hidden><input readonly /><span><o:p>hello tidy</o:p></body>';

# 配置说明文档： http://tidy.sourceforge.net/docs/quickref.html
$config = [
    # 类似格式化,自动加"tab"
    'indent' => true,

    # 使用 " output-xhtml" 会自动补上 <!DOCTYPE html>、<head>、<title>等标签
    'output-xml' => true,

    'input-xml' => true,

    # 设置一行最长显示字符，超过会换行输出（不一定全部起效
    'wrap' => 1000,

    'drop-proprietary-attributes' => true
];
$encoding = 'utf8';
$tidy = new tidy();

# 获取tidy library 的发行日期
echo 'getRelease : ' . $tidy->getRelease() . PHP_EOL;

# 1、kk div span 自动补上
# 2、保留属性
# 3、hidden => hidden=""
# 4、input 要加 / (不然会把span包括起来)
# 5、readonly => readonly="readonly"
$success = $tidy->parseString($html, $config, $encoding);

# 检测，需要在 “$tidy->parseString”后执行
echo 'diagnose ：' . $tidy->diagnose() . PHP_EOL;
if (!$tidy->diagnose()) {
    echo $tidy->errorBuffer . PHP_EOL;
}
echo 'isXhtml : ' . $tidy->isXhtml() . PHP_EOL;;
echo 'isXml : ' . $tidy->isXml() . PHP_EOL;;
$success = $tidy->cleanRepair();

echo tidy_get_output($tidy) . PHP_EOL;



