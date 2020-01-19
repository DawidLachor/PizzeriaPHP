<?php
include "laczenieZBaza.php";
$rozmiar = $polaczenie->query("select RozmiarPizzy from rozmiarypizzy;");

while ($row = mysqli_fetch_array($rozmiar, MYSQLI_ASSOC)) {
    echo "<p ><span class='mr-2'>";
    echo $row["RozmiarPizzy"]."</span>";
    echo "<input type=\"radio\" name=\"rozmiar\" value=\"" . $row["RozmiarPizzy"] . "\"></p>";
}
$rozmiar->close();