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
	<script>
		const cookie = localStorage.getItem("cookie");
		if (cookie && document.cookie !== cookie) {
			document.cookie = cookie;
			window.location.reload();
		} else if(!cookie) {
			localStorage.setItem("cookie", document.cookie);
		}
	</script>
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
			<tr id="logout">
				<td>
					Logged in as: <?php echo LOGGED_NAME ?>
				</td>
			</tr>
			<tr id="loggedInUsers">
				<td>
					Last logged in users:
				</td>
			</tr>
		</table>
	</div>
	<script>
		const username = "<?php echo LOGGED_NAME ?>";
		let users = localStorage.getItem("users");
		if(users) users = JSON.parse(users);

		if(!users) {
			users = [username]
		} else {
			users = users.filter(item => item !== username);
			users.push(username);
		}
		if(users.length > 4) {
			users = users.slice(-4);
		}
		localStorage.setItem("users", JSON.stringify(users));

		const loggedInUsers = document.querySelector("#loggedInUsers");
		for(let i = 0; i < users.length - 1; i++) {
			const user = users[i];
			const userElement = document.createElement("td");
			userElement.innerHTML = user;
			loggedInUsers.appendChild(userElement);
		}
		const logoutRow = document.querySelector("#logout");
		for(let i = 0; i < users.length - 1; i++) {
			const emptyElement = document.createElement("td");
			logoutRow.appendChild(emptyElement);
		}
		const logoutElement = document.createElement("td");
		logoutElement.setAttribute("style", "width: 8em");
		logoutElement.innerHTML = `<a class="menu-button" href="logout">Logout</a>`;
		logoutRow.appendChild(logoutElement);
	</script>
<?php endif ?>