<?php
	include_once('common.php');
	$name = $_POST['name'];
	$password = $_POST['password'];
	if(empty($name))
	{
		echo "<script> alert('用户名不能为空!'); location.href='reg.php';</script>";
	}
	else if(empty($password))
	{
		echo "<script> alert('密码不能为空!'); location.href='reg.php';</script>";
	}
	else if($password != $_POST['password2'])
	{
		echo "<script> alert('密码不一致!'); location.href='reg.php';</script>";
	}
	else if(mysqli_num_rows(mysqli_query($db, "select name from user where name = '".$name."'")) == 1)
	{
		echo "<script> alert('用户已存在!'); location.href='reg.php';</script>";
	}
	else
	{
		$password = hash("sha256", $password);
		mysqli_query($db, "insert into user values('".$name."', '".$password."', 3, 0)");
		echo "<script> alert('注册成功!'); location.href='index.php';</script>";
	}
?>