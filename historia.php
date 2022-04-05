<?php

	require_once "php/connect.php";

	function roman_num($number){
		$num = intval($number);
		$result ="";
	
		$roman_numbers = array('M'=>1000,'CM' =>900,'D'=>500,'CD'=>400,'C'=>100,'XC' =>90,'L'=>50,'XL'=>40,'X'=>10,'IX' =>9,'V'=>5,'IV'=>4,'I'=>1);
	
		foreach($roman_numbers as $roman=>$value){
	
			$check=intval($num/$value);
			$result .= str_repeat($roman,$check);
			$num = $num % $value;
		}
	
		return $result;
	}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="Shortcut icon" href="img/olslogo.png" />
    <title>OLS | Historia</title>
    <meta name="description" content="Oficjalna strona Oświęcimskiej Ligi Siatkówki." />
    <meta name="keywords" content="liga, siatkówka, ols, regulamin, mecze, drużyny" />
    <meta name="author" content="Piotr Karaś" />

    <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1" />

    <link rel="stylesheet" href="bootstrapcss/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Barlow:900|Source+Sans+Pro:400,700" rel="stylesheet">

    <script src="skrypty/scroll.js"></script>
    <script src="skrypty/tel_navig.js"></script>
</head>

<body>

    <div id="thebigtop"></div>

    <div id="wrapper" class="container-fluid">
        
		<?php include_once "php/nav.php"; ?>
    
		<a href="logowanie.php" class="admpanel">A</a>

        <header>
            Oświęcimska Liga<br>Siatkówki
        </header>

        <main>

			<?php
		
				$n = 0;

				$baza = "baza60034_ols";
				if($host=="localhost") $baza = "ols";

				$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

				if ($polaczenie->connect_errno!=0) { 
					echo "Error: ".$polaczenie->connect_errno;
				} else {

					date_default_timezone_set('Europe/Warsaw');
					$info = getdate();
					$jakim = $info['mon'];
					$jakir = $info['year'];

					if($jakim<6) $edycjatu = roman_num($jakir-2000);
					else $edycjatu = roman_num($jakir-1999);

					#WYSZUKANIE TABELI DRUŻYN
					$sqltabnaczuja = "SHOW TABLES LIKE 'druzyny%'";
					if($tabrezultatnc = @$polaczenie->query($sqltabnaczuja)) $ileminusjeden = mysqli_num_rows($tabrezultatnc);

					$sqltab = "SELECT * FROM (SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$baza."' AND TABLE_NAME LIKE 'druzyny%' LIMIT ".($ileminusjeden-1).") AS dupa ORDER BY dupa.TABLE_NAME DESC";

					if($tabrezultat = @$polaczenie->query($sqltab))
					{
						$iletab = mysqli_num_rows($tabrezultat)+$n;
						$ilenadwa = floor(($iletab)/2);
						echo<<<END
						<div class="contentbox" style="background-color: #eee;">

							<h1><i class="icon-book"></i></i>Historia OLS</h1>
							<h2>Obecnie rozgrywana jest już $edycjatu edycja OLS</h2>
							<h2>Poniżej prezentujemy wyniki poprzednich sezonów</h2>

							<div class="space"></div>
				
							<div class="row no-gutters">
		
								<div class="col-md-6 col-xl-4 offset-xl-2">
									<div class="tilesezony">
										<ul class="sezony">
END;

						for ($i = $iletab; $i > 0; $i--) 
						{
							if($i==$ilenadwa){
								echo				'</ul>';
								echo			'</div>';
								echo		'</div>';
								echo		'<div class="col-md-6 col-xl-4">';
								echo			'<div class="tilesezony">';
								echo				'<ul class="sezony">';
							}

							if($i>$n){ 
								$row = mysqli_fetch_assoc($tabrezultat);
								$nazwatab[$i] = $row['TABLE_NAME'];

								$edycja = roman_num($i+13)." Edycja -";
								$sezon = " Sezon ".((int)substr($nazwatab[$i], 7, 2)+2000)."/".((int)substr($nazwatab[$i], 7, 2)+2001);

								$cale[$i] = $edycja.$sezon;
								echo "<li><a href="."#".($i).">".$cale[$i]."</a></li>";
							} else {
								echo $nn[$i];
							}
							
							if($i==1){
								echo				'</ul>';
								echo			'</div>';
								echo		'</div>';
								echo	'</div>';
								echo '</div>';
							}
						}

						#WYPISANIE TABELI Z BAZY DANYCH
						echo '<div id="tabelacontent">';
						for ($i = $iletab; $i > $n; $i--) 
						{
							$sql = 'SELECT * FROM '.$nazwatab[$i].' ORDER BY kategoria,
							(wygrane*2 + przegrane*1) DESC, (setywyg/(setyprzg+0.0000000001)) DESC, (punktyzd/(punktystr+0.0000000001)) DESC, nrdruzyny';
							
							$ileols1 = 0;
							$flaga = false;

							if($rezultat = @$polaczenie->query($sql)) 
							{
								$iled = mysqli_num_rows($rezultat);

								$kat[0] = "OLS1";
								for ($x = 1; $x <= $iled; $x++) 
								{
									$row = mysqli_fetch_assoc($rezultat);
									$id = $row['id'];
									$nrdruzyny = $row['nrdruzyny'];
									$nazwa = $row['nazwa'];
									$grupa = $row['grupa'];
									$kat[$x] = $row['kategoria'];

									if(($iled != 0) && ($x==1)){
										echo<<<down
										<div id="$i" class="kat">$cale[$i]</div>
										<div class="row no-gutters">
											<div class="col-6">
												<div class="row no-gutters" style="font-family: 'Barlow', sans-serif;">
													<div class="col-2"><div class="tilestatn" style="background-color: #999;">msc</div></div>
													<div class="col-10"><div class="tilestatn" style="background-color: #999;">$kat[$x]</div></div>
												</div>
down;
									}

									if($kat[$x]==$kat[$x-1]) {
										$msc = $x;
										if($flaga==false) $ileols1++;
									} else {
										$msc = $x-$ileols1;
										$flaga = true;
										echo<<<down
										</div>
										<div class="col-6">
											<div class="row no-gutters" style="font-family: 'Barlow', sans-serif;">
												<div class="col-2"><div class="tilestatn" style="background-color: #999;">msc</div></div>
												<div class="col-10"><div class="tilestatn" style="background-color: #999;">$kat[$x]</div></div>
											</div>
down;
									}

									if($flaga==true) $msc=$x-$ileols1;
									
									if($msc==1){
										$kolorek = 'style="background-color: #d1ab12; text-shadow: 2px 2px 4px #000;"';
										$kolorek2 = 'style="background-color: #f2dd8a;"';
									}
									else if($msc==2){
										$kolorek = 'style="background-color: #87879e; text-shadow: 2px 2px 4px #000;"';
										$kolorek2 = 'style="background-color: #cccce5;"';
									}
									else if($msc==3){
										$kolorek = 'style="background-color: #a8843c; text-shadow: 2px 2px 4px #000;"';
										$kolorek2 = 'style="background-color: #edcc8b;"';
									} else {
										$kolorek = "";
										$kolorek2 = "";
									}

									echo<<<END
									<div class="row no-gutters" style="font-family: 'Barlow', sans-serif;">
										<div class="col-12"><div class="tilestatspanel" style="height: 0;"></div></div>
										<div class="col-2"><div class="tilestatsm" $kolorek>$msc</div></div>
										<div class="col-10"><div class="tilestatn" $kolorek2>$nazwa</div></div>
									</div>
END;
									if($x==$iled){
										echo	'</div>';
										echo '</div>';
									}
								}

								$rezultat->close();
							}

						}

						#DOPISANIE STARYCH TABEL
						for($i = 0; $i < $n; $i++){
							$odtylu = $n-$i;
							echo $nt[$odtylu];
						}

						echo '</div>';
					}
				}

			?>

        </main>

        <?php include_once "php/footer.php"; ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrapjs/bootstrap.min.js"></script>

</body>

</html>