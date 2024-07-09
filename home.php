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
                <ul class="opções" style="padding-left: 20px;">
                    <input type="checkbox" hidden id="opções_menu" class="opçoes_botao">
                    <label class="opções_rotulo">
                        <li class="opções_item texto_grande"><h2 style="width:250px">Estilos musicais</h2></li>
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
             <form action="pesquisa.php" method="post" style="display:flex;align-items:center; margin-right:30px">
                <input hidden name="mais" value="">
                <input type="text" name="pesquisa" placeholder="pesquise uma banda ou local">
                <button type="submit" class="botao">Pesquisar</button>
             </form>
        <?php
            if($artista != null){
                if($artista == "1"){
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
        <?php 
            $estilos = ['sertanejo', 'rock', 'eletronica', 'pop', 'funk'];

            for($i = 0; $i < count($estilos)-1; $i++){
                ?><section id="<?php echo $estilos[$i]?>" style="margin-top: 150px;">
                <?php
                $estilo = $estilos[$i];
                $querySelecao = "SELECT id, banda, local, estilo, horario, data_show, imagem, aprovado, curtidas FROM shows WHERE aprovado = '1' and estilo = '$estilos[$i]' ORDER BY data_show";
                if($estilo=="eletronica"){
                    $estilo = "eletrônica";
                }
                $aquivos = $conexao->query($querySelecao)->fetch_all(MYSQLI_ASSOC);
                if(count($aquivos)>0){
                    ?><h1>Próximos shows de <?php echo $estilo?></h1>
                    <?php
                }
                echo "<div class='bloco'>";
                $quant = count($aquivos);
                if($quant>4)$quant = 4;
                for ($show = 0; $show<$quant; $show++) {
                    $id = $aquivos[$show]['id'];
                    $banda = $aquivos[$show]['banda'];
                    $horario = $aquivos[$show]['horario'];
                    $data = $aquivos[$show]['data_show'];
                    $local = $aquivos[$show]['local'];
                    $curtidas = $aquivos[$show]['curtidas'];

                    
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

                            <h2 class="banda"><?php echo $banda; ?></h2>
                            <div class="horario_data">
                                <h3 class="horario"><?php echo date('H:i', strtotime($horario)); ?></h3>
                                <h3 class="data"><?php echo date("d/m/Y", strtotime($data)); ?></h3>
                            </div>    
                            <h3 class="local"><?php echo $local; ?></h3>
                            <h3 class="curtidas"><?php echo $curtidas?> curtidas</h3>
                            <?php if($email == "admin@admin.com"){?>
                                <form></form>
                                <form action="negar.php" method="post">
                                    <input hidden name="id" value="<?php echo $id; ?>">
                                    <input type="submit" value="Excluir" class="botao">
                                </form>
                            <?php
                            }?>
                        </button>        
                    </form>
                <?php } 
                if($quant==4){?>
                    <form action="pesquisa.php" method="post" style="display: flex; width:100%; justify-content:center">
                        <input hidden value="" name="pesquisa">
                        <input hidden value="<?php echo $estilos[$i]?>" name="mais">
                        <button type="submit" class="botao">Ver mais shows</button>
                    </form>
                <?php
                }
                echo "</div>";
                ?>
                </section>
                <?php
            }

            $conexao->close();
        ?>
    </main>
    <footer>
        <p class="computador">Projeto Integrador Senac</p>
        <p class="celular">P.I Senac</p>
        <p>&copy;2024 - Todos os direitos reservados</p>
        <p>suporteeshowpr@gmail.com</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>

