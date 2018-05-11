<?php

Class Data extends SplQueue
{
    /**
     * @var Data
     */
    private static  $data ;

    public static  function getInstance(){
        if(self::$data === null) {
            self::$data = new self();
        }
        return self::$data;
    }
}

Class ReadWorker extends Worker
{

    public function run()
    {
        while (1) {
            if (Data::getInstance()->isEmpty() === false)//receiving datas
            {
                $arr = Data::getInstance()->dequeue();
                echo 'Received data:' . print_r($arr, 1) . chr(10);
            } else{
                var_dump(spl_object_hash((Data::getInstance())));
                sleep(1);
            }
        }
    }

}

Class WriteWorker extends Worker
{
    public function run()
    {
        while (1) {
            Data::getInstance()->enqueue(222);//writting datas
            var_dump(spl_object_hash((Data::getInstance())));
            echo 1;
            sleep(1);
        }
    }
}
var_dump(spl_object_hash((Data::getInstance())));
$data = new Data();
$reader = new ReadWorker();
$writer = new WriteWorker();
$writer->start();
$reader->start();

echo 'stacker :' . $reader->getStacked() . PHP_EOL;
