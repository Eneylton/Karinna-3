<?php

$resultados = '';

foreach ($produtos2 as $item) {
   if (empty($item->foto)) {
      $foto = 'imgs/sem.jpg';
   } else {
      $foto = $item->foto;
   }


   $resultados .= '<tr>
                      <td>
                      <a href="galeria-list.php?id=' . $item->id . '">
                      <img style="width:80px; heigth:70px;object-fit: contain;" src="../.' . $foto . '" class="img-thumbnail">
                      </a>
                      </td>
                      <td>' . $item->codigo . '</td>
                      <td>' . $item->barra . '</td>
                      <td>' . date('d/m/Y à\s H:i:s', strtotime($item->data)) . '</td>
                      <td style="text-transform: uppercase;">' . $item->nome . '</td>
                      <td style="text-transform: uppercase;">' . $item->categoria . '</td>
                      <td>
                      
                      <span style="font-size:16px" class="' . ($item->estoque <= 3 ? 'badge badge-danger' : 'badge badge-primary') . '">' . $item->estoque . '</span>
                      
                      </td>
                      <td style="text-align: center;"> <button type="button" class="btn btn-info"> R$ ' . number_format($item->valor_compra, "2", ",", ".") . '</button></td>
                      <td style="text-align: center; width:300px">
                      
                      <a href="galeria-insert.php?id=' . $item->id . '">
                         <button type="button" class="btn btn-warning"> <i class="fas fa-images"></i></button>
                       </a>

                       <a href="produto-edit.php?id=' . $item->id . '">
                         <button type="button" class="btn btn-success"> <i class="fas fa-paint-brush"></i> </button>
                       </a>

                       <a href="produto-delete.php?id=' . $item->id . '">
                       <button type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                       </a>


                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="6" class="text-center" > Nenhum produto encontrada !!!!! </td>
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


                  <div class="row ">
                     <form method="get">
                        <div class="col-12">


                           <input type="text" placeholder="Pesquisar" class="form-control" name="buscar" value="<?= $buscar ?>" autofocus>

                        </div>

                     </form>

                     <button type="submit" class="btn btn-warning" name="">
                        <i class="fas fa-search"></i>

                        Pesquisar

                     </button>
                     &nbsp; &nbsp;


                     <a href="produto-insert.php">
                        <button type="submit" class="btn btn-success"> <i class="fas fa-plus"></i></button>
                     </a>



                  </div>



               </div>
               <br>
               <div class="table-responsive">
                  <table class="table table-dark table-hover table-striped table-bordered ">
                     <thead>
                        <tr>
                           <th> IMAGEM </th>
                           <th> CÓDIGO </th>
                           <th> BARRA </th>
                           <th> DATA </th>
                           <th> NOME </th>
                           <th> CATEGORIA </th>
                           <th> QTD </th>
                           <th style="text-align: center;"> VALOR </th>
                           <th style="text-align: center;"> AÇÃO </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?= $resultados ?>
                     </tbody>

                  </table>
               </div>

            </div>

         </div>

      </div>

   </div>
</section>

<?= $paginacao ?>