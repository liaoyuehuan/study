<?php

trait Type
{
    public function getClassReflection()
    {
        return new ReflectionClass($this);
    }

    public function say()
    {
        var_dump('trait say');
    }

    public function hello()
    {
        echo ' hello type';
    }

    public function showTrait(){
        echo 'trait -------- '.__TRAIT__.PHP_EOL;
    }
}

trait Type2
{
    public function hello()
    {
        echo ' hello type2';
    }

    public function world()
    {
        echo ' world ';
    }
}
trait CombineType
{
    use Type, Type2 {
        Type2::hello insteadof Type;
    }
}

class TestType
{
    use Type, Type2 {
        Type2::hello insteadof Type;
        Type::hello as hello2;         //as 无法解决冲突的
    }

    public function testType()
    {
        var_dump($this->getClassReflection());
    }

    public function say()
    {
        var_dump(' my say');
    }
}



class CombineTestType
{
    use CombineType;
}


$obj = new TestType();
$obj->testType();
$obj->say();
$obj->hello();
$obj->hello2();
$obj->showTrait();

$obj2 = new CombineTestType();
$obj2->world();

