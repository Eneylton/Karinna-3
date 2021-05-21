<?php
$modal = '';
$i = 0;

if (isset($galerias)) {
    foreach ($galerias as $item) {
        $actives = '';

        if ($i == 0) {
            $actives = 'active';
        }
        $i++;

        $modal .= '<div class="col-sm-2">
                   <a href="../.'.$item->foto.'" data-toggle="lightbox" data-title="Imagens" data-gallery="gallery">
                   <img src="../.'.$item->foto.'" class="img-fluid mb-2" alt="white sample"/>
        </a>
      </div>';
    }
}

?>

<div class="col-12">
            <div class="card card-purple" style="margin-top: 10px;">
              <div class="card-header">
              <div>
                                <a href="produto-list.php" class="btn btn-dark float-right">
                                    <i class="fas fa-check"></i> voltar
                                </a>
                            </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <?=$modal?>
                </div>
              </div>
            </div>
          </div>