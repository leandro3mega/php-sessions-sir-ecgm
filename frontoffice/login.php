<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
    header("location: index.php");
    exit;
}

require_once("connectdb.php");

// Define variables and initialize with empty values
$email = $password = "";

//echo(password_hash("admin", PASSWORD_DEFAULT));

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Check if username is empty
    if (empty(trim($_POST["email"]))) {
        //$username_err = "Please enter username.";
    } else {
        $email = trim($_POST["email"]);
        echo("</br>" . $email);
    }
    
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        //$password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
        echo("</br>" . $password);
    }
    
    // Validate credentials
    // Prepare a select statement
    $sql = "SELECT idutilizador, email, password, nome, numero, fotografia FROM utilizador WHERE email = ?";
        
    if ($stmt = $connectDB->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_email);
            
        // Set parameters
        $param_email = $email;
            
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Store result
            $stmt->store_result();
                
            // Check if username exists, if yes then verify password
            if ($stmt->num_rows == 1) {
                // Bind result variables
                $stmt->bind_result($id, $email, $hashed_password, $nome, $numero, $fotografia);
                if ($stmt->fetch()) {
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, so start a new session
                        //session_start();
                            
                        // Store data in session variables
                        $_SESSION["logged"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["email"] = $email;
                        $_SESSION["nome"] = $nome;
                        $_SESSION["numero"] = $numero;
                        $_SESSION["fotografia"] = $fotografia;
                            
                        // Redirect user to index page
                        header("location: index.php");
                    } else {
                        // Display an error message if password is not valid
                        echo "A palavra passe inserida não é valida.";
                    }
                }
            } else {
                echo"Não foi encontrada conta com o email: " . $email;
            }
        } else {
            echo "Algo correu mal. Por favor tente de novo.";
        }
    }
        
    // Close statement
    $stmt->close();
}

// Close connection
$connectDB->close();