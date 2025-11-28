<?php 
include('conexao.php'); // Conexão com o banco de dados

$sqlCategorias = "SELECT * FROM categorias"; // Seleciona as categorias
$resultCategorias = $conexao->query($sqlCategorias); // Faz a consula (Query) e adiciona no $sqlCategorias
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
                <a href="dashboard.php">Editar</a>
            </div>
        </nav>
    </header>

    <main>
    <!--
    ============================== SOBRE O INDEX ============================================================
    1 - O primeiro while vai separar as categorias (HQ / MANGÁ / INFANTIL) fetch_assoc vai ser true quando ainda 
    tiver categorias, caso não tenha, é falso e acaba o while :)
        2 - h1 recebe o nome da categoria
        3 - Pegando o ID da categoria atual
        4 - Pegar todos os livros que pertencem a essa categoria + consulta (query)
        5 - Cria o container dos livros da categoria
        6 - While que busca livros da categoria selecionada pelo while pai
            7 - Pegando o preço do livro
            8 - Pegando o desconto do livro
            9 - Fazendo o cálculo do preço final / preço com desconto
    =========================================================================================================
    -->
        <?php 
        while ($categoria = $resultCategorias->fetch_assoc()) { ?> 
            <h1 class='category'><?= htmlspecialchars($categoria['nome']) ?></h1>
            
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
                    <img src="./Assets/Uploads/<?= htmlspecialchars($livro['imagem']) ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>">
                    <h3><?= htmlspecialchars($livro['titulo']) ?></h3>

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
                    <button>
                        Comprar
                    </button>
                </div>
            <?php 
            } 
            ?>
            </div>
        <?php 
        } 
        ?>
        <footer>
            <p>&copy; 2025 SuperBooks. Desenvolvido com PHP/MySQL, CSS e JS</p>
        </footer>
    </main>
</body>
</html>

<!--
Feito por/Made by: Pablo Silva
Obrigado por visitar, considere deixar uma estrela no repositório!
Thanks for visiting, please consider leaving a star on this repository!

