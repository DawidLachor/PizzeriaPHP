<?php
include "laczenieZBaza.php";
if ($polaczenie->connect_errno) {
    echo "<div>nie dział</div>";
    exit;
} else {
    $polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    $polaczenie->query("SET CHARSET utf8");
    $pizza = 1;
    $zapytanie = $polaczenie->query(" select idPizza, NazwaPizzy from pizze where StandarPizza = 1;");
    while ($row = mysqli_fetch_array($zapytanie, MYSQLI_ASSOC)) {
        echo "<div class='col-6'>";
        echo $pizza;
        echo ". ";
        echo $row['NazwaPizzy']."<br>";
        $skladniki = $polaczenie->query("select dodatki.NazwaDodatku from dodatki inner join dod_pizz on dodatki.idDodatku = dod_pizz.idDodatku inner join pizze on pizze.idPizza = dod_pizz.idPizzy where dod_pizz.idPizzy =  ". $row['idPizza'] ." ;");
        while ($skl = mysqli_fetch_array($skladniki, MYSQLI_ASSOC)){
            echo $skl["NazwaDodatku"];
            echo ", ";
        }
        $skladniki->close();
        $pizza = $pizza + 1;

        echo "</div>";
        }
    $zapytanie->close();
}

?>