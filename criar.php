<?php
include('conexao.php');

// Pegando as categorias e ordenando em ordem alfabética + consulta (query)
$sqlCat = "SELECT * FROM categorias ORDER BY nome ASC";
$resCat = $conexao->query($sqlCat);


if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Formulário enviado

    $titulo = $_POST['titulo'];
    $preco = floatval($_POST['preco']);
    $desconto = intval($_POST['desconto']);
    $categoria_id = intval($_POST['categoria_id']);

    $imagem = null; // Escolha da imagem (Começa como null)

    if (!empty($_FILES['imagem']['name'])) { // Imagem e nome do livro escolhidos
        $nomeImg = time() . "-" . $_FILES['imagem']['name'];
        $caminho = "./Assets/Uploads/" . $nomeImg;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $imagem = $nomeImg;
        }
    }

    // Inserindo as informações escolhidas pelo usuário
    $sql = "INSERT INTO livros (titulo, preco, desconto, categoria_id, imagem)
            VALUES (?, ?, ?, ?, ?)";

    // Preparando o banco de dados
    // Adicionando os parâmetros nos buracos dos values -> ?, ?, ?, ?, ?
    // Executa :)
    // Após criar o livro, volta para a dashboard
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sdiis", $titulo, $preco, $desconto, $categoria_id, $imagem);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./Assets/CSS/style-form.css?v=<?= time() ?>">
    <link rel="shortcut icon" href="./Assets/Imgs/favicon.ico" type="image/x-icon">
    
    <title>Criar Produto</title>
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
                <a href="dashboard.php">Voltar</a>
            </div>
        </nav>
    </header>

    <main class="form-container">
        <h2>Criar Novo Produto</h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <label>Título do Livro</label>
            <input type="text" name="titulo" required>

            <label>Preço</label>
            <input type="number" name="preco" step="0.01" required>

            <label>Desconto (%)</label>
            <input type="number" name="desconto" min="0" max="100" value="0" required>

            <label>Categoria</label>
            <select name="categoria_id" required>
                <option value="">Selecione...</option>
                <?php while ($c = $resCat->fetch_assoc()) { ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
                <?php 
                }
                ?>
            </select>

            <label>Imagem</label>
            <input type="file" name="imagem" accept="image/*">

            <button class="botao-criar" type="submit">Criar Produto</button>
        </form>
    </main>
</body>
</html>
