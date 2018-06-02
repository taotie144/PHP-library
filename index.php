<?php
	setcookie("user", "", time()-10, "/");
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
			<h1 style="opacity: 0.6;">LOG IN</h1>
			<form action="mysql.php" method="post">
				<p>
					<input type="text" name="name" placeholder="用户名" autofocus class="test" />
				</p>
				<p>
					<input type="password" name="password" placeholder="密码" class="test" />
				</p>
				<p>
					<button type="submit" class="but">登录</button>
				</p>
				<p>
					<a href="reg.php">注册新账号</a>
				</p>
			</form>
		</div>
	
	</div>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Pop per.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>