<?php 
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
    }
    $mais = null;
    if(key_exists('mais',$_POST)){
        $mais = $_POST["mais"];
    }
    if($mais != null){
        if($mais=="123") $mais = "";
        if(key_exists('mais',$_SESSION) && $_SESSION['mais'] != $mais){
            $_SESSION['mais'] = $mais;
        }else if(!key_exists('mais',$_SESSION)){
            $_SESSION['mais'] = $mais;
        }
    }else{
        if(key_exists('mais',$_SESSION)){
            $mais = $_SESSION['mais'];
        }
    }

    $pesquisa = null;
    if(key_exists('pesquisa',$_POST)){
        $pesquisa = $_POST["pesquisa"];
    }
    if($pesquisa != null){
        if(key_exists('pesquisa',$_SESSION) && $_SESSION['pesquisa'] != $pesquisa){
            $_SESSION['pesquisa'] = $pesquisa;
        }else if(!key_exists('pesquisa',$_SESSION)){
            $_SESSION['pesquisa'] = $pesquisa;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        input{
            height: 30px;
        }
        .botao{
            height: 45px;
            padding: 0px;
        }
        li form .botao{
            height: auto;
        }
        li form{
            margin: 0;
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
        <section id="<?php echo $mais?>" style="margin-top: 150px;">
        <?php
        if($mais==null){
            $mais = "";
        }
        $estilo = $mais;
        if($pesquisa==null){
            $pesquisa = "";
        }
        $querySelecao = "SELECT id, banda, local, estilo, horario, data_show, imagem, aprovado, curtidas FROM shows WHERE estilo like '%$mais%' and local like '%$pesquisa%' or estilo like '%$mais%' and banda like '%$pesquisa%' ORDER BY data_show";
        if($estilo=="eletronica"){
            $estilo = "eletrônica";
        }
        $aquivos = $conexao->query($querySelecao)->fetch_all(MYSQLI_ASSOC);
        if($mais!=""){?><h1>Todos os shows de <?php echo $estilo?></h1><?php }
        if($pesquisa!=""){?><h2>Resultados da pesquisa:  <?php echo $pesquisa?></h2><?php }?>
        <form action="pesquisa.php" method="post" style="display: flex; width:100%; justify-content:center; align-items:center">
            <label>Estilo: </label>
            <select name="mais" class="select-dropdown">
                <option value="123">Todos</option>
                <option value="sertanejo" <?php if($mais=="sertanejo") echo "selected";?>>Sertanejo</option>
                <option value="rock" <?php if($mais=="rock") echo "selected";?>>Rock</option>
                <option value="eletronica" <?php if($mais=="eletronica") echo "selected";?>>Eletrônica</option>
                <option value="pop" <?php if($mais=="pop") echo "selected";?>>Pop</option>
                <option value="funk" <?php if($mais=="funk") echo "selected";?>>Funk</option>
            </select>
            <input type="text" name="pesquisa" placeholder="Banda ou local do show" value="<?php echo $pesquisa;?>">
            <button type="submit" class="botao">Pesquisar</button>
        </form>
        <?php
        
        echo "<div class='bloco'>";
        $quant = count($aquivos);
        for ($show = 0; $show<$quant; $show++) {
            $id = $aquivos[$show]['id'];
            $banda = $aquivos[$show]['banda'];
            $horario = $aquivos[$show]['horario'];
            $data = $aquivos[$show]['data_show'];
            $local = $aquivos[$show]['local'];
            $curtidas = $aquivos[$show]['curtidas']
            ?>
            <form class="container cadastrado" method="post" action="sobre.php">
                <button type="submit" class="sobre">
                    <input hidden value="<?php echo $id; ?>" name="id">
                    <div>
                        <img src="data:image/jpeg;base64, <?php 
                    $querySelecionaPorCodigo = "SELECT imagem FROM shows WHERE banda = '$banda' AND horario = '$horario' AND data_show = '$data'";
                    $imagem = mysqli_fetch_object($conexao->query($querySelecionaPorCodigo));
                    echo base64_encode($imagem->imagem); ?>" alt="">
                    
                    </div>

                    <h3 class="banda"><?php echo $banda; ?></h3>
                    <div class="horario_data">
                        <h3 class="horario"><?php echo date('H:i', strtotime($horario)); ?></h3>
                        <h3 class="data"><?php echo date("d/m/Y", strtotime($data)); ?></h3>
                    </div>    
                    <p class="local"><?php echo $local; ?></p>
                    <h3 class="curtidas"><?php echo $curtidas?> curtidas</h3>
                    <?php if($email == "admin@admin.com"){?>
                        <form action="negar.php" method="post">
                            <input hidden name="id" value="<?php echo $id; ?>">
                            <input type="submit" value="Excluir" class="botao">
                        </form>
                    <?php
                    }?>
                </button>        
            </form>
            
        <?php } 
        echo "</div>";
        if($quant==0){?>
            <h2>Nenhum show encontrado!</h2>
        <?php
        }
        $conexao->close();
        ?>
        </section>
    </main>
    <footer <?php if($quant==0) echo "style='position:fixed;width:100%;bottom:0'"; 
                else if($quant<3) echo "id='footer'";?>>
        <p class="computador">Projeto Integrador Senac</p>
        <p class="celular">P.I Senac</p>
        <p>&copy;2024 - Todos os direitos reservados</p>
        <p>suporteeshowpr@gmail.com</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>

