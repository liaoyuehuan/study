
//define() 使用AMD规范来定义模块
define(function () {
    var test = function () {
        alert("hello require");
    };
    return {test: test};
});

