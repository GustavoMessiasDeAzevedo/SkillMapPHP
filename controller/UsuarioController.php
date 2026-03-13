<?php
session_start();

require_once('../model/Usuario.php');
require_once('../model/Codigo_Verificacao.php');
require_once('../services/EmailService.php');
require_once('../repository/UsuarioRepository.php');
require_once('../repository/HabilidadeRepository.php');
require_once('../repository/CodigoVerificacaoRepository.php');

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';
try {
    switch ($acao) {
        case 'cadastrar':
            processarCadastro($pdo);
            break;
        case 'excluir':
            processarExcluir($pdo);
            break;
        case 'editar':
            processarEditar($pdo);
            break;
        case 'login':
            processarLogin($pdo);
            break;
        case 'logout':
            processarLogout($pdo);
            break;
        case 'alterar_senha':
            $email = $_POST['email'] ?? '';
            $usuario = solicitarRecuperacao($pdo, $email);
            if (!$usuario) {
                $_SESSION['ms'] = "Email não encontrado!";
                header("Location: ../view/AlterarSenhaEmail.php");
                exit();
            } else {
                $token = bin2hex(random_bytes(32));
                $codigoObjeto = new Codigo_Verificacao($usuario['id'], $token, date('Y-m-d H:i:s', strtotime('+10 minutes')));
                $codigoRepository = new CodigoVerificacaoRepository($pdo);
                $codigoRepository->inserirCódigo($codigoObjeto);
                $enviado = EmailService::enviarRecuperacao($email, $token);
                if ($enviado) {
                    $_SESSION['msEmail'] = "Email de recuperação enviado!";
                } else {
                    $_SESSION['msEmail'] = "Falha ao enviar email, tente novamente!";
                }
                header("Location: ../index.php");
                exit();
            }
            break;

        case 'redefinir_senha':
            $token = trim($_POST['token'] ?? $_GET['token'] ?? ''); 
            $novaSenha = $_POST['senha'] ?? '';
            $sucesso = redefinirSenha($pdo, $token, $novaSenha);

            if ($sucesso) {
                $_SESSION['msSenha'] = "Senha alterada com sucesso! Faça login.";
                header("Location: ../index.php");
            } else {
                $_SESSION['msSenha'] = "Token inválido ou expirado. Tente novamente.";
                header("Location: ../index.php");
            }
            exit();
            break;
        default:
            echo "Nenhuma ação detectada";
            break;
    }
} catch (Exception $e) {
    echo "Erro no sistema" . $e->getMessage();
}

function processarCadastro($pdo)
{
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $localizacao = $_POST['localizacao'] ?? '';
    $habilidades = $_POST['habilidades'] ?? '';

    $quantidade = mb_strlen($senha);
    if ($quantidade <= 3) {
        $_SESSION['ms'] = true;
        header("location: ../index.php");
        exit();
    }
    $usuario = new Usuario($nome, $email, $localizacao);
    $usuario->definirSenha($senha);

    $usuarioRepositorio = new UsuarioRepository($pdo);
    $novoIdUsuario = $usuarioRepositorio->Inserir($usuario);

    if ($novoIdUsuario > 0 && !empty(trim($habilidades))) {
        $habilidadeRepositorio = new HabilidadeRepository($pdo);
        $listaHabilidades = explode(',', $habilidades);

        foreach ($listaHabilidades as $item) {
            $nomeHabilidade = trim($item);

            if (!empty($nomeHabilidade)) {
                $habilidadeRepositorio->inserirUnicaEAssociar($nomeHabilidade, $novoIdUsuario);
            }
        }
    }
    $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    header("location: ../index.php");
}

function processarExcluir($pdo)
{
    $id = $_POST['id'] ?? $_GET['id'] ?? 0;
    if ($id != $_SESSION['usuario_id']) {
        header("Location: ../view/perfil.php?erro=permissao");
        exit;
    }
    $usuarioRepository = new UsuarioRepository($pdo);
    if ($usuarioRepository->deletarDadosUsuario($id)) {
        session_unset();
        session_destroy();
        header("Location: ../index.php?msg=conta_excluida");
    } else {
        header("Location: ../view/perfil.php?erro=falha_ao_excluir");
    }
    exit;
}

function processarEditar($pdo)
{
    if ($_POST['acao'] === 'editar') {
        $id = (int)$_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $localizacao = $_POST['localizacao'];
        $habilidades = $_POST['habilidades'] ?? []; // O array de IDs dos checkboxes
        $usuarioRepository = new UsuarioRepository($pdo);

        $usuarioRepository->atualizarDadosUsuario($id, $nome, $email, $localizacao);


        $usuarioRepository->atualizarHabilidades($id, $habilidades);

        header("Location: ../view/perfil.php?id=$id&sucesso=1");
        exit();
    }
}

function processarLogin($pdo)
{
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';


    $usuarioRepositorio = new UsuarioRepository($pdo);
    $usuarioLogado = $usuarioRepositorio->buscarEmail($email);
    if ($usuarioLogado) {
        if (password_verify($senha, $usuarioLogado['senha_hash'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['usuario_id'] = $usuarioLogado['id'];
            $_SESSION['usuario_nome'] = $usuarioLogado['nome'];
            $_SESSION['usuario_localizacao'] = $usuarioLogado['localizacao'];
            header("Location: /SkillMap/view/dashboard.php");
            exit();
        } else {
            echo "Email ou senha incorretos, tente novamente!";
        }
    } else {
        echo "Usuário não encontrado";
    }
}

function processarLogout($pdo)
{
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php?msg=saiu");
    exit();
}

function solicitarRecuperacao($pdo, $email)
{
    $stmt = $pdo->prepare("SELECT id FROM Usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch();
}

function redefinirSenha($pdo, $token, $novaSenha)
{
    $codigoRepository = new CodigoVerificacaoRepository($pdo);
    $codigoInfo = $codigoRepository->buscarPorCodigo($token);

    if (!$codigoInfo) {
        return false;
    }

    $expiraEm = strtotime($codigoInfo['expira_em']);

    if ((bool)$codigoInfo['usado'] === true) {
        return false;
    }

    if ($expiraEm < time()) {
        return false;
    }

    $usuarioRepository = new UsuarioRepository($pdo);
    $usuarioRepository->atualizarSenha($codigoInfo['usuario_id'], $novaSenha);

    $codigoRepository->marcarUsado($codigoInfo['id']);

    return true;

}
