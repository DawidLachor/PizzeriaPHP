<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Zamówienia</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <a class="navbar-brand p-2" href="index.php">Pizzaria</a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link menu" href="index.php">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu " href="Zamowienia.php">Zamówienia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu active" href="Podsumowanie.php">Podsumowanie</a>
                </li>
            </ul>
        </div>
    </nav>
    <img src="image/slide-bg-1.jpg" class="img-fluid image" alt="Pizza">
</header>
<div class="container-fluid bg-light">
    <div class="row">
        <h1 class="col-12 text-center">PODSUMOWANIE DNIA: </h1>
        <form class="col-6" action="Podsumowanie.php" method="post">
            <h3>Sprawdz czy dodać pizze do standardowych</h3>
            <label for="dzien">Podaj za który dzien wyliczyc premie: </label>
            <input type="text" class="form-control"  name="dzien" placeholder="YYYY-MM-DD">
            <button type="submit" name="addPizza" class="btn btn-warning mb-3 mt-3">Dodsumuj dzień</button>
        </form>
        <form class="col-6" action="Podsumowanie.php" method="post">
            <h3>Wylicz premie dla kelnerów</h3>
            <label for="procent">Podaj procent premi: </label>
            <input type="number" class="form-control"  name="procent" placeholder="Procent">
            <label for="dzienPremi">Podaj za który dzien wyliczyc premie: </label>
            <input type="text" class="form-control"  name="dzienPremi" placeholder="YYYY-MM-DD">
            <button type="submit" name="procentButton" class="btn btn-warning mb-3 mt-3">Wylicz premie</button>
        </form>
        <?php include "premiaKelner.php"?>
        <?php include "pizzaStandard.php"?>


    </div>
</div>

<footer class="bg-dark">
    <span class="text-light d-inline text-center">&copy; Wszystkie prawa zastrzezone</span>
</footer>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>