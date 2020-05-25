<?php



class MyThread extends Thread{
    public function run(){
        for ($i = 1;$i < 100 ; ++$i){
            sleep(1);
            echo 1;
        }
    }
}

class MyThread2 extends Thread{
    public function run(){
        for ($i = 1;$i < 100 ; ++$i){
            sleep(1);
            echo 2;
        }
    }
}

$worker = new Worker();

echo "There are currently {$worker->count()} tasks on the stack to be col".PHP_EOL;
$thread1 = new MyThread();
$thread2 = new MyThread2();
$thread1->start();
sleep(2);
echo "There are currently {$worker->getStacked()} tasks on the stack to be col".PHP_EOL;
$thread2->start();
echo "There are currently {$worker->count()} tasks on the stack to be col".PHP_EOL;