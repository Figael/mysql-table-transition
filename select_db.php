<?php

if (!isset($_POST))
{
    exit(0);
}

require 'db.php';

$rsl = array();

#show tables
if (isset($_POST['db']))
{  
    $tmp = Db::gI()->sT($_POST['db'])->q("SHOW tables");
    if (!empty($tmp))
    {
        foreach ($tmp as $each)
        {
            $rsl['table'][] = $each['Tables_in_'.$_POST['db']];
        }
    }
}
#output
echo json_encode($rsl);