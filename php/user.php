<?php 


/**
 * 
 */
class user extends Model
{
	protected $tabela = "user"	;

	public function insertCliente($nome,$email,$telefone)
	{
		$id = $this->getID($nome,$email,$telefone);
		if ($id > 0) {

			return $id;

		}
		else{
			$sql = "INSERT INTO cliente(nome, email, telefone) VALUES(:nome, :email, :telefone)";
			$insert = $this->conexao->prepare($sql);
			$insert->bindValue(":nome", $nome);
			$insert->bindValue(":email", $email);
			$insert->bindValue(":telefone", $telefone);
			$insert->execute();

			return $this->getID($nome,$email,$telefone);	
		}

		
	}
	public function getID($nome,$email,$telefone)
	{
		$sql = "SELECT *FROM cliente WHERE telefone = :telefone AND email = :email";


		$all = $this->conexao->prepare($sql);

		$all->bindValue(":email", $email);
		$all->bindValue(":telefone", $telefone);
		$all->execute();

		return $all->fetch()['id'];
	}

	public function updatesms($field, $value,$where,$valWhere)
	{
		$sql = "UPDATE fala SET ".$field." = :".$field." WHERE ".$where."= :".$where;
		//var_dump($sql);
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":".$field, $value);
		$find->bindValue(":".$where, $valWhere);
		return $find->execute();
	}

	public function getSms($limit)
	{
		$sql = "SELECT * FROM fala WHERE lida = 0 ORDER BY id DESC LIMIT ".$limit.",10 ";


		$all = $this->conexao->prepare($sql);

		$all->execute();

		return $all->fetchAll();

	}

	public function getNumSms()
	{
		$sql = "SELECT * FROM fala WHERE lida = 0 ORDER BY id DESC ";


		$all = $this->conexao->prepare($sql);

		$all->execute();

		return $all->rowCount();

	}


	public function actualizeTodos(){
		$sql = "UPDATE fala SET lida = 1 WHERE 1";
		
		$getsms = $this->conexao->prepare($sql);
		
		return $getsms->execute();

	}
	public function getchatSms($limit,$dados)
	{
		$sql = "SELECT cli.* FROM `chat` c, cliente cli, user u WHERE ((u.id = c.to AND cli.id = c.from) OR (u.id = c.from AND cli.id = c.to)) AND u.id = :dado HAVING COUNT(c.id) > 0 LIMIT ".$limit.",10 ";


		$all = $this->conexao->prepare($sql);

		$all->bindValue(":dado", $dados);

		$all->execute();

		return $all->fetchAll();

	}

	public function getchatSmsUser($limit,$dados,$dados2)
	{
		$sql = "SELECT *FROM chat c JOIN chatuser cu On cu.id = c.to WHERE (cu.id = c.to OR cu.id = c.from) AND ((cu.id = :dado2 AND :dado = c.from) OR (cu.id = :dado AND :dado2 = c.from)) LIMIT ".$limit.",10 ";


		$all = $this->conexao->prepare($sql);

		$all->bindValue(":dado", $dados);
		$all->bindValue(":dado2", $dados);

		$all->execute();

		return $all->fetchAll();

	}

	public function getSmsl($limit)
	{
		$sql = "SELECT * FROM fala WHERE lida = 1 ORDER BY id DESC LIMIT ".$limit.",10 ";


		$all = $this->conexao->prepare($sql);

		$all->execute();

		return $all->fetchAll();

	}
	public function login($nome, $senha){
		
		$sql = "SELECT *FROM ".$this->tabela." WHERE email = :nome AND senha = :senha";
		//var_dump($sql);
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":nome", $nome);
		$find->bindValue(":senha", $senha);
		$find->execute();

		return $find->fetch();
	}

	public function findUser($field, $value){
		
		$sql = "SELECT u.*, f.local as 'imagem' FROM user u JOIN foto f ON f.id_entidade = u.id WHERE f.entidade = 'user' AND u.".$field." = :".$field;

		//var_dump($sql);
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":".$field, $value);
		$find->execute();

		return $find->fetch();
	}
	public function findUserchat($field, $value){
		
		$sql = "SELECT *FROM chatuser WHERE ".$field." = :".$field;

		//var_dump($sql);
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":".$field, $value);
		$find->execute();

		return $find->fetch();
	}
	
	public function findCliente($field, $value){
		
		$sql = "SELECT *FROM cliente WHERE ".$field." = :".$field;

		//var_dump($sql);
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":".$field, $value);
		$find->execute();

		return $find->fetch();
	}

	public function selectUser(){
		
		$sql = "SELECT u.*, f.local as 'imagem' FROM user u JOIN foto f ON f.id_entidade = u.id WHERE f.entidade = 'user' ORDER BY u.id DESC";

		//var_dump($sql);
		$find = $this->conexao->prepare($sql);
		$find->execute();

		return $find->fetchAll();
	}
	public function selectUserOnline(){
		
		$sql = "SELECT u.*, f.local as 'imagem' FROM user u JOIN foto f ON f.id_entidade = u.id WHERE f.entidade = 'user' ";

		//var_dump($sql);
		$find = $this->conexao->prepare($sql);
		$find->execute();

		return $find->fetchAll();
	}
