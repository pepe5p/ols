<?php

	require_once "connect.php";

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="Shortcut icon" href="img/olslogo.png" />
    <title>OLS | Galeria</title>
    <meta name="description" content="Oficjalna strona Oświęcimskiej Ligi Siatkówki." />
    <meta name="keywords" content="liga, siatkówka, ols, regulamin, mecze, drużyny" />
    <meta name="author" content="Piotr Karaś" />

    <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1" />

    <link rel="stylesheet" href="bootstrapcss/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Barlow:900|Source+Sans+Pro:400,700" rel="stylesheet">

    <script src="skrypty/tel_navig.js"></script>
</head>

<body>

    <div id="thebigtop"></div>

    <div id="wrapper" class="container-fluid">

        <div id="tel-navig">

            <div id="options" onclick="pokaz()">
                <i class="icon-th-list"></i>
            </div>

            <ul id="navig">
                <li><a href="index.php"><i class="icon-home"></i> Strona Główna</a></li>
                <!--<li><a href="info.php"><i class="icon-info-circled"></i> Ogólne Informacje</a></li>-->
                <li><a href="regulamin.php"><i class="icon-doc-text-inv"></i> Regulamin</a></li>
                <li><a href="historia.php"><i class="icon-book"></i> Historia</a></li>
                <li><a href="galeria.php"><i class="icon-picture"></i> Galeria</a></li>
                <li><a href="druzyny.php"><i class="icon-users"></i> Drużyny</a></li>
                <li><a href="tabela.php"><i class="icon-award"></i> Tabela</a></li>
            </ul>

            <div id="logo"><a href="index.php"><img src="img/olslogo.png" title="Strona Główna" /></a></div>

        </div>

        <nav>
            <ol>
                <li><a href="index.php"><i class="icon-home"></i> Strona Główna</a></li>
                <!--<li><a href="info.php"><i class="icon-info-circled"></i> Ogólne Informacje</a></li>-->
                <li><a href="regulamin.php"><i class="icon-doc-text-inv"></i> Regulamin</a></li>
                <li><a href="historia.php"><i class="icon-book"></i> Historia</a></li>
                <li class="home"><a href="galeria.php"><i class="icon-picture"></i> Galeria</a></li>
                <li><a href="druzyny.php"><i class="icon-users"></i> Drużyny</a></li>
                <li><a href="tabela.php"><i class="icon-award"></i> Tabela</a></li>
            </ol>
        </nav>

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
                        $sql = 'SELECT * FROM galeria ORDER BY id DESC';
						if($rezultat = @$polaczenie->query($sql)) 
						{
                            $num_rows = mysqli_num_rows($rezultat);

                            for($i=1; $i<= $num_rows; $i++){
                                $row = mysqli_fetch_assoc($rezultat);
                                $title = $row['title'];
                                $text = $row['text'];
                                $path = $row['path'];
                                $src = $row['src'];
                                $fsize = $row['fsize']."px";

                                if($src=="yt") {
                                    $elo = '<div class="iframebox">'.$path.'</div>';
                                }
                                else {
                                    $elo = '<a href="'.$path.'">
                                        <div class="imgiopis">
                                            <img class="img-fluid" src="'.$src.'" />
                                            <div class="opis">Zobacz Galerię</div>
                                        </div>
                                    </a>';
                                }

                                echo<<<END
                                <article>
                                    <div class="galerybox">
                                        <div class="row no-gutters">
                                            <div class='col-sm-5' style="font-size: $fsize;">
                                                <div class="title">$title</div>
                                                <div class="text">$text</div>
                                            </div>
                                            <div class='col-sm-7' style="background-color: #ccc;">
                                                $elo
                                            </div>
                                        </div>
                                    </div>
                                </article>
END;
                            }
                        }
                    }
                ?>
            </div>
        </main>

        <div id="footer">

            <div class="gugiel">
                <div class="inf"><i class="icon-info-circled"></i></div>
                <a target="_blank" href="https://www.google.pl/maps/place/Miejskie+Gimnazjum+nr+2/@50.0316156,19.230014,15.71z/data=!4m5!3m4!1s0x47169509849e97cf:0xc50b7c099240e9d4!8m2!3d50.0323582!4d19.2340417">mecze<br />odbywają się<br />w SP2</a>
            </div>

            <div id="footer2">
                <div id="logos">
                    <p>
                        <a target="_blank" href="http://web.um.oswiecim.pl/oswiecim/"><img src='img/logomiasto.png' /></a><a target="_blank" href="http://www.mosir.oswiecim.pl/stronaGlowna-7.html"><img src='img/logomosir.jpg' /></a><a target="_blank" href="http://sp2osw.pl/"><img src='img/logosp2.jpg' /></a><a target="_blank" href="http://setbol.eu"><img src='img/logosetbol.jpg' /></a><a target="_blank" href="http://web.um.oswiecim.pl/oswiecim/"><img src='img/logomiasto.png' /></a><a target="_blank" href="http://www.mosir.oswiecim.pl/stronaGlowna-7.html"><img src='img/logomosir.jpg' /></a><a target="_blank" href="http://sp2osw.pl/"><img src='img/logosp2.jpg' /></a><a target="_blank" href="http://setbol.eu"><img src='img/logosetbol.jpg' /></a>
                    </p>
                </div>
            </div>

            <div class="stopka">
				<div class="footbox">
					<div class="row">
						<div class="col-4 col-lg-2">Kontakt</div>
					<div class="col-4 col-lg-2">606 134 463</div>
					<div class="col-4 col-lg-2">kryfit@op.pl</div>
					<div class="col-lg-6">2018 © Wszelkie prawa zastrzeżone.</div>
					</div>
				</div>
            </div>

		</div>
		
		<?php
			$alerttile = "";

			$news = 'SELECT id, tresc FROM newsy ORDER BY id DESC LIMIT 1';
			
			if($rezultatn = @$polaczenie->query($news))
			{
				$rown = mysqli_fetch_assoc($rezultatn);
				$id = $rown["id"];
				$tresc = $rown['tresc'];
				
				if(isset($_COOKIE["alert"])) {
					$inf = $_COOKIE["alert"];
				} else $inf = 0;

				if($inf!=$id){
					echo<<<END
					<div id="alert">
						$tresc
					</div>
					<div class="alerttile" title="close this alert">
						<form action="setcookie.php">
							<input type="hidden" name="idnews" value="$id"/>
							<input type="hidden" name="site" value="galeria.php"/>
							<button><i class="icon-cancel"></i></button>
						</form>
					</div>
END;
				}
				$polaczenie->close();
			}
		?>
        
		<div class="scrolltile" title="scroll to top">
			<a href="#thebigtop"><i class="icon-up-open"></i></a>
		</div>

    </div>

    <div id="container">

        <i id="close" class="icon-cancel" onclick="ukryj()"></i>

        <div id="foto"></div>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrapjs/bootstrap.min.js"></script>

</body>

</html>