<?php
	
	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo']))) {
		header('Location: ../logowanie.php');
		exit();
	}

	// $login = $_POST['login'];
	// $haslo = $_POST['haslo'];
	// $pass = '$2y$10$DlBBjWhhrKnGtfXUOxoJ9.fU5VCiB2vB.jVsQe6i6UoSfxSggNrVi';
	// $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

	// if((($login == "pioter") || ($login == "krysia")) && (password_verify($haslo, $pass))) {
	 	$_SESSION['zalogowany'] = true;
	 	header('Location: ../admm.php');
	// } else {
	// 	$_SESSION['blad'] = 'Nieprawidłowy login lub hasło!';
	// 	header('Location: logowanie.php');
	// }
?> 