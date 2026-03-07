<?php

class Mensagem{
    public $id;
    public $id_remetente;
    public $id_destinatario;
    public $conteudo;
    public $data_envio;
    public $lida;

    public function __construct($id_remetente, $id_destinatario,$conteudo, $id = null, $data_envio = null, $lida = false)
    {
        $this->id = $id;
        $this->id_remetente = $id_remetente;
        $this->id_destinatario = $id_destinatario;
        $this->conteudo = $conteudo;
        $this->data_envio = $data_envio;
        $this->lida = $lida;
    }
}