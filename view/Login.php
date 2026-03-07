<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Document</title>
</head>
<body>
    <div class="card">
    <header>
        <h1>Login</h1>
        <p>Insira seu email e senha</p>
    </header>
        <form action="../controller/UsuarioController.php" method="post">
            <input type="hidden" name="acao" value="login">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
            <a href="../view/AlterarSenhaEmail.php" class="btn btn-outline">Esqueci minha senha</a>
            <a href="../index.php" class="btn btn-outline">Voltar</a>
        </form>
    </div>
</body>
</html>