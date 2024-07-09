<?php 
    include_once 'conexao.php';
    if(!isset($_SESSION)){
        session_start();
        if(key_exists('artista',$_SESSION)){
            header('Location:home.php');
        }
    }
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, max-scale=1.0">
    <title>É Show</title>
    <link rel="icon" type="image/png" href="assets/logo_cima.png"/>
    <link rel="stylesheet" href="style.css?v=<? echo time(); ?>">
</head>
<body>
<header id="header">
        <nav>
            <a href="index.php" id="logo"><img src="assets/logo.png" alt=""></a>
            <section style="align-items: center; display:flex">
                <div class="celular">
                    <a href="login.php"><h2>Entrar</h2></a>
                </div>
                </div>
                <ul class="opções"  style="padding-left: 20px;">
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
            </section>
        </nav>
        <div class="computador">
            <a href="login.php"><h2>Entrar</h2></a>
        </div>
    </header>
    <main id='carrossel'>
        <h1>Cadastrar<br><span style="font-size:20px;">*não utilize informações pessoais</span></h1>
        <form action="cadastro.php" method="post" class="formulario">
            <label for="nome">Nome de usuário</label>
            <input type="nome" name="nome" required>
            <label for="email">Email</label>
            <input type="email" name="email" required>
            <label for="senha">Senha</label>
            <input type="password" name="senha" required>
            <div class="artista">
                <label>É Cantor ou Banda:</label>
                <input type="radio" name="artista" value="1">
                <label for="artista">Sim</label>
                <input type="radio" name="artista" checked value="0">
                <label for="artista">Não</label>
            </div>
            <input type="submit" value="Cadastrar" class="botao">
        </form>
    </main>
    <footer id="footer">
        <p class="computador">Projeto Integrador Senac</p>
        <p class="celular">P.I Senac</p>
        <p>&copy;2024 - Todos os direitos reservados</p>
        <p>suporteeshowpr@gmail.com</p>
    </footer>
    <script src="script.js"></script>
</body>
<?php
    if(array_key_exists("nome",$_POST)){
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $artista = $_POST["artista"];
        $senha = sha1($senha);

        $dado = ($conexao->query("SELECT * FROM clientes WHERE email = '$email'"));

        $row = $dado->fetch_all(MYSQLI_ASSOC);

        if(!array_key_exists(0,$row)){
            $sql = "INSERT INTO clientes(nome,email,senha,artista) VALUES ('$nome','$email','$senha','$artista') ";
            echo"<script>
                alert('Cadastro concluído')
                window.location.replace('login.php')
            </script>";
            $conexao->query($sql);
        }else{
            echo"<script>
                alert('Usuário com esse email já existente')
                window.location.replace('cadastro.php')
            </script>";
        }
    }
    $conexao->close();
?>
</html>