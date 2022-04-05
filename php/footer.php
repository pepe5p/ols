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
    
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno;
    }
    else
    {
        $news = 'SELECT id, tresc FROM newsy ORDER BY id DESC LIMIT 1';
        
        if($rezultatn = @$polaczenie->query($news))
        {
            $rown = mysqli_fetch_assoc($rezultatn);

            if(!$rown) return;

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
                        <input type="hidden" name="site" value="druzyny.php"/>
                        <button><i class="icon-cancel"></i></button>
                    </form>
                </div>
END;
            }
        }
    $polaczenie->close();
    }
?>

<div class="scrolltile" title="scroll to top">
    <a href="#thebigtop"><i class="icon-up-open"></i></a>
</div>