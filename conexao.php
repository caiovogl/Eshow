<?php 
    $conexao = new mysqli("sql108.infinityfree.com", "if0_35472508", "oil2voI8P6327dL", "if0_35472508_banco_eshow");

    // Check connection
    if (!$conexao) {
        die("Connection failed: " . mysqli_connect_error());
    }
    //echo "Connected successfully";
    
?>