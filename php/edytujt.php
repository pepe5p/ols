<?php
	
	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: logowanie.php');
		exit();
	}

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0) {
		echo "Error: ".$polaczenie->connect_errno;
	} else {
		$sezon = $_POST['sezon']-2000;

		if(mysqli_num_rows(@$polaczenie->query('SHOW TABLES LIKE druzyny'.$sezon.'_'.($sezon+1)))==0) 
		{
			$newtable = 'CREATE TABLE `baza60034_ols`.`druzyny'.$sezon.'_'.($sezon+1).'` (
			`id` int(11) NOT NULL,
			`nrdruzyny` int(11) NOT NULL,
			`nazwa` text COLLATE utf8_polish_ci NOT NULL,
			`kategoria` text COLLATE utf8_polish_ci NOT NULL,
			`grupa` text COLLATE utf8_polish_ci NOT NULL,
			`wygrane` int(11) NOT NULL,
			`przegrane` int(11) NOT NULL,
			`setywyg` int(11) NOT NULL,
			`setyprzg` int(11) NOT NULL,
			`punktyzd` int(11) NOT NULL,
			`punktystr` int(11) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;';
			@$polaczenie->query($newtable);

			$ustanklucza = 'ALTER TABLE `druzyny'.$sezon.'_'.($sezon+1).'` ADD PRIMARY KEY( `id`)';
			@$polaczenie->query($ustanklucza);

			$ustanai = 'ALTER TABLE `druzyny'.$sezon.'_'.($sezon+1).'` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT';
			@$polaczenie->query($ustanai);
		} else {
			echo dupa;
		}

		header('Location: ../admd.php');
		exit();

		$polaczenie->close();
	}

?>