<?php
$datetime = new DateTime();
echo 'timestamp : ' . $datetime->getTimestamp() . PHP_EOL;

echo 'timezone-name : ' . $datetime->getTimezone()->getName() . PHP_EOL;

# 返回与GM的时差：8 * 24 * 3600
echo 'timezone-offset : ' . $datetime->getOffset() . PHP_EOL;

echo 'timezone-location : ' . json_encode($datetime->getTimezone()->getLocation()) . PHP_EOL;

# l => Wednesday, T => CST
echo 'format-RFC850 : ' . "\t" . $datetime->format(DateTimeInterface::RFC850) . PHP_EOL;


# D => Wed, O => +0800
echo 'format-RFC1036 : ' . "\t" . $datetime->format(DateTimeInterface::RFC1036) . PHP_EOL;

# RFC1123 = RSS = RFC2822
echo 'format-RFC1123 : ' . "\t" . $datetime->format(DateTimeInterface::RFC1123) . PHP_EOL;
echo 'format-RSS : ' . "\t\t" . $datetime->format(DateTimeInterface::RSS) . PHP_EOL;

# P => +08:00
# W3C =  ATOM = RFC3339
echo 'format-W3C : ' . "\t\t" . $datetime->format(DateTimeInterface::W3C) . PHP_EOL;
echo 'format-ATOM : ' . "\t\t" . $datetime->format(DateTimeInterface::ATOM) . PHP_EOL;