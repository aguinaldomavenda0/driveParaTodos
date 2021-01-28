<?php
require '../include.php';
if(isset($_GET['getPastas'])){
    $num = $_GET['getPastas'];
    if($num == 0){
        $pasta = new Pasta();
        $listaPastas = $pasta->findAllNotEquals("tipo", "P");
        echo(json_encode($listaPastas));
    }else if($num > 0){
        $pasta = new Pasta();
        $listaPastas = $pasta->findAllNotEqualsDoisElementos("tipo", "S","codigoPasta",$num);
        echo(json_encode($listaPastas));
        
    }
}
else if(isset($_GET['getFiles'])){
    $ficheiro = new Ficheiro();
    $codigoPasta = $_GET['getFiles'];
    
    $listaFicheiros = $ficheiro->findAllNotEquals("codigoPasta", $codigoPasta);
    //var_dump($listaFicheiros);
    echo(json_encode($listaFicheiros));
}

else if(isset($_GET['getDownFile'])){
    $ficheiro = new Ficheiro();
    $codigoFile = $_GET['getDownFile'];
    $selecionaFicheiro = $ficheiro->find("codigo",$codigoFile);
    echo(json_encode($selecionaFicheiro));
    //header("Location:../../".$selecionaFicheiro['localizacao']);
}
else if (isset($_GET['tipo'])) {
    //$nome = htmlspecialchars($_POST['nome']);
    //$tipo = htmlspecialchars($_POST['tipo']);
    $ficheiro = new Ficheiro();
    
    if (isset($_FILES['ficheiro'])) {
        # code...
        echo "string";
        //echo(json_encode($ficheiro->add($nome, $localizacao, $tipo, 2)));
    }
        echo "string";
}
//var_dump($_GET);
?>