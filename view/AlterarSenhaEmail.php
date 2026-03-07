<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Alterar a senha</title>
</head>
<body>
    <div class="card">
        <header>
            <h1>Alterar Senha</h1>
            <p>Digite seu email</p>
        </header>

        <main>
            <form action="../controller/UsuarioController.php" method="post">
                <input type="hidden" name="acao" value="alterar_senha">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <button type="submit" class="btn btn-primary">Solicitar troca</button>
                <a href="../index.php" class="btn btn-outline">Cancelar</a>
            </form>
        </main>
    </div>
</body>
</html>