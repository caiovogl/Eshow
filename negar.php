<?php

include_once 'conexao.php';

$id = $_POST["id"];

$dado = ($conexao->query("DELETE FROM avaliacoes WHERE id_show = '$id'"));

$sql = "DELETE FROM shows WHERE shows.id = '$id'";
echo"<script>
    alert('Show excluido')
    window.location.replace('admin.php')
</script>";
$conexao->query($sql);

$conexao->close();
?>