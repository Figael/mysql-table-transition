
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysql Table Transition</title>
</head>

<center>
<table>
<tr>

<td>
params
</td>

<td>
<textarea id='param' name='param' cols =45 rows = 3 ></textarea>
</td>

</tr>

<tr>

<td>
code
</td>

<td>
<textarea  id='code' name='code' cols =45 rows = 10></textarea>
</td>

</tr>

<tr>
<td></td>

<td align="right">
<input type='button' value='func test' id='test_code' class="codes"></input>
</td>
</tr>

<tr>
<td>result</td>
<td width=400>
<br />
<div style="border:2px dashed #990033;" id='result'>
For PHP array<br />
&nbsp;&nbsp;&nbsp;
&nbsp;<font color=red><strong>return array('a'=>1,'b'=>array('c'=>1));</strong></font></font>

<font color=red><strong></strong></font><br />
EG:<br />
&nbsp;&nbsp;&nbsp;&nbsp;<textarea style="background-color:#CCCC66;color:red;"  cols ="35" rows = "3">return array('a'=>1,'b'=>array('c'=>1));</textarea><br />
</div>
</td>
</tr>

</table>




</center>

</html>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript">	
$('.codes').click(function(){

	  var param = $('#param')[0].value;
	  var code = $('#code')[0].value;
	  $.post("func_test.php", { Action: "post", a:param, c:code },
			  function (data)
			  {
				$('#result').empty();
				$('#result').append('<font color=red>'+data+'</font>');
			 });  
});
</script>