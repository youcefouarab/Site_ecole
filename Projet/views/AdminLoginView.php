<?php

class AdminLoginView extends View {
    function __construct($err = "") {
        parent::__construct();

        ?>

<!DOCTYPE html>
<html>
<head>
	<title>Login - Administration</title>
	<meta charset="utf-8">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<style type="text/css">
		body {
			background-color: #273d5d;
		}
		div.login {
			width: 50%;
			height: 50%;
			background-color: #fff;
			border-radius: 10px;
		}
		.center {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
		}
		div.login input, div.login button {
			border: none;
			border-bottom: 2px solid #888;
			padding: 10px;
			margin: 10px;
		}
		div.login button {
			background-color: #2771e8;
			color: #fff;
		}
		div.login button:hover {
			cursor: pointer;
		}
		.err {
			font-size: 12px;
			font-weight: bold;
			color: red;
		}
	</style>
</head>
<body>
	<font face="Arial">
		<center>
			<div class="login center">
				<form method="POST" action="<?php echo BASE_URL ?>adminlogin/login" class="center">
					<input type="text" name="login" placeholder="Nom d'utilisateur" required><br><br>
					<input type="password" name="password" placeholder="Mot de passe" required><br><br>
                    <?php if ($err == "err") echo '<label class="err">Login ou mot de passe incorrect</label><br>'; ?>
					<button type="submit"><b>Se Connecter</b></button>
				</form>
			</div>
		</center>
	</font>
</body>
</html>

        <?php
    }
}


