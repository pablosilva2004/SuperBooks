<?php
include('conexao.php');

if (!isset($_GET['id'])) { // Se não existir um ID na URL, retorna pra dashboard
    header("Location: dashboard.php");
    exit;
}

$id = intval($_GET['id']); // Converte o ID recebido para número inteiro

// Buscar imagem do livro
$sqlImg = "SELECT imagem FROM livros WHERE id = ?";
$stmt = $conexao->prepare($sqlImg);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) { // Se o livro existir
    $row = $res->fetch_assoc();  //remover sua imagem do servidor

    if (!empty($row['imagem'])) { // Tem imagem cadastrada
        $caminhoImagem = __DIR__ . "/Assets/Uploads/" . $row['imagem']; // Monta o caminho completo da imagem no servidor

        if (file_exists($caminhoImagem)) { // Se o arquivo existir
            unlink($caminhoImagem); // apaga a imagem do servidor
        }
    }
}

// Excluir o livro a partir do ID
// Prepara o SQLDel
// Deleta o ID do livro escolhido
// Executa
// Voltando ao dashboard
$sqlDel = "DELETE FROM livros WHERE id = ?";
$stmt = $conexao->prepare($sqlDel);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: dashboard.php");
exit;
