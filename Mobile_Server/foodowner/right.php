<!--<?php
header("Content-Type:text/html;charset=utf-8");
?>-->
<div style="overflow-x: hidden; overflow-y: auto; height: 500px; width:100%;">
	<script>
	//删除确认
		function del(){
			 if(!window.confirm('是否要删除数据??'))
			return false;
		}
	</script>
	<style type="text/css">
		td{
			text-align:center;
		}
		
	 </style>
	  
	<table width="100%" >
		<tr>
			<td>
				<?php
				//浏览图书
				if ($_REQUEST['action'] == "show"){
				?>
				<form name="form1" id="form1" method="post">
					<table width="90%" height="100%" style="padding-top:30px;" align="center" cellpadding="0" cellspacing="0" id="content" borderColor="#ff6600"  bgColor="#fffbec" border="1" frame="void">
						<?php
							$shopname=$_REQUEST['shopname'];
							$SQLDAO=new SQLDAO();
							$QueryStr="select * from food_info where shopname='$shopname'";
							$result=$SQLDAO->SQL_Query($QueryStr);
							echo "<tr height=\"20px\"><td width=\"10%\">序号</td><td width=\"30%\">菜名</td><td width=\"30%\">单价</td><td width=\"15%\">操作</td><td width=\"15%\">操作</td></tr>";
							if($result)
							{
								$i=0;
								while($list=mysql_fetch_array($result)){
									echo "<tr height=\"20px\"><td width=\"10%\">".$i."</td><td width=\"30%\">".$list["foodname"]."</td><td width=\"30%\">".$list["price"]."</td><td width=\"15%\" class='m_td'><a href=index.php?action=modify&shopname=$shopname&id=".$list["foodname"].">修改</a></td><td width=\"15%\" class='m_td'><a href=index.php?action=del&shopname=$shopname&id=".$list["foodname"]." onclick='return del();'>删除</a></td></tr>";
									$i++;
								}
							}
						?>
					</table>
				</form>
				<?php
				}
				else if($_REQUEST['action']=="insert")
				{
					$shopname=$_REQUEST['shopname'];
				?>
				<form name="intFrom" method="post" action="index.php?action=show&shopname=$shopname">
					<table width="100%" height="200"  border="0" cellpadding="0" cellspacing="0">
						<tr align="center" valign="middle">
							<td width="30%" class="c_td">&nbsp;</td>
							<td width="10%" align="right" class="c_td">&nbsp;</td>
							<td width="30%" class="c_td">&nbsp;</td>
							<td width="30%" class="c_td">&nbsp;</td>
						</tr>
						<tr>
							<td class="c_td">&nbsp;</td>
							<td align="right" valign="middle" class="c_td">菜名：</td>
							<td align="center" valign="middle" class="c_td"><input type="text" name="foodname"></td>
							<td class="c_td">&nbsp;</td>
						</tr>
						<tr>
							<td class="c_td">&nbsp;</td>
							<td align="right" valign="middle" class="c_td">单价：</td>
							<td align="center" valign="middle" class="c_td"><input type="text" name="price"></td>
          					<td class="c_td">&nbsp;</td>
						</tr>		 
						<tr align="center" valign="middle">
							<td class="c_td">&nbsp;</td>
							<td colspan="2" class="c_td">
								<input type="hidden" name="shopname" value="<?php echo $shopname ?>">
								<input type="hidden" name="action" value="insertfood">
								<input type="submit" name="Submit" value="添加">
								<input type="reset" name="reset" value="重置"></td>
							<td class="c_td">&nbsp;</td>
						</tr>
					</table>
				</form>
				<?php
				}
					if ($_REQUEST['action'] == "del")
					{
						$SQLDAO=new SQLDAO();
						$shopname=$_REQUEST['shopname'];
						$foodname=$_REQUEST['id'];
						$updateStr = "delete from food_info where foodname='$foodname' and shopname='$shopname'";
						$result1=$SQLDAO->SQL_Delete($updateStr);
						if ($result1){
							if(updateversion($shopname))
								echo "<script>alert('删除成功');location='index.php?action=show&shopname=$shopname';</script>";
						}
						else{
							echo "删除失败";
						}
					}
					else if($_REQUEST['action'] == "modify")
					{
						$SQLDAO=new SQLDAO();
						$shopname=$_REQUEST['shopname'];
						$foodname=$_REQUEST['id'];
						$updateStr = "select * from food_info where foodname='$foodname' and shopname='$shopname'";
						$result1=$SQLDAO->SQL_Query($updateStr);
						$rows = mysql_fetch_row($result1);
				?>
				<form name="intFrom" method="request" action="index.php?action=show&shopname=$shopname">
					<table width="100%" height="200"  border="0" cellpadding="0" cellspacing="0">
						<tr align="center" valign="middle">
							<td width="30%" class="c_td">&nbsp;</td>
							<td width="10%" align="right" class="c_td">&nbsp;</td>
							<td width="30%" class="c_td">&nbsp;</td>
							<td width="30%" class="c_td">&nbsp;</td>
						</tr>
						<tr>
							<td class="c_td">&nbsp;</td>
							<td align="right" valign="middle" class="c_td">菜名:</td>
							<td align="center" valign="middle" class="c_td"><input type="text" name="foodname" value="<?php echo $rows[2] ?>"></td>
							<td class="c_td">&nbsp;</td>
						</tr>
						<tr>
							<td class="c_td">&nbsp;</td>
							<td align="right" valign="middle" class="c_td">单价：</td>
							<td align="center" valign="middle" class="c_td"><input type="text" name="price" value="<?php echo $rows[3] ?>"></td>
							<td class="c_td">&nbsp;</td>
						</tr>
						<tr align="center" valign="middle">
							<td class="c_td">&nbsp;</td>
							<td colspan="2" class="c_td">
								<input type="hidden" name="action" value="modifyfood">
								<input type="hidden" name="shopname" value="<?php echo $shopname ?>">
								<input type="hidden" name="id" value="<?php echo $rows[2] ?>">
								<input type="submit" name="Submit" value="修改">
								<input type="reset" name="reset" value="重置"></td>
							<td class="c_td">&nbsp;</td>
						</tr>
					</table>
				 </form>
				<?php
					}
					if ($_REQUEST['action'] == "modifyfood"){
						if (!($_REQUEST['foodname'] and $_REQUEST['price']))
							echo "输入不允许为空。点击<a href='javascript:onclick=history.go(-1)'>这里</a>返回";
						else{
							$SQLDAO=new SQLDAO();
							$shopname=$_REQUEST['shopname'];
							$foodname=$_REQUEST['foodname'];
							$price=$_REQUEST['price'];
							$id=$_REQUEST['id'];
							$updateStr = "update food_info set foodname = '$foodname', price = '$price' where foodname = '$id' and shopname='$shopname'";
							$result=$SQLDAO->SQL_Update($updateStr);
							if ($result){
								if(updateversion($shopname))
									echo "<script>alert('修改成功');location='index.php?action=show&shopname=$shopname';</script>";
							}
							else
								echo "修改失败。点击<a href='javascript:onclick=history.go(-2)'>这里</a>返回<br>";
						}
					}
					if ($_REQUEST['action'] == "insertfood"){
						if (!($_REQUEST['foodname'] and $_REQUEST['price']))
							echo "输入不允许为空。点击<a href='javascript:onclick=history.go(-1)'>这里</a>返回";
						else{
							$SQLDAO=new SQLDAO();
							$foodname=$_REQUEST['foodname'];
							$price=$_REQUEST['price'];
							$shopname=$_REQUEST['shopname'];
							$InsertStr = "insert into food_info(shopname,foodname,price)values('$shopname','$foodname','$price')";
							$result=$SQLDAO->SQL_Insert($InsertStr);
							if ($result){
								if(updateversion($shopname))
									echo "<script>alert('添加成功');location='index.php?action=show&shopname=$shopname';</script>";
							}
							else
								echo "添加失败。点击<a href='javascript:onclick=history.go(-2)'>这里</a>返回<br>";
						}
					}
					function updateversion($shopname)
					{
						$SQLDAO=new SQLDAO();
						$select = "select * from food_tag where shop='$shopname'";
						$result12=$SQLDAO->SQL_Query($select);
						$list=mysql_fetch_array($result12);
						$version=$list["version"]+1;
						$update="update food_tag set version = '$version' where shop='$shopname'";
						$result=$SQLDAO->SQL_Update($update);
						if($result)
						{
							return true;
						}
						else
						{
							return false;
						}
					}
				?> 
			</td>
		</tr>
	</table>
</div>