<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>SkilMap</title>
</head>
<body>
    
    <div class="card">
        <header>
            <h1>Bem vindo!</h1>
            <p>Cadastro de Usuário</p>
        </header>

        <form action="../controller/UsuarioController.php" method="post" autocomplete="off">
            <input type="hidden" name="acao" value="cadastrar">

            <div class="form-group">
                <label for="nome">Usuário</label>
                <input type="text" name="nome" id="nome" placeholder="Ex: Gustavo" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="gustavo@email.com" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>
            </div>

            <div class="form-group">
                <label for="localizacao">Localização</label>
                <input type="text" name="localizacao" id="localizacao" placeholder="Digite seu estado" required>
            </div>

            <div class="form-group">
                <label for="habilidades">Habilidades</label>
                <input type="text" name="habilidades" id="habilidades" placeholder="PHP, C#, CSS" required>
                <small class="hint">Separe os itens por vírgula</small>
            </div>

            <button type="submit" class="btn btn-primary">Criar Conta</button>
            <a href="../index.php" class="btn btn-outline">Voltar</a>
        </form>
    </div>

</body>
</html>