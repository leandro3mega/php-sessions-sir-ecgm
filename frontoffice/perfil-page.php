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
                    <li class="nav-item ">
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
                    <li class="nav-item active">
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
    <div class="container fundo-container">

        <div class="row">
            <div class="col-lg-12" style="border-bottom: 2px solid #eee;">
                <h2 class="my-4">Dados Pessoais</h2>
            </div>
        </div>

        <div class="row" style="margin-top:1rem">
            <!-- 1ª Coluna -->
            <div class="col-lg-6" style="border-right: 2px solid #eee;">

                <!-- Nome -->
                <div class="form-group" id="iDivLabelNome" style="">
                    <label>Nome</label>
                    <p class="form-control-static">
                        <?php echo($_SESSION['nome']); ?>
                    </p>
                    <a class="btn btn-outline-primary" href="#">Alterar</a>
                </div>

                <!-- Email -->
                <div class="form-group" id="iDivLabelEmail" style="margin-top:2rem;">
                    <label>Email</label>
                    <p class="form-control-static">
                        <?php echo($_SESSION['email']); ?>
                    </p>
                    <a class="btn btn-outline-primary" href="#">Alterar</a>
                </div>

                <!-- Numero -->
                <div class="form-group" id="iDivLabelNumero" style="margin-top:2rem;">
                    <label>Numero</label>
                    <p class="form-control-static">
                        <?php echo($_SESSION['numero']); ?>
                    </p>

                    <a class="btn btn-outline-primary" href="#">Alterar</a>

                </div>


            </div>
            <!-- END: 1ª Coluna -->

            <!-- 2ª Coluna -->
            <div class="col-lg-6">

                <!-- Palavra Passe -->
                <div class="form-group" id="iDivLabelPassword" style="">
                    <label>Palavra Passe</label>
                    <div class="col-lg12">
                        <a class="btn btn-outline-primary" href="#">Alterar</a>
                    </div>
                </div>

                <!-- Fotografia -->
                <div class="form-group" id="iDivLabelFotografia" style="margin-top:2rem;">
                    <label>Fotografia</label>
                    <div class="col-lg-6 col-sm-4 text-center mb-4" style="padding-left:0px;">

                        <?php
                        $diretorio = "images/contactos/";
                        $imagem = $_SESSION['fotografia'];
                        echo("
                        <img class='img-fluid mx-auto' src='". $diretorio . $imagem ."' alt=''>
                        ");
                        ?>

                    </div>
                    <div class="col-lg12">
                        <a class="btn btn-outline-primary" href="#">Alterar</a>
                    </div>
                </div>
            </div>
            <!-- END: 2ª Coluna -->
        </div>

        <!-- Contactos -->
        <div class="row">
            <!-- Exemplos de inputs -->
            <div class="col-lg12">
                <a class="btn btn-primary" href="#">Alterar</a>
                <a class="btn btn-secondary" href="#">Alterar</a>
                <a class="btn btn-info" href="#">Alterar</a>
                <a class="btn btn-dark" href="#">Alterar</a>
            </div>
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