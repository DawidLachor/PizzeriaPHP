<?php
include "laczenieZBaza.php";
if ($polaczenie->connect_errno) {
    echo "<script>console.log('Brak polaczenia z baza');</script>";
    exit;
} else {
    if (isset($_POST['ciasto']) && isset($_POST['rozmiar'])) {

        $nazwa = $_POST['rodzajPizzy'];
        $rozmiar = $_POST['rozmiar'];
        $ciasto = $_POST['ciasto'];


        $query = "select Cena FROM rodzajeciasta where RodzajCiasta='$ciasto';";
        $result = mysqli_query($polaczenie, $query);

        while ($row = mysqli_fetch_array($result)) {
            $cenaciasta = $row['Cena'];
        }

        $query = "select PowiekszonaCenaDodatku FROM rozmiarypizzy where RozmiarPizzy='$rozmiar';";
        $result1 = mysqli_query($polaczenie, $query);

        while ($row = mysqli_fetch_array($result1)) {
            $rozmiarcena = $row['PowiekszonaCenaDodatku'];
        }

        if (!isset($_POST['wlasnaPizza'])) {
            $query = "select idPizza from pizze where NazwaPizzy='$nazwa';";
            $result2 = mysqli_query($polaczenie, $query);

            while ($row = mysqli_fetch_array($result2)) {
                $pizzaID = $row['idPizza'];
            }

            $query = "select sum(CenaDodatku) as suma from dodatki inner join dod_pizz on dodatki.idDodatku = dod_pizz.idDodatku inner join pizze on pizze.idPizza = dod_pizz.idPizzy where dod_pizz.idPizzy='$pizzaID';";
            $result3 = mysqli_query($polaczenie, $query);
            while ($row = mysqli_fetch_array($result3)) {
                $cenadodatkow = $row['suma'];
            }



            $cenaCalkowita = ($cenaciasta + ($rozmiarcena * $cenadodatkow));
            $rabat = ((20 * $cenaCalkowita) / 100);
            $cenaKoncowa = $cenaCalkowita - $rabat;

        } else {
            $_SESSION["nie"];
            $query = "select idDodatku, NazwaDodatku, CenaDodatku  from dodatki";
            $result3 = mysqli_query($polaczenie, $query);
            $nazwa = "";
            $cenaKoncowa = 0;
            while ($row = mysqli_fetch_array($result3)) {
                if (isset($_POST[$row['idDodatku']])) {
                    $nazwa .= str_replace(' ', '', $row['NazwaDodatku']);
                    $podwojny = 0;

                    if (isset($_POST[$row["idDodatku"] . 'd'])) {
                        $podwojny = 1;
                    }
                    if ($podwojny == 1) {
                        $cenaKoncowa += $rozmiarcena * $row['CenaDodatku'] * 2;
                    } else {
                        $cenaKoncowa += $rozmiarcena * $row['CenaDodatku'];
                    }

                    if (isset($_SESSION["listaDodatkow"])) {
                        $item_array_id = array_column($_SESSION["listaDodatkow"]);
                        if (!in_array($item_array_id)) {
                            $count = count($_SESSION["listaDodatkow"]);
                            $item_array = array(
                                'idDodatku' => $row['idDodatku'],
                                'podwojny' => $podwojny
                            );
                            }
                            $_SESSION["listaDodatkow"][$count] = $item_array;
                        } else {
                            $item_array = array(
                                'idDodatku' => $row['idDodatku'],
                                'podwojny' => $podwojny
                            );
                            $_SESSION["listaDodatkow"][0] = $item_array;
                        }
                    }


                }


            $cenaKoncowa = $cenaKoncowa + $cenaciasta;
        }


        if (isset($_SESSION["pizzaList"])) {
            $item_array_id = array_column($_SESSION["pizzaList"]);
            if (!in_array($item_array_id)) {
                $count = count($_SESSION["pizzaList"]);
                $item_array = array(
                    'nazwa' => $nazwa,
                    'rozmiar' => $rozmiar,
                    'ciasto' => $ciasto,
                    'cenaStandardRabat' => $cenaKoncowa

                );
                $_SESSION["pizzaList"][$count] = $item_array;
            } else {

            }

        } else {
            $item_array = array(
                'nazwa' => $nazwa,
                'rozmiar' => $rozmiar,
                'ciasto' => $ciasto,
                'cenaStandardRabat' => $cenaKoncowa
            );
            $_SESSION["pizzaList"][0] = $item_array;
        }


        if (!empty($_SESSION["pizzaList"])) {
            $total = 0;
            foreach ($_SESSION["pizzaList"] as $keys => $values) {
                echo "Nazwa: " . $values['nazwa'] . '<br/>';
                echo "Rozmiar: " . $values['rozmiar'] . '<br/>';
                echo "Ciasto: " . $values['ciasto'] . '<br/>';
                echo "Cena: " . round($values['cenaStandardRabat'],2) . '<br/>';
            }
        }

        $random = rand(1, 3);
        $_SESSION['random'] = $random;
    }

}

mysqli_close($polaczenie);
?>
