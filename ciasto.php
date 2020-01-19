<?php
include "laczenieZBaza.php";


    $ciasto = $polaczenie->query("select RodzajCiasta from rodzajeciasta;");

    while ($row = mysqli_fetch_array($ciasto, MYSQLI_ASSOC)) {
        echo "<p >";
        echo $row["RodzajCiasta"];
        echo "<input type=\"radio\" name=\"ciasto\" value=\"" . $row["RodzajCiasta"] . "\"></p>";
    }
    $ciasto->close();