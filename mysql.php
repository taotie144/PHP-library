<?php
	include_once('common.php');
	if(isset($_COOKIE["user"]))
	{
		$name = $_COOKIE["user"];
	}
	else
	{
		$name = $_POST['name'];
		$password = $_POST['password'];
		$password = hash("sha256", $password);
		$result = mysqli_query($db, "select * from user where name = '".$name."'");
		if(mysqli_num_rows($result) == 0)
		{
			echo "<script> alert('用户不存在!'); location.href='index.php';</script>";
		}
		if($password != mysqli_fetch_array($result)['passwd'])
		{
			echo "<script> alert('密码错误!'); location.href='index.php';</script>";
		}
	}
//	print("成功连接数据库");
//	echo $name;
	setcookie("user", $name, time()+3600, "/");
	$result = mysqli_fetch_array(mysqli_query($db, "select * from user where name = '".$name."'"));
	$num = $result['num'];
	$borrow = $result['borrow'];
	$search = ""; //记录搜索的关键字
	$callno; //记录索书号
	$book;//记录查询结果
	$list = false;
	if(isset($_GET['list']) && $_GET['list'] == 1)
	{
		$list = true;
		$history = mysqli_query($db, "select * from borrow, book where borrow.name = '".$name."' and borrow.callno = book.callno order by borrow.end asc");
		if(isset($_GET['callno']))
		{
			$callno = $_GET['callno'];
			if(mysqli_num_rows(mysqli_query($db, "select * from borrow where borrow.name = '".$name."' and borrow.callno = '".$callno."' and end is null")) == 1)
			{
				mysqli_query($db, "update borrow set end = '".date("Y-m-d")."' where name = '".$name."' and callno ='".$callno."'");
				mysqli_query($db, "update user set borrow = borrow - 1 where name = '".$name."'");
				mysqli_query($db, "update book set stock = stock + 1 where callno = '".$callno."'");
				echo "<script> alert('归还成功!'); location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
			}
			else
			{
				echo "<script> alert('归还失败!'); location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
			}
		}
	}
	if(!isset($_GET['list']) && isset($_GET['search']))//使用GET方式传输搜索关键字
	{
		$search = $_GET['search'];
		if($search == '已淘汰')
		{
			$book = mysqli_query($db, "select * from book where callno = '已淘汰'");
		}
		else
		{
			$book = mysqli_query($db, "select * from book where callno != '已淘汰' and (title like '%".$search."%' or author like '%".$search."%' or callno like '%".$search."%' or isbn like '%".$search."%' or publisher like '%".$search."%')");
		}
	}
	else
	{
		$book = mysqli_query($db, "select * from book where callno != '已淘汰'");
	}
	if(!isset($_GET['list']) && isset($_GET['id']))
	{
		$callno = $_GET['id'];
		if($borrow >= $num)
		{
			echo "<script> alert('借阅量达到上限!'); location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
		}
		else if(mysqli_num_rows((mysqli_query($db, "select stock from book where callno = '".$callno."'"))) == 0)
		{
			echo "<script> alert('索书号错误!'); location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
		}
		else if(mysqli_fetch_array(mysqli_query($db, "select stock from book where callno = '".$callno."'"))['stock'] == 0)
		{
			echo "<script> alert('暂无库存!'); location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
		}
		else if(mysqli_num_rows(mysqli_query($db, "select * from borrow where name = '".$name."' and callno = '".$callno."' and end is null")) != 0)
		{
			echo "<script> alert('正在借阅此书!'); location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
		}
		else
		{
			$date = date("Y-m-d");
			mysqli_query($db, "update book set stock = stock -1 where callno = '".$callno."'");
			mysqli_query($db, "update user set borrow = borrow + 1 where name = '".$name."'");
			mysqli_query($db, "insert into borrow values ('".$name."', '".$callno."', '".$date."', null )");
			echo "<script> alert('借阅成功!'); location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
		}
	}
