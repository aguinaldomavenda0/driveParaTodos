<?php 

/**
 * Autor: Aguinaldo Mavenda
 * Classe imovel, para gerir todos imoveis.
 */
class foto extends Model
{
	
	protected $tabela = 'foto';

	public function findAllFotos($field, $value){

		$sql = "SELECT *FROM foto WHERE ".$field." = :".$field." AND entidade = 'casa' ORDER BY principal DESC" ;
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":".$field, $value);
		$find->execute();

		return $find->fetchAll();
	}

	public function insertFoto($entidade, $local, $id, $principal){

		$sql = "INSERT INTO foto(entidade, local, id_entidade, principal) VALUES (:entidade, :local, :id_entidade, :principal)" ;
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":local", $local);
		$find->bindValue(":entidade", $entidade);
		$find->bindValue(":id_entidade", $id);
		$find->bindValue(":principal", $principal);
		return $find->execute();
	}
	public function getPrincipal($field, $value,$entidade){

		$sql = "SELECT *FROM foto WHERE ".$field." = :".$field." AND entidade = :entidade ORDER BY principal DESC" ;
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":".$field, $value);
		$find->bindValue(":entidade", $entidade);
		$find->execute();

		return $find->fetchAll();
	}
	public function deletefoto($id){
		$sql = "DELETE FROM `foto` WHERE id = :casa;";

		$insert = $this->conexao->prepare($sql);
		$insert->bindValue(":casa", $id);
		return $insert->execute();

	}
	
}

 ?>