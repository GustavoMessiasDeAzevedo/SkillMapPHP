<?php

class Codigo_Verificacao{
    public $id;
    public $usuario_id;
    public $codigo;
    public $expira_em;
    public $usado;

    public function __construct($usuario_id, $codigo, $expira_em = null, $id = null, $usado = false)
    {
        $this->usuario_id = $usuario_id;
        $this->codigo = $codigo;
        $this->expira_em = $expira_em;
        $this->id = $id;
        $this->usado = $usado;
    }
}
