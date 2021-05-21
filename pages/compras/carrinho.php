<?php

require __DIR__ . '../../../vendor/autoload.php';
session_start();

use \App\Entidy\Produto;
use \App\Session\Login;

define('TITLE', 'Meus Pedidos');
define('BRAND', 'Compras');

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';

Login::requireLogin();

if (!isset($_SESSION['carrinho_compra'])) {

    $_SESSION['carrinho_compra'] = array();
}

if (isset($_GET['acao'])) {

    if ($_GET['acao'] == 'add') {

        $id = intval($_GET['id']);

        if (!isset($_SESSION['carrinho_compra'][$id])) {

            $_SESSION['carrinho_compra'][$id] = 1;
        } else {
            $_SESSION['carrinho_compra'][$id] += 1;
        }

    }

    if ($_GET['acao'] == 'del') {
        $id = intval($_GET['id']);

        if (isset($_SESSION['carrinho_compra'][$id])) {
            unset($_SESSION['carrinho_compra'][$id]);
        }
    }

    if ($_GET['acao'] == 'up') {

        if (is_array($_POST['prod'])) {

            foreach ($_POST['prod'] as $id => $qtd) {

                $id = intval($id);
                $qtd = intval($qtd);

                if (!empty($qtd) || $qtd != 0) {

                    $_SESSION['carrinho_compra'][$id] = $qtd;

                } else {

                    unset($_SESSION['carrinho_compra'][$id]);
                }
            }
        }

        if (is_array($_POST['val'])) {

            foreach ($_POST['val'] as $id => $valor) {

                $item = Produto::getID($id);
                $val1              = $valor;
                $val2              = str_replace(".", "", $val1);
                $preco             = str_replace(",", ".",  $val2);

                $item->valor_compra = $preco;
                
                $item->atualizarPedidos();
            }

        }

    }
}

echo '
<div class="card card-purple" style="margin-top: 0px;">
               <div class="card-header">

                  <form method="get">
                     <div class="row my-7">
                        <div class="col">

                           <label>Pesquisar</label>
                           <input type="text" class="form-control" name="buscar" value="">

                        </div>


                        <div class="col d-flex align-items-end">
                           <button type="submit" class="btn btn-warning" name="">
                              <i class="fas fa-search"></i>

                              Pesquisar

                           </button>
                            &nbsp &nbsp &nbsp
                            
                            <a class="btn btn-info" href="compra-finalizar.php">
                            <i class="fa fa-upload" aria-hidden="true"></i> &nbsp;
                            Finalizar compras
                            </a>
                              
                            </a>

                           &nbsp &nbsp &nbsp

                           <button type="submit" class="btn btn-dark" name="">
                              <i class="fas fa-search"></i>

                              Relátorio

                           </button>

                        </div>


                     </div>

                  </form>

               </div>

<div>
<br>
   <a href="compra-list.php">
      <button type="submit" class="btn btn-success"> <i class="fas fa-plus"></i> &nbsp; Add produtos</button>
   </a>

<br>
<br>
<table class="table table-dark table-bordered table-hover table-striped">
   <thead>
      <tr>
      <th> PRODUTO </th>
      <th> CÓDIGO </th>
      <th> NOME </th>
      <th> QTD </th>
      <th> VALOR </th>
      <th style="text-align:center"> REMOVER </th>
      <th> SUBTOTAL </th>
      </tr>
   </thead>
   <form action="?acao=up" method="post">
   <tbody>
      ';

if (count($_SESSION['carrinho_compra']) == 0) {
    echo '<tr>
        <td colspan="7" style="text-align:center">
        Nenhum produro adicionado.....
        </td>
        </tr>';
} else {

    $_SESSION['compras'] = array();

    $total = 0;
    foreach ($_SESSION['carrinho_compra'] as $id => $qtd) {

        $item = Produto::getID($id);

        $valor1 = $item->valor_compra;
        
        $valor2 = str_replace(".", ",", $valor1);

        $sub = $qtd * $valor1;

        $total += $sub;

        echo '

            <tr>
            <td>
            <a href="galeria-list.php?id=' . $item->id . '">
            <img style="width:80px; heigth:70px;object-fit: contain;" src="../.' . $item->foto . '" class="img-thumbnail">
            </a>
            </td>
            <td>' . $item->codigo . '</td>
            <td style="text-transform:uppercase">' . $item->nome . '</td>
            <td>

            <input type="text" size="3" name="prod[' . $id . ']" value="' . $qtd . '" />

            <input type="submit" value="Atualizar" style="color:#ff0000" />
            </td>
            <td>R$

            <input type="text" size="3" name="val[' . $id . ']" value="' . $valor2 . '" id="dinheiro" />
            <input type="submit" value="Atualizar" style="color:#ff0000" />
            </td>


            <td style="text-align:center"> <a href="?acao=del&id=' . $id . '" style="color:#ff0000"><i class="fas fa-trash-alt"></i> </a></td>
            <td> R$ ' . number_format($qtd * $item->valor_compra, "2", ",", ".") . '</td>
            </tr>


            ';

        array_push(
            $_SESSION['compras'],

            array(
                'nome'               => $item->nome,
                'codigo'             => $item->codigo,
                'barra'              => $item->barra,
                'qtd'                => $qtd,
                'valor_compra'       => $item->valor_compra,
                'subtotal'           => $sub,
                'produtos_id'        => $id
            )
        );

    }

}

echo '
        <tr>
        <td colspan="6">TOTAL</td>

        <td>

        <button type="submit" class="btn btn-success btn-sm" >';

if (isset($total)) {
    echo ' R$ ' . number_format($total, "2", ",", ".") . '';
}

echo '
        </button>
        </td>
        </tr>
        </tbody>
        </form>
        </table>

        <?=$paginacao?>


';

include __DIR__ . '../../../includes/layout/footer.php';
