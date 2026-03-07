<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js"></script>
    <title>Document</title>
</head>

<body>
    <?php if (isset($_SESSION['mensagem'])): ?>
        <div id="alerta-sucesso" class="alerta-flutuante alerta-cadastro">
            <div class="alerta-content">
                <span class="icon">🚀</span>
                <p><?= $_SESSION['mensagem'] ?></p>
            </div>
            <div class="progress-bar"></div>
        </div>
        <?php unset($_SESSION['mensagem']); // Limpa para não aparecer de novo no refresh 
        ?>
    <?php endif; ?>
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'saiu'): ?>
        <div id="alerta-sucesso" class="alerta-flutuante" style="border-left-color: #64748b;">
            <div class="alerta-content">
                <span>👋</span>
                <p>Sessão encerrada com sucesso. Até logo!</p>
            </div>
            <div class="progress-bar" style="background: #64748b;"></div>
        </div>
    <?php endif; ?>
    <?php if(isset($_SESSION['ms'])):?>
        <div id="alerta-sucesso" class="alerta-flutuante alerta-erro">
            <div class="alerta-content">
                <span>🛑</span>
                <p>Não são permitidos senhas abaixo de 3 caracteres!</p>
            </div>
            <div class="progress-bar" style="background: #64748b;"></div>
        </div>
    <?php unset($_SESSION['ms']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['msEmail'])): ?>
        <div id="alerta-sucesso" class="alerta-flutuante alerta-cadastro">
            <div class="alerta-content">
                <span class="icon">🚀</span>
                <p><?= $_SESSION['msEmail'] ?></p>
            </div>
            <div class="progress-bar"></div>
        </div>
        <?php unset($_SESSION['msEmail']); // Limpa para não aparecer de novo no refresh 
        ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['msSenha'])): ?>
        <div id="alerta-sucesso" class="alerta-flutuante alerta-cadastro">
            <div class="alerta-content">
                <span class="icon">🚀</span>
                <p><?= $_SESSION['msSenha'] ?></p>
            </div>
            <div class="progress-bar"></div>
        </div>
        <?php unset($_SESSION['msSenha']); // Limpa para não aparecer de novo no refresh 
        ?>
    <?php endif; ?>
    <div class="card">
        <header>
            <h1>SkillMap</h1>
            <p>Bem vindo!</p>
        </header>

        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alerta-sucesso">
                <?php
                echo $_SESSION['mensagem'];
                unset($_SESSION['mensagem']);
                ?>
            </div>
        <?php endif; ?>
        <a href="view/Login.php" class="btn btn-primary">Login</a>
        <a href="view/Cadastro.php" class="btn btn-outline">Cadastre-se</a>

    </div>
</body>

</html>