?>
<!DOCTYPE html>
<html style="height: 100%">
<head>
	<style type="text/css">
		.test {width: 100%; padding: 6px; font-size: 1.1em;}
		.but {border: none; background-color: #467b96; color: white; font-weight: bold; height: 40px; width: 100%;}
	</style>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
	<title>图书管理系统</title>
</head>
<body style="background-color: #f4f8ff; height: 100%">
	<div class="container" style="height: 100%; display: table">
		<div class="text-center" style="display: table-cell;padding: 30px 0 0 0">
			<h2 style="opacity: 0.6; text-align: left">
				<?php echo $name == 'admin' ? "管理员" : "学生"; //判断是学生还是管理员 ?> 
				<b><i><?php echo $name; ?></i></b> 欢迎使用图书管理系统
			</h2>
			<p style="opacity: 0.6; text-align: left; position: relative; top: 6px">
				<?php echo "今天是 " . date("Y-m-d-l"); ?>
			</p>
			<p style="opacity: 0.6; text-align: left;">
				您可借阅 <b><i><?php echo $num; ?></i></b> 本书，已借阅 <b><i><?php echo $borrow; ?></i></b> 本书   
			<?php
				if(!$list)
				{
			?>
				<a href="mysql.php?list=1">查看借阅历史  </a>
			<?php
				}
				else
				{
			?>
				<a href="mysql.php">返回</a>
			<?php
				}
			?>
			<?php
				if($name == 'admin')
				{
			?>
				<a href="purchase.php">采购图书 </a>
			<?php
				}
			?>
				<a href="index.php">退出</a>
			</p>
			<?php
				if(!$list)
				{
			?>
			<form action="mysql.php" method="get">
				<p style="text-align: left">
					<input type="text" name="search" placeholder="搜索图书" value="<?php echo $search; ?>" autofocus class="test" style="width: 250px" />
					<input type="submit" value="搜索" style="text-align: right; height: 41px; width: auto; border: 1px;" />
					
				</p>
			</form>
			<?php
				}
				else
				{
			?>
			<?php
				}
			?>
			<table width=100% border="1" cellspacing="0" cellpadding="0">
				<?php
					$i = 0;
					if(!$list)
					{
				?>
					<tr>
						<th>编号</th><th>标题</th><th>作者</th><th>索书号</th><th>ISBN</th><th>出版社</th><th>库存</th><th>出版年份</th>
				<?php
						if($search != '已淘汰')
						{
				?>
						<th>借阅</th>
				<?php
						
							if($name == 'admin')
							{
				?>
						<th>淘汰</th>
				<?php
							}
						}
				?>
					</tr>
				<?php
						while($temp = mysqli_fetch_array($book))
						{
							$i++;
				?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $temp[0]; ?></td>
						<td><?php echo $temp[1]; ?></td>
						<td><?php echo $temp[2]; ?></td>
						<td><?php echo $temp[3]; ?></td>
						<td><?php echo $temp[4]; ?></td>
						<td><?php echo $temp[5]; ?></td>
						<td><?php echo $temp[6]; ?></td>
				<?php
							if($search != '已淘汰')
							{
				?>
						<td><a href="<?php echo "mysql.php?id=$temp[2]"; ?>">借阅</a></td>
						<?php							
								if($name == 'admin')
								{
						?>
						<td><a href="<?php echo "eliminate.php?id=$temp[2]" ?>">淘汰</a></td>
						<?php
								}
							}
						?>
					</tr>
				<?php
						}
					}
					else
					{
				?>
					<tr><th>编号</th><th>索书号</th><th>标题</th><th>出版社</th><th>借书日期</th><th>还书日期</th><th>归还</th></tr>
				<?php
						while($temp = mysqli_fetch_array($history))
						{
							$i++;
				?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $temp['callno']; ?></td>
						<td><?php echo $temp['title']; ?></td>
						<td><?php echo $temp['publisher']; ?></td>
						<td><?php echo $temp['start']; ?></td>
						<td><?php echo empty($temp['end'])?"未归还":$temp['end']; ?></td>
						<td>
						<?php
							if(empty($temp['end']))
							{
						?>
							<a href="<?php echo "mysql.php?list=1&callno=".$temp['callno']; ?>">归还</a>
						<?php
							}
							else
							{
								echo "已归还";
							}
						?>
						</td>
					</tr>
				<?php
						}
					}
				?>
			</table>
			<p style="text-align: left">
				<?php
					if($search == '已淘汰')
					{
				?>
				<a href="mysql.php">>>>返回</a>
				<?php
					}
					else if(!$list)
					{
				?>
				<a href="mysql.php?search=已淘汰">>>>查看已淘汰图书</a>
				<?php
					}
				?>
			</p>
		</div>
	</div>
</body>