public function getUserID($id,$nome,$senha,$email,$funcao,$imagem,$tel,$op){
	$sql = "SELECT *FROM user WHERE nome=:nome AND senha = :senha AND email = :nomeuser AND funcao = :funcao AND tel = :tel ";
	$find = $this->conexao->prepare($sql);
	$find->bindValue(":nome", $nome);
	$find->bindValue(":senha", $senha);
	$find->bindValue(":nomeuser", $email);
	$find->bindValue(":funcao", $funcao);
	$find->bindValue(":tel", $tel);
	$find->execute();
	return $find->fetch()['id'];
}
public function allUser($id,$nome,$senha,$email,$funcao,$imagem,$tel,$op)
	{
		$sql = "";
		if ($op == 1) {
			$sql = "UPDATE user SET nome=:nome, senha = :senha,email = :nomeuser, funcao = :funcao, tel = :tel WHERE id = :id ";

			$find = $this->conexao->prepare($sql);
			$find->bindValue(":nome", $nome);
			$find->bindValue(":senha", $senha);
			$find->bindValue(":nomeuser", $email);
			$find->bindValue(":funcao", $funcao);
			$find->bindValue(":tel", $tel);
			$find->bindValue(":id", $id);
			if ($find->execute()) {
					$idinterno = $id;
				
					$dadosChat = $this->conexao->prepare("UPDATE `chatuser` SET `nome` = :nomeChat WHERE `chatuser`.`id` = :idChat;");
					$dadosChat->bindValue(":idChat",$idinterno);
					$dadosChat->bindValue(":nomeChat",$nome);
					return $dadosChat->execute();
			}

		}elseif ($op == 0) {
			$sql = "INSERT INTO user( nome, email, senha, funcao, tel) VALUES (:nome,:nomeuser,:senha,:funcao,:tel)";
			$find = $this->conexao->prepare($sql);
			$find->bindValue(":nome", $nome);
			$find->bindValue(":senha", $senha);
			$find->bindValue(":nomeuser", $email);
			$find->bindValue(":funcao", $funcao);
			$find->bindValue(":tel", $tel);
			if ($this->getUserID($id,$nome,$senha,$email,$funcao,$imagem,$tel,$op)) {
			}else{
				
				if ($find->execute()) {
					$idinterno = $this->getUserID($id,$nome,$senha,$email,$funcao,$imagem,$tel,$op);
				
					$dadosChat = $this->conexao->prepare("INSERT INTO chatuser(id, nome) VALUES(:idChat, :nomeChat)");
					$dadosChat->bindValue(":idChat",$idinterno);
					$dadosChat->bindValue(":nomeChat",$nome);
					return $dadosChat->execute();
			}
			}
		}


	}
		public function insertUser($nome,$email,$telefone)
	{
		$id = $this->getID($nome,$email,$telefone);
		if ($id > 0) {

			return $id;

		}
		else{
			$sql = "INSERT INTO cliente(nome, email, telefone) VALUES(:nome, :email, :telefone)";
			$insert = $this->conexao->prepare($sql);
			$insert->bindValue(":nome", $nome);
			$insert->bindValue(":email", $email);
			$insert->bindValue(":telefone", $telefone);
			
			if ($insert->execute()) {
				$idinterno = $this->getID($nome,$email,$telefone);
				
				$dadosChat = $this->conexao->prepare("INSERT INTO chatuser(id, nome) VALUES(:idChat, :nomeChat)");
				$dadosChat->bindValue(":idChat",$idinterno);
				$dadosChat->bindValue(":nomeChat",$nome);
				$dadosChat->execute();
				return $this->getID($nome,$email,$telefone);	
			}

		}

		
	}
	
	public function insertinteresseCliente($cliente,$casa)
	{
		if ($this->verificainteresseCliente($cliente,$casa) > 0) {
			return true;
		}else{

			$sql = "INSERT INTO interesses( id_casa, id_cliente) VALUES(:casa, :cliente)";
			$insert = $this->conexao->prepare($sql);
			$insert->bindValue(":casa", $casa);
			$insert->bindValue(":cliente", $cliente);
			return $insert->execute();
		}

		
	}	
	public function verificainteresseCliente($cliente,$casa)
	{
			$sql = "SELECT *FROM `interesses` WHERE id_casa = :casa AND id_cliente = :cliente";
			$insert = $this->conexao->prepare($sql);
			$insert->bindValue(":casa", $casa);
			$insert->bindValue(":cliente", $cliente);
			$insert->execute();
			return $insert->rowCount();

		
	}
	public function numinteresseCliente()
	{
			$sql = "SELECT *FROM `interesses` WHERE `respondido`=0 ORDER BY id DESC";
			$insert = $this->conexao->prepare($sql);
			$insert->execute();
			return $insert->rowCount();

		
	}
	public function numinteresseClientes()
	{
			$sql = "SELECT *FROM `interesses` WHERE `respondido`=1 ORDER BY id DESC";
			$insert = $this->conexao->prepare($sql);
			$insert->execute();
			return $insert->rowCount();

		
	}

	public function getinteresseCliente($limit)
	{
			$sql = "SELECT isr.id as 'idcasas', c.*, i.nome as 'casa',i.descricao,f.local as 'imagem', isr.* FROM `interesses` isr JOIN cliente c ON isr.id_cliente = c.id JOIN casa i ON i.id = isr.id_casa JOIN foto f ON f.id_entidade=i.id WHERE f.entidade ='casa' AND isr.respondido = 0 GROUP BY isr.id DESC LIMIT ".$limit.",20";
			$insert = $this->conexao->prepare($sql);
			$insert->execute();
			return $insert->fetchAll();

		
	}
	
	public function getinteresseClientes($limit)
	{
			$sql = "SELECT isr.id as 'idcasas', c.*, i.nome as 'casa',i.descricao,f.local as 'imagem', isr.* FROM `interesses` isr JOIN cliente c ON isr.id_cliente = c.id JOIN casa i ON i.id = isr.id_casa JOIN foto f ON f.id_entidade=i.id WHERE f.entidade ='casa' AND isr.respondido = 1 ORDER BY isr.id DESC LIMIT ".$limit.",20";
			$insert = $this->conexao->prepare($sql);
			$insert->execute();
			return $insert->fetchAll();

		
	}

	public function updateinter($field, $value,$where,$valWhere){
		
		$sql = "UPDATE interesses SET ".$field." = :".$field." WHERE ".$where."= :".$where;
		//var_dump($sql);
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":".$field, $value);
		$find->bindValue(":".$where, $valWhere);
		return $find->execute();

		//return $find->fetch();
	}
	public function upagora($tab,$field, $value,$where,$valWhere){
		
		$sql = "UPDATE ".$tab." SET ".$field." = :".$field." WHERE ".$where."= :".$where;
		//var_dump($sql);
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":".$field, $value);
		$find->bindValue(":".$where, $valWhere);
		return $find->execute();

		//return $find->fetch();
	}

	public function deletepedido($field, $value){
		
		$sql = "DELETE FROM interesses WHERE ".$field." = :".$field;
		$find = $this->conexao->prepare($sql);
		$find->bindValue(":".$field, $value);
		return $find->execute();

	}
}


?>