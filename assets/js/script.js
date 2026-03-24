document.addEventListener("DOMContentLoaded", () => {
  const alerta = document.getElementById("alerta-sucesso");

  if (alerta) {
    setTimeout(() => {
      alerta.style.transition = "opacity 0.5s ease, transform 0.5s ease";
      alerta.style.opacity = "0";
      alerta.style.transform = "translateY(-10px)";

      setTimeout(() => {
        alerta.remove();
      }, 500);
    }, 4000);
  }
});

function confirmarExclusao(id) {
  if (confirm("Tem certeza que deseja realizar a exclusão da conta?")) {
    window.location.href =
      "../controller/UsuarioController.php?acao=excluir&id=" + id;
  }
}

const meuIdLogado = document.getElementById("meu_id")?.value;

function carregarMensagens() {
  const destinatarioId = document.getElementById("destinatario_id")?.value;
  if (!destinatarioId) return;

  fetch(`../controller/carregarChat.php?destinatario=${destinatarioId}`)
    .then((response) => response.json())
    .then((mensagens) => {
      const chatBox = document.getElementById("chat-box");
      let htmlContent = "";

      mensagens.forEach((msg) => {
        const classe =
          msg.id_remetente == meuIdLogado ? "minha-msg" : "msg-outros";
        htmlContent += `<div class="mensagem ${classe}"><p>${msg.conteudo}</p></div>`;
      });

      // Remova a verificação de "if (chatBox.innerHTML !== htmlContent)" por enquanto
      // para testar se ele renderiza sempre
      chatBox.innerHTML = htmlContent;
      chatBox.scrollTop = chatBox.scrollHeight;
    });
}

function enviarMensagem() {
  const input = document.getElementById("mensagem-texto");
  const destinatarioId = document.getElementById("destinatario_id").value;
  const conteudo = input.value.trim();

  if (conteudo === "") return;

  const formData = new FormData();
  formData.append("destinatario_id", destinatarioId);
  formData.append("conteudo", conteudo);

  fetch("../controller/enviarMensagem.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((resultado) => {
      if (resultado.success) {
        input.value = "";
        carregarMensagens();
      }
    });
}

if (document.getElementById("chat-box")) {
  carregarMensagens();
  setInterval(carregarMensagens, 2000);
}

function verificarNotificacoes() {
  fetch(
    "/SkillMap/controller/verificar_notificacoes.php?t=" + new Date().getTime(),
  )
    .then((response) => response.json())
    .then((data) => {
      const badge = document.getElementById("badge-mensagens");
      if (badge) {
        if (parseInt(data.total) > 0) {
          badge.innerText = data.total;
          badge.style.display = "flex";

          // --- O LUGAR É AQUI! ---
          // Se o PHP enviou a lista de quem mandou, a gente coloca no "title"
          if (data.quem_mandou && data.quem_mandou.length > 0) {
            const nomes = data.quem_mandou.map((r) => r.nome).join(", ");
            badge.title = "Mensagens de: " + nomes;
            // Opcional: colocar o título no ícone do chat também
            badge.parentElement.title = "Mensagens de: " + nomes;
          }
          // -----------------------
        } else {
          badge.style.display = "none";
          badge.title = ""; // Limpa o título se não tiver mensagem
        }
      }
    });
}

// ÚNICO BLOCO DE CONTROLE: Centraliza tudo que roda ao carregar a página
document.addEventListener("DOMContentLoaded", () => {
  // 1. Se estiver no Perfil (Chat)
  if (document.getElementById("chat-box")) {
    carregarMensagens();
    setInterval(carregarMensagens, 3000);
  }

  // 2. Se estiver na Dashboard
  if (window.location.pathname.includes("dashboard.php")) {
    console.log("Monitorando notificações...");
    verificarNotificacoes();
    setInterval(verificarNotificacoes, 5000);
  }
});
