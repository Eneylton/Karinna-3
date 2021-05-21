<?php

require __DIR__.'../../../vendor/autoload.php';
session_start();

use \App\Entidy\Compra;
use  \App\Entidy\Pedido;
use   \App\Session\Login;

Login::requireLogin();
$usuariologado = Login:: getUsuarioLogado();
$usuario_id = $usuariologado['id'];

foreach ($_SESSION['compras'] as $key) {
  
        $item = new Compra;
        $item->nome          = $key['nome'];
        $item->codigo        = $key['codigo'];
        $item->barra         = $key['barra'];
        $item->qtd           = $key['qtd'];
        $item->valor_compra  = $key['valor_compra'];
        $item->subtotal      = $key['subtotal'];
        $item->usuarios_id   = $usuario_id;
        $item->produtos_id   = $key['produtos_id'];
        $item->status        = 1;
        $item-> cadastar();


        $item2 = new Pedido;
        $item2->nome          = $key['nome'];
        $item2->codigo        = $key['codigo'];
        $item2->barra         = $key['barra'];
        $item2->qtd           = $key['qtd'];
        $item2->valor_compra  = $key['valor_compra'];
        $item2->subtotal      = $key['subtotal'];
        $item2->usuarios_id   = $usuario_id;
        $item2->produtos_id   = $key['produtos_id'];
        $item2->status        = 1;
        $item2-> cadastar();
    
    }    
    
    header('location:compra-sucesso.php?status=success');
    



