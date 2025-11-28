<?php 
include('conexao.php');


if (!isset($_GET['id'])) { // Se o ID não for encontrado, exibe Livro não encontrado
    die("Livro não encontrado!");
}

// ID encontrado? Pegue o ID do livro
$id = intval($_GET['id']);

// Pegando o ID do livro e adicionando o ID já criado nele + consulta (query)
$sqlLivro = "SELECT * FROM livros WHERE id = $id";
$resultLivro = $conexao->query($sqlLivro);

if ($resultLivro->num_rows == 0) {
    die("Livro não encontrado!");
}

$livro = $resultLivro->fetch_assoc();

// Pegando as categorias e colocando em ordem alfabética + consulta (query)
$sqlCategorias = "SELECT * FROM categorias ORDER BY nome ASC";
$resultCategorias = $conexao->query($sqlCategorias);

// --- SALVAR ALTERAÇÕES --- //
if (isset($_POST['salvar'])) { // Salvar foi pressionado, então salvamos as informações

    $titulo = $_POST['titulo'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];
    $desconto = $_POST['desconto'];

    // Selecionando a imagem atual
    $imagemAtual = $livro['imagem'];
    $novaImagem = $imagemAtual;

    if (!empty($_FILES['imagem']['name'])) { // SE O USUÁRIO TROCAR A IMAGEM
        $nomeArquivo = time() . "_" . $_FILES['imagem']['name'];
        $caminho = "./Assets/Uploads/" . $nomeArquivo;

        // FAZER UPLOAD
        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho);

        // ATUALIZAR NOME
        $novaImagem = $nomeArquivo;
    }

    // UPDATE FINAL
    $sqlUpdate = "UPDATE livros
              SET titulo = ?, preco = ?, categoria_id = ?, desconto = ?, imagem = ?
              WHERE id = ?";

    $stmt = $conexao->prepare($sqlUpdate);
    $stmt->bind_param("sdiisi", $titulo, $preco, $categoria_id, $desconto, $novaImagem, $id);
    $stmt->execute();

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Erro ao atualizar!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./Assets/CSS/style-form.css?v=<?= time() ?>">
    <link rel="shortcut icon" href="./Assets/Imgs/favicon.ico" type="image/x-icon">

    <title>Editar Livro</title>
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
        <h2>Editar Livro</h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <label>Título:</label>
            <input type="text" name="titulo" value="<?= htmlspecialchars($livro['titulo']) ?>"><br><br>

            <label>Preço:</label>
            <input type="number" step="0.01" name="preco" value="<?= $livro['preco'] ?>" required><br><br>

            <label>Desconto (%):</label>
            <input type="number" name="desconto" value="<?= $livro['desconto'] ?>"><br><br>

            <label>Categoria:</label>
            <select name="categoria_id">
                <?php while ($cat = $resultCategorias->fetch_assoc()) { ?>
                    <option value="<?= $cat['id'] ?>" 
                        <?= ($cat['id'] == $livro['categoria_id']) ? 'selected' : '' ?>>
                        <?= $cat['nome'] ?>
                    </option>
                <?php } ?>
            </select>
            <br><br>

            <label>Imagem atual:</label><br>
            <img src="./Assets/Uploads/<?= $livro['imagem'] ?>" width="150" class="edit-img"><br><br>

            <label>Trocar imagem:</label>
            <input type="file" name="imagem"><br><br>

            <button type="submit" name="salvar">Salvar</button>
        </form>
    </main>
</body>
</html>
