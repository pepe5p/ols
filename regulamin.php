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
    <title>OLS | Regulamin</title>
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
            <div class="contentbox" style="background-color: #eee;">

                <h1><i class="icon-doc-text-inv"></i>Regulamin OLS-K</h1>
                <h2>Oświęcimskiej Ligi Siatkówki Dziewcząt</h2>
                <h2>rok szkolny 2019/2020</h2>
                <h2><a href="files/regulamin-2019_20.docx" download>Pobierz Plik</a></h2>

            </div>

        </main>

        <?php include_once "php/footer.php"; ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrapjs/bootstrap.min.js"></script>

</body>

</html>