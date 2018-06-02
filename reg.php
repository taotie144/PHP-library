<?php
	setcookie("user", "", time()-10);
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
	<div class="container" style="height: 100%; display: table; width: 300px">
		<div class="text-center" style="display: table-cell;vertical-align: middle;padding: 20px 0 150px">
			<h1 style="opacity: 0.6;">SIGN IN</h1>
			<form action="signin.php" method="post">
				<p>
					<input type="text" name="name" placeholder="用户名" autofocus class="test" />
				</p>
				<p>
					<input type="password" name="password" placeholder="密码" class="test" />
				</p>
				<p>
					<input type="password" name="password2" placeholder="确认密码" class="test" />
				</p>
				<p>
					<button type="submit" name ="submit" class="but">注册</button>
				</p>
			</form>
		</div>
	</div>
</body>