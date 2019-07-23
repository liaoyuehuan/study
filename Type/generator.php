<?php
# 相对array封装
# 优点：节省内存
# 缺点：耗费更多的时间

/**
 * @param $start
 * @param $limit
 * @param int $step
 * @return Generator
 */
function xRange($start, $limit, $step = 1)
{
    if ($limit >= $start) {
        if ($step <= 0) {
            throw  new LogicException('step must be large 0');
        }
        for ($i = $start; $i <= $limit; $i += $step) {
            yield $i;
        }
    } else {
        if ($step >= 0) {
            throw  new LogicException('step must be less 0');
        }
        for ($i = $start; $i >= $limit; $i += $step) {
            yield $i;
        }
    }
}

/**
 * @return Generator
 */
function arr()
{
    yield 1;
    yield 2;
    yield 3;
}

/**
 * @return Generator
 */
function keyToValue()
{
    yield 'a' => 'aa';
    yield 'b' => 'bb';
}

/**
 * @return Generator
 */
function &quote()
{
    $value = 4;
    while ($value >= 0) {
        yield $value;
    }
}

function from()
{
    yield 1;
    yield from [2, 3];
}

echo '####  xRange ####' . PHP_EOL;
foreach (xRange(1, 20, 2) as $item) {
    echo $item . ' ';
}
echo PHP_EOL;

echo '####  arr ####' . PHP_EOL;;
foreach (arr() as $item) {
    echo $item . ' ';
}
echo PHP_EOL;

echo '##### keyToValue ####' . PHP_EOL;
foreach (keyToValue() as $key => $item) {
    echo $key . ' =>  ' . $item . PHP_EOL;
}

echo '#### quote ####' . PHP_EOL;
foreach (quote() as &$item) {
    echo $item-- . ' ';
}
echo PHP_EOL;
echo '#### from ####' . PHP_EOL;
foreach (from() as $item) {
    echo $item . ' ';
}
