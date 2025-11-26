<?php
include('conexao.php');

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = intval($_GET['id']);

// Buscar imagem do livro
$sqlImg = "SELECT imagem FROM livros WHERE id = ?";
$stmt = $conexao->prepare($sqlImg);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();

    if (!empty($row['imagem'])) {
        $caminhoImagem = __DIR__ . "/Assets/Uploads/" . $row['imagem'];

        if (file_exists($caminhoImagem)) {
            unlink($caminhoImagem); // apaga a imagem do servidor
        }
    }
}

// Excluir registro do banco
$sqlDel = "DELETE FROM livros WHERE id = ?";
$stmt = $conexao->prepare($sqlDel);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: dashboard.php");
exit;
