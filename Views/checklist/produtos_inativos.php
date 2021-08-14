<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Encartel</h4>
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
            <div style="margin-left:0px;margin-bottom:5px;">
                <a href="<?= BASE_URL ?>produto" class="btn btn-success"
                style="color:white"><i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
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
                    <div class="table-responsive">
                        <table id="table_res" class="display table table-striped table-hover">
                            <thead>
                                <tr>
									<th>#ID</th>
									<th>Foto</th>
									<th>Nome</th>
									<th>Categoria</th>
									<th>Descrição</th>
									<th>Preço</th>
									<th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
								<?php foreach($list_status as $item): ?>
								<?php if($item['status'] == "1"): ?>	
								<tr>
									<td>#<?= $item['id_prod'] ?></td>
									<td><img src="<?=BASE_URL?>app/<?=$item['img']?>" width="50px"></td>
									<td><?= $item['name'] ?></td>
									<td class="text-capitalize text-center"><?= $item['category'] ?></td>
									<td><?= $item['description'] ?></td>
									<td>R$ <?= number_format($item['price'],2,',','.') ?></td>
									<td>
										<div class="btn-group">
											<!-- <a href="<?= BASE_URL ?>produto/edit/<?= $item['id_prod']?>"
												class="btn btn-primary btn-sm">
												<i class="fa fa-edit"></i>
												Editar
											</a> -->
											<a href="<?= BASE_URL ?>produto/indisponivel/<?= $item['id_prod']?>"
												class="btn btn-success btn-sm">
												<i class="fas fa-power-off"></i>
												Ativar
											</a>
										</div>
									</td>
								</tr>
								<?php endif; ?>
								<?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>