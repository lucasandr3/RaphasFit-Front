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


    <div style="margin-left:0px;margin-bottom:5px;">
		<a href="<?= BASE_URL ?>produto" class="btn btn-success"><i class="fa fa-arrow-left"></i> Voltar</a>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card m-b-30">
				<div class="card-body">
					<form method="POST" action="<?= BASE_URL ?>produto/add_action" enctype="multipart/form-data">

                        <div class="form-group">
							<label>Código do Produto <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="codigo" required placeholder="Digite o código do produto" autofocus />
                        </div><br>
                        
                        <div class="form-group">
							<label>4 últimos digitos do código <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="cod_final" required placeholder="Digite os 4 últimos digitos do código" autofocus />
                        </div><br>
                        
                        <div class="form-group">
							<label>Sigla para pesquisa <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="initials" required placeholder="Ex: Chave => ch" autofocus />
                        </div><br>

						<div class="form-group">
							<label>Nome do Produto <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="name" required placeholder="Digite um Nome para o produto" autofocus />
						</div><br>

						<div class="form-group">
                            <label>Categoria <span class="text-danger">*</span></label>
                            <select name="category" class="form-control" required>
                                <option>Escolha a Categoria</option>
                            <?php foreach ($cat as $c): ?>
                                <option value="<?=$c['nome_cat']?>" class="text-capitalize">Categoria: <?=$c['nome_cat']?></option>
                            <?php endforeach; ?>    
                            </select>
						</div><br>

                        <div class="form-group">
							<label>Preço <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="price" required placeholder="0,00" autofocus />
						</div><br>

                        <div class="form-group">
							<label>Descrição <span class="text-danger">*</span></label>
							<textarea class="form-control" name="description"></textarea>
						</div><br>

                        <div class="form-group">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">Foto do Produto</h4>
                                    <p class="sub-title">Formato Permitido PNG | JPG | JPEG</p>
                                    <div class="m-b-30">
                                        <div class="fallback">
                                            <input name="arquivo" type="file" multiple="multiple">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
						<input type="submit" value="Cadastrar Produto" class="btn btn-success">
					</form>	
				</div>
			</div>
		</div> <!-- end col -->
	</div> <!-- end row -->

</div>    