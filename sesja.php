<?php
if (!isset($_SESSION)) {
    session_start();
}
include "laczenieZBaza.php";
if ($polaczenie->connect_errno) {
    echo "<script>console.log('Brak polaczenia z baza');</script>";
    exit;
} else {
    if (isset($_POST['zakup'])){

        $_SESSION["imie"] = $_POST['imie'];
        $_SESSION["nazwisko"] = $_POST['nazwisko'];
        $_SESSION["stolik"] = $_POST['stolik'];
    }
}
?>
