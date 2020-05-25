<?php
require_once './ThreadService.php';
require_once './Runnable.php';
/**
 * Class ExecutorService
 */
class ExecutorService
{
    /**
     * @return ThreadService
     */
    public static function newThreadService(){
        return new ThreadService();
    }
}

Class Hello implements Runnable{
    function run()
    {
        echo 'hello world';
    }
}

ExecutorService::newThreadService()->exec(new Hello());