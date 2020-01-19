<?php
include "laczenieZBaza.php";

$dodatki = $polaczenie->query("select idDodatku, NazwaDodatku from dodatki;");

while ($row = mysqli_fetch_array($dodatki, MYSQLI_ASSOC)) {
    echo "<p ><span class='mr-2'>";
    echo $row["NazwaDodatku"]."</span>";
    echo "<span class='mr-2'><input type=\"checkbox\" name=\"". $row["idDodatku"] ."\" value=\"" . $row["idDodatku"] . "\"></span>";
    echo "Czy podwójny dodatek: <span class='mr-2'>";
    echo "<input type=\"checkbox\" name=\"" . $row["idDodatku"] . "d\" value=\"" . $row["idDodatku"] . "\"></span></p>";
}
$dodatki->close();
