<?php

interface i
{

}

class a implements i
{

}

class b extends a
{

}

var_dump((new b()) instanceof a);
var_dump((new b()) instanceof i);