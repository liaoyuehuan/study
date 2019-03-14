<?php
require_once __DIR__.'/function.php';

$reflectionFunction = new ReflectionFunction($closureUseParams->bindTo($closureUseParams));
echo '---- name ----'.PHP_EOL;
var_dump($reflectionFunction->name);

echo '---- getClosureScopeClass  ----'.PHP_EOL;
var_dump($reflectionFunction->getClosureScopeClass());

echo '---- getClosureThis  ----'.PHP_EOL; //返回$closure->bindTo的对象
var_dump($reflectionFunction->getClosureThis());

echo '---- getDocComment  ----'.PHP_EOL;
var_dump($reflectionFunction->getDocComment());

echo '---- getEndLine  ----'.PHP_EOL;
var_dump($reflectionFunction->getEndLine());

echo '---- getExtension  ----'.PHP_EOL;
var_dump($reflectionFunction->getExtension());

echo '---- getExtensionName  ----'.PHP_EOL;
var_dump($reflectionFunction->getExtensionName());

echo '---- getFileName   ----'.PHP_EOL;
var_dump($reflectionFunction->getFileName ());

echo '---- getName   ----'.PHP_EOL;
var_dump($reflectionFunction->getName ());

echo '---- getNamespaceName   ----'.PHP_EOL;
var_dump($reflectionFunction->getNamespaceName ());

echo '---- getNumberOfParameters   ----'.PHP_EOL;
var_dump($reflectionFunction->getNumberOfParameters ());

echo '---- getNumberOfRequiredParameters   ----'.PHP_EOL;
var_dump($reflectionFunction->getNumberOfRequiredParameters());

echo '---- getParameters   ----'.PHP_EOL;
var_dump($reflectionFunction->getParameters());

#php 7.0
//echo '---- :getReturnType   ----'.PHP_EOL;
//var_dump($reflectionFunction->getReturnType());

echo '---- getShortName    ----'.PHP_EOL;
var_dump($reflectionFunction->getShortName());

echo '---- getStartLine     ----'.PHP_EOL;
var_dump($reflectionFunction->getStartLine());

echo '---- getStaticVariables    ----'.PHP_EOL;
var_dump($reflectionFunction->getStaticVariables());

#7.0
//echo '---- :hasReturnType    ----'.PHP_EOL;
//var_dump($reflectionFunction->hasReturnType());

echo '---- inNamespace    ----'.PHP_EOL;
var_dump($reflectionFunction->inNamespace());

echo '---- isClosure    ----'.PHP_EOL;
var_dump($reflectionFunction->isClosure());

echo '---- isDeprecated    ----'.PHP_EOL;
var_dump($reflectionFunction->isDeprecated());

echo '---- isGenerator    ----'.PHP_EOL;
var_dump($reflectionFunction->isGenerator());

echo '---- isInternal    ----'.PHP_EOL;
var_dump($reflectionFunction->isInternal());

echo '---- isUserDefined     ----'.PHP_EOL;
var_dump($reflectionFunction->isUserDefined ());

echo '---- isVariadic     ----'.PHP_EOL;
var_dump($reflectionFunction->isVariadic ());

echo '---- returnsReference     ----'.PHP_EOL;
var_dump($reflectionFunction->returnsReference ());




