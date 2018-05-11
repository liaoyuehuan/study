<?php

var_dump(in_array('1',[0,1],true));

$val = 0.57 * 100;
var_dump($val);
var_dump(intval(5.7 * 10));
var_dump(intval(0.5 * 10));
var_dump(intval(0.57 * 100));
var_dump(intval(0.57 * 1000));

echo PHP_EOL;

var_dump(strlen('曹'));     // 3

$str = 'o9umv-9m0mhy89fhr89gh-98h98dfh-9ghtf9gjf9nh89-fh-98f9-8h9-8uhbh-9h9hutf-
9hiogjioibno98rth89ho9ijf0oibnoivho98809tyh89rtiohniufnhiufniubnifuhiuofh89oh9fjnho9ifnh
sdiogmemgiodmfgiomdiogmiomgoipmdfgi=mdfipmgfpdsmgp=osdmgipomdfgpoimdfgio=mdfi=gmdipogmpiod
drniubspoompomioxcninslknpojzpojkopgnpomnposnpovnposmnfpomnaspovndfipobno9=sadnposadngvns
dfo0godompodfmpodfopgopdfgopfdpogmpofgpodfmgpfdmgpodfmogpmdpogmdp=gmpdgpas,-sm,p,sgpm,dpogm,p
dfibmdofimbifmbpmpv,po,vop,po,dfop,dfopb,odpf,pof,dbof,o,b,dbofd,obpf,dob,dfopb,dfopb,dfopb
wegi0mnqsoingoisdnogvimer=0mgs,pvldf,]pxf,fvop,f]pob,dpfo,po,gpo,gposd,gdf,gbpoe,dbhpo,fdpo
gjmi9emgvps,pov,.d[pgb.p[er.sdpo=gvjomfsildngfuyabdkvsalkmnfkjjbjbweybisaunfuiwbefuy9gwebfuy9w
gmweriomngiuern giunguiwenguinwerui-gnu8sndilfvmqs;omgio3jngiosdmgrlmgei-orjgeriogmfolsdmom';
// 815 482 488 500                  结论：482 182+6 482+18
var_dump(strlen($str));
var_dump(strlen(gzdeflate($str,9,ZLIB_ENCODING_RAW)));
var_dump(strlen(gzcompress($str,9,ZLIB_ENCODING_DEFLATE)));
var_dump(strlen(gzencode($str,9,FORCE_GZIP)));