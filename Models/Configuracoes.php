<?php
namespace Models;

use \Core\Model;

class Configuracoes extends Model
{
    public function getDados()
    {
        $array = array();

        $sql ="SELECT * FROM config";
        $sql = $this->db->query($sql);

        if($sql->rowCount() > 0) {
           $array = $sql->fetch(\PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function updateDados($nome_empresa, $cep, $endereco, $bairro, $complemento,
    $cidade, $estado, $email, $tel)
    {
        $sql ="UPDATE config SET nome_empresa = :ne, cep = :c, endereco = :e, bairro = :b, complemento = :com,
        cidade = :cid, estado = :es, email = :em, tel = :t";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':ne', $nome_empresa);
        $sql->bindValue(':c', $cep);
        $sql->bindValue(':e', $endereco);
        $sql->bindValue(':b', $bairro);
        $sql->bindValue(':com', $complemento);
        $sql->bindValue(':cid', $cidade);
        $sql->bindValue(':es', $estado);
        $sql->bindValue(':em', $email);
        $sql->bindValue(':t', $tel);
        $sql->execute();

        if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Dados Atualizados Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-primary mt-4" role="alert">
			            <strong><i class="fas fa-info"></i></strong> Nenhum dado para atualizar.
                        </div>';
		}
    }
}