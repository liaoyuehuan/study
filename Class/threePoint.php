<?php

class ThreePA
{
    public function __construct(...$obj)
    {
        new ThreePB(...$obj);
    }
}

class ThreePB
{
    public function __construct(...$obj)
    {

        var_dump($obj);
    }
}

new  ThreePA(1,2,3);