<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-6-29
 * Time: 16:58
 */

class TestVars
{
    public $aa = 'aa';

    public $bb = 'bb';

    private $cc = 'cc';

    protected $dd = 'dd';

    public function __construct()
    {
        echo '#### __construct ####' . PHP_EOL;
        var_dump(get_class_vars(TestVars::class));
    }
}
echo '#### __out ####' . PHP_EOL;
var_dump(get_class_vars(get_class(new TestVars())));