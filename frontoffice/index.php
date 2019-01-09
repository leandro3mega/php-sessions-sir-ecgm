<?php

session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
} else {
    header("location: iniciar-sessao.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Round About - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/round-about.css" rel="stylesheet">

    <!-- My styles -->
    <link href="css/stylesheet.css" rel="stylesheet">

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Tou Xim</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contactos-page.php">Contactos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="grupos-page.php">Grupos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="procurar-page.php">Procurar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="perfil-page.php">
                            <?php echo($_SESSION['nome']); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">(Sair)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Contactos -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="my-4">Contactos</h2>
            </div>

            <div class="col-lg-3 col-sm-4 text-center mb-4">
                <img class="rounded-circle img-fluid d-block mx-auto" src="http://placehold.it/200x200" alt="">
                <h3>John Smith
                    <small>Job Title</small>
                </h3>
                <p>social links!</p>
            </div>

        </div>

        <!-- Grupos -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="my-4">Grupos</h2>
            </div>
            <div class="col-lg-3 col-sm-4 text-center mb-4">
                <img class="rounded-circle img-fluid d-block mx-auto" src="http://placehold.it/200x200" alt="">
                <h3>John Smith
                    <small>Job Title</small>
                </h3>
                <p>social links!</p>
            </div>

        </div>

        <!-- Contactos -->
        <!-- Grupos -->
        <div class="row">

        </div>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php
    include 'footer.html';
    ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>