<?php
foreach (glob("config/*.php") as $filename)
{
    include $filename;
}



$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



 header("Access-Control-Allow-Origin: *");


if(strcmp($_REQUEST['query'],"carburante")==0)
{
    
    
$sth = mysqli_query($conn,"SELECT  colturas.nome AS label,  ROUND(SUM(attrezzos.costo_carburante*attrezzos.deperimento*attrezzos.consumo*colturas.estensione_ha), 2) AS data FROM Gestione_development.colturas, Gestione_development.trattamentos,Gestione_development.prodotto_trattamentos,Gestione_development.prodottos,Gestione_development.prezzos,Gestione_development.attrezzos WHERE Gestione_development.colturas.id=Gestione_development.trattamentos.id_coltura AND Gestione_development.trattamentos.id=Gestione_development.prodotto_trattamentos.id_trattamento AND Gestione_development.prodotto_trattamentos.id_prodotto=Gestione_development.prodottos.id AND Gestione_development.prodottos.id=Gestione_development.prezzos.id_prodotto AND Gestione_development.trattamentos.id_attrezzo=Gestione_development.attrezzos.id GROUP BY label");
$rows = array();
echo '[';
while($r = mysqli_fetch_assoc($sth)) {
  
    echo "{ label: \"";
    echo $r['label'];
    echo "\",data: ";
    echo $r['data'];
    echo "},";
}
echo']';

}
if(strcmp($_REQUEST['query'],"prodotti")==0)
{
    
    
$sth = mysqli_query($conn,"SELECT  colturas.nome AS label,  ROUND(SUM((prezzos.prezzo_fattura-(prezzos.prezzo_fattura*prezzos.sconto/100))*prodotto_trattamentos.dose_ha*colturas.estensione_ha),2) AS  data FROM Gestione_development.colturas, Gestione_development.trattamentos,Gestione_development.prodotto_trattamentos,Gestione_development.prodottos,Gestione_development.prezzos,Gestione_development.attrezzos WHERE Gestione_development.colturas.id=Gestione_development.trattamentos.id_coltura AND Gestione_development.trattamentos.id=Gestione_development.prodotto_trattamentos.id_trattamento AND Gestione_development.prodotto_trattamentos.id_prodotto=Gestione_development.prodottos.id AND Gestione_development.prodottos.id=Gestione_development.prezzos.id_prodotto AND Gestione_development.trattamentos.id_attrezzo=Gestione_development.attrezzos.id GROUP BY label");
$rows = array();
echo '[';
while($r = mysqli_fetch_assoc($sth)) {
  
    echo "{ label: \"";
    echo $r['label'];
    echo "\",data: ";
    echo $r['data'];
    echo "},";
}
echo']';

}





?>



