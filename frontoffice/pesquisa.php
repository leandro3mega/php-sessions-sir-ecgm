<?php
session_start();

require_once("connectdb.php");


if ($_POST['action'] == 'get_contacto') {
    $pesquisa = $_POST['pesquisa'];
    //-- Seleciona as ucs a mostrar na pagina novo-projeto
    selectContacto($connectDB, $pesquisa);
}

//-- Select do nome das UCs
function selectContacto($connectDB, $pesquisa)
{
    $rows = array();
    $this_user = $_SESSION['id'];

    $result = mysqli_query($connectDB, "SELECT idutilizador, nome, email, numero, fotografia 
    FROM utilizador 
    WHERE nome LIKE '%$pesquisa%' 
    OR email LIKE '%$pesquisa%'
    OR numero LIKE '%$pesquisa%'
    ORDER BY nome");

    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['idutilizador'] != $this_user) {
                
                //-- Verifica se o user já é contacto
                if (!checkIfContacto($connectDB, $this_user, $row['idutilizador'])) {
                    //echo("alert('Não é contacto')");
                    $rows[] = $row;
                }
            }
        }
        //-- print do json para ser retornado no ajax da pagina dos contactos
        print json_encode(($rows));
    } else {
        echo "</br> Não encontrou contacto";
    }
}

function checkIfContacto($connectDB, $this_user, $other_user)
{
    $result = mysqli_query($connectDB, "SELECT fk_idutilizador, fk_idutilizador_contacto
    FROM lista_contactos 
    WHERE fk_idutilizador=$this_user
    AND fk_idutilizador_contacto=$other_user");

    //-- Se encontrar ligação entre user e o novo contacto -> ignora user
    if (mysqli_num_rows($result) > 0) {
        // echo "</br> É contacto";
        return true;
    } else {
        // echo "</br> Não é contacto";
        return false;
    }
}