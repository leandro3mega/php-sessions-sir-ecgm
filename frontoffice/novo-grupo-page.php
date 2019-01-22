<?php

session_start();

require_once("connectdb.php");

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
} else {
    header("location: iniciar-sessao.php");
    exit;
}

$id = $nome = $email = $numero = $fotografia = "";
$id = $_SESSION['id'];

$result = mysqli_query($connectDB, "SELECT idutilizador, nome, email, numero, fotografia 
FROM utilizador 
WHERE idutilizador=$id");

if (mysqli_num_rows($result) == 1) {
    $row = $result->fetch_assoc();

    $nome = $row['nome'];
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

    <title>Criar Grupo</title>

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
                    <li class="nav-item">
                        <a class="nav-link" href="contactos-page.php">Contactos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="grupos-page.php">Grupos</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="perfil-page.php">
                            <?php echo($nome); ?>
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

        <form action="criargrupo.php" method="post" enctype='multipart/form-data'>
            <div class="row" style="margin-top:1rem">

                <!-- 1ª Coluna -->
                <div class="col-lg-6" style="border-right: 2px solid #eee;">

                    <!-- Input Nome -->
                    <div class="form-group" id="iDivInputNome" style="">
                        <label>Nome</label>
                        <input type="text" id="iInputNome" name="grupo_nome" min="5" required class="form-control" style="margin-bottom:15px;"
                            placeholder="Insira o seu nome">
                    </div>

                    <!-- Input descricao -->
                    <div class="form-group" id="iDivInputNome" style="">
                        <label>Descrição</label>
                        <textarea name="grupo_descricao" id="iInputDescricao" min="10" max="500" required class="form-control"
                            style="margin-bottom:15px;" placeholder="Insira a descrição..." cols="70" rows="6"></textarea>
                    </div>

                </div>
                <!-- END: 1ª Coluna -->

                <!-- 2ª Coluna -->
                <div class="col-lg-6">

                    <!-- Input Fotografia -->
                    <div class="form-group" id="iDivInputFotografia" style="">
                        <label>Fotografia</label>

                        <div class="form-group">
                            <input type="file" name="fotografia" id="fotografia_file_upload_field" required accept="image/jpeg,image/png" />
                        </div>

                    </div>

                </div>
                <!-- END: 2ª Coluna -->
            </div>

            <div class="row">

                <div class="form-group form-inline" style="margin-left:auto; margin-right: auto; margin-top: 15px">

                    <input type="submit" class="btn btn-accept" style="margin-right:15px" value="Criar Grupo">
                    <a href="grupos-page.php"><button id="iBtnCancelarNumero" class="btn btn-delete">Voltar</button></a>

                </div>
            </div>
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

<script>
var nomeInputHidden = true;
var emailInputHidden = true;
var numeroInputHidden = true;
var passwordInputHidden = true;
var fotografiaInputHidden = true;

//-- Mostra ou esconde os inputs para mudar o nome
function showhideNome() {
    var divLabelNome = document.getElementById("iDivLabelNome");
    var divInputNome = document.getElementById("iDivInputNome");
    var btnAlterarNome = document.getElementById("iBtnAlterarNome");
    var btnSubmeterNome = document.getElementById("iBtnSubmeterNome");
    var btnCancelarNome = document.getElementById("iBtnCancelarNome");

}



//-- Adiciona ou remove imagens dependendo do numero selecionado
var inputImage = document.getElementById("fotografia_file_upload_field");
inputImage.onchange = function() {

    var limiteSize = 1020; // 1 Megabyte
    var file = this.files[0];
    var input = this;
    console.log(file);

    //##### Start of reader
    var reader = new FileReader(); // CREATE AN NEW INSTANCE.

    reader.onload = function(e) {
        var img = new Image();
        img.src = e.target.result;

        img.onload = function() {
            var valido = true;
            var w = this.width;
            var h = this.height;
            var size = Math.round((file.size / 1024));

            console.log("File Name: " + file.name);
            console.log("Width: " + w);
            console.log("Height: " + h);
            console.log("Size: " + Math.round((file.size / 1024)));
            console.log("File Type: " + file.type);
            console.log("Limite: " + limiteSize);

            if (file.type == "image/png" || file.type == "image/jpeg") {
                console.log("A imagem é png ou jpeg");

                //-- Check size and dimensions of image
                if (w > 1980 || h > 1080 || size > limiteSize) {
                    alert(
                        "A imagem tem tamanho superior a 1MB ou dimensões superiores a 1960x1080."
                    );
                    input.value = "";

                } else {
                    console.log("A imagem não tem tamanho superior a 1mb");
                    valido = true;
                }
            } else {
                console.log("A imagem não é png ou jpeg");
                alert("Imagens não é de tipo suportado! Insira uma imagem PNG ou JPEG");

                input.value = "";
            }
        }
    };
    reader.readAsDataURL(file, input);
    //##### End of reader
}
</script>

</html>