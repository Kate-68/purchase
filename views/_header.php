<?php
global $site;
?>

<!DOCTYPE html>
<html lang="cs">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title><?= $this->page->title . ($this->page->title ? ' • ' : null) . $site->title; ?></title>
  	<link rel="icon" href="../assets/img/favicon.ico">
  	<link rel="stylesheet" href="../assets/css/style.css?v=<?= time(); ?>">
</head>

<body>

<div class="header">
	<a href="/">
		<div>
			<img src="/assets/img/cart.png" style="transform: scaleX(-1)"/>
		</div>
		<div>
			<h1>Purchases</h1>
			<p>Under Control<p>
		</div>
		<div>
			<img src="/assets/img/cart.png"/>
		</div>
	</a>
</div>
<?php if(LOGGED_IN) : ?>
	<div class="top-menu">
		<table>
			<tr>
				<td>
					Logged in as: <?php echo LOGGED_NAME ?>
				</td>
				<td style="width: 8em">
					<a class="menu-button" href="logout">Logout</a>
				</td>
			</tr>
		</table>
	</div>
<?php endif ?>