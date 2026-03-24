let meuIdLogado;
let socket;

document.addEventListener("DOMContentLoaded", () => {
  meuIdLogado = document.getElementById("meu_id")?.value;
  console.log("🆔 Seu ID carregado:", meuIdLogado);
  conectarSocket();

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

  if (document.getElementById("chat-box")) carregarMensagens();
  verificarNotificacoes();
});

function conectarSocket() {
  socket = new WebSocket("ws://localhost:8888");

  socket.onopen = () => {
    console.log("✅ Conectado ao servidor de Chat!");
    if (meuIdLogado) {
      socket.send(
        JSON.stringify({
          type: "login",
          usuario_id: meuIdLogado,
        }),
      );
    }
  };

  socket.onmessage = (event) => {
    const data = JSON.parse(event.data);
    console.log("📩 Mensagem recebida via Socket:", data); // Isso é vital para testar!

    const chatBox = document.getElementById("chat-box");
    // O destinatário de QUEM RECEBE é o remetente de QUEM ENVIOU
    const conversaAbertaCom = document.getElementById("destinatario_id")?.value;

    if (chatBox && String(data.remetente_id) === String(conversaAbertaCom)) {
      chatBox.innerHTML += `<div class="mensagem msg-outros"><p>${data.conteudo}</p></div>`;
      chatBox.scrollTop = chatBox.scrollHeight;
    } else {
      console.log(
        "🙈 Mensagem ignorada: você não está com o chat desse usuário aberto.",
      );
    }

    verificarNotificacoes();
  };

  socket.onclose = () => {
    console.warn("⚠️ Conexão perdida. Tentando reconectar em 3s...");
    setTimeout(conectarSocket, 3000);
  };
}

function confirmarExclusao(id) {
  if (confirm("Tem certeza que deseja realizar a exclusão da conta?")) {
    window.location.href =
      "../controller/UsuarioController.php?acao=excluir&id=" + id;
  }
}

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

  if (conteudo === "" || !socket) return;

  const payload = {
    remetente_id: meuIdLogado,
    destinatario_id: destinatarioId,
    conteudo: conteudo,
  };
  console.log("Tentando enviar via socket:", payload);
  socket.send(JSON.stringify(payload));

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
        const chatBox = document.getElementById("chat-box");
        chatBox.innerHTML += `<div class="mensagem minha-msg"><p>${conteudo}</p></div>`;
        chatBox.scrollTop = chatBox.scrollHeight;
        input.value = "";
      }
    });
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
