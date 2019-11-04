<?php

# 底色
echo "\e[40;37m 黑底白字 \e[0m" . PHP_EOL;
echo "\e[41;37m 红底白字 \e[0m" . PHP_EOL;
echo "\e[42;37m 绿底白字 \e[0m";
PHP_EOL;
echo "\e[43;37m 黄底白字 \e[0m" . PHP_EOL;
echo "\e[44;37m 蓝底白字 \e[0m" . PHP_EOL;
echo "\e[45;37m 紫底白字 \e[0m" . PHP_EOL;
echo "\e[46;37m 天蓝底白字 \e[0m" . PHP_EOL;
echo "\e[47;30m 白底黑字 \e[0m" . PHP_EOL;

# 字体颜色：30 - 37
echo "\e[31m 红色字 \e[0m" . PHP_EOL;
echo "\e[30m 黑色字 \e[0m" . PHP_EOL;
echo "\e[32m 绿色字 \e[0m" . PHP_EOL;
echo "\e[33m 黄色字 \e[0m" . PHP_EOL;
echo "\e[34m 蓝色字 \e[0m" . PHP_EOL;
echo "\e[35m 紫色字 \e[0m" . PHP_EOL;
echo "\e[36m 天蓝字 \e[0m" . PHP_EOL;
echo "\e[37m 白色字 \e[0m" . PHP_EOL;

# 最后面控制选项说明
/*\
33[0m 关闭所有属性;
\33[1m 设置高亮度;
\33[4m 下划线;
\33[5m 闪烁;
\33[7m 反显;
\33[8m 消隐;
\33[30m — \33[37m 设置前景色;
\33[40m — \33[47m 设置背景色;
\33[nA 光标上移n行;
\33[nB 光标下移n行;
\33[nC 光标右移n行;
\33[nD 光标左移n行;
\33[y;xH设置光标位置;
\33[2J 清屏;
\33[K 清除从光标到行尾的内容;
\33[s 保存光标位置;
\33[u 恢复光标位置;
\33[?25l 隐藏光标;
\33[?25h 显示光标

作者：晓得为_
链接：https://www.jianshu.com/p/8d9b2b35aaa9
来源：简书
简书著作权归作者所有，任何形式的转载都请联系作者获得授权并注明出处。
*/

# 格式控制
echo sprintf("%-30s : %s \r\n", 'worker_num', 8);
echo sprintf("%-30s : %s \r\n", 'deamoize', 'true');