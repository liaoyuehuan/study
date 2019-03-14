<?php

ini_set('display_errors',"On");
error_reporting(E_ALL);
$locale = 'zh_CN';
$domain = 'messages';
if (defined('LC_MESSAGES')) {
    setlocale(LC_MESSAGES,$locale);
    bindtextdomain($domain,__DIR__.'/locale/');
} else {
    putenv("LANG={$locale}"); // windows
    putenv("LC_MESSAGES={$locale}"); // windows
    bindtextdomain($domain,__DIR__.'/locale/');
}
textdomain($domain);

echo _("hello").PHP_EOL;
echo gettext("world").PHP_EOL;