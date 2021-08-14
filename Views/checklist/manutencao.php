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
            <div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
                    <h4 class="card-title" id="card-title-travel"><?=$titulo?></h4>								
                    <div>
                        <select id="sel-data-manu" style="height: 43px;
                        border-radius: 5px;border: 1px solid #999;outline: none;padding: 10px;border-top-right-radius: 0px;
                        border-bottom-right-radius: 0px;margin-right:-4px;width: 200px;">
                            <option value="todos">Escolha o Tipo</option>
                            <optgroup label="Departamento">
                                <option value="borracharia">Borracharia</option>
                                <option value="eletrica">Elétrica</option>
                                <option value="mecanica">Mecânica</option>
                            </optgroup> 
                            <optgroup label="Equipamento">
                                <option>Cavalo</option>
                                <option>Semi-Reboque</option>
                                <option>Reboque</option>
                            </optgroup>
                        </select>
                        <!-- <input type="date" id="inpi-data-manu" placeholder="Escolha o Tipo..." style="height: 43px;
                        border-radius: 5px;border: 1px solid #999;outline: none;padding: 10px;border-top-right-radius: 0px;
                        border-bottom-right-radius: 0px;margin-right:-4px;" 
                        /> -->
                        <button onclick="manuType()" class="btn btn-success" style="margin-top:-4px;padding:11px;font-weight:bold;border-top-left-radius:0px;border-bottom-left-radius:0px;background-color:#4CAF50!important;border:#4CAF50!important;color:white;">Filtrar</button>
                    </div>				
                </div>
                <div class="card-body">
                    <div class="">
                        <table id="table_res" class="table table-striped table-hover">
                            <thead>
                                <tr>
									<th>Número</th>
									<th>Frota</th>
									<th>Tipo</th>
									<th>Equipamento</th>
									<!-- <th>Tempo</th> -->
									<th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="body-manu">
                                <?php foreach($manutencao as $m): ?>	
								<tr>
									<td>#<?= $m['id'] ?></td>
                                    <?php foreach(json_decode($m['manutencao_json']) as $mm): ?>
									<td><?=$mm->frota?></td>
                                    <td><?=$mm->tipo?></td>
                                    <td><?=$mm->equipamento?></td>
                                    <?php endforeach ;?>
									<td>
										<div class="btn-group">
											<a href="<?= BASE_URL ?>checklist/manu_detalhes/<?=$m['id']?>"
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