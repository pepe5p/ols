<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: logowanie.php');
		exit();
	}

	require_once "php/connect.php";

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

	<script src="skrypty/admin.js"></script>
    <script src="skrypty/tel_navig.js"></script>
    <script src="skrypty/months.js"></script>
</head>

<body>

    <div id="thebigtop"></div>

	<div id="wrapper" class="container-fluid">

		<?php include_once "php/admnav.php"; ?>

		<main>
			
			<div id="tabelacontent">
				
				<?php

					$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
					if ($polaczenie->connect_errno!=0)
					{
						echo "Error: ".$polaczenie->connect_errno;
					}
					else
					{
						#SPRAWDZENIE OBECNEGO ROKU
						date_default_timezone_set('Europe/Warsaw');
						$info = getdate();
						$jakim = $info['mon'];
						$jakir = $info['year'];

						if($jakim<6) $thetabela = "druzyny".($jakir-2001)."_".($jakir-2000);
						else $thetabela = "druzyny".($jakir-2000)."_".($jakir-1999);
						
						if(mysqli_num_rows(@$polaczenie->query("SHOW TABLES LIKE '".$thetabela."'"))==0) 
						{
							$newtable = 'CREATE TABLE `baza60034_ols`.'.$thetabela.' (
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

							$ustanklucza = 'ALTER TABLE `'.$thetabela.'` ADD PRIMARY KEY( `id`)';
							@$polaczenie->query($ustanklucza);

							$ustanai = 'ALTER TABLE `'.$thetabela.'` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT';
							@$polaczenie->query($ustanai);
						}

						#POBRANIE TABELI Z USTAWIEŃ
						$opt1 = 'SELECT ustawienie FROM ustawienia WHERE nazwa = "segadmm"';
						if($optrezultat1 = @$polaczenie->query($opt1))
						{
							$row = mysqli_fetch_assoc($optrezultat1);
							$seg = $row['ustawienie'];
						}
						$opt2 = 'SELECT ustawienie FROM ustawienia WHERE nazwa = "katadmm"';
						if($optrezultat2 = @$polaczenie->query($opt2))
						{
							$row = mysqli_fetch_assoc($optrezultat2);
							$kat = $row['ustawienie'];
						}
						$opt3 = 'SELECT ustawienie FROM ustawienia WHERE nazwa = "iddadmm"';
						if($optrezultat3 = @$polaczenie->query($opt3))
						{
							$row = mysqli_fetch_assoc($optrezultat3);
							$idwybd = $row['ustawienie'];
						}
						
						#POBRANIE DRUŻYN Z OBECNEGO SEZONU
						$sql0 = 'SELECT id, nrdruzyny, kategoria, nazwa, grupa FROM '.$thetabela.' ORDER BY kategoria, nrdruzyny';
						if($rezultat0 = @$polaczenie->query($sql0))
						{
							$ilem0 = mysqli_num_rows($rezultat0);

							$selekcik1 = '<option value="0">Wszystkie mecze</option>';
							$selekcik2 = '<option value="0">Wszystkie mecze</option>';
							
							$selekcik1n = '';
							$selekcik2n = '';

							#USTAWIANIE OSTATNIEGO WYSZUKIWANIA
							$wybranyols1 = '';
							$wybranyols2 = '';
							$wybranyols1i2 = '';
							$pokaols1 = "";
							$pokaols2 = "";
							$pokamonth = '';
							$pokaall = '';

							if(isset($_POST['kategoria'])){
								$kat = $_POST['kategoria'];
								$pokaols1 = 'display: none';
								$pokaols2 = 'display: none';
							}
							
							if($kat=="OLS1i") {
								if(isset($_POST['idwybd1'])) $wd = (int)$_POST['idwybd1'];
								else $wd = $idwybd;
								$wybranyols1 = "selected";
								$pokaols1 = 'display: block';
							} else if($kat=="OLS2i") {
								if(isset($_POST['idwybd2'])) $wd = (int)$_POST['idwybd2'];
								else $wd = $idwybd;
								$wybranyols2 = "selected";
								$pokaols2 = 'display: block';
							} else $wybranyols1i2 = "selected";

							if(isset($_POST['segregacja'])) $seg = $_POST['segregacja'];
							if($seg == "month") $pokamonth = 'selected';
							else $pokaall = 'selected';

							for ($i = 1; $i <= $ilem0; $i++) 
							{
								$row = mysqli_fetch_assoc($rezultat0);
								$idd[$i] = $row['id'];
								$nrdruzyny[$idd[$i]] = $row['nrdruzyny'];
								$nazwa[$idd[$i]] = $row['nazwa'];
								$kategoriad[$i] = $row['kategoria'];
								$grupa[$idd[$i]] = $row['grupa'];
								
								$wybranad = "";
								
								if((isset($wd)) && ($idd[$i] == $wd)) {
									$wybranad = "selected";
								}
								
								if($kategoriad[$i]=="OLS1") {
									$selekcik1 = $selekcik1."<option value=".$idd[$i]." ".$wybranad.">(".$nrdruzyny[$idd[$i]].") ".$nazwa[$idd[$i]]." (gr.".$grupa[$idd[$i]].")</option>";
									$selekcik1n = $selekcik1n."<option value=".$idd[$i].">(".$nrdruzyny[$idd[$i]].") ".$nazwa[$idd[$i]]." (gr.".$grupa[$idd[$i]].")</option>";
								} else {
									$selekcik2 = $selekcik2."<option value=".$idd[$i]." ".$wybranad.">(".$nrdruzyny[$idd[$i]].") ".$nazwa[$idd[$i]]." (gr.".$grupa[$idd[$i]].")</option>";
									$selekcik2n = $selekcik2n."<option value=".$idd[$i].">(".$nrdruzyny[$idd[$i]].") ".$nazwa[$idd[$i]]." (gr.".$grupa[$idd[$i]].")</option>";
								}
							}

							echo<<<END
							<form id="wyszukaj" method="post">
								<div class="panel" style="margin: 80px 0 20px 0;">
									<div class="row">
										
										<div class="col-2 col-lg-1 offset-lg-3" style="padding: 0 5px 0 0;"><select style="height: 40px;" id="kategoria" name="kategoria" onchange="pokazkat()"><option value="all" $wybranyols1i2>OLS1 i 2</option><option value="OLS1i" $wybranyols1>OLS1</option><option value="OLS2i" $wybranyols2>OLS2</option></select></div>
										<div class="col-4 col-lg-3" style="padding: 0; height: 40px; background-color: #ddd;">
											<div id="idols1" style="padding: 0; $pokaols1"><select style="height: 40px;" name="idwybd1">$selekcik1</select></div>
											<div id="idols2" style="padding: 0; $pokaols2"><select style="height: 40px;" name="idwybd2">$selekcik2</select></div>
										</div>
										<div class="col-3 col-lg-1" style="padding: 0 0 0 5px; height: 40px;">
												<select style="height: 40px; background-color: #ddd;" name="segregacja">
													<option value="all" $pokaall>Wszystko</option>
													<option value="month" $pokamonth>Miesiące</option>
												</select>
										</div>
										<div class="col-3 col-lg-1" style="padding: 0 0 0 5px;"><input type="submit" style="height: 40px; font-size: 15px" value="Wyszukaj" /></div>
										<div class="w-100" style="height: 10px;"></div>
										
										<div class="col-4 col-lg-2 offset-lg-3" style="padding: 0;" onclick="dodajallm()"><div class="paneltile"><i class="icon-plus-squared"></i><p>Wygeneruj mecze</p></div></div>
										<div class="col-4 col-lg-2" style="padding: 0 0 0 5px;" onclick="usunallm()"><div class="paneltile"><i class="icon-minus-squared"></i><p>Usuń mecze</p></div></div>
										<div class="col-4 col-lg-2" style="padding: 0 0 0 5px;" onclick="dodajm()"><div class="paneltile"><i class="icon-plus"></i><p>Dodaj mecz</p></div></div>

									</div class="row">
								</div>
							</form>
END;

							$rezultat0->close();
						}

						#DODAWANIE NOWEGO MECZU
						if(isset($_POST['data'])){
							
							$katn = $_POST['kategorian'];
							if($katn=="OLS1") {
								$idgosc = $_POST['idgosc1'];
								$idgosp = $_POST['idgosp1'];
							} else if($katn=="OLS2") {
								$idgosc = $_POST['idgosc2'];
								$idgosp = $_POST['idgosp2'];
							}
							$data = $_POST['data'];
							$godzina = $_POST['godzina'];
							
							$sql2 = "INSERT INTO mecze (`id`, `idgosc`, `idgosp`, `kategoria`, `data`, `godzina`) VALUES (NULL, '".$idgosc."', '".$idgosp."', '".$katn."', '".$data."', '".$godzina."');";

							if($rezultat2 = @$polaczenie->query($sql2)){
								echo '<p style="font-family:'."'Barlow'".', sans-serif; margin-top: 20px;">Dodano nowy mecz!</p>';
							}
						}

						#WYPISANIE WYNIKOW
						if(isset($_POST['segregacja'])){
							$seg = $_POST['segregacja'];
							$zmianaopt = "UPDATE ustawienia SET ustawienie = '".$seg."' WHERE nazwa = 'segadmm'";
							@$polaczenie->query($zmianaopt);
						}
						if($seg == "month") $miechornot = 12;
						else $miechornot = 1;

						for($miech = 1; $miech <= $miechornot; $miech++) 
						{
							#WYSZUKIWANIE MECZY DRUŻYNY
							if(isset($_POST['kategoria'])){
								$kat = $_POST['kategoria'];
								$zmianaopt = "UPDATE ustawienia SET ustawienie = '".$kat."' WHERE nazwa = 'katadmm'";
								@$polaczenie->query($zmianaopt);
							}
							if($kat=="OLS1i") {
								if(isset($_POST['idwybd1'])){
									$idwybd = $_POST['idwybd1'];
									$zmianaopt = "UPDATE ustawienia SET ustawienie = '".$idwybd."' WHERE nazwa = 'iddadmm'";
									@$polaczenie->query($zmianaopt);
								}
								$jakakat = " AND kategoria = 'OLS1'";
							} else if($kat=="OLS2i") {
								if(isset($_POST['idwybd2'])){
									$idwybd = $_POST['idwybd2'];
									$zmianaopt = "UPDATE ustawienia SET ustawienie = '".$idwybd."' WHERE nazwa = 'iddadmm'";
									@$polaczenie->query($zmianaopt);
								}
								$jakakat = " AND kategoria = 'OLS2'";
							} else {
								$idwybd = 0;
								$zmianaopt = "UPDATE ustawienia SET ustawienie = '0' WHERE nazwa = 'iddadmm'";
								@$polaczenie->query($zmianaopt);
								$jakakat = "";
							}

							if($idwybd != 0) $druzyny = " AND (idgosc = ".$idwybd." OR idgosp = ".$idwybd.")";
							else $druzyny = "";

							if($seg == "month") $sqlmiech = "MONTH(data) = ".$miech; 
							else $sqlmiech = "1=1";

							$sql = 'SELECT * FROM mecze WHERE '.$sqlmiech.$druzyny.$jakakat.' ORDER BY data ASC, godzina ASC';
							
							if($rezultat = @$polaczenie->query($sql))
							{
								$ilem = mysqli_num_rows($rezultat);

								if($seg == "month") {
									if($miech == 1) {
										echo '<div id="Styczen" class="miesiac">
												<div class="monthnav">
													<i class="icon-left-open" onclick="grudzien()"></i>
													<h1>Styczeń <i class="icon-calendar"></i></h1>
													<i class="icon-right-open" onclick="luty()"></i>
												</div>
												<div class="row no-gutters">';
									}
									if($miech == 2) {
										echo '<div id="Luty" class="miesiac">
												<div class="monthnav">
													<i class="icon-left-open" onclick="styczen()"></i>
													<h1>Luty <i class="icon-calendar"></i></h1>
													<i class="icon-right-open" onclick="marzec()"></i>
												</div>
												<div class="row no-gutters">';
									}
									if($miech == 3) {
										echo '<div id="Marzec" class="miesiac">
												<div class="monthnav">
													<i class="icon-left-open" onclick="luty()"></i>
													<h1>Marzec <i class="icon-calendar"></i></h1>
													<i class="icon-right-open" onclick="kwiecien()"></i>
												</div>
												<div class="row no-gutters">';
									}
									if($miech == 4) {
										echo '<div id="Kwiecien" class="miesiac">
												<div class="monthnav">
													<i class="icon-left-open" onclick="marzec()"></i>
													<h1>Kwiecień <i class="icon-calendar"></i></h1>
													<i class="icon-right-open" onclick="maj()"></i>
												</div>
												<div class="row no-gutters">';
									}
									if($miech == 5) {
										echo '<div id="Maj" class="miesiac">
												<div class="monthnav">
													<i class="icon-left-open" onclick="kwiecien()"></i>
													<h1>Maj <i class="icon-calendar"></i></h1>
												</div>
												<div class="row no-gutters">';
									}
									if($miech == 9) {
										echo '<div id="Wrzesien" class="miesiac">
												<div class="monthnav">
													<h1>Wrzesień <i class="icon-calendar"></i></h1>
													<i class="icon-right-open" onclick="pazdziernik()"></i>
												</div>
												<div class="row no-gutters">';
									}
									if($miech == 10) {
										echo '<div id="Pazdziernik" class="miesiac">
												<div class="monthnav">
													<i class="icon-left-open" onclick="wrzesien()"></i>
													<h1>Październik <i class="icon-calendar"></i></h1>
													<i class="icon-right-open" onclick="listopad()"></i>
												</div>
												<div class="row no-gutters">';
									}
									if($miech == 11) {
										echo '<div id="Listopad" class="miesiac">
												<div class="monthnav">
													<i class="icon-left-open" onclick="pazdziernik()"></i>
													<h1>Listopad <i class="icon-calendar"></i></h1>
													<i class="icon-right-open" onclick="grudzien()"></i>
												</div>
												<div class="row no-gutters">';
									}
									if($miech == 12) {
										echo '<div id="Grudzien" class="miesiac">
												<div class="monthnav">
													<i class="icon-left-open" onclick="listopad()"></i>
													<h1>Grudzień <i class="icon-calendar"></i></h1>
													<i class="icon-right-open" onclick="styczen()"></i>
												</div>
												<div class="row no-gutters">';
									}
									if($miech == 13) {
										echo '<div id="Inne" class="miesiac">
												<div class="monthnav">
													<h1>Wszystkie <i class="icon-calendar"></i></h1>
													<i class="icon-right-open" onclick="wrzesien()"></i>
												</div>
												<div class="row no-gutters">';
									}
									if((($miech < 6) || ($miech > 8)) && ($ilem == 0)) echo '<div style="margin-right: auto; margin-left: auto;">w tym miesiącu nie ma meczy lub jeszcze ich nie wprowadziliśmy<br><i class="icon-calendar-empty" style="font-size: 70px;"></i></div>';
								} else if($seg == "all") {
									echo '<div id="Wszystkie" class="miesiac">
											<div class="monthnav">
												<h1>Wszystkie <i class="icon-calendar"></i></h1>
											</div>
											<div class="row no-gutters">';
								}

								$tamtadata = 100000000000000;
								for ($i = 1; $i <= $ilem; $i++) 
								{
									$row = mysqli_fetch_assoc($rezultat);
									$id = $row['id'];
									$idgosc = $row['idgosc'];
									$idgosp = $row['idgosp'];
									$kategoria = $row['kategoria'];
									$data = $row['data'];
									$godzina = $row['godzina'];
									$gosc1s = $row['gosc1s'];
									$gosp1s = $row['gosp1s'];
									$gosc2s = $row['gosc2s'];
									$gosp2s = $row['gosp2s'];
									$gosc3s = $row['gosc3s'];
									$gosp3s = $row['gosp3s'];

									if($kategoria == "OLS1") $jakic = "w";
									else $jakic = "w2";

									if($godzina == "") {
										$godzina = "??:??";
									}

									$kategoria = $kategoria." (gr.".$grupa[$idgosc].")";

									$idgoscplus = "(".$nrdruzyny[$idgosc].") ".$nazwa[$idgosc];
									$idgospplus = "(".$nrdruzyny[$idgosp].") ".$nazwa[$idgosp];

									$wygsetygosc = 0;
									$wygsetygosp = 0;

									if($gosc1s>$gosp1s) {
										$gosc1sw = "s1";
										$gosp1sw = "s0";
										$wygsetygosc++;
									} else if($gosc1s<$gosp1s) {
										$gosc1sw = "s0";
										$gosp1sw = "s1";
										$wygsetygosp++;
									} else {
										$gosc1sw = "s0";
										$gosp1sw = "s0";
									}

									if($gosc2s>$gosp2s) {
										$gosc2sw = "s1";
										$gosp2sw = "s0";
										$wygsetygosc++;
									} else if($gosc2s<$gosp2s) {
										$gosc2sw = "s0";
										$gosp2sw = "s1";
										$wygsetygosp++;
									} else {
										$gosc2sw = "s0";
										$gosp2sw = "s0";
									}

									$tiebreak = "";

									if($gosc3s>$gosp3s){
										$gosc3sw = "s1";
										$gosp3sw = "s0";
										$wygsetygosc++;
									} else if($gosc3s<$gosp3s){
										$gosc3sw = "s0";
										$gosp3sw = "s1";
										$wygsetygosp++;
									#} else if((($gosc1s != 0) && ($gosp1s != 0)) && (($gosc3s == 0) && ($gosp3s == 0))){
										#$gosc3sw = "s0";
										#$gosp3sw = "s0";
										#$tiebreak = 'style ="display: none;"';
									} else {
										$gosc3sw = "s0";
										$gosp3sw = "s0";
									}

									if(($wygsetygosc==0) && ($wygsetygosp==0)) {
										$wygsetygosc = "?";
										$wygsetygosp = "?";
									}

									$numer = (string)$id;

									$edytuji = "edytuj".$numer;
									$usuni = "usun".$numer;
									$idgosci = "idgosc".$numer;
									$idgospi = "idgosp".$numer;
									$datai = "data".$numer;
									$godzinai = "godzina".$numer;
									$gosc1si = "gosc1s".$numer;
									$gosp1si = "gosp1s".$numer;
									$gosc2si = "gosc2s".$numer;
									$gosp2si = "gosp2s".$numer;
									$gosc3si = "gosc3s".$numer;
									$gosp3si = "gosp3s".$numer;

									if(($data > $tamtadata) && ($druzyny == "")){
										echo '<div class="w-100"></div>';
									}
									$tamtadata = $data;

									echo<<<END
										<div class="col-sm-6 col-md-4" style="padding: 0 1px 10px 1px;">
											<form action="php/edytujm.php" method="post">

												<div id="$edytuji"><div class="tilestatspanel" onclick="edytujm($id, '$data', '$godzina', $gosc1s, $gosp1s, $gosc2s, $gosp2s, $gosc3s, $gosp3s)" style="width: 50%; float: left; margin: 0 0 2px 0; cursor: pointer;">Edytuj</div></div>
												<div id="$usuni"><div class="tilestatspanel" onclick="usunm($id)" style="width: 50%; float: left; margin: 0 0 2px 0; cursor: pointer;">Usuń</div></div>
												<div style="clear: both;"></div>

												<div class="wynik">
									
													<input type="hidden" name="id" value="$id">

													<div class="t" id="$datai">$data</div>
													<div class="t" style="float: left;">$kategoria</div>
													<div class="t" id="$godzinai" style="padding-right: 5%;">$godzina</div>

													<div class="d" id="$idgosci">$idgoscplus</div>
													<input type="hidden" name="idgosc" value="$idgosc">
													<div style="height: 10px;"></div>

													<div class="$jakic">$wygsetygosc</div>
													<input type="hidden" name="setygosc" value="$wygsetygosc">
													<div class="$gosc1sw" id="$gosc1si">$gosc1s</div>
													<input type="hidden" name="gosc1sold" value="$gosc1s">
													<div class="$gosc2sw" id="$gosc2si">$gosc2s</div>
													<input type="hidden" name="gosc2sold" value="$gosc2s">
													<div class="$gosc3sw" id="$gosc3si" $tiebreak>$gosc3s</div>
													<input type="hidden" name="gosc3sold" value="$gosc3s">
													<div style="clear: both;"></div>

													<div class="$jakic">$wygsetygosp</div>
													<input type="hidden" name="setygosp" value="$wygsetygosp">
													<div class="$gosp1sw" id="$gosp1si">$gosp1s</div>
													<input type="hidden" name="gosp1sold" value="$gosp1s">
													<div class="$gosp2sw" id="$gosp2si">$gosp2s</div>
													<input type="hidden" name="gosp2sold" value="$gosp2s">
													<div class="$gosp3sw" id="$gosp3si" $tiebreak>$gosp3s</div>
													<input type="hidden" name="gosp3sold" value="$gosp3s">
													<div style="clear: both;"></div>

													<div style="height: 10px;"></div>
													<div class="d" id="$idgospi">$idgospplus</div>
													<input type="hidden" name="idgosp" value="$idgosp">

												</div>

											</form>
										</div>
END;
								}
								$rezultat->close();
							}
							if(($miech < 6) || ($miech > 8)) echo '</div></div>';
						}
						$polaczenie->close();
					}

				?>

			</div>

			<?php
				echo<<<END
					<div id="new" class="row">
						<div id="newtile" class="col-sm-6 col-md-4 col-xl-3 offset-sm-3">
							<form id="newm" method="post">

								<div id="edytuj"><div class="tilestatspanel" style="width: 50%; margin: 0 0 2px 0; float: left;"><input type="submit" value="Potwierdź" /></div></div>
								<div id="usun"><div class="tilestatspanel" style="width: 50%; margin: 0 0 2px 0; float: left;"><a href="admm.php">Anuluj</a></div></div>
								<div style="clear: both;"></div>

								<div class="wynik">
									
									<input type="hidden" name="id" value="0">

									<div class="t" id="data"><input type="date" name="data" value="data" /></div>
									<div class="t" style="float: left;"><select style="height: 22px;" id="kategorian" name="kategorian" onclick="pokazkatn()"><option value="OLS1">OLS1</option><option value="OLS2">OLS2</option></select></div>
									<div class="t" id="godzina" style="padding-right: 5%;"><input type="text" name="godzina" placeholder="??:??" /></div>

									<div class="d" id="idgoscols1" style="padding: 0;"><select style="height: 29px; background-color: #ddd;" name="idgosc1">$selekcik1n</select></div>
									<div class="d" id="idgoscols2" style="padding: 0;"><select style="height: 29px; background-color: #ddd;" name="idgosc2">$selekcik2n</select></div>
									<div style="height: 10px;"></div>

									<div class="w" id="versus">VS</div>
									<div style="clear: both;"></div>

									<div style="height: 10px;"></div>
									<div class="d" id="idgospols1" style="padding: 0;"><select style="height: 29px; background-color: #ddd;" name="idgosp1">$selekcik1n</select></div>
									<div class="d" id="idgospols2" style="padding: 0;"><select style="height: 29px; background-color: #ddd;" name="idgosp2">$selekcik2n</select></div>

								</div>

							</form>
						</div>
					</div>
END;
			?>

        </main>

	</div>

</body>

</html>