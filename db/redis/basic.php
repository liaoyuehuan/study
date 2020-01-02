<?php
$conf = [
    'host' => '192.168.50.75',
    'port' => 6379,
    'password' => '123456',
    'timeout' => 2,
    'persistent' => true,
    'prefix' => 'test_'
];
$redis = new Redis();

# 连接
if (!$redis->pconnect($conf['host'], $conf['port'], $conf['timeout'])) {
    exit("connect error : " . $redis->getLastError());
};
# 密码认证
if (!empty($conf['password']) && !$redis->auth($conf['password'])) {
    exit("auth error : " . $redis->getLastError());
}

# option
$redis->setOption(Redis::OPT_PREFIX, $conf['prefix']); // 自动加前缀
$redis->setOption(Redis::OPT_READ_TIMEOUT, 2);
$redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
// $redis->setOption(Redis::OPT_SCAN, Redis::SCAN_NORETRY); // default
// $redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);


$redis->set('aa', 1);
$redis->set('bb', ['aa' => 'bb']);
# 设置 OPT_SERIALIZER => SERIALIZER_PHP
# 返回整型 1，
$res = $redis->get('aa');
# 设置 OPT_SERIALIZER => SERIALIZER_PHP
# 返回数组，
$res = $redis->get('bb');
# 删除key（deprecate : delete）
$res = $redis->del('bb');
# 批量获取 mget （deprecate : getMultiple）
$res = $redis->mget(['aa', 'bb']);
