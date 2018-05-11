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

    /**
     * 10bit
     * @var null
     */
    static $machineId = null;

    public static function machineId($mId = 0)
    {
        self::$machineId = $mId;
    }


    public static function generateParticle()
    {
        //time
        $time = floor(microtime(true) * 1000);

        $time -= self::EPOCH;

        $base = decbin(self::max41bit + $time);

        if (!self::$machineId) {
            $machineid = self::$machineId;
        } else {
            $machineid = str_pad(decbin(self::$machineId), 10, '0', STR_PAD_LEFT);
        }

        $random = str_pad(decbin(mt_rand(0, self::max12bit)), 12, '0', STR_PAD_LEFT);

        $base = $base . $machineid . $random;

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
echo PHP_INT_MAX . PHP_EOL;
echo $id . PHP_EOL;
echo date('Y-m-d H:i:s', $time / 1000);