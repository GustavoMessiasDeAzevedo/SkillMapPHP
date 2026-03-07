<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
require_once "../ConexaoDB/conexaoDB.php";
require_once "../repository/UsuarioRepository.php";
require_once "../repository/HabilidadeRepository.php";
$habilidadeRepository = new HabilidadeRepository($pdo);
$usuarioRepository = new UsuarioRepository($pdo);

$idDaSessao = $_SESSION['usuario_id'] ?? 0; 


$dadosUsuario = $usuarioRepository->buscarPorId($idDaSessao);

$todasAsHabilidades = $habilidadeRepository->listarTodas();

$habilidadesAtuais = $habilidadeRepository->buscarIdsPorUsuario((int)$idDaSessao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Editar Perfil - <?php echo htmlspecialchars($usuario['nome']); ?></title>
</head>

<body class="dashboard-body">
    <nav class="navbar">
        <a href="perfil.php?id=<?= $usuario['id'] ?>" class="btn-back">⬅ Cancelar e Voltar</a>
    </nav>

    <main class="content-wrapper">
        <div class="profile-container">
            <header class="profile-header">
                <h2>Editar Meu Perfil</h2>
                <p>Mantenha seus dados atualizados para os recrutadores</p>
            </header>

            <form action="../controller/UsuarioController.php" method="POST" style="text-align: left;">
                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="id" value="<?= $dadosUsuario ['id'] ?>">

                <div class="form-group">
                    <label>Nome Completo</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($dadosUsuario['nome']) ?>" required>
                </div>

                <div class="form-group">
                    <label>E-mail Profissional</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($dadosUsuario['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Localização (Cidade/Estado)</label>
                    <input type="text" name="localizacao" value="<?= htmlspecialchars($dadosUsuario ['localizacao'] ?? '') ?>" placeholder="Ex: São Paulo, SP">
                </div>

                <div class="form-group">
                    <label>Minhas Habilidades</label>
                    <div class="skills-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; text-align: left; margin-top: 10px;">
                        <?php foreach ($todasAsHabilidades as $hab): ?>
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: normal;">
                                <input type="checkbox"
                                    name="habilidades[]"
                                    value="<?= $hab['id'] ?>"
                                    <?= in_array($hab['id'], $habilidadesAtuais) ? 'checked' : '' ?>
                                    style="width: auto;">
                                <?= htmlspecialchars($hab['nome']) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <small class="hint">Marque para adicionar, desmarque para remover.</small>
                </div>

                <div class="profile-actions-container">
                    <div class="button-group">
                        <button type="submit" class="btn-edit">Salvar Alterações</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

</body>

</html>