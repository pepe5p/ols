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

		date_default_timezone_set('Europe/Warsaw');
		$info = getdate();
		$jakim = $info['mon'];
		$jakir = $info['year'];

		if($jakim<6) $thetabela = "druzyny".($jakir-2001)."_".($jakir-2000);
		else $thetabela = "druzyny".($jakir-2000)."_".($jakir-1999);

		$id = $_POST['id'];
		$idgosc = $_POST['idgosc'];
		$idgosp = $_POST['idgosp'];
		$data = $_POST['data'];
		$godzina = $_POST['godzina'];
		$gosc1s = $_POST['gosc1s'];
		$gosp1s = $_POST['gosp1s'];
		$gosc2s = $_POST['gosc2s'];
		$gosp2s = $_POST['gosp2s'];
		$gosc3s = $_POST['gosc3s'];
		$gosp3s = $_POST['gosp3s'];
		$setygoscold = $_POST['setygosc'];
		$setygospold = $_POST['setygosp'];
		$gosc1sold = $_POST['gosc1sold'];
		$gosp1sold = $_POST['gosp1sold'];
		$gosc2sold = $_POST['gosc2sold'];
		$gosp2sold = $_POST['gosp2sold'];
		$gosc3sold = $_POST['gosc3sold'];
		$gosp3sold = $_POST['gosp3sold'];

		if($setygoscold == "?") $setygoscold = 0;
		if($setygospold == "?") $setygospold = 0;

		#pkt
		$goscpktold = $gosc1sold + $gosc2sold + $gosc3sold;
		$gosppktold = $gosp1sold + $gosp2sold + $gosp3sold;
		$goscpkt = $gosc1s + $gosc2s + $gosc3s;
		$gosppkt = $gosp1s + $gosp2s + $gosp3s;

		$bilansgosc = $goscpkt - $goscpktold;
		$bilansgosp = $gosppkt - $gosppktold;
			
		#sety
		$setygosc = 0;
		$setygosp = 0;

		if($gosc1s>$gosp1s) $setygosc++;
		else if($gosc1s<$gosp1s) $setygosp++;

		if($gosc2s>$gosp2s) $setygosc++;
		else if($gosc2s<$gosp2s) $setygosp++;

		if($gosc3s>$gosp3s) $setygosc++;
		else if($gosc3s<$gosp3s) $setygosp++;

		$bilanssetygosc = $setygosc - $setygoscold;
		$bilanssetygosp = $setygosp - $setygospold;
			
		#wygrane i przegrane
		$wygralgoscold = 0;
		$wygralgospold = 0;
		$wygralgoscnew = 0;
		$wygralgospnew = 0;

		if($setygoscold > $setygospold) $wygralgoscold = 1;
		else if($setygoscold < $setygospold) $wygralgospold = 1;

		if($setygosc > $setygosp) $wygralgoscnew = 1;
		else if($setygosc < $setygosp) $wygralgospnew = 1;

		$zmianapktgosc = 0;
		$zmianapktgosp = 0;

		if(($wygralgoscold == $wygralgospold) && ($wygralgoscnew > $wygralgospnew)) {
			$zmianapktgosc = 1;
		} else if(($wygralgoscold == $wygralgospold) && ($wygralgoscnew < $wygralgospnew)) {
			$zmianapktgosp = 1;
		} else if(($wygralgoscold > $wygralgospold) && ($wygralgoscnew == $wygralgospnew)) {
			$zmianapktgosc = -1;
		} else if(($wygralgoscold < $wygralgospold) && ($wygralgoscnew == $wygralgospnew)) {
			$zmianapktgosp = -1;
		} else if(($wygralgoscold > $wygralgospold) && ($wygralgoscnew < $wygralgospnew)) {
			$zmianapktgosc = -1;
			$zmianapktgosp = 1;
		} else if(($wygralgoscold < $wygralgospold) && ($wygralgoscnew > $wygralgospnew)) {
			$zmianapktgosc = 1;
			$zmianapktgosp = -1;
		}
		
		if (isset($_POST['update_button'])) {

			$godzinas = (string)$godzina;

			if($data!="") {
				$sql = "UPDATE mecze SET data='".$data."' WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($godzina!="") {
				$sql = "UPDATE mecze SET godzina='".$godzina."' WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($gosc1s!="") {
				$sql = "UPDATE mecze SET gosc1s=".$gosc1s." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($gosp1s!="") {
				$sql = "UPDATE mecze SET gosp1s=".$gosp1s." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($gosc2s!="") {
				$sql = "UPDATE mecze SET gosc2s=".$gosc2s." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($gosp2s!="") {
				$sql = "UPDATE mecze SET gosp2s=".$gosp2s." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($gosc3s!="") {
				$sql = "UPDATE mecze SET gosc3s=".$gosc3s." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}
			if($gosp3s!="") {
				$sql = "UPDATE mecze SET gosp3s=".$gosp3s." WHERE id=".$id.";";
				$rezultat = @$polaczenie->query($sql);
			}

			#aktualiwoanie tabeli drużyn
			if(($bilansgosc != 0) || ($bilansgosp != 0)) {
				$sql = "UPDATE ".$thetabela." SET punktyzd = punktyzd + ".$bilansgosc.", punktystr = punktystr + ".$bilansgosp." WHERE id=".$idgosc.";";
				$rezultat = @$polaczenie->query($sql);
				$sql2 = "UPDATE ".$thetabela." SET punktyzd = punktyzd + ".$bilansgosp.", punktystr = punktystr + ".$bilansgosc." WHERE id=".$idgosp.";";
				$rezultat2 = @$polaczenie->query($sql2);
			}
			if(($bilanssetygosc != 0) || ($bilanssetygosp != 0)) {
				$sql = "UPDATE ".$thetabela." SET setywyg = setywyg + ".$bilanssetygosc.", setyprzg = setyprzg + ".$bilanssetygosp." WHERE id=".$idgosc.";";
				$rezultat = @$polaczenie->query($sql);
				$sql2 = "UPDATE ".$thetabela." SET setywyg = setywyg + ".$bilanssetygosp.", setyprzg = setyprzg + ".$bilanssetygosc." WHERE id=".$idgosp.";";
				$rezultat2 = @$polaczenie->query($sql2);
			}
			if(($zmianapktgosc != 0) || ($zmianapktgosp != 0)) {
				$sql = "UPDATE ".$thetabela." SET wygrane = wygrane + ".$zmianapktgosc.", przegrane = przegrane + ".$zmianapktgosp." WHERE id=".$idgosc.";";
				$rezultat = @$polaczenie->query($sql);
				$sql2 = "UPDATE ".$thetabela." SET wygrane = wygrane + ".$zmianapktgosp.", przegrane = przegrane + ".$zmianapktgosc." WHERE id=".$idgosp.";";
				$rezultat2 = @$polaczenie->query($sql2);
			}

		} else if (isset($_POST['delete_button'])) {

			$sql = "DELETE FROM mecze WHERE id='".$id."';";
			$rezultat = @$polaczenie->query($sql);

			if(($goscpktold != 0) || ($gosppktold != 0)) {
				$sql = "UPDATE ".$thetabela." SET punktyzd = punktyzd - ".$goscpktold.", punktystr = punktystr - ".$gosppktold." WHERE id=".$idgosc.";";
				$rezultat = @$polaczenie->query($sql);
				$sql2 = "UPDATE ".$thetabela." SET punktyzd = punktyzd - ".$gosppktold.", punktystr = punktystr - ".$goscpktold." WHERE id=".$idgosp.";";
				$rezultat2 = @$polaczenie->query($sql2);
			}
			if(($setygoscold != 0) || ($setygospold != 0)) {
				$sql = "UPDATE ".$thetabela." SET setywyg = setywyg - ".$setygoscold.", setyprzg = setyprzg - ".$setygospold." WHERE id=".$idgosc.";";
				$rezultat = @$polaczenie->query($sql);
				$sql2 = "UPDATE ".$thetabela." SET setywyg = setywyg - ".$setygospold.", setyprzg = setyprzg - ".$setygoscold." WHERE id=".$idgosp.";";
				$rezultat2 = @$polaczenie->query($sql2);
			}
			if(($wygralgoscold != 0) || ($wygralgospold != 0)) {
				$sql = "UPDATE ".$thetabela." SET wygrane = wygrane - ".$wygralgoscold.", przegrane = przegrane - ".$wygralgospold." WHERE id=".$idgosc.";";
				$rezultat = @$polaczenie->query($sql);
				$sql2 = "UPDATE ".$thetabela." SET wygrane = wygrane - ".$wygralgospold.", przegrane = przegrane - ".$wygralgoscold." WHERE id=".$idgosp.";";
				$rezultat2 = @$polaczenie->query($sql2);
			}

		}

		header('Location: ../admm.php');
		exit();

		$polaczenie->close();
	}

?>