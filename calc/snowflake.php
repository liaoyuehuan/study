<?php

date_default_timezone_set('PRC');

/**
 * 默认情况下41bit的时间戳可以支持该算法使用到2082年，
 * Class Particle
 */
abstract class Particle
{
    const EPOCH = 1479533469598;
    const max12bit = 4095;
    const max41bit = 1099511627775;

    private static $msCacheValue = [
        'current_ms' => 0,
        'current_list' => []
    ];

    private static function isInMsRepeat($currentMs, $value)
    {
        if (self::$msCacheValue['current_ms'] === $currentMs) {
            if (array_key_exists($value, self::$msCacheValue['current_list'])) {
                return true;
            } else {
                self::$msCacheValue['current_list'][$value] = null;
                return false;
            }
        } else {
            self::$msCacheValue['current_ms'] = $currentMs;
            self::$msCacheValue['current_list'] = [$value => null];
            return false;
        }
    }

    /**
     * 10bit
     * @var null
     */
    static $machineId = null;

    public static function machineId($mId = 0)
    {
        self::$machineId = $mId;
    }


    public static function generateParticle($machineId = null)
    {
        //time
        $time = floor(microtime(true) * 1000);

        $time -= self::EPOCH;

        $base = decbin(self::max41bit + $time);

        if (empty($machineId)) {
            if (self::$machineId) {
                $machineId = self::$machineId;
            } else {
                $machineId = 0;
            }
        }
        $machineId = str_pad(decbin($machineId), 10, '0', STR_PAD_LEFT);

        $random = str_pad(decbin(mt_rand(0, self::max12bit)), 12, '0', STR_PAD_LEFT);

        $base = $base . $machineId . $random;
        if (self::isInMsRepeat($time, $base)) {
            return self::generateParticle();
        }
        return bindec($base);
    }

    public static function timeFromParticle($particle)
    {
        /*
        * Return time
        */
        return bindec(substr(decbin($particle), 0, 41)) - self::max41bit + self::EPOCH;
    }
}

$id = Particle::generateParticle();
$time = Particle::timeFromParticle($id);//
echo $id . PHP_EOL;
echo $id . PHP_EOL;
echo date('Y-m-d H:i:s', $time / 1000);

$ids = [];
$start = floor(microtime(true) * 1000);
for ($i = 1; $i <= 100000; $i++) {
    usleep(0.1);
    $id = Particle::generateParticle();
    $ids[$id] = true;
}
var_dump(count($ids));

$end = floor(microtime(true) * 1000);
echo PHP_EOL . ($end - $start) . 'ms';