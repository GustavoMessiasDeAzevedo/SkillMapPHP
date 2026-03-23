<?php
session_start();
if (!isset($_SESSION['usuario_nome'])) {
    header("Location: index.php"); // Expulsa se não estiver logado
    exit();
}

require_once "../ConexaoDB/conexaoDB.php";
require_once "../repository/UsuarioRepository.php";
$termo = (isset($_GET['termo']) ? $_GET['termo'] : null);
$usuarioRepository = new UsuarioRepository($pdo);
$usuarios = $usuarioRepository->listarUsuario($termo, $_SESSION['usuario_localizacao']);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css?v=6">
    <script src="../assets/js/script.js"></script>
    <title>SkillMap</title>
</head>

<body class="dashboard-body">
    <nav class="navbar">
        <div class="header-content">
            <div class="user-menu">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="Perfil.php?id=<?php echo $_SESSION['usuario_id']; ?>" class="profile-link">
                        <div class="avatar-circle">
                            <?php echo strtoupper(substr($_SESSION['usuario_nome'], 0, 1)); ?>
                        </div>
                        <span>Meu perfil</span>
                    </a>

                    <div class="notificacao-container" style="position: relative; display: inline-block;">
                        <span class="icon" style="font-size: 24px;">💬</span>
                        <span id="badge-mensagens" class="badge">0</span>
                    </div>
                    <a href="dashboard.php" class="btn-home">Tela inicial</a> 🏠
                <?php endif; ?>
            </div>

            <div class="search-container">
                <form action="dashboard.php" method="get" class="search-box">
                    <input type="text" name="termo" id="termo" placeholder="Busque por habilidades">
                    <button type="submit" class="btn-primary">Buscar</button>
                </form>
            </div>

            <div class="logout-area">
                <a href="../controller/UsuarioController.php?acao=logout" class="logout-link">Sair</a>
            </div>
        </div>
    </nav>

    <main class="content-wrapper">
        <header class="content-header">
            <h2>Explorar talentos</h2>
            <p>Encontre pessoas com habilidades que você precisa</p>
        </header>

        <div class="user-grid">
            <?php foreach ($usuarios as $user): ?>
                <div class="user-card">
                    <div class="card-header">
                        <h3><?php echo htmlspecialchars($user['nome']); ?></h3>
                        <span class="location"><?php echo htmlspecialchars($user['localizacao'] ?? 'Brasil'); ?></span>
                    </div>

                    <div class="card-body">
                        <p class="user-email"><?php echo htmlspecialchars($user['email']); ?></p>
                        <div class="skills-tag">
                            <?php
                            $skill = explode(',', $user['habilidades']);
                            foreach ($skill as $skills): ?>
                                <a href="dashboard.php?termo=<?php echo urlencode(trim($skills)) ?>" class="tag">
                                    <?php echo htmlspecialchars(trim($skills)); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <a href="perfil.php?id=<?php echo $user['id'] ?>" class="btn-outline btn-full">Ver Perfil Completo</a>
                </div> <?php endforeach; ?>
        </div>
    </main>
</body>

</html>