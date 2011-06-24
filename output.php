<?php
set_time_limit(0);

require 'db.php';

list ($sdb, $stable) = explode('&', $_GET['original_table'], 2);

list ($tdb, $ttable) = explode('&', $_GET['target_table'], 2);

$GLOBALS['sdb'] = $sdb;
$GLOBALS['stable'] = $stable;

$GLOBALS['tdb'] = $tdb;
$GLOBALS['ttable'] = $ttable;

$field_mapping = $_GET['f_name'];
$func_mapping = $_GET['func'];

initFunc($field_mapping, $func_mapping);
getSql($field_mapping, $func_mapping);

function initFunc (&$fieldMap, &$funcMap)
{
    foreach ($fieldMap as $key => &$value)
    {
        if (isset($funcMap[$key]) && '#' != $funcMap[$key])
        {
            //echo $funcMap[$key], '<p>';
            
            $funcMap[$key] = create_function('$a', '{' . $funcMap[$key] . '}');
        }
    }
}

function offerDownload ($sql, $downLoadName)
{
    // 输入文件标签
    header("Pragma: public");
    header("Expires: 0");
    Header("Content-type: application/octet-stream");
    Header("Accept-Ranges: bytes");
    Header("Accept-Length: " . strlen($sql));
    Header("Content-Disposition: attachment; filename={$downLoadName}.sql");
    // 输出文件内容
    echo $sql;
}

function getSql ($fieldMap, $funcMap)
{
    $rsl = Db::gI()->sT($GLOBALS['sdb'])->gF($GLOBALS['stable']);
    
    $len = 0;
    
    $sql = '';
    
    foreach ($rsl as $row)
    {
        $rsl = convert($row, $fieldMap, $funcMap);
        $sql .= create_insert_sql($rsl, $len);
        ++$len;
        if ($len > 30)
        {
            $len = 0;
        }
    }
    offerDownload($sql, $GLOBALS['tdb'] . '_' . $GLOBALS['ttable']);
}

function create_insert_sql (array &$rsl, $len, $max = 30)
{
    $sql = '';
    
    if (0 == $len)
    {
        $sql = "INSERT INTO `{$GLOBALS['tdb']}`.`{$GLOBALS['ttable']}`(";
        
        $is_first = true;
        foreach ($rsl as $key => $value)
        {
            if (!$is_first)
            {
                $sql .= ',';
            
            }
            $sql .= "`{$key}`";
            $is_first = false;
        }
        
        $sql .= ") VALUES\n";
    }
    else
    {
        $sql .= ",\n";
    }
    
    $sql .= '(';
    $is_first = true;
    foreach ($rsl as $key => $value)
    {
        if (!$is_first)
        {
            $sql .= ',';
        
        }
        $value = str_replace("\"", "\\\"", $value);
        $sql .= "\"{$value}\"";
        $is_first = false;
    }
    
    $sql .= ')';
    
    if ($len == $max)
    {
        $sql .= ";\n";
    }
    //echo $sql;exit();
    return $sql;

     //file_put_contents('/home/figael/www/ad.txt', $sql , FILE_APPEND);
}

function convert (&$row, &$fieldMap, &$funMap)
{
    $rsl = array();
    foreach ($fieldMap as $key => &$value)
    {
        if (isset($funMap[$key]) && '#' != $funMap[$key])
        {
            // 有转化方法
            $rsl[$key] = $funMap[$key]($row);
            continue;
        }
        elseif ('#' != $fieldMap[$key])
        {
            $rsl[$key] = $row[$fieldMap[$key]];
        }
    }
    return $rsl;
}