MERRY CHRISTMAS!
⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣻⡛⢿⣿⡿⣛⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣕⣹⣕⣽⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣎⡿⣱⣿⡏⣾⠿⣛⣛⠻⠿⣟⡻⣛⡻⠿⣛⠟⣛⠻⣿⣟⢻⢻⣿⣿⣿⣿⣿⣿⣿⣿⣿⡏⣧⣺⢟⣹⣿⣿⣿⣿
⣿⣿⣿⣿⣧⣾⣔⣽⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡜⣿⣴⠋⣿⡇⡏⣾⠥⢼⠷⣨⣿⣏⣙⣣⡎⣿⢩⣛⣱⡜⣿⡜⠸⣱⣿⣿⣿⣿⣿⣿⣿⣿⣯⠊⣼⡪⣽⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠋⠿⢙⡜⢣⣣⠿⣧⢣⡻⢧⡭⢅⡫⢿⣧⣻⣿⣷⣿⣼⣿⣿⠿⠜⡿⣱⣿⣿⣿⣿⣿⣿⣿⣿⣿⢖⡵⠈⣕⢼⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠿⣛⣿⣛⣛⠟⣛⡟⣿⣿⣿⣿⣿⣿⣿⣿⢟⣿⢻⣿⣿⣿⣿⣿⡿⢿⣿⣿⣿⣿⣇⡻⠖⣱⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣾⣰⣷⣘⣾⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⢣⣾⢫⣶⣮⠻⣰⢹⡇⣛⣟⢻⢟⣛⡿⣻⡛⢊⣉⢺⢟⡻⢟⡟⢫⣾⣼⡿⣛⣻⢟⣻⡻⣛⣿⡻⡿⣛⠯⣝⢻⡿⢛⠿⣻⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⢸⣿⡜⢿⣿⢿⢿⢸⡏⣦⣿⡇⣷⣿⡏⣼⣥⡆⣿⢸⠸⢷⣥⡑⡇⣿⢸⣿⢼⣿⢱⢸⣿⣴⣿⡇⡧⣉⠦⣿⡇⡇⠻⣶⣬⢺⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⠿⣿⣧⣙⠿⠷⢶⣋⡌⠾⣧⣉⠿⣷⣫⣿⣧⣽⣿⣥⣿⣌⠳⠥⠼⣣⣇⡻⠿⣋⠼⣿⣌⠼⣿⣉⠿⢧⣜⠿⢬⡻⠷⣁⢦⠤⢟⣽⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣟⣻⣿⣿⠃⣤⠈⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠿⠛⠛⣉⣉⣉⠛⠻⠿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⡻⢿⣿⣿⣿
⣿⣿⣿⠛⣋⣉⣁⣼⣿⣧⣌⣉⣙⠛⣿⣿⣿⡿⠉⠙⠛⠿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠟⢉⣠⣶⣾⣿⣿⣿⣿⣿⣷⣦⣌⠙⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣮⣏⣿⣿⣿
⣿⣿⣿⣷⣌⠻⣿⣿⣿⣿⣿⠟⣁⣴⣿⣿⣿⠀⢠⡙⢷⣦⣌⠙⠿⣿⣿⣻⣿⣿⠿⢋⣠⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠿⣿⡦⠈⠋⣉⣠⠤⡈⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⠁⣿⡿⠿⢿⣿⡀⣿⣿⣿⣿⡇⠀⣿⣿⣆⠹⣿⣿⣦⣈⠛⠿⠟⠁⠐⠛⢋⣉⡛⠛⠻⠿⠿⠿⣿⣿⣿⣿⠟⠂⣠⣴⣶⠿⢋⣤⣶⠁⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣯⡀⢉⣤⣶⣤⡉⠃⣿⣿⣿⣿⠇⢸⣿⣿⣿⣦⠸⣿⣿⡟⢁⣴⣾⣿⣿⣿⣿⣿⣿⣿⣶⣾⣶⣶⣤⡉⠋⢠⣴⣿⣿⡿⢋⣴⣿⣿⣿⠀⢸⣿⣿⣿⣟⣿⣿⣿⣿⣿
⣿⣿⣿⣿⠟⣠⣾⣿⣿⣿⣷⣄⠹⣿⣿⣿⠀⣿⣿⡏⠠⣤⣄⠹⠿⠃⠘⠛⠛⠛⠛⠻⠿⠿⠿⠿⢿⣿⣿⣿⣿⣷⣶⣦⡈⢻⠏⠀⠛⠻⣿⣿⣿⠀⠈⠻⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⠟⢁⣴⣿⣿⡟⠋⢉⡉⢻⣦⡈⠻⣿⠀⢿⣿⠉⢤⣼⠟⢀⣴⣾⣿⣿⠿⢿⣿⣶⣶⣶⣶⣶⣦⣤⣉⣉⡉⠻⢿⣿⡿⠀⣴⣿⠟⢁⣼⣿⣿⠀⣼⣦⠘⠛⡛⠻⢿⣿⣿⣿
⠟⢋⣴⣿⣿⣿⣿⡇⢢⣾⡻⢀⣿⣿⣦⡘⠂⢸⣿⣷⠄⢁⣴⣿⣿⣿⣿⡏⢰⣿⣿⣿⣿⣿⣿⣿⡟⢿⣿⣿⣿⣶⣦⣤⣴⣦⡈⠻⣶⠄⢹⣿⡿⢀⡉⢉⣁⣸⣿⣷⠈⢿⣿⣿
⣶⣿⠱⠹⠿⣿⣿⣿⣦⣤⣴⣾⣿⣿⣿⣿⡆⠸⡿⠁⡴⣻⣿⣿⣿⣿⠟⠀⣿⣿⣿⣿⣿⣿⣿⣿⡇⢸⣿⣿⣿⡏⢻⣿⣿⣿⡿⢆⠀⣶⣿⣿⠇⢸⡇⢸⣿⣿⣿⣿⡇⢸⣿⣿
⣿⣿⣿⣌⣃⢛⡻⣿⣿⣿⣿⣿⣿⠿⣿⣿⣿⠀⢀⣾⣿⣷⣿⣿⠿⠁⠼⢸⣿⣿⣿⣿⣿⣿⣿⣿⠁⠘⣿⣿⣿⣿⡄⢿⣿⣿⣿⣎⣧⠘⣿⡿⢀⣿⣿⣆⠙⠿⠟⢉⣠⣾⣿⣿
⠛⢋⡁⢿⣿⣾⢶⡰⢪⢩⣹⢿⢿⡦⢌⡉⠉⠀⣾⣿⣿⡏⣹⡁⢠⣾⣷⠸⣿⠻⣿⣿⣿⣿⢹⡏⢰⣦⠀⣌⡙⢿⣧⠸⣿⣿⣿⣿⣿⡆⠸⠁⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣾⣿⣷⣤⣭⣤⣾⣿⣿⣶⣾⣬⣵⣘⣃⣔⠃⣸⣿⣿⣿⠁⠏⣰⡿⠿⢿⡄⢻⠀⢿⣿⣿⡇⡘⢠⣿⣿⣧⡘⢿⣾⣿⠀⣿⣿⣿⣿⡿⢿⡀⣄⠘⣿⣿⣿⣿⣿⣿⡿⣪⣽⣿⣿
⣿⡟⡩⢤⣍⠻⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠀⠏⢸⣿⣧⠈⠰⠉⣠⠄⠀⢬⣄⢀⣄⠙⢿⠀⣴⣟⣉⣀⣀⠉⠂⡙⠿⡄⣿⣿⣿⣿⣇⢸⡇⢹⠀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⡀⢷⣾⡿⢀⣿⣿⣿⣿⡟⠁⢠⣄⢹⣿⣇⠐⠘⣿⣇⢠⠁⣼⠁⠀⢴⠀⢻⣿⣿⣷⣶⣶⣿⡟⠁⣄⠀⠈⢂⠈⢦⠀⣿⣿⣿⣿⡟⢸⣷⣾⠀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣦⣤⣴⣿⣿⣿⣿⣿⣧⠘⠿⠋⣸⣿⣿⠁⣤⡈⠻⠈⡧⣿⠀⡀⠀⡀⣸⣿⣿⣿⣿⣿⣿⡇⠀⠁⠀⠀⢸⡇⣰⢀⣿⣿⣿⣿⡇⣸⣿⣿⡄⢻⣿⣿⣿⠏⣴⣤⣬⣉⠛⠻
⣿⠿⠛⣿⣿⣿⣿⣿⡿⢿⣿⣿⣿⣿⣿⣿⠃⣸⢿⣿⡷⢀⠿⣮⣂⣙⣋⣠⣿⣿⣻⣿⣿⣿⣿⣇⠘⢦⠴⢁⠞⣩⠇⣸⣿⣿⣿⣿⠀⣿⣿⣿⣷⡀⢻⣿⣿⠄⡙⠛⠿⢿⡿⢀
⣴⣶⡄⠻⢿⣿⡿⠟⣁⣄⠻⠿⠿⢉⣙⡋⢰⡏⢸⣿⣷⠸⣌⣘⣺⣿⣿⣿⣏⠛⣋⡙⠛⢻⣿⣿⣷⣶⣒⡛⠿⠋⠴⢋⣽⣿⣿⠇⣸⢹⣿⣿⠙⣷⠈⣿⡟⢠⣿⣿⣶⡆⢠⣾
⣿⣿⢿⣷⣶⣶⣶⣾⣿⣿⣷⣶⣶⣿⣿⣇⠸⠀⠘⣿⣿⡀⠹⣿⣿⣿⣿⣿⣿⠀⣿⣿⣿⢘⣿⣿⣿⣿⣶⣿⣶⠆⣸⣿⣿⣿⠏⣰⣿⢸⣿⡿⠀⢸⠀⣿⠃⣼⣿⣿⣿⠁⣾⣿
⣿⣗⣗⢟⡛⣿⣿⣿⣿⡟⢁⢠⣄⠹⣿⣿⣦⣀⣆⠙⢿⣇⠰⣄⠙⠻⠿⣿⣿⣧⣈⣛⣋⣼⣿⣿⣿⣿⠿⠛⠁⢠⣿⣿⠟⠁⣴⡿⠃⢸⡿⢁⡄⠈⣴⣿⡀⢻⣿⣿⣿⣷⡌⢻
⣿⣿⣿⣦⣵⡱⠎⢟⡻⡆⠳⠿⠟⢠⣿⣿⣿⣿⡉⠓⠄⢉⣀⡉⠀⡐⠂⢀⣈⡉⠉⠉⣉⣉⡉⠉⠀⢀⠤⢀⠴⠟⠋⢁⠄⠰⠋⣠⠀⣉⣤⣾⣿⣿⣿⣿⣿⣦⡈⠻⠿⠿⠃⣼
⣿⡿⠋⢉⠛⢿⣿⣮⣵⣐⢃⡆⡌⠛⡛⠿⠿⢿⠿⢿⢧⠈⠻⣿⡿⢋⡁⠘⠻⠿⣧⠐⠟⢁⣴⣾⣿⣿⣶⡶⠀⠲⣾⣿⣶⣶⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣶⣶⣾⣿
⣿⡀⢬⣼⡇⢸⣿⣿⣿⣿⣿⣷⣶⣧⣭⣦⣛⣼⣘⣸⣬⣼⡶⠈⣠⣿⠁⣾⡷⠦⠈⣡⠈⣡⣤⣶⣦⠈⣉⣤⣾⣦⠈⢿⣿⡟⢛⠿⡿⣿⣿⣿⡿⠋⣁⣤⣤⣄⠙⣿⣿⣿⣿⣿
⣿⣷⣤⣭⣤⣿⣿⣿⣿⣏⠙⣿⣿⡍⠻⣿⡟⢁⣤⣄⠙⠟⢠⣾⡿⠹⠐⠛⠓⠶⠈⠛⠠⣶⣾⣿⡟⠰⢻⣿⣿⣿⣧⠈⣿⣏⣱⢹⣎⣽⣿⠏⣠⣾⣿⣿⠿⠛⢀⣿⣿⣿⣿⣿
⠿⠋⢿⣿⣿⣿⣿⣿⣿⣿⣷⣤⣭⣤⣶⡄⢠⣿⣿⣿⠷⠀⠛⠻⢁⣤⣾⣿⣷⠀⢁⠀⣷⣌⠙⠛⠁⢠⣿⣿⣿⣿⣿⡆⢸⣿⣿⣿⣿⣿⡏⢰⣿⣿⠟⢁⣴⣾⣿⣿⣿⣿⣿⣿
⣶⣿⣄⠛⢿⣿⣿⠿⢛⣿⣿⣿⣿⣿⠿⠇⠀⠰⢦⢌⠀⢰⣿⠀⠩⠛⠛⠻⢿⠇⠼⠆⢿⣿⠦⠹⠁⠛⠛⠛⠿⠿⢿⣿⠈⣿⣿⣿⣿⣿⠃⣾⣿⡟⢠⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣷⣦⣤⣤⣶⡿⠿⢿⣿⡏⢠⣄⣘⡛⢂⣠⣤⠖⢂⣠⣤⣀⡘⠉⠁⢈⡀⢂⣠⠀⣤⣴⢠⣶⣿⣿⣿⣶⣶⣦⡈⠀⢿⣿⣿⣿⣿⠀⣿⣿⡇⢸⣿⣿⠿⠛⣿⢿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⡏⡠⢰⣦⠹⡇⠸⢿⣿⣿⢸⣿⡟⢰⣶⣦⣬⡽⣭⣴⡆⣿⡇⢸⡿⠀⣿⣷⡈⠉⣩⣈⠛⠛⠛⢿⣿⣿⠀⣿⣿⣿⣿⡄⣿⣿⡇⢸⣿⣟⠧⢓⠀⡫⣿⢿⣿
⣝⣿⣛⢻⣿⣿⣿⣇⠙⠛⢋⣰⠏⠀⣦⣤⣌⢸⣿⡇⠘⠻⠿⢿⡇⡿⠿⠃⣿⠇⢠⠄⢈⣉⠙⢉⣤⣌⣽⣿⡿⠀⠶⠚⣉⣠⣿⣿⣿⣿⡇⣿⣿⡇⢸⣿⣯⣝⢕⢹⣔⢭⣾⣿
⣿⣿⣮⣎⠶⠹⣛⢿⣿⣿⣿⡇⠸⡧⠘⣿⣿⢸⣿⡇⢸⣿⣶⣶⡄⣶⣾⠇⠠⠲⣦⣤⡙⢿⣿⡆⢹⣿⣿⣿⠃⠄⠰⣿⣿⣿⣿⣿⣿⣿⠃⣿⣿⡇⢸⣿⣿⣯⣏⣾⣮⣾⣿⣿
⣿⣿⣿⣿⣿⣧⣭⣌⠶⡹⣛⠃⠸⡷⠈⣿⣿⢸⣿⡇⢸⣿⣿⣿⡇⣿⠁⣴⣾⣿⣿⣿⣧⠸⣿⡇⠸⠟⢋⣀⣤⣶⣦⡈⠻⣿⣿⣿⣿⠏⣰⣿⣿⠁⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
⠿⠋⣿⣿⣿⣿⣿⡿⠻⣷⣬⣦⣐⠀⢾⣿⣿⢸⣿⡇⢸⣿⣿⣿⡇⣯⠐⣿⣿⣿⣿⣿⠏⠸⠿⠃⣴⣿⣿⣿⣿⣿⣿⣿⣦⡈⠿⠛⣁⣴⣿⡿⢁⣼⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣾⣆⠙⠛⠛⠛⢉⣤⣦⣌⡙⠻⠿⠷⠆⢠⣍⣈⠛⠃⠸⠿⢿⣿⡇⣿⠷⠄⠉⣉⣉⣤⣶⣶⣶⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣄⠹⠟⠟⠋⣠⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⡇⢸⣿⣿⣿⡇⢰⣶⣶⣾⣿⠟⠋⢰⣿⣷⣶⣦⣤⣬⣤⣴⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡆⢰⣦⡈⢻⣿⣿⣿⣿⣷⣿⣿⣿⣿⣿⣿⣿
⣿⣿⠟⢉⣩⡄⢸⣿⣿⣿⡇⢠⢭⣉⠛⠃⣴⣃⡘⠻⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠿⠟⢠⣾⣿⡧⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⡀⣤⣤⣥⣈⣉⣉⣉⣁⣨⣥⣤⠀⡀⢿⣿⣿⣦⣈⣉⣉⠛⠻⢿⠿⠿⢿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠿⠛⠛⠛⠛⢁⣴⣶⣾⣿⣿⠿⠃⣼⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣧⠉⠛⠻⠿⠿⠿⠿⠿⠛⠛⠃⣸⣷⣄⠉⢿⣿⣿⣿⣿⣿⣷⣤⣶⣶⣦⣤⣉⣡⣤⣤⣤⣤⣤⣤⣶⣿⣿⣿⣿⣿⣿⣿⣿⡿⠃⣴⣾⣿⣿⡿⠻⢻⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⠀⣿⣿⣷⣶⣶⣶⣿⣿⣿⠀⣿⣿⣿⣷⣤⣉⠛⠻⠿⠻⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠟⢉⣉⣡⣴⣾⣿⣿⣿⣿⣟⣩⡛⣴⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⡇⠸⣿⣿⣿⣿⣿⣿⣿⡇⢸⣿⣿⣿⣿⣿⣿⣿⣿⣶⠀⣤⣉⣉⣛⣉⣉⡌⠙⠛⠛⠛⢋⣉⣤⣬⣭⠁⢠⣴⣄⠙⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣷⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣦⣤⣌⣉⣉⣉⣥⣤⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡆⢰⣮⣭⣿⣿⣿⡇⢸⢰⣭⣟⣿⣿⣯⣵⡖⢠⣄⠹⡽⡆⢹⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠀⣿⣿⣿⣿⣿⣧⠀⠸⣿⣿⣿⣿⣿⣿⢁⠈⣿⠀⣿⣿⠀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
-->