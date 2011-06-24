	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Mysql Table Transition</title>
	</head>
	
	<style type="text/css">
	 one 
	{ 
	display:block; 
	overflow:hidden; 
	height:1px; 
	margin:0 4px; 
	border-left:1px solid #B2D0EA; 
	border-right:1px solid #B2D0EA; 
	background:#B2D0EA; 
	} 
	.two 
	{ 
	display:block; 
	overflow:hidden; 
	height:1px;
	margin:0 3px;
	border-left:1px solid #B2D0EA;
	border-right:1px solid #B2D0EA; 
	background:#B2D0EA; 
	} 
	.three 
	{ 
	display:block; 
	overflow:hidden; 
	height:1px; 
	margin:0 2px; 
	border-left:1px solid #B2D0EA; 
	border-right:1px solid #B2D0EA; 
	background:#EDF7FF; 
	} 
	.four 
	{ 
	display:block; 
	overflow:hidden; 
	height:1px; 
	margin:0 1px; 
	border-left:1px solid #B2D0EA; 
	border-right:1px solid #B2D0EA; 
	background:#EDF7FF; 
	} 
	.rou
	{ 
	border-left:1px solid #B2D0EA; 
	border-right:1px solid #B2D0EA; 
	} 
	.rou2 
	{ 
	border-left:1px solid #B2D0EA; 
	border-right:1px solid #B2D0EA; 
	background:#EDF7FF; 
	}
	</style>
	
	<body></body>
	
	
	
	<p class="two"> </p>
	<p class="three"> </p>
	<p class="four"> </p>
	<div class="rou2" align="center">Common Functions</div>
	<p class="four"> </p>
	<p class="three"> </p>
	<p class="two"> </p>
	
	<p class="two"> </p>
	<p class="three"> </p>
	<p class="four"> </p>
	<div class="rou" align="center"><font color='red' size='3'>Db::gI()->sT($db)->q($sql);</font><br>//return array(0=>queryResult,,,,)</div>
	<p class="four"> </p>
	<p class="three"> </p>
	<p class="two"> </p>
	
	<br />
	</p>
	
	<center>
	
	<table >
	<tr>
	
	<td width="45%" align="left">
	<div style="border:2px dashed #990033;">
	<center><font size="+2" color="#CC3300" ><strong>original table</strong></font></center>
	<select class='dbs' name="s_db" id="s_db">
	<?php
	require_once 'db.php';
	$tmp = Db::gI()->q("SHOW databases");
	if (!empty($tmp))
	{
		foreach ($tmp as $each)
		{
			echo "<option value='{$each['Database']}'>{$each['Database']}</option>";
		}
	}
	?>
	</select>
	--
	<select name="s_table" id="s_table">
	</select>
	</div>
	</td>
	
	<td width="5%" align="center">
	<strong>=== ></strong>
	</td>
	
	<td width="45%" align="left">
	<div style="border:2px dashed #990033;">
	<center><font size="+2" color="#CC3300" ><strong>ultimate table</strong></font></center>
	<select class='dbs' name="t_db" id="t_db">
	<?php
	if (!empty($tmp))
	{
		foreach ($tmp as $each)
		{
			echo "<option value='{$each['Database']}'>{$each['Database']}</option>";
		}
	}
	?>
	</select> -- <select name="t_table" id="t_table">
	</select>
	</div>
	</td>
	
	<td>
	<br />
	<input  type="button" value="func" onclick="openwin()"><br>  
	<input type='button' value='start' id='start'></input>
	</td>
	
	</tr>
	</table>
	</center>

	
	<p>
	
	<center>
	<form name="input" action="output.php" method="get">
	
	<div id='comparision' name='comparision'></div>
	</form>
	</center>
	
	</html>
	
	<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
	<script type="text/javascript">	
	$('#start').click(function(){
	
		var sdb = $('#s_db').val();	
		var tdb = $('#t_db').val();
		
		var ttable = $('#t_table').val();
		var stable = $('#s_table').val();
		
		$.post("convertion.php", { Action: "post", s_db:sdb, s_table:stable, t_db:tdb, t_table:ttable},
				function (data)
				{
					$('#comparision').empty();
					$('#comparision').append(data.html);
					$('#comparision').append("<br /><div align=\"center\"><input type=\"submit\" value=\"OK\" /></div>");
	
					var tmp = tdb+"&"+ttable;
					$('#target_table').val(tmp);

					tmp = sdb+"&"+stable;
					$('#original_table').val(tmp);
					
				},'json');
	});
	
	  $('.dbs').change(function(){
		  dep_id = this.value;
		  var key = this.id.substr(0,2) + "table";
		  $('#'+key).empty();
		  $.post("select_db.php", { Action: "post", db:dep_id },
				  function (data)
				  {       	  		
					var table = data.table;
					for(var i=0;i<table.length;i++)
					{
						$('#'+key).append("<option value='"+table[i]+"'>"+table[i]+"</option>");
					}
				 },"json");  
	  });

	  
	
	function disDetail(ArrayName, DivName)
	{	
		var dis_key = "fmn_"+DivName;
	
		var dis = document.getElementById(dis_key);
	
		dis.innerHTML = myCom[ArrayName];
		
	}

	function openwin() 
	{
	    window.open("func_input.php","newwindow","height=480, width=460, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no") 
	    return false;
	}
	
	function addFormula(Module)
	{
		var c_name = Module.name;
		
		var c_key = c_name.substring(4, c_name.length);
	
		var dis_key  = "fmy_"+c_key;
		var fun_key = "func_" +c_key;
		
		var fml= document.getElementById(dis_key);
		var fuml= document.getElementById(fun_key);
	
		
		if(Module.checked)
		{
			fml.style.display ="";
		}
		else
		{
			fuml.value="#";
			fml.style.display ="none";
		}
	}
	</script>

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
