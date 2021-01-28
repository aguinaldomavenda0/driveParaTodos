<?php 
include 'php/include.php';
if (isset($_GET['pasta']) && isset($_POST["nomePasta"])) {
	$p = new Pasta();
	$nomePasta = htmlspecialchars($_POST['nomePasta']);
	$numPasta = htmlspecialchars($_GET['pasta']);
	$pastaDestino = $p->find("codigo",$numPasta);

	if ($pastaDestino['permicao'] == "A") {
		header("Location:./");
	}else{
		$p->addPasta($nomePasta, "S", $numPasta, "M");
		header("Location:./");

	}


}else{

	$nome = htmlspecialchars($_POST['nome']);
	$tipo = htmlspecialchars($_GET['tipo']);
	$pasta = htmlspecialchars($_GET['pasta']);
	$pastaInstancia = new Pasta();
	$ps = $pastaInstancia->find("codigo",$pasta);
	if ($ps['permicao']=="M") {
		$ficheiro = new Ficheiro();
		$localizacao = $ficheiro->uploadfFicheiro($_FILES['ficheiroSelecionado'],"ficheiros/");
		echo($ficheiro->addFile($nome, $localizacao, $tipo, $pasta));
	}
	header("Location:./");
}


?>