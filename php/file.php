<?php 

/**
 * Autor: Aguinaldo Mavenda
 * Classe ficheiro, para Gerenciar todos os ficheiro da bD
 */
class ficheiro extends Model
{
	
	protected $tabela = 'ficheiro';

	public function addFile($nome, $localizacao, $tipo, $pasta)
	{
		$sql = "INSERT INTO ficheiro(nome, localizacao, tipo, codigoPasta) VALUES (:nome, :localizacao, :tipo, :pasta)" ;
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":nome",$nome);
		$find->bindValue(":localizacao",$localizacao);
		$find->bindValue(":tipo",$tipo);
		$find->bindValue(":pasta",$pasta);
		return $find->execute();
	}

	public function uploadfFicheiro($ficheiro,$pasta){
		
		$formatos = array("pdf","pptx");
		$extensao = pathinfo($ficheiro['name'], PATHINFO_EXTENSION);
		if(in_array($extensao, $formatos)){
    		$temporario = $ficheiro['tmp_name'];
    		$novoNome = "maven".uniqid().".$extensao";
		    if(move_uploaded_file($temporario, $pasta.$novoNome)){
        		$mensagem = "Upload feito com sucesso!";
    		}
    		else{
        		$novoNome = "";
    		}
		}else{
    		$novoNome = "";
		}

		return $novoNome;
//return $pasta.'maven'.$novoNome;
	}
}

?>