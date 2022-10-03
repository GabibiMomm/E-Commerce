<?php
    //conexao

    $username = 'root';
    $password = '';
    
    try{
        $conexao = new PDO('mysql:host=localhost;dbname=meu_commerce', $username, $password);
        //$conn->setAtribute(PDO::ATR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

?>