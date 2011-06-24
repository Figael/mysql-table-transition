<?php

if (!isset($_POST))
{
    exit();
}

require_once 'db.php';

$source = Db::gI()->sT($_POST['s_db'])->gTC($_POST['s_table']);

$target = Db::gI()->sT($_POST['t_db'])->gTC($_POST['t_table']);


$tmp = array();
foreach ($source as $key => $value)
{
    if (!isset($target[$key]))
    {
        $tmp[] = $key;
    }
}

$rsl = '';


$rsl .= "<script type=\"text/javascript\">\n";
$rsl .= "\tvar myCom=new Array();";
foreach ($source as $key => $value)
{
    $rsl .= "myCom['{$key}'] = '{$value['type']}' + '<br>' + '{$value['comment']}';\n";
}
$rsl .= "</script>";

$rsl .= "<table border=\"1\" >\n";


$rsl .='<tr bgcolor=lightblue><td><div align="center"><font color="#CC3300"><strong>Original Table In Green，Ultimate Table In Red</strong></font></div></td>
<td><div align="center"><font color="#CC3300"><strong>Ultimate Field</strong></font></div></td>
<td><div align="center"><font color="#CC3300"><strong>Original Field</strong></font></div></td>
<td>
For PHP Function:<br>
&nbsp;&nbsp;&nbsp;<font face="Arial, Helvetica, sans-serif">&nbsp;<font color=red><strong>function eg($a){ return $a[\'god\'];}</strong></font></font><font color=red><strong></strong></font><br>
EG:<br>
&nbsp;&nbsp;&nbsp;&nbsp;<textarea style="background-color:#CCCC66;color:red;">return $a[\'god\'];</textarea><br>
default value:#，which disables the func，default param name is: $a  (one row of table）<br>
<textarea name=original_table id=original_table  style=display:none></textarea>
<textarea name=target_table id=target_table  style=display:none></textarea>
</td>
</tr>';



foreach ($target as $key => $value)
{
    $rsl .= "\t<tr>\n";
    
    $rsl .= "\t\t<td WIDTH=400><div style= \"border:1px dashed #990033; BACKGROUND-COLOR:#66CC99; \" >{$value['type']}<br>{$value['comment']}<div>\n";
    //if (!isset($source[$key]))
    

    if (isset($source[$key]))
    {
        $rsl .= "\t\t\t<div name=\"fmn_{$key}\" id=\"fmn_{$key}\" style= \"BACKGROUND-COLOR:#CC6666 \">{$source[$key]['type']}<br>{$source[$key]['comment']}</div>\n\t\t</td>\n";
    }
    else 
    {
        $rsl .= "\t\t\t<div name=\"fmn_{$key}\" id=\"fmn_{$key}\" style= \"BACKGROUND-COLOR:#CC6666 \"></div>\n\t\t</td>\n";
    }

    $rsl .= "\t\t<td><center><strong>{$key}</strong></center></td>\n";

    $rsl .= "\t\t<td>\n";
    $rsl .= "\t\t<select name=\"f_name[{$key}]\" id=\"s_{$key}\"  onChange=\"disDetail(this.options[selectedIndex].text, '{$key}');\">\n";
    $is_in = false;
    foreach ($tmp as $v)
    {
        $rsl .= "\t\t\t<option value=\"{$v}\">{$v}</option>\n";
    }
    
    if (isset($source[$key]))
    {
        $rsl .= "\t\t\t<option value=\"{$key}\" selected='selected'>{$key}</option>\n";
        $rsl .= "\t\t</select>\n";
        
        $rsl .= "\t\t<div style=\"BACKGROUND-COLOR:#CCCC66\" >\n";
        $rsl .= "\t\t\t<input type=\"checkbox\" name=\"add_{$key}\" value =\"#\" onchange=\"addFormula(add_{$key})\">formula</div>\n\t\t</td>\n";
        
        //无需转化的
        $rsl .= "\t\t<td WIDTH=430>\n";

        //输入框
        $rsl .= "\t\t\t<div name=\"fmy_{$key}\" id=\"fmy_{$key}\"  style=\"display:none;\">";
        $rsl .= "\n\t\t\t<textarea style=\"background-color:#CCCC66;color:black\" name=\"func[{$key}]\" id=\"func_{$key}\" cols =\"50\" rows = \"3\">#</textarea>\n\t\t\t</div>\n";
        //$rsl .= "<div class='codes' id='ts_{$key}' name='ts_{$key}'>test</div>";
        $rsl .= "\t\t</td>\n";
    }
    else
    {
        $rsl .= "\t\t\t<option value=\"#\" selected='selected'>{$key}</option>\n";
        $rsl .= "\t\t\t</select>\n\t\t</td>\n";
        
        //注释
        $rsl .= "\t\t<td WIDTH=430>\n";
               
        //输入框
        $rsl .= "\t\t\t<div name=\"fmy_{$key}\">";
        $rsl .= "\t\t\t<textarea style=\"background-color:#CCCC66;color:black\" name=\"func[{$key}]\" cols =\"50\" rows = \"3\">#</textarea>\n\t\t\t</div>\n";
        //$rsl .= "<div id='ts_{$key}' name='ts_{$key}' class=\"codes\">test</div>";
        $rsl .= "\t\t</td>\n";
    }
    $rsl .= "\t</tr>\n";
}
$rsl .= "</table>
\n";

$final['html'] = $rsl;

echo json_encode($final);
















