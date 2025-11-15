<?php 
include('conexao.php'); // CONEXÃO COM O BANCO DE DADOS

//BUSCANDO AS CATEGORIAS
$sqlCategorias = "SELECT * FROM categorias"; // PEGANDO AS CATEGORIAS
$resultCategorias = $conexao->query($sqlCategorias); // conexão faz uma consulta (query) e o que ele encontrar vai ser adicionado na $sqlCategorias


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./Assets/CSS/style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="./Assets/Imgs/favicon.ico" type="image/x-icon">

    <title>Superbooks - Tem de tudo!</title>
</head>
<body>
    <header class="nav-header">
        <nav class="nav-container">
            <div class="nav-logo">
                <a href="./index.php">
                    <img src="./Assets/Imgs/SB-Logo.png" alt="SuperBooks">
                </a>
            </div>
            
            <div class="nav-admin">
                <img src="./Assets/Imgs/SB-Admin.png" alt="Admin">
                <a href="editar.php">Editar</a>
            </div>
        </nav>
    </header>

    <main>
    <!--
    Esse while vai separar os livros por categoria (HQ / MANGÁ / INFANTIL) fetch_assoc vai ser true quando ainda 
    tiver categorias, caso não tenha, é falso e acaba o while :)

    Busca livros da categoria selecionada pelo while (){}

    H2 vai receber o nome da categoria

    esse while pega todos os livros da categoria selecionada no while pai
    -->
        <?php 
        while ($categoria = $resultCategorias->fetch_assoc()) { ?>
            <h1 class='category'><?= $categoria['nome']?></h1>
            
            <?php
            $categoria_id = $categoria['id'];
            $sqlLivros = "SELECT * FROM livros WHERE categoria_id = $categoria_id";
            $resultLivros = $conexao->query($sqlLivros);
            ?>
            <div class='books-list'>

            <?php 
            while ($livro = $resultLivros->fetch_assoc()) {
            
                $preco = $livro['preco'];
                $desconto = $livro['desconto'];
                $preco_final = $preco - ($preco * ($desconto / 100));
            ?>
                
                <div class='card'>
                    <img src='./Assets/Uploads/<?= $livro['imagem']?>' alt='<?= $livro['titulo']?>'>
                    <h3><?=$livro['titulo'] ?></h3>
                <?php
                if($desconto > 0) { ?> 
                    <p class='price-gross'>R$ <?= number_format($preco, 2, ',', '.')?></p>
                    <p class='price-net'>R$ <?= number_format($preco_final, 2, ',', '.')?></p>
                <?php  
                }
                else { ?> 
                    <p class='price-net'>R$ <?= number_format($preco, 2, ',', '.')?></p>
                <?php
                }
                ?> 
                    <button>Comprar</button>
                </div>
            <?php 
            } 
            ?>
            </div>
        <?php 
        } 
        ?>
    </main>
</body>
</html>