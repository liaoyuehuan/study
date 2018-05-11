require.config({
    baseUrl: "js",
    paths: {
        "hello": "hello",
        "jquery": ["https://code.jquery.com/jquery-3.3.1.min"]
    },
    shim: {
        'hello':
            ['css!./hello.css'],
    },
    map: {
        '*': {
            'css': 'require-css/css'
        }
    },
});
require(["hello", "jquery", 'vue'], function (hello, $, Vue) {
    alert("main loading finish");
    hello.test();
    alert($.inArray('test3', ['test', 'test2']))
    Vue.component('company_comp', {
        props: ['companies'],
        template:
        '<form class="layui-form" action="">' +
        '<label class="layui-form-label">企业</label>' +
        '<div class="layui-input-inline">' +
        '<select name="modules" lay-verify="required" lay-search="">' +
        '<option value="">直接选择或搜索选择</option></select>' +
        '<option v-for="(value, key) in companies" v-bind:companies="companies" v-bind:value="key" >{{value}}</option>' +
        '</select>' +
        '</div>' +
        '</form>'
    });
});