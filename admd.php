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
</head>

<body>

	<div id="wrapper" class="container-fluid">

		<?php include_once "php/admnav.php"; ?>
	
		<main>
			
			<div id="tabelacontent">

				<?php
					
					$baza = "_baza60034";
					if($host=="localhost") $baza = "";

					$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
					if ($polaczenie->connect_errno!=0)
					{
						echo "Error: ".$polaczenie->connect_errno;
					}
					else
					{
						#POBRANIE TABELI Z USTAWIEŃ
						$opt = 'SELECT ustawienie FROM ustawienia WHERE nazwa = "sezonadmd"';

						if($optrezultat = @$polaczenie->query($opt))
						{
							$row = mysqli_fetch_assoc($optrezultat);
							$thetabela = $row['ustawienie'];
						}

						#WYSZUKANIE TABELI DRUŻYN
						if(isset($_POST['tabele'])) $thetabela = $_POST['tabele'];

						$zmianaopt = "UPDATE ustawienia SET ustawienie = '".$thetabela."' WHERE nazwa = 'sezonadmd'";
						@$polaczenie->query($zmianaopt);

						$sqltab = "SHOW TABLES LIKE 'druzyny%'";
						if($tabrezultat = @$polaczenie->query($sqltab))
						{
							$iletab = mysqli_num_rows($tabrezultat);

							$tabele = "";

							for ($i = 1; $i <= $iletab; $i++) 
							{
								$row = mysqli_fetch_assoc($tabrezultat);
								$nazwatab = $row['Tables_in'.$baza.'_ols (druzyny%)'];
								if($thetabela == $nazwatab) $tabele = $tabele.'<option value='.$nazwatab.' selected>'.$nazwatab.'</option>';
								else $tabele = $tabele.'<option value='.$nazwatab.'>'.$nazwatab.'</option>';
							}
						}

						echo<<<END
							<form id="tabele" method="post">
								<div class="panel" style="margin: 80px 0 20px 0;">
									<div class="row">
										<div class="col-4 col-lg-2 offset-lg-3" style="padding: 0; height: 40px; background-color: #ddd;">
											<div style="padding: 0;"><select style="height: 40px;" name="tabele">$tabele</select></div>
										</div>
										<div class="col-4 col-lg-2" style="padding: 0 0 0 5px;"><input type="submit" style="height: 40px; font-size: 15px" value="Pokaż Tabele" /></div>
										<div class="col-4 col-lg-2" style="padding: 0 0 0 5px;" onclick="usunallm()"><div class="paneltile"><i class="icon-book"></i><p>Zmień sezon</p></div></div>
										<div class="w-100" style="height: 10px;"></div>
										
										<div class="col-4 col-lg-2 offset-lg-3" style="padding: 0;" onclick="dodajt()"><div class="paneltile"><i class="icon-plus-squared"></i><p>Dodaj tabelę</p></div></div>
										<div class="col-4 col-lg-2" style="padding: 0 0 0 5px;" onclick="usunallm()"><div class="paneltile"><i class="icon-minus-squared"></i><p>Usuń tabelę</p></div></div>
										<div class="col-4 col-lg-2" style="padding: 0 0 0 5px;" onclick="dodajd()"><div class="paneltile"><i class="icon-plus"></i><p>Dodaj drużynę</p></div></div>
									</div>
								</div>
							</form>

							<div class="row no-gutters">
								<div class="col-2 col-md-1"><div class="tilestats" style="background-color: #999;">nr</div></div>
								<div class="col-6 col-md-3"><div class="tilestats" style="background-color: #999;">nazwa drużyny</div></div>
								<div class="col-2 col-md-1"><div class="tilestats" style="background-color: #999;">kateg.</div></div>
								<div class="col-2 col-md-1"><div class="tilestats" style="background-color: #999;">grupa</div></div>
								<div class="col-4 col-md-2"><div class="tilestats" style="background-color: #999;">bilans meczy</div></div>
								<div class="col-4 col-md-2"><div class="tilestats" style="background-color: #999;">bilans setów</div></div>
								<div class="col-4 col-md-2"><div class="tilestats" style="background-color: #999;">blians pkt</div></div>
							</div>
END;

						#NOWA DRUŻYNA
						if(isset($_POST['nrdruzyny'])){
							
							$nrdruzyny = $_POST['nrdruzyny'];
							$nazwa = $_POST['nazwa'];
							$kategoria = $_POST['kategoria'];
							$grupa = $_POST['grupa'];
							$sezon = $_POST['sezon'];
							
							$sql2 = "INSERT INTO ".$sezon." (`id`, `nrdruzyny`, `nazwa`, `kategoria`, `grupa`, `wygrane`, `przegrane`, `setywyg`, `setyprzg`, `punktyzd`, `punktystr`) VALUES (NULL, '".$nrdruzyny."', '".$nazwa."', '".$kategoria."', '".$grupa."', '0', '0', '0', '0', '0', '0');";
							
							if($rezultat2 = @$polaczenie->query($sql2)){
								echo '<p style="font-family:'."'Barlow'".', sans-serif; margin-top: 20px;">Dodano nową drużynę do tabeli "<span style="color: #dd6062;">'.$sezon.'</span>"!</p>';
							}
						}

						#WYPISANIE OLS
						$sql = 'SELECT * FROM '.$thetabela.' ORDER BY kategoria, nrdruzyny';

						if($rezultat = @$polaczenie->query($sql))
						{
							 $ileols1 = mysqli_num_rows($rezultat);

							for ($i = 1; $i <= $ileols1; $i++) 
							{
								$row = mysqli_fetch_assoc($rezultat);
								$id = $row['id'];
								$nrdruzyny = $row['nrdruzyny'];
								$nazwa = $row['nazwa'];
								$kategoria = $row['kategoria'];
								$grupa = $row['grupa'];
								$wygrane = $row['wygrane'];
								$przegrane = $row['przegrane'];
								$setywyg = $row['setywyg'];
								$setyprzg = $row['setyprzg'];
								$punktyzd = $row['punktyzd'];
								$punktystr = $row['punktystr'];

								$numer = (string)$id;

								$imgi = "img".$numer;
								$edytuji = "edytuj".$numer;
								$usuni = "usun".$numer;
								$nrdruzynyi = "nrdruzyny".$numer;
								$nazwai = "nazwa".$numer;
								$kategoriai = "kategoria".$numer;
								$grupai = "grupa".$numer;
								$wygranei = "wygrane".$numer;
								$przegranei = "przegrane".$numer;
								$setywygi = "setywyg".$numer;
								$setyprzgi = "setyprzg".$numer;
								$punktyzdi = "punktyzd".$numer;
								$punktystri = "punktystr".$numer;

								echo<<<END
								<form action="php/edytujd.php" method="post" enctype="multipart/form-data">
									<div class="row no-gutters">
										<input type="hidden" name="id" value="$id">
										<input type="hidden" name="sezon" value="$thetabela">
										<div class="col-2 col-md-6"><div class="tilestatspanel"></div></div>
										<div class="col-2 col-md-2" id="$imgi"><div class="tilestatspanel"></div></div>
										<div class="col-4 col-md-2" id="$edytuji"><div class="tilestatspanel" onclick="edytujd($id, $nrdruzyny, '$nazwa', '$kategoria', '$grupa', $wygrane, $przegrane, $setywyg, $setyprzg, $punktyzd, $punktystr)" style="cursor: pointer;">Edytuj</div></div>
										<div class="col-4 col-md-2" id="$usuni"><div class="tilestatspanel" onclick="usund($id)" style="cursor: pointer;">Usuń</div></div>
										<div class="col-2 col-md-1"><div class="tilestatsm" id="$nrdruzynyi">$nrdruzyny</div></div>
										<div class="col-6 col-md-3"><div class="tilestatn" id="$nazwai">$nazwa</div></div>
										<div class="col-2 col-md-1"><div class="tilestatn" id="$kategoriai" style="overflow-x: visible;">$kategoria</div></div>
										<div class="col-2 col-md-1"><div class="tilestatn" id="$grupai">$grupa</div></div>
										<div class="col-2 col-md-1"><div class="tilestats" id="$wygranei">$wygrane</div></div>
										<div class="col-2 col-md-1"><div class="tilestats" id="$przegranei">$przegrane</div></div>
										<div class="col-2 col-md-1"><div class="tilestats" id="$setywygi">$setywyg</div></div>
										<div class="col-2 col-md-1"><div class="tilestats" id="$setyprzgi">$setyprzg</div></div>
										<div class="col-2 col-md-1"><div class="tilestats" id="$punktyzdi">$punktyzd</div></div>
										<div class="col-2 col-md-1 w-100"><div class="tilestats" id="$punktystri">$punktystr</div></div>
									</div>
								</form>
END;
								
							}
							$rezultat->close();
						}
						$polaczenie->close();
					}
				?>
			</div>

			<?php
				echo<<<END
					<div id="new" class="row">
						<div id="newtile" class="col-md-6 offset-md-3">
							<form id="newd" method="post">
								<div class="row no-gutters">
									<input type="hidden" name="sezon" value="$thetabela">
									<div class="col-4"><div class="tilestatspanel"></div></div>
									<div class="col-4" id="edytuj"><div class="tilestatspanel"><input type="submit" value="Potwierdź" /></div></div>
									<div class="col-4" id="usun"><div class="tilestatspanel"><a href="admd.php">Anuluj</a></div></div>
									<div class="col-2"><div class="tilestatsm" id="nrdruzyny"><input type="number" name="nrdruzyny" min="1" value="1" /></div></div>
									<div class="col-6"><div class="tilestatn" id="nazwa"><input type="text" name="nazwa" value="UKS" /></div></div>
									<div class="col-2"><div class="tilestatn" id="kategoria" style="overflow-x: visible;"><select style="height: 50px; background-color: #ccc;" name="kategoria"><option>OLS1</option><option>OLS2</option></select></div></div>
									<div class="col-2"><div class="tilestatn" id="grupa"><input type="text" name="grupa" value="A" /></div></div>
								</div>
							</form>
						</div>
					</div>

					<div id="newtab" class="row">
						<div id="newtile" class="col-md-6 offset-md-3">
							<form action="php/php/edytujt.php" id="newt" method="post">
								<div class="row no-gutters">
									<div class="col-4"><div class="tilestatspanel"></div></div>
									<div class="col-4" id="edytuj"><div class="tilestatspanel"><input type="submit" value="Potwierdź" /></div></div>
									<div class="col-4" id="usun"><div class="tilestatspanel"><a href="admd.php">Anuluj</a></div></div>
									<div class="col-8"><div class="tilestatn">Rok początku sezonu:</div></div>
									<div class="col-4"><div class="tilestatsm"><input type="number" name="sezon" min="2000" max="2099" value="2020" /></div></div>
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