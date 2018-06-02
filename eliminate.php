<?php
	include_once('common.php');
	if(empty($_COOKIE['user']) || $_COOKIE['user'] != 'admin' || empty($_GET['id']) || $_GET['id'] == '已淘汰')
	{
		echo "<script> alert('状态错误!'); location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
	}
	else
	{
		$callno = $_GET['id'];
		if(mysqli_num_rows(mysqli_query($db, "select * from book where callno = '".$callno."'")) == 0)
		{
			echo "<script> alert('无此书!'); location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
		}
		else
		{
			mysqli_query($db, "update book set callno = '已淘汰', stock = 0 where callno = '".$callno."'"); //库存设为0,
			mysqli_query($db, "update user set borrow = borrow - 1 where name in (select name from borrow where callno = '".$callno."' and end is null)"); //已此借书的用户还书
			mysqli_query($db, "update borrow set end = '".date("Y-m-d")."' where callno = '".$callno."' "); //设置还书日期
			echo "<script> alert('淘汰成功!'); location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
		}
	}
?>