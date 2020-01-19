<?php
include "laczenieZBaza.php";


    $ciasto = $polaczenie->query("select RodzajCiasta from rodzajeciasta;");

    while ($row = mysqli_fetch_array($ciasto, MYSQLI_ASSOC)) {
        echo "<p ><span class='mr-2'>";
        echo $row["RodzajCiasta"].'</span>';
        echo "<input type=\"radio\" name=\"ciasto\" value=\"" . $row["RodzajCiasta"] . "\" required></p>";
    }
    $ciasto->close();