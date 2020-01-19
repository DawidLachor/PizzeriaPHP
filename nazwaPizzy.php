<?php
foreach ($_SESSION["pizzaList"] as $keys => $values) {
    echo "<p class='col-12'>";
    echo "Nazwa: " . $values['nazwa'] . '<br/>';
    echo "Rozmiar: " . $values['rozmiar'] . '<br/>';
    echo "Ciasto: " . $values['ciasto'] . '<br/>';
    echo "Cena do zapłaty: " . round($values['cenaStandardRabat'],2) . '<br/>';
    echo "</p>";
}
