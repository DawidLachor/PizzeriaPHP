<?php
if (!isset($_SESSION)) {
    session_start();
}

include "laczenieZBaza.php";
if ($polaczenie->connect_errno) {
    echo "<script>console.log('Brak polaczenia z baza');</script>";
    exit;
} else {
    $polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    $polaczenie->query("SET CHARSET utf8");

    $zapytanie = $polaczenie->query(" select idPizza, NazwaPizzy from pizze where StandarPizza = 1;");

    while ($row = mysqli_fetch_array($zapytanie, MYSQLI_ASSOC)) {

        echo "<div class='col-6'>";
        echo $row['idPizza'];
        echo ". ";
        echo $row['NazwaPizzy'];
        echo "<div class='col-6'>";
        $skladniki = $polaczenie->query("select dodatki.NazwaDodatku from dodatki inner join dod_pizz on dodatki.idDodatku = dod_pizz.idDodatku inner join pizze on pizze.idPizza = dod_pizz.idPizzy where dod_pizz.idPizzy =  " . $row['idPizza'] . " ;");

        while ($skl = mysqli_fetch_array($skladniki, MYSQLI_ASSOC)) {
            echo $skl["NazwaDodatku"];
            echo ", ";
        }
        $skladniki->close();

        $nazwa = str_replace(' ', '', $row['NazwaPizzy']);
        echo '<form action="Zamowienia.php" method="post">';
        echo "</div>";
        echo "<div>";
        echo '<button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#' . $nazwa . '">Zamów</button>';
        echo "</div>";
        echo "</div>";

        echo '<div id="' . $nazwa . '" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                             <h4 class="modal-title">Wybór pizzy</h4>
                        <button type="button" class="close" data-dismiss="modal">
                        &times;
                        </button>
                    </div>
                    <div class="modal-body">
                    <input type="text" name="rodzajPizzy" value="' . $row['NazwaPizzy'] . '" readonly><br/>
                    <input type="text" name="idPizzy" value="' . $row['idPizza'] . '" class="d-none" readonly><br/>
                    <label>Grubość ciasta</label><br/>';
        ciasta($polaczenie);
        echo '<label>Rozmiar pizzy</label><br/>';
        rozmiar($polaczenie);
        echo '<br/>
                        <button type="submit" name="zamow" class="btn btn-warning">Zamów</button>
                       
                    </div>
                </div>
            </div>
        </div>
        </form>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>';
    }
    $zapytanie->close();
}

function ciasta($polaczenie)
{
    $ciasto = $polaczenie->query("select RodzajCiasta from rodzajeciasta;");

    while ($row = mysqli_fetch_array($ciasto, MYSQLI_ASSOC)) {
        echo "<p >";
        echo $row["RodzajCiasta"];
        echo "<input type=\"radio\" name=\"ciasto\" value=\"" . $row["RodzajCiasta"] . "\"></p>";
    }
    $ciasto->close();
}

function rozmiar($polaczenie)
{
    $rozmiar = $polaczenie->query("select RozmiarPizzy from rozmiarypizzy;");

    while ($row = mysqli_fetch_array($rozmiar, MYSQLI_ASSOC)) {
        echo "<p >";
        echo $row["RozmiarPizzy"];
        echo "<input type=\"radio\" name=\"rozmiar\" value=\"" . $row["RozmiarPizzy"] . "\"></p>";
    }
    $rozmiar->close();
}

?>