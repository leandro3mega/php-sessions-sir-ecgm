<?php
session_start();

require_once("connectdb.php");


if ($_POST['action'] == 'add_to_group') {
    $user_id = $_POST['user'];
    $grupo = $_POST['grupo'];
    //--
    adicionarAoGrupo($connectDB, $user_id, $grupo);
} elseif ($_POST['action'] == 'add_to_lista') {
    $user = $_SESSION['id'];
    //--
    adicionarContactoLista($connectDB, $user);
}

function adicionarAoGrupo($connectDB, $user_id, $grupo)
{
    // -- If statement is prepared
    if ($stmt = mysqli_prepare($connectDB, "INSERT INTO utilizador_grupo (fk_idutilizador, fk_idgrupo, cargo) VALUES (?, ?, ?)")) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $user_id, $grupo, $param_cargo);

        $param_cargo = 1;
            
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "</br> Dados inseridos com sucesso. -> (USER)Aluno: " . $_SESSION['nome'];
        } else {
            echo "</br> Ocurreu um erro: Não conseguiu executar a query: " . mysqli_error($connectDB) . ". ";
        }
    } else {
        echo "</br> Ocurreu um erro: Não conseguiu preparar a query: " . mysqli_error($connectDB) . " . ";
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
}

function adicionarContactoLista($connectDB, $user_id)
{
    // -- If statement is prepared
    if ($stmt = mysqli_prepare($connectDB, "INSERT INTO lista_contactos (fk_idutilizador, fk_idutilizador_contacto) VALUES (?, ?)")) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_this_user, $param_contacto);

        $param_this_user = $user_id;
        $param_contacto = $_POST['contacto'];
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "</br> Dados inseridos com sucesso.";
        } else {
            echo "</br> Ocurreu um erro: Não conseguiu executar a query: " . mysqli_error($connectDB) . ". ";
        }
    } else {
        echo "</br> Ocurreu um erro: Não conseguiu preparar a query: " . mysqli_error($connectDB) . " . ";
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
}