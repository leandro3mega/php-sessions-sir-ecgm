<?php

session_start();

require_once("connectdb.php");

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
} else {
    header("location: iniciar-sessao.php");
    exit;
}

//-- TODO: Select da info do contacto
$id = $nome = $email = $numero = $fotografia = "";
// $id = 25;
$id = (int)$_GET['contacto_id'];
//echo("id: " . $id);

$result = mysqli_query($connectDB, "SELECT idutilizador, nome, email, numero, fotografia 
    FROM utilizador 
    WHERE idutilizador=$id");

    if (mysqli_num_rows($result) == 1) {
        $row = $result->fetch_assoc();

        $nome = $row['nome'];
        $email = $row['email'];
        $email = $row['email'];
        $numero = $row['numero'];
        $fotografia = $row['fotografia'];
    } else {
        echo "</br> Não encontrou contacto";
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

<body class="body-site">

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
                    <li class="nav-item">
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
    <div class="container fundo-container">

        <!-- Nome do contacto -->
        <div class="row" style="padding:1rem; ">
            <div class="col-lg-12" style="border-bottom: 2px solid #eee;">
                <h2 class="my-4">
                    <?php echo($nome); ?>
                </h2>
            </div>
        </div>
        <form>

            <!-- Container for contacto perfil -->
            <div class="row" style="min-height:500px">

                <!-- DIV para a fotografia -->
                <div class="col-lg-5 col-sm-4" style='border-right: 2px solid #eee;'>
                    <!-- Fotografia -->
                    <div class="form-group" style="">

                        <div class="text-center mb-4" style="">

                            <?php

                        $diretorio = "images/contactos/";
                        $imagem = $fotografia;
                        echo("<img class='img-fluid mx-auto' style='max-height:200px; height:auto; width:auto;' src='". $diretorio . $imagem ."' alt=''>");
                        
                        ?>

                        </div>
                    </div>
                </div>

                <!-- DIV para a info do contacto -->
                <div class="col-lg-7 col-sm-4" style='padding-left:50px; padding-right:50px'>
                    <!-- Nome -->
                    <div class="form-group" style="">
                        <label>Email</label>
                        <h5 class="form-control-static">
                            <?php echo($email); ?>
                        </h5>
                    </div>

                    <!-- Numero -->
                    <div class="form-group" style="margin-top:50px">
                        <label>Número de Contacto</label>
                        <h5 class="form-control-static">
                            <?php echo($numero); ?>
                        </h5>
                    </div>

                    <!-- Elemento Hidden Para adicionar contacto-->
                    <?php
                    echo "
                    <input type = 'hidden' value = '" . $id . "'name = 'contacto_id' >
                    <input type = 'hidden' value = '" . $nome . "'name = 'contacto_nome' >
                    ";

                    //#######
                    // Botao de adicionar contacto -->
                    $this_user = $_SESSION['id'];

                    $result = mysqli_query($connectDB, "SELECT fk_idutilizador, fk_idutilizador_contacto
                    FROM lista_contactos 
                    WHERE fk_idutilizador='$this_user'
                    AND fk_idutilizador_contacto=$id");

                    //-- Se encontrar ligação entre user e o novo contacto -> ignora user
                    if (mysqli_num_rows($result) > 0) {
                        // é contacto
                        echo "
                        <div class='row' style='margin-left:auto; margin-right:auto; padding-top: 50px; padding-bottom: 50px;'>
                            <input type='submit' class='btn ' style='color:red; border-color:red' value='Remover'>
                        </div>
                        ";
                    } else {
                        // echo "</br> Não é contacto";
                        echo "
                        <div class='row' style='margin-left:auto; margin-right:auto; padding-top: 50px; padding-bottom: 50px;'>
                            <input type='submit' class='btn btn-outline-primary' value='Adicionar'>
                        </div>
                        ";
                    }

                    
                    ?>

                </div>
            </div>
            <!-- END: container for contacto perfil -->



        </form>
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