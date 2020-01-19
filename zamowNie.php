<?php
include "laczenieZBaza.php";
if (isset($_SESSION["listaDodatkow"])) {

    if (!empty($_SESSION["pizzaList"])) {
        foreach ($_SESSION["pizzaList"] as $keys => $values) {

            $rozmiarPizzy = $values['rozmiar'];
            $rozmiar = $polaczenie->query("select idRozmiarPizzy from rozmiarypizzy where  RozmiarPizzy ='" . $rozmiarPizzy . "';");
            while ($row = mysqli_fetch_array($rozmiar)) {
                $idRozmiar = $row['idRozmiarPizzy'];
            }

            $rodzajCiasta = $values['ciasto'];
            $ciasto = $polaczenie->query("select idRodzajCiasta from rodzajeciasta where  RodzajCiasta ='" . $rodzajCiasta . "';");
            while ($row = mysqli_fetch_array($ciasto)) {
                $idCiasta = $row['idRodzajCiasta'];
            }

            $nazwaPizzy = $values['nazwa'];

            $polaczenie->query("insert into pizze values(0,'" . $nazwaPizzy . "',0);");
            $pizza = $polaczenie->query("select idPizza from pizze where NazwaPizzy='" . $nazwaPizzy . "';");
            while ($row = mysqli_fetch_array($pizza)) {
                $idPizzy = $row['idPizza'];
            }


            $polaczenie->query("insert into manupizze values(0," . $idPizzy . "," . $idRozmiar . "," . $idCiasta . ");");
        }
    }

//        Wpisywanie dodatków
    foreach ($_SESSION["listaDodatkow"] as $keys => $values) {
        $polaczenie->query("insert into dod_pizz values(0," . $idPizzy . "," . $values['idDodatku'] . "," . $values['podwojny'] . ");");
    }
//Wpisywanie klientów
    $polaczenie->query("insert into klienci values(0,'" . $_SESSION['imie'] . "','" . $_SESSION['nazwisko'] . "');");

//    wpisywanie Zamowienia
    $klient = $polaczenie->query(" select idKlienci from klienci where Imie = '" . $_SESSION['imie'] . "' and Nazwisko = '" . $_SESSION['nazwisko'] . "';");
    while ($row = mysqli_fetch_array($klient)) {
        $idKlienta = $row['idKlienci'];
    }

    $data = date('Y-m-d');


    foreach ($_SESSION["pizzaList"] as $keys => $values) {

        $menu = $polaczenie->query("select idMenu from manupizze where idPizzy = " . $idPizzy . " and idRozmiarPizzy = " . $idRozmiar . " and idRodzajCiasta = " . $idCiasta . ";");
        while ($row = mysqli_fetch_array($menu)) {
            $idMenu = $row['idMenu'];
        }


        $polaczenie->query(" insert into zamowienia values(0, " . $_SESSION['random'] . ", " . $_SESSION['stolik'] . ", " . $idKlienta . ", '" . $data . "', " . $idMenu . ");");
    }
}
