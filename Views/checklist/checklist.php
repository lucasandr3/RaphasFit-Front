<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Vick Logística</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?=BASE_URL?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#"><?=$titulo?></a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h4 class="card-title"><?=$titulo?></h4>
                        </div>

                        <div class="col">
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <table id="table_res" class="table table-striped table-hover">
                            <thead>
                                <tr>
									<th>Número</th>
									<th>Frota</th>
									<th>Data hora inicio</th>
									<th>Data hora fim</th>
									<th>Tempo</th>
									<th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
								<?php foreach($checklist as $c): ?>	
								<tr>
									<td>#<?= $c['id'] ?></td>
                                    <?php foreach(json_decode($c['checklist_json']) as $cc): ?>	
									<td><?=$cc->frota?></td>
                                    <td>
                                        <?=date('d/m/y', strtotime($cc->hora))?>
                                        ás
                                        <?=date('H:i:s', strtotime($cc->hora))?>
                                        hs
                                    </td>
                                    <?php
                                     $hora_ini =  new DateTime($cc->hora);
                                     $hora_fim =  new DateTime($c['date_final']);
                                     $tempo = $hora_ini->diff($hora_fim);  
                                     $diferenca = $tempo->format('%h:%i:%s');
                                    ?>
                                    <?php endforeach ;?>
                                    <td>
                                        <?=date('d/m/y', strtotime($c['date_final']))?>
                                        ás
                                        <?=date('H:i:s', strtotime($c['date_final']))?>
                                        hs
                                    </td>
                                    <td>
                                        <?php if($diferenca < '0:0:60') : ?>
                                            <?=$diferenca?> Seg
                                        <?php elseif($diferenca < '0:60:00') : ?>
                                            <?=$diferenca?> Min
                                        <?php else : ?>
                                            <?=$diferenca?> Hs    
                                        <?php endif; ?> 
                                    </td>
									<td>
										<div class="btn-group">
											<a href="<?= BASE_URL ?>checklist/detalhes/<?= $c['id']?>"
												class="btn btn-primary btn-xs">
												Detalhes
											</a>
										</div>
									</td>
								</tr>
								<?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>