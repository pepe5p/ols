<?php
	
	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../logowanie.php');
		exit();
	}

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0) {
		echo "Error: ".$polaczenie->connect_errno;
	} else {
		if (isset($_POST['update_button'])) {

			$id = $_POST['id'];
			$sezon = $_POST['sezon'];
			
			$nrdruzyny = $_POST['nrdruzyny'];
			$nazwa = $_POST['nazwa'];
			$kategoria = $_POST['kategoria'];
			$grupa = $_POST['grupa'];
			$wygrane = $_POST['wygrane'];
			$przegrane = $_POST['przegrane'];
			$setywyg = $_POST['setywyg'];
			$setyprzg = $_POST['setyprzg'];
			$punktyzd = $_POST['punktyzd'];
			$punktystr = $_POST['punktystr'];

			$nazwas = (string)$nazwa;

			if(($_FILES["teamimg"]["name"])!=""){
				$target_dir = "../img/druzyny/$sezon/";
				$target_file = $target_dir.$id.".jpg";
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				if(!move_uploaded_file($_FILES["teamimg"]['tmp_name'], $target_file)) {
					echo 'coś poszło nie tak';
				} else {
					header('Location: ../admd.php');
					exit();
				}
			}

			if($nrdruzyny!="") {
				$sql = "UPDATE ".$sezon." SET nrdruzyny=".$nrdruzyny." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($nazwas!="") {
				$sql = "UPDATE ".$sezon." SET nazwa='".$nazwas."' WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($kategoria!="") {
				$sql = "UPDATE ".$sezon." SET kategoria='".$kategoria."' WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($grupa!="") {
				$sql = "UPDATE ".$sezon." SET grupa='".$grupa."' WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($wygrane!="") {
				$sql = "UPDATE ".$sezon." SET wygrane=".$wygrane." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($przegrane!="") {
				$sql = "UPDATE ".$sezon." SET przegrane=".$przegrane." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($setywyg!="") {
				$sql = "UPDATE ".$sezon." SET setywyg=".$setywyg." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($setyprzg!="") {
				$sql = "UPDATE ".$sezon." SET setyprzg=".$setyprzg." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($punktyzd!="") {
				$sql = "UPDATE ".$sezon." SET punktyzd=".$punktyzd." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($punktystr!="") {
				$sql = "UPDATE ".$sezon." SET punktystr=".$punktystr." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}

		} else if (isset($_POST['delete_button'])) {
			$id = $_POST['id'];
			$sezon = $_POST['sezon'];
			$sql = "DELETE FROM ".$sezon." WHERE id='".$id."';";

			$rezultat = @$polaczenie->query($sql);
			echo $sql;
		}

		header('Location: ../admd.php');
		exit();

		$polaczenie->close();
	}

?>