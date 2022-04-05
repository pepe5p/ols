<?php

	require_once "php/connect.php";

	if(isset($_POST['kategoria'])) $scroll = 1;
	else $scroll = 0;

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="Shortcut icon" href="img/olslogo.png" />
    <title>OLS</title>
    <meta name="description" content="Oficjalna strona Oświęcimskiej Ligi Siatkówki." />
    <meta name="keywords" content="liga, siatkówka, ols, regulamin, mecze, drużyny" />
    <meta name="author" content="Piotr Karaś" />

    <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1" />

    <link rel="stylesheet" href="bootstrapcss/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Barlow:900|Source+Sans+Pro:400,700" rel="stylesheet">
	
    <script src="skrypty/admin.js"></script>
    <script src="skrypty/categories.js"></script>
    <script src="skrypty/months.js"></script>
    <script src="skrypty/scroll.js"></script>
    <script src="skrypty/tel_navig.js"></script>
</head>

<body onload="scroll(<?php echo $scroll ?>)">

    <div id="thebigtop"></div>
	
    <div id="wrapper" class="container-fluid">

		<?php include_once "php/nav.php"; ?>

		<a href="logowanie.php" class="admpanel">A</a>

        <header>
            Oświęcimska Liga<br>Siatkówki
        </header>

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

							if(isset($_POST['kategoria'])){
								$pokaols1 = 'display: none';
								$pokaols2 = 'display: none';
							
								$kat = $_POST['kategoria'];
								if($kat=="OLS1i") {
									$wd = (int)$_POST['idgosc1'];
									$wybranyols1 = "selected";
									$pokaols1 = 'display: block';
								} else if($kat=="OLS2i") {
									$wd = (int)$_POST['idgosc2'];
									$wybranyols2 = "selected";
									$pokaols2 = 'display: block';
								} else $wybranyols1i2 = "selected";
							}

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
									$selekcik1n = $selekcik1n."<option value=".$idd[$i]." ".$wybranad.">(".$nrdruzyny[$idd[$i]].") ".$nazwa[$idd[$i]]." (gr.".$grupa[$idd[$i]].")</option>";
								} else {
									$selekcik2 = $selekcik2."<option value=".$idd[$i]." ".$wybranad.">(".$nrdruzyny[$idd[$i]].") ".$nazwa[$idd[$i]]." (gr.".$grupa[$idd[$i]].")</option>";
									$selekcik2n = $selekcik2n."<option value=".$idd[$i]." ".$wybranad.">(".$nrdruzyny[$idd[$i]].") ".$nazwa[$idd[$i]]." (gr.".$grupa[$idd[$i]].")</option>";
								}
							}

							echo<<<END
							<form id="wyszukaj" method="post">
								<div class="panel" style="margin: 80px 0 20px 0;">
									<div class="row">
										
										<div class="col-2 col-lg-1 offset-lg-3" style="padding: 0 5px 0 0;"><select style="height: 40px;" id="kategoria" name="kategoria" onchange="pokazkat()"><option value="all" $wybranyols1i2>OLS1 i 2</option><option value="OLS1i" $wybranyols1>OLS1</option><option value="OLS2i" $wybranyols2>OLS2</option></select></div>
										<div class="col-7 col-lg-4" style="padding: 0; height: 40px; background-color: #ddd;">
											<div id="idols1" style="padding: 0; $pokaols1"><select style="height: 40px;" name="idgosc1">$selekcik1</select></div>
											<div id="idols2" style="padding: 0; $pokaols2"><select style="height: 40px;" name="idgosc2">$selekcik2</select></div>
										</div>
										<div class="col-3 col-lg-1" style="padding: 0 0 0 5px;"><input type="submit" style="height: 40px; font-size: 15px" value="Wyszukaj" /></div>

									</div class="row">
								</div>
							</form>
END;

							$rezultat0->close();
						}

						#WYPISANIE WYNIKOW

						$months = ["Styczeń","Luty","Marzec","Kwiecień","Maj","","","","Wrzesień","Październik","Listopad","Grudzień"];

						for($i = 8; $i < 12; $i++) 
						{
							$druzyny = "";
							$jakakat = "";
							$idgosc = 0;
							$sqlmiech = "MONTH(data) = ".($i+1); 

							#WYSZUKIWANIE MECZY DRUŻYNY
							if(isset($_POST['kategoria'])){
							
								$kat = $_POST['kategoria'];
								if($kat=="OLS1i") {
									$idgosc = $_POST['idgosc1'];
									$jakakat = " AND kategoria = 'OLS1'";
								} else if($kat=="OLS2i") {
									$idgosc = $_POST['idgosc2'];
									$jakakat = " AND kategoria = 'OLS2'";
								}

								if($idgosc != 0){
									$druzyny = " AND (idgosc = ".$idgosc." OR idgosp = ".$idgosc.")";
								}
							}

							$sql = 'SELECT * FROM mecze WHERE '.$sqlmiech.$druzyny.$jakakat.' ORDER BY data ASC, godzina ASC';
							
							if($rezultat = @$polaczenie->query($sql))
							{
								$ilem = mysqli_num_rows($rezultat);
									
								$show = ' ';
								if($i!=($jakim-1)) $show = ' style="display: none;"';
								echo<<<END
								<div id="m$i" class="miesiac"$show>
									<div class="monthnav">
										<i class="icon-left-open" onclick="previous($i)"></i>
										<h1>$months[$i]<i class="icon-calendar"></i></h1>
										<i class="icon-right-open" onclick="next($i)"></i>
									</div>
								<div class="row no-gutters">
END;
								if((($i < 5) || ($i > 7)) && ($ilem == 0)) echo '<div style="margin-right: auto; margin-left: auto;">w tym miesiącu nie ma meczy lub jeszcze ich nie wprowadziliśmy<br><i class="icon-calendar-empty" style="font-size: 70px;"></i></div>';
							
								$tamtadata = 100000000000000;
								for ($j = 1; $j <= $ilem; $j++) 
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
									} else if((($gosc1s != 0) && ($gosp1s != 0)) && (($gosc3s == 0) && ($gosp3s == 0))){
										$gosc3sw = "s0";
										$gosp3sw = "s0";
										$tiebreak = 'style ="display: none;"';
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
										<div class="col-sm-6 col-md-4 " style="padding: 0 1px 10px 1px;">
											<div class="wynik">

												<div class="t">$data</div>
												<div class="t" style="float: left;">$kategoria</div>
												<div class="t" style="padding-right: 5%;">$godzina</div>

												<div class="d">$idgoscplus</div>
												<div style="height: 10px;"></div>

												<div class="$jakic">$wygsetygosc</div>
												<div class="$gosc1sw">$gosc1s</div>
												<div class="$gosc2sw">$gosc2s</div>
												<div class="$gosc3sw" $tiebreak>$gosc3s</div>
												<div style="clear: both;"></div>

												<div class="$jakic">$wygsetygosp</div>
												<div class="$gosp1sw">$gosp1s</div>
												<div class="$gosp2sw">$gosp2s</div>
												<div class="$gosp3sw" $tiebreak>$gosp3s</div>
												<div style="clear: both;"></div>

												<div style="height: 10px;"></div>
												<div class="d">$idgospplus</div>
													
											</div>
										</div>
END;
								}
								$rezultat->close();
							}
							if($i==11) $i = -1;
							if($i==4) $i = 12;
							if(($i < 5) || ($i > 7)) echo '</div></div>';
						}
					}

				?>

			</div>

        </main>

		<?php include_once "php/footer.php"; ?>

	</div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrapjs/bootstrap.min.js"></script>

</body>

</html>