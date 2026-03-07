<?php
session_start();
if (!isset($_SESSION['usuario_nome'])) {
    header("Location: index.php");
    exit();
}
require_once "../ConexaoDB/conexaoDB.php";
require_once "../repository/UsuarioRepository.php";
$id_usuario = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id_usuario) {
    header("Location: dashboard.php");
    exit();
}
$usuarioRepository = new UsuarioRepository($pdo);
$usuario = $usuarioRepository->buscarPorId($id_usuario);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
    <script src="../assets/js/script.js"></script>
    <title>Perfil de <?php echo htmlspecialchars($usuario['nome']); ?></title>
</head>

<body class="dashboard-body">
    <nav class="navbar">
        <a href="dashboard.php" class="btn-back">⬅ Voltar ao Dashboard</a>
    </nav>

    <main class="content-wrapper">
        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
            <div id="alerta-sucesso" class="alerta-flutuante">
                <div class="alerta-content">
                    <span class="icon">✅</span>
                    <p>Perfil atualizado com sucesso!</p>
                </div>
                <div class="progress-bar"></div>
            </div>
        <?php endif; ?>
        <div class="profile-container">
            <div class="profile-header">
                <div class="avatar-large">
                    <?php echo strtoupper(substr($usuario['nome'], 0, 1)); ?>
                </div>
                <h2><?php echo htmlspecialchars($usuario['nome']); ?></h2>
                <p class="location"><?php echo htmlspecialchars($usuario['localizacao'] ?? 'Brasil'); ?></p>
            </div>

            <div class="profile-info">
                <h3>Sobre este talento</h3>
                <p><strong>E-mail de contato:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
                <div class="skills-section">
                    <h3>Minhas Habilidades</h3>
                    <div class="skills-tag">
                        <?php
                        $skills = explode(',', $usuario['habilidades']);
                        foreach ($skills as $s): ?>
                            <span class="tag"><?php echo trim(htmlspecialchars($s)); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="profile-actions-container">
                <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $usuario['id']): ?>
                    <div class="button-group">
                        <a href="Editar_perfil.php" class="btn-edit">Editar Meu Perfil</a>

                        <form action="../controller/UsuarioController.php" method="POST" onsubmit="return confirm('Deseja mesmo excluir sua conta? Isso é permanente!');">
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

                            <button type="submit" class="btn-danger">Excluir conta</button>
                        </form>
                    </div>
                <?php else: ?>
                    <a href="mailto:<?php echo $usuario['email']; ?>" class="btn-contact">
                        Entrar em contato
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($_SESSION['usuario_id'] != $usuario['id']): ?>
            <div class="chat-wrapper">
                <h3>Conversar com <?php echo explode(' ', htmlspecialchars($usuario['nome']))[0]; ?></h3>

                <input type="hidden" id="meu_id" value="<?php echo $_SESSION['usuario_id']; ?>">
                <input type="hidden" id="destinatario_id" value="<?php echo $usuario['id']; ?>">

                <div id="chat-box" class="chat-window">
                </div>

                <div class="chat-input-area">
                    <input type="text" id="mensagem-texto" placeholder="Escreva uma mensagem..."
                        onkeypress="if(event.key === 'Enter') enviarMensagem()">
                    <button type="button" onclick="enviarMensagem()" class="btn-send">Enviar</button>
                </div>
            </div>
        <?php endif; ?>

    </main>
</body>

</html>