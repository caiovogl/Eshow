<?php 
    include_once 'conexao.php';

    if(!isset($_SESSION)){
        session_start();
        if(key_exists('artista',$_SESSION)){
            $artista = $_SESSION['artista'];
        }else{
            $artista = null;
        }
        if(key_exists('email',$_SESSION)){
            $email = $_SESSION['email'];
        }else{
            $email = null;
        }
        $id = null;
        if(key_exists('id',$_POST)){
            $id = $_POST["id"];
        }
        if($id != null){
            if(key_exists('id_sobre',$_SESSION) && $_SESSION['id_sobre'] != $id){
                $_SESSION['id_sobre'] = $id;
            }else if(!key_exists('id_sobre',$_SESSION)){
                $_SESSION['id_sobre'] = $id;
            }
        }else{
            $id = $_SESSION['id_sobre'];
        }
        if(!key_exists('id_sobre', $_SESSION)){
            header('Location:home.php');
        }

        if(key_exists('avaliacao',$_POST)){
            $querySelecao = "SELECT id_show, email FROM avaliacoes WHERE id_show = '$id'";
            $aprovacoes = $conexao->query($querySelecao)->fetch_all(MYSQLI_ASSOC);  
            $curtidas = count($aprovacoes);
            if($_POST['avaliacao'] == 'insert'){
                $sql = "INSERT INTO avaliacoes(id_show, email) VALUES('$id', '$email')";
                $conexao->query($sql);
                $curtidas+=1;
                $sql = "UPDATE shows SET curtidas = '$curtidas' WHERE id = '$id'";
                $conexao->query($sql);
                header("Location:sobre.php");
            }else if($_POST['avaliacao'] == 'delete'){
                $sql = "DELETE FROM avaliacoes WHERE id_show = '$id' AND email = '$email'";
                $conexao->query($sql);
                $curtidas-=1;
                $sql = "UPDATE shows SET curtidas = '$curtidas' WHERE id = '$id'";
                $conexao->query($sql);
                header("Location:sobre.php");
            }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        .botao{
            border: 1px solid black;
        }
        li form .botao{
            border: 0;
        }
        @media screen and (max-width: 426px){
            #footer{
                position: initial;
                width: unset;
            }
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
    <main>
        <section id="sertanejo" style="margin-top: 150px;">
            
            <?php
            $querySelecao = "SELECT banda, local, estilo, horario, data_show, descricao, imagem, aprovado FROM shows WHERE id = '$id'";
            $aquivos = $conexao->query($querySelecao)->fetch_all(MYSQLI_ASSOC);
            echo "<div class='bloco'>";

            $banda = $aquivos[0]['banda'];
            $horario = $aquivos[0]['horario'];
            $data = $aquivos[0]['data_show'];
            $local = $aquivos[0]['local'];
            $descricao = $aquivos[0]['descricao'];
            
            $querySelecao = "SELECT id_show, email FROM avaliacoes WHERE id_show = '$id'";
            $aprovacoes = $conexao->query($querySelecao)->fetch_all(MYSQLI_ASSOC);  
            $curtidas = count($aprovacoes);
            ?>
            <div class="pagina_sobre">
                <div>
                    <div>
                        <img src="data:image/jpeg;base64, <?php 
                    $querySelecionaPorCodigo = "SELECT imagem FROM shows WHERE banda = '$banda' AND horario = '$horario' AND data_show = '$data'";
                    $imagem = mysqli_fetch_object($conexao->query($querySelecionaPorCodigo));
                    echo base64_encode($imagem->imagem); ?>" alt="">
                    
                    </div>

                    <h3 class="banda"><?php echo $banda; ?></h3>
                    <div>
                        <h3 class="horario"><?php echo date('H:i', strtotime($horario)); ?></h3>
                        <h3 class="data"><?php echo date("d/m/Y", strtotime($data)); ?></h3>
                    </div>    
                    <p class="local" style="margin-left: 0px;"><?php echo $local; ?></p>
                </div>
                <div style="display:flex;flex-direction:column;justify-content:space-between">
                    <div>
                        <h2>Descrição</h2>
                        <p style="text-align: justify;"><?php echo $descricao; ?></p>
                    </div>
                    <div>
                        <div id="like">
                            <form action="sobre.php" method="post" id="formInsert">
                                <input hidden value="insert" name="avaliacao">
                            </form>
                            <div class="logar_curtir">
                                <h2>Gostou do show?</h2>
                                <h3>Faça login para que sua opinião seja levada em conta.</h3>
                                <a class="entrar_curtir" href="login.php"><h3>Fazer login</h3></a>
                            </div>
                            <img src="assets/like.png" alt="curtir" class="img_curtir" onclick="like()">
                        </div>
                        <div style="display:none" id="liked">
                            <form action="sobre.php" method="post" id="formDelete">
                                <input hidden value="delete" name="avaliacao">
                            </form>
                            <img src="assets/liked.png" alt="curtir" class="img_curtir" onclick="dislike()">
                        </div>
                        <h3><?php echo $curtidas?> curtidas</3>
                    </div>
                </div>
            </div>
            <?php
            echo "</div>";
            ?>
        </section>
    </main>
    <footer id="footer">
        <p class="computador">Projeto Integrador Senac</p>
        <p class="celular">P.I Senac</p>
        <p>&copy;2024 - Todos os direitos reservados</p>
        <p>suporteeshowpr@gmail.com</p>
    </footer>
    <script src="script.js"></script>
    <script>
        botao_like = document.querySelector("#like");
        necessario = document.querySelector(".logar_curtir");
        document.addEventListener('click', e=>{
            if(!botao_like.contains(e.target)){
                necessario.style.display = "none";
            }
        })
        <?php 
            $sql = "SELECT id, email FROM avaliacoes WHERE id_show = '$id' AND email = '$email'";
            $aprovou = $conexao->query($sql)->fetch_all(MYSQLI_ASSOC);  
            if($aprovou!=null){
                echo "document.querySelector('#liked').style.display = 'block';
                document.querySelector('#like').style.display = 'none';";
            }
            $conexao->close();
        ?>
        function like(){
            if('<?php echo $email?>'!=''){
                document.getElementById("formInsert").submit();
            }else{
                necessario.style.display = "block";
            }
        }
        function dislike(){
            document.getElementById("formDelete").submit();
        }
        
    </script>
</body>
</html>

