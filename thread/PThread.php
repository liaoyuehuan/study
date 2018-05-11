<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/23
 * Time: 14:35
 */

class PThread extends Thread
{

    private $runnable;

    public function __construct(Runnable $runnable)
    {
        $this->runnable = $runnable;
    }

    public function run()
    {
        $this->runnable->run();
    }
}