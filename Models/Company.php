<?php
namespace Models;

use \Core\Model;

class Company extends Model {

	public function getAll()
	{
		$array = array();

		$sql = "SELECT * FROM checklist";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getAllMan()
	{
		$array = array();

		$sql = "SELECT * FROM manutencao";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getCheckId($id)
	{
		$array = array();

		$sql ="SELECT * FROM checklist WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
		   $array = $sql->fetch(\PDO::FETCH_ASSOC);	
		}

		return $array;
	}

	public function getManuId($id)
	{
		$array = array();

		$sql ="SELECT * FROM manutencao WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
		   $array = $sql->fetch(\PDO::FETCH_ASSOC);	
		}

		return $array;
	}

	public function getAllProducts()
	{
		$array = array();

		$sql = "SELECT * FROM produtos ORDER BY category ASC";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getAllProductsInativo()
	{
		$array = array();

		$sql = "SELECT * FROM produtos INNER JOIN categoria on(produtos.category = categoria.id_cat) WHERE status = 1";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getCategorias()
	{
		$array = array();

		$sql ="SELECT * FROM categoria";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
		   $array = $sql->fetchAll(\PDO::FETCH_ASSOC);	
		}
		return $array;
	}

	public function getCatId($id_cat)
	{
		$sql ="SELECT id_cat FROM categoria WHERE id_cat = '$id_cat'";
		$sql = $this->db->query($sql);
		return $cat_nome = $sql->fetch(\PDO::FETCH_ASSOC);
	}

	public function saveProduct($codigo, $cod_final, $initials, $name, $category, $price, $description, $nome)
	{
		$sql ="INSERT INTO produtos SET codigo = :cd, cod_final = :cf, initials = :in, name = :n, category = :c, price = :p, description = :d, img = :u";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':cd', $codigo);	
		$sql->bindValue(':cf', $cod_final);	
		$sql->bindValue(':in', $initials);
		$sql->bindValue(':n', $name);	
		$sql->bindValue(':c', $category);	
		$sql->bindValue(':p', $price);	
		$sql->bindValue(':d', $description);	
		$sql->bindValue(':u', $nome);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Produto Adicionado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao cadastrar Produto.
                        </div>';
		}
	}

	public function saveCompany($name_company, $phone, $zipcode, $street, $number, $neighborhood,
            $city, $state, $category_name, $email_user, $senha, $slug, $id)
	{
		$sql ="INSERT INTO companies SET id = :id, category_company = :category_company, name_company = :name_company, slug = :slug";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);	
		$sql->bindValue(':category_company', $category_name);	
		$sql->bindValue(':name_company', $name_company);	
		$sql->bindValue(':slug', $slug);
		$sql->execute();

		if($sql->rowCount() > 0) {
			
			$sqlc ="INSERT INTO config_menu SET id_company = :id_company";
			$sqlc = $this->db->prepare($sqlc);
			$sqlc->bindValue(':id_company', $id);	
			$sqlc->execute();

			if($sqlc->rowCount() > 0) {
				
				$sqls ="INSERT INTO store_info SET id_company = :id_company, name_store = :ns, zipcode = :zip,
				street = :st, neighborhood = :nei, state = :sta, city = :ci, number = :num, phone = :ph";
				$sqls = $this->db->prepare($sqls);
				$sqls->bindValue(':id_company', $id);	
				$sqls->bindValue(':ns', $name_company);	
				$sqls->bindValue(':zip', $zipcode);	
				$sqls->bindValue(':st', $street);	
				$sqls->bindValue(':nei', $neighborhood);	
				$sqls->bindValue(':sta', $state);	
				$sqls->bindValue(':ci', $city);	
				$sqls->bindValue(':num', $number);	
				$sqls->bindValue(':ph', $phone);	
				$sqls->execute();

				if($sqls->rowCount() > 0) {

					$permission = 2;
					$passhash = password_hash($senha, PASSWORD_DEFAULT);
					$sqlu ="INSERT INTO usuarios SET id_company = :id_company, id_permissao = :idp, nome_user = :nu,
					email_user = :em, senha = :pass";
					$sqlu = $this->db->prepare($sqlu);
					$sqlu->bindValue(':id_company', $id);	
					$sqlu->bindValue(':idp', $permission);	
					$sqlu->bindValue(':nu', $name_company);	
					$sqlu->bindValue(':em', $email_user);	
					$sqlu->bindValue(':pass', $passhash);	
					$sqlu->execute();
					
					if($sqlu->rowCount() > 0) {
						$_SESSION['company_register'] = $id;
						return true;
					} else {
						return false;
					}
				}
			}
		}

	}

	public function updateSubscribe($status, $id_company)
	{
		$sql ="UPDATE companies SET company_status = :company_status WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':company_status', $status);
		$sql->bindValue(':id', $id_company);
		$sql->execute();
	}

	public function getProdId($id_prod)
	{
		$array = array();

		$sql ="SELECT * FROM produtos WHERE id_prod = :id_prod";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_prod', $id_prod);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
		   $array = $sql->fetch(\PDO::FETCH_ASSOC);	
		}

		return $array;
	}

	public function editProduct($codigo, $cod_final, $initials, $name, $category, $price, $description, $nome = NULL, $id_prod)
	{
		if ($nome) {
			
			$sql ="UPDATE produtos SET codigo = :cd, cod_final = :cf, initials = :in, name = :n, category = :c, price = :p, description = :d, img = :u WHERE id_prod = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':cd', $codigo);	
			$sql->bindValue(':cf', $cod_final);	
			$sql->bindValue(':in', $initials);
			$sql->bindValue(':n', $name);	
			$sql->bindValue(':c', $category);	
			$sql->bindValue(':p', $price);	
			$sql->bindValue(':d', $description);	
			$sql->bindValue(':u', $nome);
			$sql->bindValue(':id', $id_prod);
			$sql->execute();

		} else {
			
			$sql ="UPDATE produtos SET codigo = :cd, cod_final = :cf, initials = :in, name = :n, category = :c, price = :p, description = :d WHERE id_prod = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':cd', $codigo);	
			$sql->bindValue(':cf', $cod_final);	
			$sql->bindValue(':in', $initials);
			$sql->bindValue(':n', $name);	
			$sql->bindValue(':c', $category);	
			$sql->bindValue(':p', $price);	
			$sql->bindValue(':d', $description);	
			$sql->bindValue(':id', $id_prod);	
			$sql->execute();
		}

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Produto Atualizado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Atualizar Produto.
                        </div>';
		}
	}

	public function toggleStatus($id_prod)
	{
		$sql ="UPDATE produtos SET status = 1 - status WHERE id_prod = '$id_prod'";
		$sql = $this->db->query($sql);
	}

	public function getAllManutencao()
	{
		$array = array();

		$sql ="SELECT * FROM manutencao";
		$sql = $this->db->query($sql);
		
		if($sql->rowCount() > 0) {
		   $array = $sql->fetchAll(\PDO::FETCH_ASSOC);	
		}

		return $array;
	}
}