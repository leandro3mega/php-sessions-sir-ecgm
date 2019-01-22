<?php

session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
    header("location: index.php");
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

    <title>Tou Xim - Registar</title>

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
                        <a class="btn btn-primary" href="iniciar-sessao.php">Iniciar Sessão</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="card card-register mx-auto mt-5" style="margin-bottom:100px">
            <div class="card-header">Criar Nova Conta</div>
            <div class="card-body" style="padding-top:0.5rem">
                <form id="formregister" action="registo.php" method="post" onsubmit="return validaForm()" enctype='multipart/form-data'>
                    <!-- Nome -->
                    <div class="form-group">
                        <label class="label-bold" style="margin-top:0">Dados</label>
                        <div class="form-label-group">
                            <input type="text" name="nome" id="inome" class="form-control" required="required"
                                placeholder="Nome Completo">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" name="email" id="iemail" class="form-control" required="required"
                                placeholder="Email">
                        </div>
                    </div>

                    <!-- Numero -->
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="tel" name="numero" id="inumero" class="form-control" min="9" required="required"
                                placeholder="Número de telemovel">
                        </div>
                    </div>

                    <!-- Passwords -->
                    <div class="form-group">
                        <div class="form-row">

                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="password" name="password" id="ipassword" class="form-control" required="required"
                                        placeholder="Palavra Passe">
                                    <label class="label-bold" id="iHintPassword"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="password" name="confirmPassword" id="iconfirmPassword" class="form-control"
                                        required="required" placeholder="Confirme a Palavra Passe">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <!-- Carregar fotografia -->
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <label class="label-bold">Fotografia</label>
                                    <input type="file" name="fotografia" id="fotografia_file_upload_field" onChange="verificaImagem()"
                                        accept="image/jpeg,image/png" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Submeter">

                </form>
                <div class="text-center">
                    <a class="d-block small mt-3" href="iniciar-sessao.php">Iniciar Sessão</a>
                </div>
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

<script>
function validaForm() {
    var password1 = document.getElementById("ipassword");
    var password2 = document.getElementById("iconfirmPassword");
    var hintPassword = document.getElementById("iHintPassword");

    if (password1.value != password2.value) {
        hintPassword.style = "color: rgb(206, 77, 77)";
        hintPassword.innerHTML = "As passwords não são iguais!";
        return false;
    } else {
        hintPassword.style = "color: rgb(77, 206, 142);";
        hintPassword.innerHTML = "";
        return true;
    }

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