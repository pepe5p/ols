<?php

	session_start();

	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: admm.php');
		exit();
	}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="Shortcut icon" href="img/olslogo.png" />
    <title>OLS | Panel Admina</title>
    <meta name="description" content="Oficjalna strona Oświęcimskiej Ligi Siatkówki." />
    <meta name="keywords" content="liga, siatkówka, ols, regulamin, mecze, drużyny" />
    <meta name="author" content="Piotr Karaś" />

    <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1" />

    <link rel="stylesheet" href="bootstrapcss/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Barlow:900|Source+Sans+Pro:400,700" rel="stylesheet">

    <script src="skrypty/tel_navig.js"></script>
    <script src="skrypty/slide.js"></script>
    <script src="skrypty/months.js"></script>
</head>

<body>

	<form action="php/zaloguj.php" method="post" id="logowanie">
		<i class="icon-login"></i>Login:
		<input type="text" name="login"/>
		<i class="icon-login"></i>Hasło:
		<input type="password" name="haslo"/>
		<input type="submit" value="Zaloguj się "/>
		<?php

			if(isset($_SESSION['blad'])){	
				$blad = $_SESSION['blad'];
				echo "<div class='blad'>$blad</div>";
			}

			session_unset();
		?>
	</form>

</body>

</html>