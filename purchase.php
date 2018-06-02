<?php
	include_once('common.php');
	$title = isset($_GET['title']) ? $_GET['title'] : "";
	$author = isset($_GET['author']) ? $_GET['author'] : "";
	$callno = isset($_GET['callno']) ? $_GET['callno'] : "";
	$isbn = isset($_GET['isbn']) ? $_GET['isbn'] : "";
	$publisher = isset($_GET['publisher']) ? $_GET['publisher'] : "";
	$stock = isset($_GET['stock']) ? $_GET['stock'] : "";
	$year = isset($_GET['year']) ? $_GET['year'] : "";
	if(empty($_COOKIE['user']) || $_COOKIE["user"] != 'admin')
	{
		echo "<script> alert('状态错误!'); location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
	}
	else if(isset($_GET['submit']))
	{
		if(empty($title) || empty($author) || empty($callno) || empty($publisher) || empty($stock) || empty($year) || $stock == 0 || $callno == '已淘汰')
		{
			echo "<script> alert('输入为空或者状态错误!'); location.href='purchase.php?title=$title&author=$author&callno=$callno&isbn=$isbn&publisher=$publisher&stock=$stock&year=$year';</script>";
		}
		else if(mysqli_num_rows(mysqli_query($db, "select * from book where callno = '".$callno."'")) > 0)
		{
			echo "<script> alert('索书号重复!'); location.href='purchase.php?title=$title&author=$author&callno=$callno&isbn=$isbn&publisher=$publisher&stock=$stock&year=$year';</script>";
		}
		else //输入无误
		{
			mysqli_query($db, "insert into book values('".$title."', '".$author."', '".$callno."', '".$isbn."', '".$publisher."', '".$stock."', '".$year."')");
			$title = "";
			$author = "";
			$callno = "";
			$isbn = "";
			$publisher = "";
			$stock = "";
			$year = "";
			echo "<script> alert('采购成功!'); location.href='purchase.php';</script>";
		}
	}
?>

<!doctype html>
<html>
<head>
	<style type="text/css">
		.test {width: 100%; padding: 6px; font-size: 1.1em;}
		.but {border: none; background-color: #467b96; color: white; font-weight: bold; height: 40px; width: 100%;}
		th {width: 100px; padding: 5px; height: auto;}
	</style>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
	<title>图书采购系统</title>
</head>

<body style="background-color: #f4f8ff; height: 100%">
	<div class="container" style="height: 100%; display: table">
		<div class="text-center" style="display: table-cell;padding: 30px 0 0 0">
			<h2 style="opacity: 0.6; text-align: left">
				管理员 <b><i>admin</i></b> 欢迎使用图书采购系统
			</h2>
			<p style="opacity: 0.6; text-align: left; position: relative; top: 6px">
				<?php echo "今天是 " . date("Y-m-d-l"); ?>
				<a href="mysql.php">  返回首页</a>
			</p>
			<form action="purchase.php?yes=1" method="get" style="padding: 10px">
			<table>
			<tr>
				<th style="text-align: left">书名</th>
				<td><input type="text" name="title" value="<?php echo isset($title)?$title:""; ?>" style="width: 300px" /></td>
			</tr>
			<tr>
				<th style="text-align: left">作者</th>
				<td><input type="text" name="author" value="<?php echo isset($author)?$author:""; ?>" style="width: 300px" /></td>
			</tr>
			<tr>
				<th style="text-align: left">索书号</th>
				<td><input type="text" name="callno" value="<?php echo isset($callno)?$callno:""; ?>" style="width: 300px" /></td>
			</tr>
			<tr>
				<th style="text-align: left">ISBN</th>
				<td><input type="text" name="isbn" value="<?php echo isset($isbn)?$isbn:""; ?>" style="width: 300px" /></td>
			</tr>
			<tr>
				<th style="text-align: left">出版社</th>
				<td><input type="text" name="publisher" value="<?php echo isset($publisher)?$publisher:""; ?>" style="width: 300px" /></td>
			</tr>
			<tr>
				<th style="text-align: left">数量</th>
				<td><input type="number" name="stock" value="<?php echo isset($stock)?$stock:""; ?>" style="width: 300px" /></td>
			</tr>
			<tr>
				<th style="text-align: left">出版年份</th>
				<td><input type="number" name="year" value="<?php echo isset($year)?$year:""; ?>" style="width: 300px" /></td>
			</tr>
			<tr>
				<th> </th>
				<td style="text-align: left"><input type="submit" value="确认采购" name="submit" /></td>
			</tr>
			</table>
			</form>
		</div>
	</div>
</body>
</html>