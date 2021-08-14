<?php
namespace Models;

use \Core\Model;

class Colaboradores extends Model
{
    public function getAll()
    {
        $array = array();
        $sql ="SELECT * FROM usuarios as u INNER JOIN permission_groups as pg on u.id_permissao = pg.id_group
		WHERE status = 0 ORDER BY id_user ASC";
        $sql = $this->db->query($sql);
        if($sql->rowCount() > 0) {
           $array = $sql->fetchAll(\PDO::FETCH_ASSOC);     
        }
        return $array;
	}

	public function getAllAccess()
    {
        $array = array();
        $sql ="SELECT * FROM usuarios as u INNER JOIN permission_groups as pg on u.id_permissao = pg.id_group
		ORDER BY id_user ASC";
        $sql = $this->db->query($sql);
        if($sql->rowCount() > 0) {
           $array = $sql->fetchAll(\PDO::FETCH_ASSOC);     
        }
        return $array;
	}

	public function getAllInactive()
    {
        $array = array();
        $sql ="SELECT * FROM usuarios as u INNER JOIN permission_groups as pg on u.id_permissao = pg.id_group
		WHERE status = 1 ORDER BY id_user ASC";
        $sql = $this->db->query($sql);
        if($sql->rowCount() > 0) {
           $array = $sql->fetchAll(\PDO::FETCH_ASSOC);     
        }
        return $array;
	}
	
	public function getUserId($id_user)
    {
        $array = array();
        $sql ="SELECT * FROM usuarios as u INNER JOIN permission_groups as pg on u.id_permissao = pg.id_group
		WHERE id_user = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id_user);
		$sql->execute();
        if($sql->rowCount() > 0) {
           $array = $sql->fetch(\PDO::FETCH_ASSOC);     
        }
        return $array;
    }

    public function getColabReg($id_colab)
	{
		$array = array();
		$sql ="SELECT * FROM colaboradores as c INNER JOIN permission_groups as pg on(c.cargo = pg.id_group) WHERE id_colab = :id_colab";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_colab', $id_colab);
		$sql->execute();
		if($sql->rowCount() > 0) {
		   $array = $sql->fetch(\PDO::FETCH_ASSOC);	
		}
		return $array;
    }

    public function getCargos()
    {
        $array = array();
        $sql ="SELECT * FROM permission_groups";
        $sql = $this->db->query($sql);
        if($sql->rowCount() > 0) {
           $array = $sql->fetchAll(\PDO::FETCH_ASSOC); 
        }
        return $array;
	}
	
	public function registerColaborador($nome_user, $email_user, $permissao, $status, $senha)
	{
		$passhash = password_hash($senha, PASSWORD_DEFAULT);

		$sql ="INSERT INTO usuarios SET id_permissao = :ip, nome_user = :n, email_user = :e, senha = :s, status = :ss";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":ip", $permissao);
		$sql->bindValue(":n", $nome_user);
		$sql->bindValue(":e", $email_user);
		$sql->bindValue(":ss", $status);
		$sql->bindValue(":s", $passhash);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Colaborador Cadastrado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao cadastrar Colaborador.
                        </div>';
		}
	}

    public function saveColaborador($nome_colab, $registro, $email, $tel, $salario, $cargo, $status)
    {
        $sql ="INSERT INTO colaboradores SET nome_colab = :nc, registro = :r, email = :em, tel = :t,
        salario = :s, cargo = :c, status = :st, data_admissao = NOW()";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':nc', $nome_colab);	
		$sql->bindValue(':r', $registro);	
		$sql->bindValue(':em', $email);	
		$sql->bindValue(':t', $tel);	
		$sql->bindValue(':s', $salario);	
		$sql->bindValue(':c', $cargo);
		$sql->bindValue(':st', $status);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Colaborador Cadastrado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao cadastrar Colaborador.
                        </div>';
		}
    }

    public function getColabId($id_colab)
	{
		$array = array();
		$sql ="SELECT * FROM colaboradores as c INNER JOIN permission_groups as pg on(c.cargo = pg.id_group) WHERE id_colab = :id_colab";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_colab', $id_colab);
		$sql->execute();
		if($sql->rowCount() > 0) {
		   $array = $sql->fetch(\PDO::FETCH_ASSOC);	
		}
		return $array;
    }

    public function editColab($nome_user, $email_user, $permissao, $status, $senha, $id_user)
    {

		if ($senha == '') {
			
			$sql ="UPDATE usuarios SET nome_user = :nu, email_user = :em, id_permissao = :ip,
			status = :st WHERE id_user = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':nu', $nome_user);	
			$sql->bindValue(':em', $email_user);	
			$sql->bindValue(':ip', $permissao);			
			$sql->bindValue(':st', $status);
			$sql->bindValue(':id', $id_user);
			$sql->execute();

		} else {

			$hash = password_hash($senha, PASSWORD_DEFAULT);
		
			$sql ="UPDATE usuarios SET nome_user = :nu, email_user = :em, id_permissao = :ip, senha = :s,
			status = :st WHERE id_user = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':nu', $nome_user);	
			$sql->bindValue(':em', $email_user);	
			$sql->bindValue(':ip', $permissao);	
			$sql->bindValue(':s', $hash);		
			$sql->bindValue(':st', $status);
			$sql->bindValue(':id', $id_user);
			$sql->execute();
		}
		
		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Colaborador Atualizado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Atualizar Colaborador.
                        </div>';
		}
    }

    public function toggleStatusInactive($nome_user)
	{
		$sql ="UPDATE usuarios SET status = 1 - status WHERE nome_user = '$nome_user'";
        $sql = $this->db->query($sql);
        
        if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Colaborador Atualizado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Atualizar Colaborador.
                        </div>';
		}
	}

	public function toggleStatusActive($nome_user)
	{
		$sql ="UPDATE usuarios SET status = 0 WHERE nome_user = '$nome_user'";
        $sql = $this->db->query($sql);

        if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Colaborador Atualizado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Atualizar Colaborador.
                        </div>';
		}
	}
}