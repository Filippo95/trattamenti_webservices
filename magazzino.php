<?php
foreach (glob("../config/*.php") as $filename)
{
    include $filename;
}

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



 header("Access-Control-Allow-Origin: *");

if(strcmp($_REQUEST['action'],"carichi")==0)
{
    
    $sth = mysqli_query($conn,"SELECT prodottos.id, prodottos.nome, prezzos.prezzo_fattura, prezzos.sconto, SUM(caricos.quantit) as totale,ROUND((prezzos.prezzo_fattura+(prezzos.prezzo_fattura*prezzos.sconto)/100)*SUM(caricos.quantit),2) as stima FROM `caricos`, prodottos,prezzos WHERE caricos.id_prodotto=prodottos.id AND prodottos.id=prezzos.id_prodotto AND  YEAR(prezzos.data) = YEAR(CURDATE()) GROUP BY prodottos.id, prodottos.nome, prezzos.prezzo_fattura, prezzos.sconto");
    $rows = array();
    while($r = mysqli_fetch_assoc($sth)) 
    {
        $rows[] = $r;
    }
    echo  json_encode($rows);
    
}
if(strcmp($_REQUEST['action'],"consumi")==0)
{
    
    $sth = mysqli_query($conn,"Select prodottos.id, SUM(prodotto_trattamentos.dose_ha*colturas.estensione_ha) as consumo FROM trattamentos,colturas,prodotto_trattamentos,prodottos WHERE trattamentos.id_coltura=colturas.id AND prodotto_trattamentos.id_prodotto=prodottos.id AND prodotto_trattamentos.id_trattamento=trattamentos.id GROUP BY prodottos.id,prodotto_trattamentos.dose_ha,colturas.estensione_ha");
    $rows = array();
    while($r = mysqli_fetch_assoc($sth)) 
    {
        $rows[] = $r;
    }
    echo  json_encode($rows);
    
}