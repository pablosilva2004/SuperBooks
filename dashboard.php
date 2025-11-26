<?php
include('conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./Assets/CSS/style-dashboard.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="./Assets/Imgs/favicon.ico" type="image/x-icon">
    <script src="./Assets/JS/script.js" defer></script>

    <title>Superbooks - Dashboard</title>
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
                <a href="index.php">Voltar</a>
            </div>
        </nav>
    </header>
    <!--
    ============================== SOBRE A DASHBOARD ============================================================
    Div de ações da Dashbaord (Criar um novo livro)
    Pegando as categorias + consulta (query)
    While criando as tabelas e separando por categorias e seus respectivos livros
        pegando o id da categoria
        Pegando os livros dessa categoria em específica e colocando em ordem alfabética
            -> pega todas as colunas da tabela livro
            -> dizemos que estamos consultando a tabela livros com o apelido de l
            -> JOIN = juntar. Ou seja, o id da categoria é igual ao categoria_id (Chave estrangeira de livros)
            -> Selecionamos os livros apenas da categoria que está rodando no While
            -> Ordenamos os livros em ordem alfabética (título de A - Z)
        + consulta (query)


    =========================================================================================================
    -->
    <main>
        <div class="dashboard-actions">
            <a class="btn-criar" href="criar.php">➕ Criar Novo Produto</a>
        </div>

        <?php
        $sqlCat = "SELECT * FROM categorias"; 
        $resultCat = $conexao->query($sqlCat); 

        while ($cat = $resultCat->fetch_assoc()) {
            $cat_id = $cat['id'];

            $sqlLivros = "SELECT l.*, c.nome AS categoria 
                        FROM livros l
                        JOIN categorias c ON l.categoria_id = c.id
                        WHERE l.categoria_id = $cat_id
                        ORDER BY l.titulo ASC";

            $resultLivros = $conexao->query($sqlLivros);
        ?>
            <table class="tabela">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Desconto</th>
                        <th>Preço Líquido</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    while ($l = $resultLivros->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $l['id'] ?></td>
                            <td><?= htmlspecialchars($l['titulo']) ?></td>
                            <td><?= htmlspecialchars($l['categoria']) ?></td>
                            <td>R$ <?= number_format($l['preco'], 2, ',', '.') ?></td>
                            <td><?= intval($l['desconto']) ?>%</td>
                            <td>R$ <?= number_format($l['preco'] - ($l['preco'] * ($l['desconto'] / 100)), 2, ',', '.') ?></td>

                            <td>
                                <a class="btn editar" href="editar.php?id=<?= $l['id'] ?>">Editar</a>
                                <a class="btn excluir" href="excluir.php?id=<?= $l['id'] ?>" onclick="return ConfirmarExclusao()">Excluir</a>
                            </td>
                        </tr>
                    <?php 
                    } 
                    ?>
                </tbody>
            </table>
        <?php 
        }
        ?>
        </main>
    <footer>
        <p>&copy; 2025 SuperBooks. Desenvolvido com PHP/MySQL, CSS e JS</p>
    </footer>
</body>
</html>