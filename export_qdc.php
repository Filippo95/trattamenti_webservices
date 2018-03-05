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


    
    
$sth = mysqli_query($conn,"SELECT trattamentos.data, colturas.nome,colturas.estensione_ha,trattamentos.semina,trattamentos.trapianto,trattamentos.fioritura,trattamentos.raccolta,prodottos.nome as pr_nome,trattamentos.avversit,prodotto_trattamentos.dose_ha FROM trattamentos, prodotto_trattamentos,prodottos,colturas WHERE trattamentos.id=prodotto_trattamentos.id_trattamento AND prodotto_trattamentos.id_prodotto=prodottos.id AND trattamentos.id_coltura=colturas.id");
$rows = array();

while($r = mysqli_fetch_assoc($sth)) {
  
echo '["'.$r['data'].'","'.$r['nome'].'","'.$r['estensione_ha'].'","'.$r['semina'].'","'.$r['trapianto'].'","'.$r['fioritura'].'","'.$r['raccolta'].'","'.$r['pr_nome'].'","'.$r['avversit'].'","'.$r['dose_ha'].'"],';
}







?>



