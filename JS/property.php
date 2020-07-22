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

    // Obj.prototype.属性区别于obj.属性，Obj.prototype.所有对象都被加上了
    Obj.prototype.v_prototype = '我被增加到类了';
    obj.v_add = '我对增加到对象了';

    console.log('obj.v_prototype    : ' + obj.v_prototype); //我被增加到类了
    console.log('obj.v_add  : ' + obj.v_add);//我对增加到对象了

    Object.defineProperty(obj, 'v_define_property', {
        // 随便设置一个属性，set和get都用不了
        // enumerable: false, // 属性是否可以在 for...in 循环和 Object.keys() 中被枚举。默认：false
        // configurable: false, // configurable特性表示对象的属性是否可以被删除，以及除value和writable特性外的其他特性是否可以被修改。
        // writable: false,
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

    console.log('enumerable keys',Object.keys(obj));
    console.log('enumerable entries',Object.entries(obj));
    console.log('enumerable values',Object.values(obj));

    console.log('obj.v_add-getOwnPropertyDescriptors',Object.getOwnPropertyDescriptor(obj,'v_add'));

    function SunObj() {
        Obj.call(this) // 调用父类的构造方法
    }

    SunObj.property = Object.create(obj); // 子类继承父类


    // 配置讲解
    var c = Object.create(obj,{
        //数据属性
        //  1、value：包含该属性的数据值，默认为undefined。
        //  2、writable：表示能否修改属性的值。默认：true。如true：修改数据不起效
        //  3、enumerable：表示能否通过for-in循环返回属性。默认：false
        //  4、configurable:表示能否通过delete删除属性从而重新定义属性，能否修改属性的特性，或能否把属性修改为访问器属性，默认为true。
        val1 : {
            writable:true,
            configurable:true,
            value: "value-val1"
        },
        // 访问器属性
        // configurable：表示能否通过delete删除属性从而重新定义属性，能否修改属性的特性，或能否把属性修改为访问器属性，默认为false。
        // enumerable：表示能否通过for-in循环返回属性，默认为false。
        // Get：在读取属性时调用的函数，默认为undefined。
        // Set：在写入属性时调用的函数，默认为undefined。
        acc1: {
            configurable: false,
            get: function () {
                return 100;
            },
            set: function (value) {
                console.log("set acc1 :",value)
            }
        }
    });
    console.log("create-c.val1: ",c.val1)
    console.log("create-c.acc1: ",c.acc1)

</script>
</body>
</html>