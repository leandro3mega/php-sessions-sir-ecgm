<?php
session_start();

require_once("connectdb.php");

$user_id = $_POST['user'];

if ($_POST['action'] == 'delete_from_group') {
    //-- Apaga contacto do grupo
    deleteFromGrupo($connectDB, $user_id);
} elseif ($_POST['action'] == 'delete_from_lista') {
    //-- Seleciona os grupos a mostrar na pagina novo-projeto
    deleteFromLista($connectDB, $user_id);
}

function deleteFromGrupo($connectDB, $user_id)
{
    // inicializar prepared statement
    $stmt = $connectDB->prepare("DELETE FROM utilizador_grupo WHERE fk_idutilizador=?");
    
    if (false === $stmt) {
        echo "Não conseguiu preparar a query";
    }
    
    $stmt->bind_param("s", $user_id);

    // executar
    if ($stmt->execute()) {
        echo "</br>Ligações em utilizador_grupo removidas com sucesso.";
    } else {
        echo "</br>Ocurreu um erro: Não conseguiu executar a query: " . mysqli_error($connectDB) . ". ";
    }

    $stmt->close();
}

function deleteFromLista($connectDB, $user_id)
{
    $contacto = $_POST['contacto'];

    // inicializar prepared statement
    $stmt = $connectDB->prepare("DELETE FROM lista_contactos WHERE fk_idutilizador_contacto=?");
    
    if (false === $stmt) {
        echo "Não conseguiu preparar a query";
    }
    
    $stmt->bind_param("s", $param_contacto);

    $param_contacto = $contacto;

    // executar
    if ($stmt->execute()) {
        echo "</br>Ligações em utilizador_grupo removidas com sucesso.";
    } else {
        echo "</br>Ocurreu um erro: Não conseguiu executar a query: " . mysqli_error($connectDB) . ". ";
    }

    $stmt->close();
}