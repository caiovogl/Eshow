<?php
    if(!isset($_SESSION)){
        session_start();
        if(key_exists('artista',$_SESSION)){
            $artista = $_SESSION['artista'];
        }else{
            $artista = null;
        }
    }

    include_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" type="image/png" href="assets/logo_cima.png"/>
    <link rel="stylesheet" href="style.css?v=<? echo time(); ?>">
    <link rel="stylesheet" href="home.css?v=<? echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
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
                        echo '<a href="cadastro.php"><h2>Cadastrar</h2></a>';
                        echo '<a href="login.php"><h2>Entrar</h2></a>';
                    }
                ?>
                </div>
            </section>
        </nav>
        <div class="computador">
        <?php
            if($artista != null){
                if($artista == "1"){
                    echo '<a href="cadastro_show.php" style="margin-right:30px"><h2>Cadastrar show</h2></a>';
                }
                echo '<a href="logout.php"><h2>Sair</h2></a>';
            }else{
                echo '<a href="cadastro.php" style="margin-right:30px"><h2>Cadastrar</h2></a>';
                echo '<a href="login.php"><h2>Entrar</h2></a>';
            }
        ?>
        </div>
    </header>
    
    <main>
        <section class="principal">
            <h1>Bem vindo ao É Show!</h1>
            <h2>Shows mais esperados do site</h2>
            
            <!-- Slider main container -->
            <div class="swiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                        <?php  
                            
                            $querySelecao = "SELECT id, banda, local, horario, data_show, imagem, aprovado, curtidas FROM shows WHERE aprovado = '1' ORDER BY curtidas DESC";
                            $aquivos = $conexao->query($querySelecao)->fetch_all(MYSQLI_ASSOC);
                            
                            $quant = count($aquivos);
                            if($quant>5)$quant = 5;
                            for ($show = 0; $show<$quant; $show++) {
                                echo '<div class="swiper-slide">';
                                
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
                                </button>        
                            </form>
                        </div>
                    <?php } 
                    $conexao->close();
                    ?>

                </div>  
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>

            <a href="home.php" class="botao">Ver mais shows</a>
        </section>
        <section class="formulario">
            <h2>Você é um cantor ou banda e ainda não tem uma conta?</h2>
            <a href="cadastro.php" class="botao">Cadastrar</a>
            <h2 class="jaconta">Já tem uma conta?</h2>
            <a href="login.php" class="botao">Entrar</a>
        </section>
    </main>

    <footer id="footer">
        <p class="computador">Projeto Integrador Senac</p>
        <p class="celular">P.I Senac</p>
        <p>&copy;2024 - Todos os direitos reservados</p>
        <p>suporteeshowpr@gmail.com</p>
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        autoplay: {
            delay: 5000,
        },
        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        });
</script>
</html>