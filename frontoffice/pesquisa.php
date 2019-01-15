<?php
session_start();

require_once("connectdb.php");


if ($_POST['action'] == 'get_contacto') {
    $pesquisa = $_POST['pesquisa'];
    //-- Seleciona as ucs a mostrar na pagina novo-projeto
    selectContacto($connectDB, $pesquisa);
} elseif ($_POST['action'] == 'get_grupo') {
    $pesquisa = $_POST['pesquisa'];
    //-- Seleciona os grupos a mostrar na pagina novo-projeto
    selectGrupo($connectDB, $pesquisa);
} elseif ($_POST['action'] == 'get_nomes') {
    $pesquisa = $_POST['pesquisa'];
    $grupo = $_POST['grupo'];
    //-- Seleciona os grupos a mostrar na pagina novo-projeto
    selectRegistos($connectDB, $pesquisa, $grupo);
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

//-- Select do grupo
function selectGrupo($connectDB, $pesquisa)
{
    $rows = array();
    $this_user = $_SESSION['id'];

    $result = mysqli_query($connectDB, "SELECT idgrupo, nome, descricao, fotografia 
    FROM grupo 
    WHERE nome LIKE '%$pesquisa%' 
    OR descricao LIKE '%$pesquisa%'
    ORDER BY nome");

    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
                
            //-- Verifica se o utilizador já é membro do grupo
            if (!checkIfAlreadyLinked($connectDB, $this_user, $row['idgrupo'])) {
                //echo("alert('Não é contacto')");
                $rows[] = $row;
            }
        }
        //-- print do json para ser retornado no ajax da pagina dos contactos
        print json_encode(($rows));
    } else {
        echo "</br> Não encontrou contacto";
    }
}

//-- Verifica se o utilizador ´já é membro do grupo
function checkIfAlreadyLinked($connectDB, $this_user, $grupo)
{
    $result = mysqli_query($connectDB, "SELECT fk_idutilizador, fk_idgrupo, cargo 
    FROM utilizador_grupo 
    WHERE fk_idutilizador=$this_user
    AND fk_idgrupo=$grupo");

    //-- Se encontrar ligação entre user e o novo contacto -> ignora user
    if (mysqli_num_rows($result) > 0) {
        // echo "</br> É contacto";
        return true;
    } else {
        // echo "</br> Não é contacto";
        return false;
    }
}

//-- Select dos users registados que correspondam a pesquisa
function selectRegistos($connectDB, $pesquisa, $grupo)
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
                //--
                if (!checkIfMember($connectDB, $grupo, $row['idutilizador'])) {
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

//-- Verifica se já é membro do grupo
function checkIfMember($connectDB, $grupo, $possivel_membro)
{
    $result = mysqli_query($connectDB, "SELECT fk_idutilizador, fk_idgrupo, cargo 
    FROM utilizador_grupo 
    WHERE fk_idutilizador=$possivel_membro
    AND fk_idgrupo=$grupo");

    //-- Se encontrar ligação entre user e o novo contacto -> ignora user
    if (mysqli_num_rows($result) > 0) {
        // echo "</br> É contacto";
        return true;
    } else {
        // echo "</br> Não é contacto";
        return false;
    }
}