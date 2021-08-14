<div class="container-fluid">
	<div class="page-title-box">
		<div class="row align-items-center menu-bread">
			<div class="col-sm-6">
				<h4 class="page-title">Edição de Produto</h4>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-right">
					<li class="breadcrumb-item"><a href="javascript:void(0);">Encartel</a></li>
					<li class="breadcrumb-item active">Produtos</li>
				</ol>
			</div>
		</div>
		<!-- end row -->
	</div>

    <div style="margin-left:0px;margin-bottom:5px;">
		<a href="<?= BASE_URL ?>produto" class="btn btn-success"><i class="fa fa-arrow-left"></i> Voltar</a>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card m-b-30">
				<div class="card-body">
					<form method="POST" action="<?= BASE_URL ?>produto/edit_action" enctype="multipart/form-data">

						<div class="form-group">
							<label>Código do Produto <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="codigo" value="<?=$prod['codigo']?>" required placeholder="Digite o código do produto" autofocus />
                        </div><br>
                        
                        <div class="form-group">
							<label>4 últimos digitos do código <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="cod_final" value="<?=$prod['cod_final']?>" required placeholder="Digite os 4 últimos digitos do código" autofocus />
                        </div><br>
                        
                        <div class="form-group">
							<label>Sigla para pesquisa <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="initials" value="<?=$prod['initials']?>" required placeholder="Ex: Chave => ch" autofocus />
                        </div><br>

						<div class="form-group">
							<label>Nome do Produto <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="name" value="<?=$prod['name']?>" required placeholder="Digite um Nome para o produto" autofocus />
						</div><br>

						<div class="form-group">
                            <label>Categoria <span class="text-danger">*</span></label>
                            <span class="sub-title text-danger">No Caso de mudança de categoria favor subir novamente a foto do produto</span>
                            <select name="category" class="form-control" required>
                                <option value="<?=$prod['category']?>" class="text-capitalize">Categoria: <?=$prod['category']?></option>
                            <?php foreach ($cat as $c): ?>
                                <option value="<?=$c['nome_cat']?>" class="text-capitalize">Categoria: <?=$c['nome_cat']?></option>
                            <?php endforeach; ?>    
                            </select>
						</div><br>

                        <div class="form-group">
							<label>Preço <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="price" value="<?=$prod['price']?>" required placeholder="0,00" autofocus />
						</div><br>

                        <div class="form-group">
							<label>Descrição <span class="text-danger">*</span></label>
							<textarea class="form-control" name="description">
                                <?=$prod['description']?>
                            </textarea>
						</div><br>

                        <div class="form-group">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">Foto do Produto</h4>
                                    <p class="sub-title">Formato Permitido PNG | JPG | JPEG</p>
                                    <p class="sub-title text-danger">No Caso de mudança de categoria favor subir novamente a foto do produto</p>
                                    <div class="m-b-30">
                                        <div class="fallback">
                                            <input name="arquivo" type="file" multiple="multiple">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Foto Atual</label><br>
                            <img src="<?=BASE_URL?>app/<?=$prod['img']?>" alt="" width="200px">    
                        </div>

                        <input class="sr-only" type="text" name="id_prod" value="<?=$prod['id_prod']?>">
                        
						<input type="submit" value="Salvar Alterações" class="btn btn-success">
					</form>	
				</div>
			</div>
		</div> <!-- end col -->
	</div> <!-- end row -->

</div>    