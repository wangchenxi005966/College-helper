<table width="100%" height="100%" align="center" cellpadding="1" cellspacing="0" id="content" borderColor="#ff6600"  bgColor="#fffbec" border="1" frame="void">
	<style type="text/css">
		a
		{
			TEXT-DECORATION:none;
		}
		a:hover{TEXT-DECORATION:underline}
	</style>

	<tr width="100%" height="30%">
		<td>
			<div width="100%">
				<table width="100%" style="margin-top:0">
					<tr width="100%">
						<td>
							 <img  src="img/8.gif" />
						</td>
						<td>
						<?php
							$shopname=$_REQUEST['shopname'];
							$SQLDAO=new SQLDAO();
							$QueryStr="select * from food_tag where shop='$shopname'";
							$result=$SQLDAO->SQL_Query($QueryStr);
							$list=mysql_fetch_array($result);
							$owner=$list["owner"];
							echo "<p style='color:red' align='left'>店名：".$shopname."</p><p style='color:red' align='left'>店主：".$owner."</p>";            
						?>
						</td>
					</tr>
				</table>
				<table>
					<tr>
						<td>
							<table>
								<tr>
									<td width="20%">
										<img style="height:12%;width:80%" src="img/star.png" />
									</td>
									<td width="20%">
										<img style="height:12%;width:80%" src="img/star.png" />
									</td>
									<td width="20%">
										<img style="height:12%;width:80%" src="img/star.png" />
									</td>
									<td width="20%">
										<img style="height:12%;width:80%" src="img/star.png" />
									</td>
									<td width="20%">
										<img style="height:12%;width:80%" src="img/star.png" />
									</td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
	<tr width="100%" height="70%">
		<td style="padding:0" style="text-align:left">
			<h4 style="color:green">食品安全，从点滴做起！</h4>
			<ul style="color:red;" align="left"><h3 align="left">食品安全法</h3>
				<li ><span><a href="http://www.lawtime.cn/info/shipin/zhiliang/20120320242127.html" target="_blank">食品质量标准体系</a></span></li>
				<li><span><a href="http://www.lawtime.cn/info/shipin/shiwu/20120320242126.html"
				 target="_blank">食品安全管理制度</a></span></li>
				<li><span><a href="http://www.lawtime.cn/info/shipin/shiwu/20120320242123.html" target="_blank">选择安全食品的注意事项</a></span></li>
			</ul>
			<ul style="color:red;" align="left"><h3 align="left">食品安全风波</h3>
				<li><span><a href="http://www.cnpad.net/News/V14214.html" target="_blank">德国“毒黄瓜”风波</a></span></li>
				<li><span><a href="http://www.cnpad.net/News/V14215.html" target="_blank">美国“沙门氏菌污染鸡蛋”事件</a></span></li>
				<li><span><a href="http://www.cnpad.net/news/v14213.html" target="_blank">日本"毒大米"事件</a></span></li>
			</ul>
		</td>
	</tr>
	  <!--<script>
	  ShowAd();
	  </script>-->
</table>