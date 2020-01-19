<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Pizzeria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v5.5.0/js/all.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Basic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    -
    <script src="bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>

</head>

<body data-spy="scroll" data-target="#paseknawigacji">
<!-------------------------nawigacja---------------------------->
<nav class="navbar navbar-expand-lg navbar-dark bg-da rk fixed-top">
    <a class="navbar-brand" href="#"><img src="play.svg" alt="play"/><span> Pizzeria    </span></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#paseknawigacji">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="paseknawigacji">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#zamowienie">Pizza</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#podsumowanie">Podsumowanie</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#contact">Kontakt</a>
            </li>
        </ul>
    </div>
</nav>

<!-------------------------------------startowa-------------------------------->
<div id="startowa">


    <!--- ----------------------------------landingpage------------------------------>


    <!--- ------------------------------landingpagestop------------------------------>
</div>

<!--- ----------------------------------o nas -------------------------------->
<div id="zamowienie" class="offset">
    <div class="row text-center">


        <div class="col-md-12">
            <div class="container">

            </div>
        </div>
    </div>
</div>

<h1>Wybierz kelnera aby obliczyć jego prowizję</h1>
<form action="index4.php" method="POST">
    Kamil <input type="radio" name="kelner" value="Kamil"> <br/>
    Dominik<input type="radio" name="kelner" value="Dominik"><br/>
    Marcin<input type="radio" name="kelner" value="Marcin"> <br/>
    Mariusz<input type="radio" name="kelner" value="Mariusz"> <br/>

    Wybierz %<input type="number" name="procent"><br/>
    <?php
    $data = date("Y-m-d");

    echo "Wybierz date <input type='date' name='data' value=$data>";
    ?>
    <input type="submit" name="submit" value="Sprawdź"><br/>

</form>
<?php
include 'baza.php';

if (isset($_POST['submit'])) {
    if (isset($_POST['kelner'])) {
        $query = "select idKelner from Kelner where Imie='{$_POST['kelner']}';";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result)) {

            $idKelner = $row['idKelner'];
        }

    }

    $procent = $_POST['procent'] / 100;
    $query = "SELECT * from Kelner;";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_array($result)) {
        $zarobek = 0;

        $query1 = "SELECT idMenu from Zamowienia where idKelner='$idKelner' AND Data = '{$_POST['data']}';";
        $result1 = mysqli_query($conn, $query1);

        while ($row1 = mysqli_fetch_array($result1)) {
            $query2 = "select idPizza from ManuPizza where idMenu = " . $row1['idMenu'] . ";";
            $result2 = mysqli_query($conn, $query2);


            $queryRozmiarid = "select idRozmiarPizza from ManuPizza where idMenu=" . $row1['idMenu'] . ";";
            $resultRozmiarid = mysqli_query($conn, $queryRozmiarid);
            while ($rowRozmiarid = mysqli_fetch_array($resultRozmiarid)) {
                $idRozmiar = $rowRozmiarid['idRozmiarPizza'];
            }

            $queryRodzajid = "select idRodzajCiasta from ManuPizza where idMenu=" . $row1['idMenu'] . ";";
            $resultRodzajid = mysqli_query($conn, $queryRodzajid);
            while ($rowRodzajid = mysqli_fetch_array($resultRodzajid)) {
                $idRodzaj = $rowRodzajid['idRodzajCiasta'];
            }

            $queryCenaRodzaj = "select Cena from RodzajeCiasta where idRodzajCiasta='$idRodzaj';";
            $resultCenaRodzaj = mysqli_query($conn, $queryCenaRodzaj);
            while ($rowCenaRodzaj = mysqli_fetch_array($resultCenaRodzaj)) {
                $cenaRodzaj = $rowCenaRodzaj['Cena'];
            }

            $queryCenaRozmiar = "select CenaDodatkuPowiekszona from RozmiarPizza where idRozmiarPizza='$idRozmiar';";
            $resultCenaRozmiar = mysqli_query($conn, $queryCenaRozmiar);
            while ($rowCenaRozmiar = mysqli_fetch_array($resultCenaRozmiar)) {
                $cenaRozmiar = $rowCenaRozmiar['CenaDodatkuPowiekszona'];
            }

            while ($row2 = mysqli_fetch_array($result2)) {
                $query3 = "select sum(CenaDodatki) as suma from Dodatki inner join Dodatki_Pizza on Dodatki.idDodatki = Dodatki_Pizza.idDodatki inner join Pizza on Pizza.idPizza = Dodatki_Pizza.idPizza where Dodatki_Pizza.idPizza=" . $row2['idPizza'] . " AND Dodatki_Pizza.PodwojneDodatki=0;";
                $result3 = mysqli_query($conn, $query3);
                while ($row3 = mysqli_fetch_array($result3)) {
                    $zarobek += $row3['suma'];
                }

                $query4 = "select sum(CenaDodatki) as suma from Dodatki inner join Dodatki_Pizza on Dodatki.idDodatki = Dodatki_Pizza.idDodatki inner join Pizza on Pizza.idPizza = Dodatki_Pizza.idPizza where Dodatki_Pizza.idPizza=" . $row2['idPizza'] . " AND Dodatki_Pizza.PodwojneDodatki=1;";

                $result4 = mysqli_query($conn, $query4);
                while ($row4 = mysqli_fetch_array($result4)) {
                    $zarobek += ($row4['suma'] * 2);
                }

            }
        }

    }
    $Suma = 0;
    $Suma = $Suma + (($zarobek * $cenaRozmiar) + $cenaRodzaj);
    $calyZarobek = $Suma * $procent;
    echo $Suma . "<br/>";
    echo $procent . "<br/>";
    echo number_format($calyZarobek, 2, ',', ' ') . " zł";

}

