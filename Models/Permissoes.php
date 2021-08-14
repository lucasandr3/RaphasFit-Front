<?php
namespace Models;

use \Core\Model;

class Permissoes extends Model
{
	public function getPermissionGroupName($id_permissao)
	{	
		$sql ="SELECT nome_group FROM permission_groups WHERE id_group = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_permissao);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$data = $sql->fetch();

			return $data['nome_group'];
		} else {
			return '';
		}
	}

	public function getPermissoes($id_permissao)
	{	
		$array = array();

		$sql ="SELECT id_permission_item FROM permission_links WHERE id_permission_group = :id_permissao";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_permissao', $id_permissao);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$data = $sql->fetchAll();
			$ids = array();
			foreach ($data as $data_item) {
				$ids[] = $data_item['id_permission_item'];
			}

			$sql ="SELECT slug FROM permission_items WHERE id_p_item IN (".implode(',', $ids).")";
			$sql = $this->db->query($sql);

			if ($sql->rowCount() > 0) {
				$data = $sql->fetchAll();
				foreach ($data as $data_item) {
					$array[] = $data_item['slug'];
				}
			}
		}

		return $array;
	}

	public function getAllGroups()
	{
		$array = array();

		$sql ="SELECT permission_groups.*, (select count(usuarios.id_user) from usuarios where usuarios.id_permissao = permission_groups.id_group) as total_users FROM permission_groups";
		$sql = $this->db->query($sql);

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getAllItems()
	{
		$array = array();

		$sql ="SELECT * FROM permission_items";
		$sql = $this->db->query($sql);

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function deleteGroup($id_group)
	{
		$sql ="SELECT id_user FROM usuarios WHERE id_permissao = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_group);
		$sql->execute();

		if ($sql->rowCount() === 0) {
			
			$sql ="DELETE FROM permission_links WHERE id_permission_group = :id_group";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':id_group', $id_group);
			$sql->execute();

			$sql ="DELETE FROM permission_groups WHERE id_group = :id_group";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':id_group', $id_group);
			$sql->execute();
		}
	}

	public function addGroup($nome_group)
	{
		$sql ="INSERT INTO permission_groups SET nome_group = :nome_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':nome_group', $nome_group);
		$sql->execute();

		return $this->db->lastInsertId();
	}

	public function linkItemToGroup($id_item, $id_group)
	{
		$sql ="INSERT INTO permission_links SET id_permission_group = :id_group, id_permission_item = :id_item";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_group);
		$sql->bindValue(':id_item', $id_item);
		$sql->execute();
	}

	public function editName($new_name, $id_group)
	{
		$sql ="UPDATE permission_groups SET nome_group = :nome_group WHERE id_group = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':nome_group', $new_name);
		$sql->bindValue(':id_group', $id_group);
		$sql->execute();
	}

	public function clearLinks($id_group)
	{
		$sql ="DELETE FROM permission_links WHERE id_permission_group = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_group);
		$sql->execute();
	}

	public function addPermissao($nome, $slug)
	{
		$sql ="INSERT INTO permission_items SET nome = :nome, slug = :slug";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':nome', $nome);
		$sql->bindValue(':slug', $slug);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$_SESSION['alert'] = "Swal.fire({
                                  position: 'center',
                                  type: 'success', 
                                  title: 'Permissão Adicionada Com Sucesso!',
                                  showConfirmButton: false,
                                  timer: 2500
                                })";
		} else {
			$_SESSION['alert'] = "Swal.fire({
                                  position: 'center',
                                  type: 'error', 
                                  title: 'Erro ao Adicionar Permissão!',
                                  showConfirmButton: false,
                                  timer: 2500
                                })";
		}
	}

	public function editPermissao($id_p_item, $nome)
	{
		$sql ="UPDATE permission_items SET nome = :nome WHERE id_p_item = :id_p_item";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':nome', $nome);
		$sql->bindValue(':id_p_item', $id_p_item);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$_SESSION['alert'] = "Swal.fire({
                                  position: 'center',
                                  type: 'success', 
                                  title: 'Permissão Atualizada Com Sucesso!',
                                  showConfirmButton: false,
                                  timer: 2500
                                })";
		} else {
			$_SESSION['alert'] = "Swal.fire({
                                  position: 'center',
                                  type: 'error', 
                                  title: 'Erro ao Atualizar Permissão!',
                                  showConfirmButton: false,
                                  timer: 2500
                                })";
		}
	}
}