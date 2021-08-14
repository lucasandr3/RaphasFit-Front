<?php
namespace Models;

use \Core\Model;

class Abastecimento extends Model
{
	public function getAbastecimento()
	{
		$array = array();

		$sql ="SELECT * FROM diesel ORDER BY date_diesel DESC";
		$sql = $this->db->query($sql);

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function addDespesa($descricao, $valor, $data_d, $conta, $id_cat, $id_user)
	{
		$sql ="INSERT INTO despesa SET descricao = :descricao, valor = :valor, data_d = :data_d,
		conta = :conta, id_cat = :id_cat, id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':descricao', $descricao);
		$sql->bindValue(':valor', $valor);
		$sql->bindValue(':data_d', $data_d);
		$sql->bindValue(':conta', $conta);
		$sql->bindValue(':id_cat', $id_cat);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$_SESSION['msg'] = "Swal.fire({
                                  position: 'center',
                                  type: 'success', 
                                  title: 'Despesa Adicionada Com Sucesso!',
                                  showConfirmButton: false,
                                  timer: 2500
                                })";
		} else {
			$_SESSION['msg'] = "Swal.fire({
                                  position: 'center',
                                  type: 'error',
                                  title: 'Erro ao Adicionar Despesa!',
                                  showConfirmButton: false,
                                  timer: 2500
                                })";
		}
	}

	public function getAll($id_user)
	{
		$array = array();

		$data = date('F');

		$sql ="SELECT * FROM despesa as d INNER JOIN cat_despesa as cd ON(d.id = cd.id) WHERE MONTHNAME(data_d) = '$data'";
		$sql = $this->db->query($sql);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getTotal($id_user)
	{
		$array = array();

		$sql ="SELECT SUM(valor), moeda_des FROM despesa WHERE id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

	public function addDesRecorrente($descricao, $valor, $ventrada, $juro, $qtd_parc, $data_parc, $conta, $id_cat, $id_user)
	{
		$sql ="INSERT INTO des_recorrente SET descricao = :descricao, valor = :valor, ventrada = :ventrada, juro = :juro, qtd_parc = :qtd_parc, data_parc = :data_parc, conta = :conta, id_cat = :id_cat, id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':descricao', $descricao);
		$sql->bindValue(':valor', $valor);
		$sql->bindValue(':ventrada', $ventrada);
		$sql->bindValue(':juro', $juro);
		$sql->bindValue(':qtd_parc', $qtd_parc);
		$sql->bindValue(':data_parc', $data_parc);
		$sql->bindValue(':conta', $conta);
		$sql->bindValue(':id_cat', $id_cat);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$_SESSION['msg'] = "Swal.fire({
                                  position: 'center',
                                  type: 'success', 
                                  title: 'Despesa Adicionada Com Sucesso!',
                                  showConfirmButton: false,
                                  timer: 2500
                                })";
		} else {
			$_SESSION['msg'] = "Swal.fire({
                                  position: 'center',
                                  type: 'error',
                                  title: 'Erro ao Adicionar Despesa!',
                                  showConfirmButton: false,
                                  timer: 2500
                                })";
		}
	}

	public function getAllReco($id_user)
	{
		$array = array();

		$sql ="SELECT * FROM des_recorrente as dr INNER JOIN cat_despesa as cd ON(dr.id_cat = cd.id)";
		$sql = $this->db->query($sql);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getTotalRecorrente($id_user)
	{
		$array = array();

		$sql ="SELECT SUM(valor) FROM des_recorrente WHERE id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

	public function getDespesaList($id_user)
	{
		$array = array();

		$data = date('m');

		$sql ="SELECT SUM(valor) as total,
					  data_d,
					  id_user
					  FROM despesa as d INNER JOIN cat_despesa as cd ON(d.id_cat = cd.id)
					  WHERE id_user = :id_user GROUP BY month(data_d)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
			foreach($array as $item) {
                $array[$item['data_d']] = $item['total'];
            }
		}

		return $array;
	}

	public function getExpensesList($period1, $period2, $id_user) {
		$array = array();
		$currentDay = $period1;
		while($period2 != $currentDay) {
			$array[$currentDay] = 0;
			$currentDay = date('Y-m-d', strtotime('+1 day', strtotime($currentDay)));
		}

		$sql = "SELECT DATE_FORMAT(data_d, '%Y-%m-%d') as data_d, SUM(valor) as total FROM despesa WHERE id_user = :id_user AND data_d BETWEEN :period1 AND :period2 GROUP BY DATE_FORMAT(data_d, '%Y-%m-%d')";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':period1', $period1);
		$sql->bindValue(':period2', $period2);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$rows = $sql->fetchAll();

			foreach($rows as $item) {
				$array[$item['data_d']] = $item['total'];
			}
		}


		return $array;
	}

	public function getDespesasMaisUsadas($id_user)
	{
		$array = array();

		$sql ="SELECT SUM(id_cat) as total FROM despesa as d INNER JOIN cat_despesa as cd ON(d.id_cat = cd.id) GROUP BY id_cat LIMIT 4";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}
} 