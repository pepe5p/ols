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
    <title>OLS | Drużyny</title>
    <meta name="description" content="Oficjalna strona Oświęcimskiej Ligi Siatkówki." />
    <meta name="keywords" content="liga, siatkówka, ols, regulamin, mecze, drużyny" />
    <meta name="author" content="Piotr Karaś" />

    <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1" />

    <link rel="stylesheet" href="bootstrapcss/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Barlow:900|Source+Sans+Pro:400,700" rel="stylesheet">

    <script src="skrypty/scroll.js"></script>
    <script src="skrypty/gallery.js"></script>
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
            <div class="row no-gutters">
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

                        if($jakim<6){
                            $thetabela = "druzyny".($jakir-2001)."_".($jakir-2000);
                        }
                        else{
                            $thetabela = "druzyny".($jakir-2000)."_".($jakir-1999);
                        }

                        $sql = 'SELECT * FROM '.$thetabela;

                        if($rezultat = @$polaczenie->query($sql)) 
                        {
                            $ile = mysqli_num_rows($rezultat);

                            for($i = 1; $i <= $ile; $i++) {
                                $row = mysqli_fetch_assoc($rezultat);
                                $id = $row['id'];
                                $nazwa = $row['nazwa'];
                                $path = 'img/druzyny/'.$thetabela.'/'.$id.'.jpg';
                                $onclick = 'onclick=show("'.$path.'")';

                                if(!file_exists($path)) {
                                    $path = 'img/druzyny/empty.jpg';
                                    $onclick = "";
                                }
                                
                                echo<<<END
                                <div class='col-sm-6 col-lg-4'>
                                    <div class='imgiopis'>
                                        <div $onclick>
                                            <img class="img-fluid" src=$path />
                                        </div>
                                        <div $onclick class='opis'>$nazwa</div>
                                    </div>
                                </div>
END;
                            }

                            $rezultat->close();
                        }
                    }
                ?>
            </div>
        </main>
        
        <?php include_once "php/footer.php"; ?>
        
    </div>

    <div id="container">
        <i id="close" class="icon-cancel" onclick="hide()"></i>
        <div id="foto"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrapjs/bootstrap.min.js"></script>

</body>

</html>