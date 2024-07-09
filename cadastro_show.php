<?php 
    if(!isset($_SESSION)){
        session_start();
        if($_SESSION['email'] != null){
            $email = $_SESSION['email'];
        }
        if($_SESSION['artista'] != null){
            $artista = $_SESSION['artista'];
        }else{
            header('Location:home.php');
        }   
    }

    include_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, max-scale=1.0">
    <title>É Show</title>
    <link rel="icon" type="image/png" href="assets/logo_cima.png"/>
    <link rel="stylesheet" href="style.css?v=<? echo time(); ?>">
    <style>
        .botao{
            border: 1px solid black;
        }
    </style>
</head>
<body>
<header id="header">
        <nav>
            <a href="index.php" id="logo"><img src="assets/logo.png" alt=""></a>
            <section style="align-items: center; display:flex">
                <div class="celular">
                <?php
                    if($artista != null){
                        if($artista == true){
                            echo '<a href="cadastro_show.php" style="margin-right:30px"><h2>Cadastrar show</h2></a>';
                        }
                        echo '<a href="logout.php"><h2>Sair</h2></a>';
                    }else{
                        echo '<a href="login.php"><h2>Entrar</h2></a>';
                    }
                ?>
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
        <?php
            if($artista != null){
                if($artista == true){
                    echo '<a href="cadastro_show.php" style="margin-right:30px"><h2>Cadastrar show</h2></a>';
                }
                echo '<a href="logout.php"><h2>Sair</h2></a>';
            }else{
                echo '<a href="login.php"><h2>Entrar</h2></a>';
            }
        ?>
        </div>
    </header>
    <main id='carrossel'>
        <h1>Cadastrar show</h1>
        <form action="cadastro_show.php" method="post" enctype="multipart/form-data" class="formulario"> 
            <label for="banda">Nome da banda</label>
            <input type="text" name="banda" required>
            <label for="local">Local</label>
            <input type="text" name="local" placeholder="Lugar, cidade, estado" required>
            <div class="estilo">
                <label for="estilo">Estilo de música</label>
                <select name="estilo">
                    <option value="sertanejo">Sertanejo</option>
                    <option value="eletronica">Eletrônica</option>
                    <option value="rock">Rock</option>
                    <option value="pop">Pop</option>
                    <option value="funk">Funk</option>
                </select>
            </div>
            <div class="data_cadastro">
                <label for="horario">Horário:</label>
                <input type="time" name="horario" required id="horario">
                <label for="data">Data:</label>
                <input type="date" name="data" required>
            </div>
            <label for="descricao">Descrição do show</label>
            <textarea name="descricao" cols="30" rows="10" maxlength="850" placeholder="Rua, Características do show etc"></textarea>
            <label for="imagem">Imagem da banda</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="99999999"/>
            <input type="file" name="imagem" required>
            <input type="submit" value="Cadastrar" class="botao">
        </form>
        
            <?php
            $aprovado = ['0', '1'];
            for($i = 0; $i<count($aprovado); $i++){
                $querySelecao = "SELECT id, banda, local, estilo, horario, data_show, imagem FROM shows WHERE email = '$email' and aprovado = '$aprovado[$i]'";
                $aquivos = $conexao->query($querySelecao)->fetch_all(MYSQLI_ASSOC);
                if(count($aquivos)>0){
                    if($aprovado[$i] == 1){ 
                        echo "<h1 style='text-align:center; margin-top:40px'>Shows aprovados</h1>";
                    }else{
                        echo "<h1 style='text-align:center; margin-top:40px'>Shows em análise</h1>";
                    }
                }
                echo "<div class='bloco'>";
                for ($show = 0; $show<count($aquivos); $show++) {
                    $id = $aquivos[$show]['id'];
                    $banda = $aquivos[$show]['banda'];
                    $horario = $aquivos[$show]['horario'];
                    $data = $aquivos[$show]['data_show'];
                    $local = $aquivos[$show]['local'];
                    ?>
                    <div class="container cadastrado">
                        <div>
                            <img src="data:image/jpeg;base64, <?php 
                        $querySelecionaPorCodigo = "SELECT imagem FROM shows WHERE email = '$email' AND banda = '$banda' AND horario = '$horario' AND data_show = '$data'";
                        $imagem = mysqli_fetch_object($conexao->query($querySelecionaPorCodigo));
                        echo base64_encode($imagem->imagem); ?>" alt="">
                        
                        </div>
                        <h3 class="banda"><?php echo $banda; ?></h3>
                        <div class="horario_data">
                            <h3 class="horario"><?php echo date('H:i', strtotime($horario)); ?></h3>
                            <h3 class="data"><?php echo date("d/m/Y", strtotime($data)); ?></h3>
                        </div>    
                        <p class="local"><?php echo $local; ?></p>
                        <form action="negar.php" method="post">
                            <input hidden name="id" value="<?php echo $id; ?>">
                            <input type="submit" value="Excluir" class="botao">
                        </form>
                    </div>
                <?php } 
                echo "</div>";
            }?>
        
    </main>
    <footer <?php if(count($aquivos)==0){echo "id='footer'";}?>>
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

session_start();


if($_SESSION['email'] != null){
    $email = $_SESSION['email'];
}

if(array_key_exists("data",$_POST)){
    $banda = $_POST["banda"];
    $local = $_POST["local"];
    $estilo = $_POST["estilo"];
    $horario = $_POST["horario"];
    $descricao = $_POST["descricao"];
    $data = $_POST["data"];
    $imagem = $_FILES['imagem']['tmp_name'];
    $tamanho = $_FILES['imagem']['size'];
    $tipo = $_FILES['imagem']['type'];
    $nome = $_FILES['imagem']['name'];

    $chars = array('"',"'");

    $banda = str_replace($chars,"",$banda);

    $dado = ($conexao->query("SELECT * FROM shows WHERE banda = '$banda' AND horario = '$horario' AND data_show = '$data'"));

    $row = $dado->fetch_all(MYSQLI_ASSOC);
    
    if(!array_key_exists(0,$row)){
        $imageType = exif_imagetype($imagem);
        $peso = filesize($imagem);
        if ($imageType === IMAGETYPE_JPEG || $imageType === IMAGETYPE_PNG || $imageType === IMAGETYPE_WEBP) {
            if($peso > 204800){
                echo"<script>
                    alert('Imagem maior que 200kb, coloque uma imagem menor')
                    window.location.replace('cadastro_show.php')
                </script>";
            }
            $fp = fopen($imagem, "rb");
            $conteudo = fread($fp, $tamanho);
            $conteudo = addslashes($conteudo);
            fclose($fp);

            $sql = "INSERT INTO shows(email,banda,local,estilo,horario,data_show,imagem,descricao) VALUES ('$email','$banda','$local','$estilo','$horario','$data','$conteudo','$descricao') ";
            echo"<script>
                alert('Show cadastrado com sucesso')
                window.location.replace('cadastro_show.php')
            </script>";
            $conexao->query($sql);
        } else {
            echo"<script>
                alert('Cadastre uma imagem válida')
                window.location.replace('cadastro_show.php')
            </script>";
        }
    }else{
        echo"<script>
            alert('Show já cadastrado nesse dia e horario')
            window.location.replace('cadastro_show.php')
        </script>";
    }
}
    



$conexao->close();
?>