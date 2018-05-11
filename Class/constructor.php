<?php

class A
{
    private static $instance;

    public static function getInstance(){
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        echo 'A';
        new B();
    }
}

class B
{
    private static $instance;

    public static function getInstance(){
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        echo 'B';
        new A();
    }
}
new A();

