<?php 

/**
 * Autor: Aguinaldo Mavenda
 * Classe Pasta, para gerir todas as pastas do arquivadas.
 */
class pasta extends Model
{
	
	protected $tabela = 'pasta';

	public function addPasta($nome, $tipo, $pasta, $permicao)
	{
		$sql = "INSERT INTO pasta(nome, tipo, codigoPasta, permicao) VALUES(:nome, :tipo, :pasta, :permicao) " ;
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":nome",$nome);
		$find->bindValue(":tipo",$tipo);
		$find->bindValue(":pasta",$pasta);
		$find->bindValue(":permicao",$permicao);
		return $find->execute();
	}
}

?>