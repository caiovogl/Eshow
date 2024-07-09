<?php 
    if(!isset($_SESSION)){
        session_start();
        if(key_exists('artista',$_SESSION)){
            header('Location:home.php');
        }
    }
?>

</html><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, max-scale=1.0">
    <title>É Show</title>
    <link rel="icon" type="image/png" href="assets/logo_cima.png"/>
    <link rel="stylesheet" href="style.css?v=<? echo time(); ?>">
    <style>
        li form{
            margin: 0;
        }
    </style>
</head>
<body>
    <header id="header">
        <nav>
            <a href="index.php" id="logo"><img src="assets/logo.png" alt=""></a>
            <ul class="opções">
                <input type="checkbox" hidden id="opções_menu" class="opçoes_botao">
                <label class="opções_rotulo">
                    <li class="opções_item texto_grande"><h2>Estilos musicais</h2></li>
                    <li class="opções_item texto_pequeno"><h2>Estilos</h2></li>
                </label>
                <ul class="lista-menu">
                    <li class="lista-menu_item">
                        <form action="pesquisa.php" method="post" style="display: flex; width:100%; justify-content:center">
                            <input hidden value="" name="pesquisa">
                            <input hidden value="sertanejo" name="mais">
                            <button type="submit" class="botao lista-menu_link"><h2>Sertanejo</h2></button>
                        </form>
                    </li>
                    <li class="lista-menu_item">
                        <form action="pesquisa.php" method="post" style="display: flex; width:100%; justify-content:center">
                            <input hidden value="" name="pesquisa">
                            <input hidden value="eletronica" name="mais">
                            <button type="submit" class="botao lista-menu_link"><h2>Eletrônica</h2></button>
                        </form>
                    </li>
                    <li class="lista-menu_item">
                        <form action="pesquisa.php" method="post" style="display: flex; width:100%; justify-content:center">
                            <input hidden value="" name="pesquisa">
                            <input hidden value="rock" name="mais">
                            <button type="submit" class="botao lista-menu_link"><h2>Rock</h2></button>
                        </form>
                    </li>
                    <li class="lista-menu_item">
                        <form action="pesquisa.php" method="post" style="display: flex; width:100%; justify-content:center">
                            <input hidden value="" name="pesquisa">
                            <input hidden value="pop" name="mais">
                            <button type="submit" class="botao lista-menu_link"><h2>Pop</h2></button>
                        </form>
                    </li>
                    <li class="lista-menu_item">
                        <form action="pesquisa.php" method="post" style="display: flex; width:100%; justify-content:center">
                            <input hidden value="" name="pesquisa">
                            <input hidden value="funk" name="mais">
                            <button type="submit" class="botao lista-menu_link"><h2>Funk</h2></button>
                        </form>
                    </li>
                </ul>
            </ul>
        </nav>
    </header>
    <main id='carrossel'>
        <h1>Login<br><span style="font-size:20px;">*Use sua Conta do É Show</span></h1>
        <form action="login.php" method="post" class="formulario">
            <label for="email">Email</label>
            <input type="email" name="email" required>
            <label for="senha">Senha</label>
            <input type="password" name="senha" required>
            <input type="submit" value="Entrar" class="botao">
        </form>
        <p>Não tem uma conta? <a href="cadastro.php" style="color:#C97932;">Cadastrar</a></p>
    </main>
    <footer class="baixo">
        <p class="computador">Projeto Integrador Senac</p>
        <p class="celular">P.I Senac</p>
        <p>&copy;2024 - Todos os direitos reservados</p>
        <p>suporteeshowpr@gmail.com</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
<?php 
    include_once 'conexao.php';

    if(array_key_exists("email",$_POST)){
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $senha = sha1($senha);

        $dado = ($conexao->query("SELECT * FROM clientes WHERE email = '$email'"));

        $row = $dado->fetch_all(MYSQLI_ASSOC);

        if(array_key_exists(0,$row)){
            if($row[0]['email'] == $email && $row[0]['senha'] == $senha){
                if(!array_key_exists("email",$_SESSION)){
                    session_start();
                    $_SESSION["artista"] = $row[0]['artista'];
                    $_SESSION["email"] = $row[0]['email'];
                    if($email!="admin@admin.com"){
                        echo"<script>
                            window.location.replace('home.php')
                        </script>";
                    }else{
                        echo"<script>
                            window.location.replace('admin.php')
                        </script>";
                    }
                }
            }else{
                echo"<script>
                    alert('O usuário ou senha estão incorretos')
                    window.location.replace('login.php')
                </script>";
            }
        }else{
            echo"<script>
                alert('Usuário não encontrado')
                window.location.replace('login.php')
            </script>";
        }
    }   
    $conexao->close();
?>

