<?php

	require_once "php/connect.php";

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="Shortcut icon" href="img/olslogo.png" />
    <title>OLS | Tabela</title>
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

					if ($polaczenie->connect_errno!=0) { 
						echo "Error: ".$polaczenie->connect_errno;
					} else {
						#SPRAWDZENIE OBECNEGO ROKU
						date_default_timezone_set('Europe/Warsaw');
						$info = getdate();
						$jakim = $info['mon'];
						$jakir = $info['year'];

						if($jakim<6) $thetabela = "druzyny".($jakir-2001)."_".($jakir-2000);
						else $thetabela = "druzyny".($jakir-2000)."_".($jakir-1999);

						$sql = 'SELECT * FROM '.$thetabela.' WHERE kategoria="OLS1" ORDER BY (wygrane*2 + przegrane*1) DESC, (setywyg/(setyprzg+0.0000000001)) DESC, (punktyzd/(punktystr+0.0000000001)) DESC, nrdruzyny';

						if($rezultat = @$polaczenie->query($sql)) 
						{
							$ileols1 = mysqli_num_rows($rezultat);

							if($ileols1 != 0) 
							{
								echo '<div class="kat">OLS 1</div>';
								echo '<div class="row no-gutters" style="font-family: '."'Barlow'".', sans-serif;">';
								echo '	<div class="col-1"><div class="tilestats" style="background-color: #999;">msc</div></div>';
								echo '	<div class="col-6"><div class="tilestats" style="background-color: #999;">nazwa drużyny</div></div>';
								echo '	<div class="col-1"><div class="tilestats" style="background-color: #999;">pkt</div></div>';
								echo '	<div class="col-1"><div class="tilestats" style="background-color: #999;">Z</div></div>';
								echo '	<div class="col-1"><div class="tilestats" style="background-color: #999;">P</div></div>';
								echo '	<div class="col-2"><div class="tilestats" style="background-color: #999;">sety</div></div>';
								echo '</div>';
							}

							for ($i = 1; $i <= $ileols1; $i++) {
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

								$duzepunkty = $wygrane * 2 + $przegrane * 1;
								
								echo<<<END
								<div class="row no-gutters" style="font-family: 'Barlow', sans-serif;">
									<div class="col-12"><div class="tilestatspanel" style="height: 0;"></div></div>
									<div class="col-1"><div class="tilestatsm">$i</div></div>
									<div class="col-6"><div class="tilestatn">$nazwa</div></div>
									<div class="col-1"><div class="tilestatp">$duzepunkty</div></div>
									<div class="col-1"><div class="tilestats">$wygrane</div></div>
									<div class="col-1"><div class="tilestats">$przegrane</div></div>
									<div class="col-1"><div class="tilestats">$setywyg</div></div>
									<div class="col-1"><div class="tilestats">$setyprzg</div></div>
								</div>
END;
							}

							$rezultat->close();
						}

						$sql2 = 'SELECT * FROM '.$thetabela.' WHERE kategoria="OLS2" ORDER BY (wygrane*2 + przegrane*1) DESC, (setywyg/(setyprzg+0.0000000001)) DESC, (punktyzd/(punktystr+0.0000000001)) DESC, nrdruzyny';

						if($rezultat2 = @$polaczenie->query($sql2)) 
						{
							$ileols2 = mysqli_num_rows($rezultat2);

							if($ileols2 != 0) 
							{
								echo '<div class="kat">OLS 2</div>';
								echo '<div class="row no-gutters" style="font-family: '."'Barlow'".', sans-serif;">';
								echo '	<div class="col-1"><div class="tilestats" style="background-color: #999;">msc</div></div>';
								echo '	<div class="col-6"><div class="tilestats" style="background-color: #999;">nazwa drużyny</div></div>';
								echo '	<div class="col-1"><div class="tilestats" style="background-color: #999;">pkt</div></div>';
								echo '	<div class="col-1"><div class="tilestats" style="background-color: #999;">Z</div></div>';
								echo '	<div class="col-1"><div class="tilestats" style="background-color: #999;">P</div></div>';
								echo '	<div class="col-2"><div class="tilestats" style="background-color: #999;">sety</div></div>';
								echo '</div>';
							}

							if(($ileols1 == 0) && ($ileols2 == 0)) echo '<div class="kat" style="font-size: 22px;">Nie znaleziono żadnych drużyn</div>';

							$ilerazem = $ileols1 + $ileols2;

							for ($i = $ileols1 + 1; $i <= $ilerazem; $i++)
							{
								$row = mysqli_fetch_assoc($rezultat2);
								$id = $row['id'];
								$nrdruzyny = $row['nrdruzyny'];
								$nazwa = $row['nazwa'];
								$grupa = $row['grupa'];
								$wygrane = $row['wygrane'];
								$przegrane = $row['przegrane'];
								$setywyg = $row['setywyg'];
								$setyprzg = $row['setyprzg'];
								$punktyzd = $row['punktyzd'];
								$punktystr = $row['punktystr'];

								$x = $i - $ileols1;
								
								$duzepunkty = $wygrane * 2 + $przegrane * 1;

								echo<<<END
								<div class="row no-gutters" style="font-family: 'Barlow', sans-serif;">
									<div class="col-12"><div class="tilestatspanel" style="height: 0;"></div></div>
									<div class="col-1"><div class="tilestatsm">$x</div></div>
									<div class="col-6"><div class="tilestatn">$nazwa</div></div>
									<div class="col-1"><div class="tilestatp">$duzepunkty</div></div>
									<div class="col-1"><div class="tilestats">$wygrane</div></div>
									<div class="col-1"><div class="tilestats">$przegrane</div></div>
									<div class="col-1"><div class="tilestats">$setywyg</div></div>
									<div class="col-1"><div class="tilestats">$setyprzg</div></div>
								</div>
END;

							}

							$rezultat2->close();
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