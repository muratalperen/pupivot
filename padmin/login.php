<?php
if (isset($_SESSION['user']))
{
  header('Location: ' . URL . 'admin/');
  exit();
}
?>
<!DOCTYPE html>
<html lang="<?php echo $settings->language; ?>" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title><?php echo _w('login'); ?></title>
		<style media="screen">
		*{
			font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
		}
		body{
			background-color: #d2d6de;
			color: #333;
			height: 100%;
			margin: 0px;
		}
		form{
			width: 360px;
			margin: 7% auto;
			padding: 30px 10px;
			margin-top: 100px;
			background-color: #fff;
		}
		form > h1{text-align: center;}
		form > input{
			display: block;
			width: 90%;
			height: 34px;
			padding: 6px 12px;
			font-size: 14px;
			line-height: 1.42857143;
			color: #555;
			background-color: #fff;
			background-image: none;
			border: 1px solid #ccc;
			margin: auto;
		}
		form > a{
			display: block;
			text-align: center;
			margin:20px;
			color: #555;
		}
		.error{
			color: red;
			padding: 12px;
		}
		@media only screen and (max-width:768px){
			form{
				width: 90%;
			}
		}
		</style>
	</head>
	<body>

		<form action="api/login" method="post">
			<h1><?php echo _w('login'); ?></h1>
		  <?php echo isset($_GET['redirect']) ? '<input type="hidden" name="redirect" value="' . htmlspecialchars($_GET['redirect']) . '">' : '' ; ?>
		  <input type="email" name="mail" autofocus="autofocus" placeholder="<?php echo _w('mail'); ?>" autofocus required><br>
		  <input type="password" name="password" placeholder="<?php echo _w('password'); ?>" required><br>
			<?php echo isset($_GET['error']) ? '<p class="error">' . _w($_GET['error']) . '</p>' : '' ; ?>
		  <input type="submit" value="<?php echo _w('login'); ?>">

			<a href="https://github.com/muratalperen/" target="_blank"><?php echo _w('poweredByText'); ?></a>
		</form>

	</body>
</html>
