<?php

include_once 'conexao.php';

$id = $_POST["id"];

$dado = ($conexao->query("SELECT * FROM shows WHERE id = '$id'"));

$row = $dado->fetch_all(MYSQLI_ASSOC);

$sql = "UPDATE shows SET aprovado = '1' WHERE shows.id = $id;";
echo"<script>
    alert('Show aprovado')
    window.location.replace('admin.php')
</script>";
$conexao->query($sql);

$conexao->close();
?>