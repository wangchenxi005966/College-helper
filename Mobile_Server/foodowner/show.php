<table width="72%" height="23" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="60%" background="images/dh_back.gif"><div align="left">&nbsp;&nbsp;&nbsp;今天是：&nbsp;<script language=JavaScript>
		var today=new Date();
		function initArray(){
			this.length=initArray.arguments.length;
			for(var i=0;i<this.length;i++)
				this[i+1]=initArray.arguments[i];  
		}
		var d=new initArray(
			"星期日",
			"星期一",
			"星期二",
			"星期三",
			"星期四",
			"星期五",
			"星期六");
		document.write(
			"<font color=#00A600 style='font-weight:bold;font-size:10pt;font-family: 宋体'> ",
				today.getFullYear(),"年",
				today.getMonth()+1,"月",
				today.getDate(),"日",
				"&nbsp;&nbsp;",
				d[today.getDay()+1],
			"</font>" ); 
		</script></div>
	</td>
	
    <td width="40%" background="images/dh_back.gif">
		<div align="right">
		<?php
			$shopname=$_GET['shopname'];
			echo "<a href='index.php?action=insert&shopname=$shopname' >添加菜单</a>&nbsp;&nbsp;&nbsp;";
			echo "<a href='login.html'>退出</a>&nbsp;&nbsp;&nbsp;";
		?>
		</div>
	</td>
  </tr>
</table>