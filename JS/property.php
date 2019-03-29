<html>
<body>
<script type="text/javascript">
    function Obj() {
        var v_private = '我是私有属性啊'; //私有属性
        this.v_object = '我是对象属性啊'; //对象属性
        Obj.v_static = '我是静态属性啊'; //静态属性
        var v_private_fun = function () {
            return '我是私有方法啊';
        }; //私有方法
        this.v_object_fun = function () {
            return '我是对象方法啊'
        }; //对象方法

        Obj.v_static_fun = function () {
            return '我是静态方法啊';
        }; //静态方法
    }

    var obj = new Obj();
    console.log('obj.v_private  : ' + obj.v_private); //undefined
    console.log('obj.v_object:  :' + obj.v_object); //我是对象属性啊
    console.log('Obj.v_static   : ' + Obj.v_static); //我是静态属性啊

    Obj.prototype.v_prototype = '我被增加到类了';
    obj.v_add = '我对增加到对象了';

    console.log('obj.v_prototype    : ' + obj.v_prototype); //我被增加到类了
    console.log('obj.v_add  : ' + obj.v_add);//我对增加到对象了

    Object.defineProperty(obj, 'v_define_property', {
        // 随便设置一个属性，set和get都用不了
        // enumerable: false,
        // configurable: false,
        // writable: true,
        // value: "static",
        set: function (value) {
            return this.value = 'set-' + value;
        },
        get: function () {
            return this.value;
        }
    });
    obj.v_define_property = '我的手动设置了，被触发了set';
    console.log('obj.v_define_property  : ' + obj.v_define_property); //set-我的手动设置了，被触发了set

</script>
</body>
</html>