mysqli_close($polaczenie);
?>


<h1>Sprawdź czy jakieś zamówienie powtórzyło się 3 razy </h1>
<form action="index4.php" method="POST">
    <input type="submit" name="niestandardowa" value="Sprawdź"><br/>

</form>
<?php
include 'baza.php';
if (isset($_POST['niestandardowa'])) {


    $dodatkiPizza = array();
    $IDPizza = array();

    $data = "SELECT * from Zamowienia where Data='$data';";
    $rdata = mysqli_query($conn, $data);
    while ($row = mysqli_fetch_array($rdata)) {
        $idMenu = "select idPizza from ManuPizza where idMenu=" . $row['idMenu'] . ";";
        $ridMenu = mysqli_query($conn, $idMenu);


        while ($row1 = mysqli_fetch_array($ridMenu)) {
            $idPizza = "SELECT idPizza from Pizza WHERE NazwaPizza='Niestandardowa';";
            $resultPizza = mysqli_query($conn, $idPizza);
            while ($row4 = mysqli_fetch_array($resultPizza)) {
                $idDodatki = "SELECT * from Dodatki_Pizza where idPizza=" . $row4['idPizza'] . ";";
                $ridDodatki = mysqli_query($conn, $idDodatki);
                while ($row2 = mysqli_fetch_array($ridDodatki)) {


                    $idKlient = "select idKlient from Zamowienia where idMenu=" . $row['idMenu'] . ";";
                    $ridKlient = mysqli_query($conn, $idKlient);
                    while ($rowk = mysqli_fetch_array($ridKlient)) {
                        $KlientID = $rowk['idKlient'];

                    }


                    if (isset($dodatkiPizza)) {
                            $count = count($dodatkiPizza);
                            $item_array = array(
                                'idPizza' => $row2['idPizza'],
                                'idDodatki' => $row2['idDodatki'],
                                'PodwojneDodatki' => $row2['PodwojneDodatki']
                            );
                            $dodatkiPizza[$count] = $item_array;

                    } else {
                        $item_array = array(
                            'idPizza' => $row2['idPizza'],
                            'idDodatki' => $row2['idDodatki'],
                            'PodwojneDodatki' => $row2['PodwojneDodatki']
                        );
                        $dodatkiPizza[0] = $item_array;
                    }


                    if (isset($IDPizza)) {
                        $item_array_id = array_column($IDPizza, "idPizza");
                        if (!in_array($row2['idPizza'], $item_array_id)) {
                            $count = count($IDPizza);
                            $item_array = array(
                                'idPizza' => $row2['idPizza']
                            );
                            $IDPizza[$count] = $item_array;
                        }
                    } else {
                        $item_array = array(
                            'idPizza' => $row2['idPizza']
                        );
                        $IDPizza[0] = $item_array;
                    }

                }

            }

        }
        break;
    }

    $dodatkiPizza2 = $dodatkiPizza;

    foreach ($dodatkiPizza2 as $key => $values) {
        //echo $values['idKlient'] . " ";
        //echo $values['idPizza'] . " ";
        //echo $values['idDodatki'] . "<br/>";

    }
    echo count($IDPizza) . "<br/>";
    foreach ($IDPizza as $key => $value) {
        foreach ($dodatkiPizza2 as $keys => $values) {
            if ($value['idPizza'] == $values['idPizza']) {
                foreach ($dodatkiPizza as $keyss => $valuess) {

                }
            }
        }
    }
    foreach ($dodatkiPizza2 as $key => $value) {
        $licznik = 0;
        $pizzerka = "";
        $dodatkowa = array();
        foreach ($dodatkiPizza as $keys => $values) {
            //echo "EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE<br/>";      
            if ($value['idDodatki'] === $values['idDodatki'] && $value['PodwojneDodatki'] === $values['PodwojneDodatki']) {

                $licznik++;
                // echo "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA"; 
                if (count($dodatkowa) != 0) {
                    $count = count($dodatkowa);
                    $item_array = array(

                        'idPizzerka' => $values['idPizza']
                    );
                    $dodatkowa[$count] = $item_array;

                } else {
                    $item_array = array(
                        'idPizzerka' => $values['idPizza']
                    );
                    $dodatkowa[0] = $item_array;
                }
                $dodatkiPizza[$keys]['idDodatki'] = 0;
                $values['idDodatki'] = 0;
                //echo "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA ".$values['idDodatki']; 
            }

        }
        //echo $licznik."<br/>";

        if ($licznik >= 3) {
            $idPizzerka = $value['idPizza'];

            foreach ($dodatkowa as $keys => $values) {
                $query = "SELECT idMenu from ManuPizza where idPizza='{$values['idPizzerka']}';";

                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($result)) {
                    $idMenuu = $row['idMenu'];
                    //echo $idMenuu."<br/>";
                    $query1 = "SELECT idKlient from Zamowienia where idMenu='$idMenuu';";
                    $result1 = mysqli_query($conn, $query1);
                    while ($row = mysqli_fetch_array($result1)) {
                        $idKlientaa = $row['idKlient'];
                        $query2 = "SELECT Imie from Klient where idKlient='$idKlientaa';";
                        $result2 = mysqli_query($conn, $query2);
                        while ($row = mysqli_fetch_array($result2)) {
                            $imieKlienta = $row['Imie'];
                            $pizzerka .= $imieKlienta;
                            //echo $pizzerka."<br/>";
                        }
                    }
                }


            }
            $exist = "SELECT count (NazwaPizza) as suma from Pizza where NazwaPizza='" . $pizzerka . "';";
            $rexist = mysqli_query($conn, $exist);
            while ($rowexist = mysqli_fetch_array($rexist)) {
                $existing = $rowexist['suma'];
            }
            if (existing == 0) {
                $queryInto = "INSERTt INTO Pizza values(NULL,'" . $pizzerka . "',1);";
                $resultInto = mysqli_query($conn, $queryInto);

                $idpizza = "SELECT idPizza from Pizza where NazwaPizza='" . $pizzerka . "';";
                $resultidPizza = mysqli_query($conn, $idpizza);
                while ($rowidPizza = mysqli_fetch_array($resultidPizza)) {
                    $idPizzerka2 = $rowidPizza['idPizza'];
                    //echo "<div class='col-12'>IdPizzy: ".$idPizzerka."<br>";
                }

                $idDod = "SELECT idDodatki,PodwojneDodatki from Dodatki_Pizza where idPizza='$idPizzerka';";
                $resultidDod = mysqli_query($conn, $idDod);
                while ($rowidDod = mysqli_fetch_array($resultidDod)) {

                    //echo "<div class='col-12'>IdPizzy1: ".$idPizzerka."<br>";
                    //echo "<div class='col-12'>IdPizzy1: ".$idPizzerka2."<br>";
                    //echo "<div class='col-12'>IdDodatku: ".$rowidDod['idDodatki']."<br>";
                    //echo "<div class='col-12'>Podwujne: ".$rowidDod['PodwojneDodatki']."<br>";


                    $dodawanieDodatkow = "INSERTt INTO Dodatki_Pizza values(NULL,'$idPizzerka2','{$rowidDod['idDodatki']}','{$rowidDod['PodwojneDodatki']}');";
                    $resultidDod = mysqli_query($conn, $dodawanieDodatkow);


                }
            }
        }
    }
}

