(function () {
    var skim_haha = {};
    skim_haha.test = function () {
        alert('hello skim');
    }
    define('skim_haha', [], function() {
        return skim_haha;
    })
})()