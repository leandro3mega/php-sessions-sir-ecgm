<?php

session_start();

require_once("connectdb.php");

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
                        <a class="nav-link" href="contactos-page.php">Contactos</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="grupos-page.php">Grupos</a>
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
    <div class="container fundo-container" style="min-height:800px">

        <!-- Pesquisa -->
        <div class="row">
            <div class="col-lg-12" style=" padding:1rem; background-color:rgb(19, 185, 157);">
                <div class="col-md-10 col-lg-6 mx-auto text-center">

                    <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
                    <h2 class="text-white mb-5">Procure grupos</h2>

                    <div class="form-group form-inline">
                        <input type="text" class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" id="inputPesquisa"
                            placeholder="Pesquisar...">
                    </div>

                </div>
            </div>
        </div>


        <!-- Container for grupos -->
        <div id="meusGrupos">
            <?php
                $lista_grupos = array();
                $diretorio = "images/grupos/";
                
                //-- Select das ligações entre users e grupos para ver quais os grupos a que o user loggado pertence
                if ($stmt = $connectDB->prepare("SELECT fk_idutilizador, fk_idgrupo, cargo FROM utilizador_grupo WHERE fk_idutilizador = ?")) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("s", $param_id);

                    // Set parameters
                    $param_id = $_SESSION['id'];

                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            //echo("</br>Contacto: " . $row['fk_idutilizador_contacto']);
                            $lista_grupos[] = $row['fk_idgrupo'];
                        }
                    } else {
                        echo "</br>Oops! Something went wrong. Please try again later.";
                    }
                }

                // Close statement
                $stmt->close();


                //-- Seleciona a info para cada id de contacto
                if ($stmt = $connectDB->prepare("SELECT nome, descricao, fotografia FROM grupo WHERE idgrupo=? ORDER BY nome")) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("s", $param_id);

                    for ($i=0; $i < count($lista_grupos); $i++) {
                        //echo("No for: " . $lista_ids[$i]);

                        // Set parameters
                        $param_id = $lista_grupos[$i];
                        //echo("</br>Param Contacto_id: " . $param_id);

                        // Attempt to execute the prepared statement
                        if ($stmt->execute()) {
                            // associar os parametros de output
                            $stmt->bind_result($r_nome, $r_descricao, $r_fotografia);

                            // store result
                            $stmt->store_result();

                            // iterar / obter resultados
                            $stmt->fetch();

                            if ($stmt->num_rows == 1) {

                                //echo("</br>Contacto: " . " | Nome: " . $r_nome);
                                echo "
                                <form id='".$lista_grupos[$i]."' action='grupo-page.php' enctype='multipart/form-data' method='GET'>
                                    <div class='row'>
                                        
                                        <div class='col-md-5'>
                                            <img class='img-fluid rounded mb-3 mb-md-0' src='".$diretorio .$r_fotografia."' alt=''>
                                        </div>
                                        
                                        <div class='col-md-7'>
                                            <h3>". $r_nome ."</h3>
                                            <P>". $r_descricao ."</P>
                                            <input type='hidden' value='" . $lista_grupos[$i] . "' name='grupo_id'>
                                            <input type='hidden' value='" . $r_nome . "' name='grupo_nome'>
                                            
                                            <input type='submit' class='btn btn-outline-primary' value='Ver Grupo'>
                                        </div>
                                    
                                    </div>
                                </form>
                                ";

                                echo "<hr>";
                            } else {
                                echo "</br>Não existe utilizador com o id";
                            }
                        } else {
                            echo "</br>Oops! Something went wrong. Please try again later.";
                        }
                    }
                }
                // Close statement
                $stmt->close();


            ?>
        </div>
        <!-- END: Container for grupos -->

        <div class="row" id="pesquisaContainer">

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
var inputPesquisa = document.getElementById("inputPesquisa");
var contactosContainer = document.getElementById("meusGrupos");
var pesquisaContainer = document.getElementById("pesquisaContainer");

inputPesquisa.addEventListener("keyup", pesquisaContacto);

function pesquisaContacto() {
    var pesquisa = inputPesquisa.value;
    console.log(inputPesquisa.value);

    if (!pesquisa) {
        console.log("Sem valor")
        contactosContainer.style = "min-height: 400px; padding:1rem !important; padding-top:2rem !important;";
        pesquisaContainer.style = "display:none";
    } else {
        console.log("Com valor")
        contactosContainer.style = "display:none";
        pesquisaContainer.style = "min-height: 400px; padding:1rem !important; padding-top:2rem !important;";

        pesquisaContainer.innerHTML = "";

        //-- Se o input de pesquisa tive conteudo, verifica se existem contactos com info identica
        $.ajax({
            type: "POST",
            url: 'pesquisa.php',
            data: {
                'action': 'get_grupo',
                'pesquisa': pesquisa
            },
            dataType: 'json',
            success: function(response) {
                $.each(response, function(index, element) {
                    console.log(element); // print json code

                    $("#pesquisaContainer").append(
                        "<div class = 'col-lg-3 col-sm-3 text-center mb-4' name ='contacto[]' style=''>" +

                        "<form id='formPesquisaContacto[]' action='grupo-page.php' enctype='multipart/form-data' method='GET'>" +
                        "<div class='form-group'>" +

                        "<img class='rounded-circle img-fluid d-block mx-auto'style='height:150px' src ='images/grupos/" +
                        element.fotografia + "' alt = ''>" +

                        "<input type = 'hidden' value = '" + element.idgrupo +
                        "'name = 'grupo_id' >" +
                        "<input type = 'hidden' value = '" + element.nome +
                        "'name = 'grupo_nome' >" +

                        "<h4 class='h4-overflow-limit'> " + element.nome + "</h4>" +
                        //"<p>" + element.numero + "</p>" +
                        "</div>" +
                        "<input type='submit' class='btn btn-outline-primary' value='Ver Perfil'>" +
                        "</form>" +

                        "</div>"

                    );
                });
                //alert(response);
            }
        });
    }
}
</script>

</html>