?>


<!--- -------------------------Modalne------------------------------------------>

<!--- ----------------------------------contact --------------------------------------->
<div id="contact" class="offsetcontact">
    <footer>
        <div class="row justify-content-center">

            <div class="col-md-12 text-center">
                <h2><strong>Skontaktuj sie z nami</strong></h2>
                <p>39-300 Mielec<br>ul. Mickiewicza 12<br>Tel.: 555-444-333 </p>
                <p><a href="tel:515494230"><i class="fas fa-phone"></a></i></p>
                <a href="mailto:info@crossfitmielec.com.pl">info@pizza.com.pl</a>
                <p><a href="https://pl-pl.facebook.com/" target="_blank"><i class="fab fa-facebook-square"></i></a>
                    <a href="https://twitter.com/?lang=pl" target="_blank"><i class="fab fa-twitter-square"></i></a>
                    <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a></p>

            </div>
        </div>

        <div id="mapy">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d20478.397804339995!2d19.926553195909612!3d50.09003643450879!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb467c85af785ef03!2sDa%20Grasso!5e0!3m2!1spl!2spl!4v1578231774315!5m2!1spl!2spl"
                    width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen=""></iframe>

        </div>

    </footer>

</div>
<!--- ----------------------------Okno modalne------------------------------------>


<!--- ----------------------------------## --------------------------------------->
<!--- ----------------------SKRYPTY DO BOOTSTRAPA -------------------------------->

</body>
</html>