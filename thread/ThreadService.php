<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/23
 * Time: 14:30
 */

require_once './PThread.php';
class ThreadService
{
    public function exec(Runnable $runnable){
        $thread = new PThread($runnable);
        $thread->start();
    }
}
