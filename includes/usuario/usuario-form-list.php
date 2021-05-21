<?php

$resultados = '';

foreach ($usuarios as $item) {

   $resultados .= '<tr>
                      <td>' . $item->id . '</td>
                      <td>' . $item->nome . '</td>
                      <td>' . $item->email . '</td>
                      <td style="text-align: center;">
                        
                       <a href="usuario-edit.php?id=' . $item->id . '">
                         <button type="button" class="btn btn-primary"> <i class="fas fa-paint-brush"></i> </button>
                       </a>

                       <a href="usuario-delete.php?id=' . $item->id . '">
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

                     <div class="col-12">

                        <div class="col-8 float-left">
                           <input type="text" class="form-control" placeholder="Buscar por nome / Email" name="buscar" value="<?= $buscar ?>">
                        </div>
                        <div class="col-4 float-right">

                           <button type="submit" class="btn btn-warning float-right">
                              <i class="fas fa-search"></i>

                              Pesquisar

                           </button>
                           &nbsp; &nbsp;
                           <a href="../../gerar-pdf.php" class="btn btn-dark float-right" target="blank">
                              <i class="fas fa-file-pdf"></i> &nbsp; &nbsp;

                              PDF

                           </a>

                        </div>

                     </div>
                  </form>

               </div>
               <br />
               <div>

                  <a href="usuario-insert.php">
                     <button type="submit" class="btn btn-success"> <i class="fas fa-plus"></i> Adicionar Novo Usuário</button>
                  </a>

               </div>
               <hr>
               <div class="table-responsive">
                  <table class="table table-bordered table-dark table-bordered table-hover table-striped">
                     <thead>
                        <tr>
                           <th> ID </th>
                           <th> NOME </th>
                           <th> EMAIL </th>
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