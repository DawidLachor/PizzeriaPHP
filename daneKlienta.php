<?php
if (!isset($_SESSION)) {
    session_start();
}
    echo "<p class='col-12'>Imie: ";
    echo $_SESSION['imie'];
    echo "</p>";
    echo "<p class='col-12'>Nazwisko: ";
    echo $_SESSION['nazwisko'];
    echo "</p>";
    echo "<p class='col-12'>Numer stoliku: ";
    echo $_SESSION['stolik'];
    echo "</p>";
?>
