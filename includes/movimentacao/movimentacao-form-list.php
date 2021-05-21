<?php
$despesa  = 0;
$receita  = 0;
$valor1  = 0;
$total = 0;
$resultados = '';


$list = '';

foreach ($categorias as $item) {

   $list .= '<option value="' . $item->id . '">' . $item->nome . '</option>';
}

foreach ($movimentacao as $item) {
   
   $status_id = $item->status;

   if ($item->status <= 0) {
      $valor1 = 0;
      if ($item->tipo == 0) {

         $despesa += $valor1;
      } else {

         $receita += $valor1;
      }
   } else {

      if ($item->tipo == 0) {

         $despesa += $item->valor;
      } else {

         $receita += $item->valor;
      }
   }


   $total = ($receita - $despesa);


   $resultados .= '<tr>
                     <td>
                     
                     <span style="color:' . ($item->status <= 0 ? '#ff0000' : '#00ff00') . '"> 
                     <i class="fa fa-circle" aria-hidden="true"></i> 
                     </span>
                     
                     </td>
                     <td style="display:none">' . $item->id . '</td>
                     <td style="display:none">' . $item->catdesp_id . '</td>
                     <td style="display:none">' . $status_id . '</td>
                     <td>
                      
                      <span style="color:' . ($item->status <= 0 ? '#ff0000' : '#00ff00') . '">
                      ' . ($item->status <= 0 ? 'EM ABERTO' : 'PAGO') . '
                      </span>
                      
                      </td>
                      <td>
                      
                      <span style="color:' . ($item->tipo <= 0 ? '#f2a9a9 ' : '#48da59 ') . '">
                      ' . ($item->tipo <= 0 ? 'DESPESA' : 'RECEITA') . '
                      </span>
                      
                      </td>
                      <td>' . date('d/m/Y à\s H:i:s ', strtotime($item->data)) . '</td>
                      <td style="text-transform: uppercase; font-weight: 600;">' . $item->categoria . '</td>
                      <td style="text-transform: uppercase; ">' . $item->pagamento . '</td>
                      <td style="text-transform: uppercase; ">' . $item->usuario . '</td>
                      <td style="text-transform: uppercase; font-weight: 600;"> R$ ' . number_format($item->valor, "2", ",", ".") . '</td>
                      <td style="text-align: center;">
                        
                      
                      <button type="submit" class="btn btn-success editbtn" > <i class="fas fa-paint-brush"></i> </button>
                      &nbsp;

                       <a href="categoria-delete.php?id=' . $item->id . '">
                       <button type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                       </a>


                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="6" class="text-center" > Nenhuma Vaga Encontrada !!!!! </td>
                                                     </tr>';


unset($_GET['status']);
unset($_GET['pagina']);
$gets = http_build_query($_GET);

//PAGINAÇÂO

$paginacao = '';
$paginas = $pagination->getPages();

foreach ($paginas as $key => $pagina) {
   $class = $pagina['atual'] ? 'btn-primary' : 'btn-secondary';
   $paginacao .= '<a href="?pagina=' . $pagina['pagina'] . '&' . $gets . '">

                  <button type="button" class="btn ' . $class . '">' . $pagina['pagina'] . '</button>
                  </a>';
}

?>

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card card-purple">
               <div class="card-header">

                  <form method="get">
                     <div class="row my-7">
                        <div class="col">

                           <label>Buscar por Nome</label>
                           <input type="text" class="form-control" name="buscar" value="<?= $buscar ?>">

                        </div>


                        <div class="col d-flex align-items-end">
                           <button type="submit" class="btn btn-warning" name="">
                              <i class="fas fa-search"></i>

                              Pesquisar

                           </button>

                        </div>


                     </div>

                  </form>
               </div>
               <br />
               <div>


                  <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i>&nbsp; Adicionar</button>


               </div>
               <br>
               <div class="table-responsive">

                  <table class="table table-bordered table-dark table-bordered table-hover table-striped">
                     <thead>
                        <tr>
                           <th style="text-align: center; width:10px"> <i class="fa fa-align-justify" aria-hidden="true"></i> </th>
                           <th style="text-align: center; width:200x;"> STATUS </th>
                           <th style="text-align: center; width:50px"> TIPO </th>
                           <th style="text-align: left; width:250px"> DATA </th>
                           <th style="text-align: left;"> CATEGORIA </th>
                           <th style="text-align: left; width:350px"> FORMA DE PAGAMENTO </th>
                           <th style="text-align: left; width:250px"> USUÁRIO </th>
                           <th style="text-align: left; width:250px"> VALOR </th>
                           <th style="text-align: center; width:200px"> AÇÃO </th>
                        </tr>

                     </thead>
                     <tbody>
                        <?= $resultados ?>
                     </tbody>
                     <tr>
                        <td colspan="7" style="text-align: right;">
                           TOTAL
                        </td>
                        <td colspan="3">
                           R$ <?= number_format($total, "2", ",", "."); ?>
                        </td>
                     </tr>

                  </table>

               </div>


            </div>

         </div>

      </div>

   </div>

</section>

<?= $paginacao ?>


<div class="modal fade" id="modal-default">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"> &nbsp; Adicionar
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <label>Categoria</label>
               <select class="form-control select2bs4" style="width: 100%;" name="catdesp_id">
                  <option value="">Selecione uma Categoria !!!</option>

                  <?= $list ?>

               </select>
            </div>
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Salvar
            </button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<!-- EDITAR -->

<div class="modal fade" id="editmodal">
   <div class="modal-dialog">
   <form action="./movimentacao-edit.php" method="get">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Editar Categoria Despesas
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
               <label>Nome</label>
               <input type="text" class="form-control" name="status" id="status_id" required>
            </div>
            <div class="form-group">
                     <label>Categoria</label>
                     <select class="form-control" style="width: 100%;" name="catdesp_id" id="catdesp_id" >

                        <?= $list; ?>

                     </select>
                  </div>
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Salvar
            </button>
         </div>
      </div>
      </form> 
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
