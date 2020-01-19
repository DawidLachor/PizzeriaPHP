<?php
include "laczenieZBaza.php";

$dodatki = $polaczenie->query("select idDodatku, NazwaDodatku from dodatki;");

while ($row = mysqli_fetch_array($dodatki, MYSQLI_ASSOC)) {
    echo "<p >";
    echo $row["NazwaDodatku"];
    echo "<input type=\"checkbox\" name=\"". $row["idDodatku"] ."\" value=\"" . $row["idDodatku"] . "\">";
    echo "Czy podwójny dodatek: ";
    echo "<input type=\"checkbox\" name=\"" . $row["idDodatku"] . "d\" value=\"" . $row["idDodatku"] . "\"></p>";
}
$dodatki->close();
