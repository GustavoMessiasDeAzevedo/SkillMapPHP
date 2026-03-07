<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Alterar Senha</title>
</head>

<body>
    <div class="card">
        <header>
            <h1>Altere sua senha</h1>
            <p>Informe sua nova senha!</p>
        </header>

        <form action="../controller/UsuarioController.php" method="post">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <input type="hidden" name="acao" value="redefinir_senha">
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>
            </div>

            <button type="submit" class="btn btn-primary">Alterar senha</button>
            <a href="../index.php" class="btn btn-outline">Cancelar</a>
        </form>
    </div>
</body>

</html>