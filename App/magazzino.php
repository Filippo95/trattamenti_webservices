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

    $sql = "select prodottos.id, prodottos.nome, prezzos.prezzo_fattura, prezzos.sconto, ROUND(SUM( Distinct prodotto_trattamentos.dose_ha*colturas.estensione_ha),2) as Q_consumata , ROUND(SUM( DISTINCT caricos.quantit),2) as Q_caricata,ROUND(SUM( DISTINCT caricos.quantit)-SUM( Distinct prodotto_trattamentos.dose_ha*colturas.estensione_ha),2) as Giacenza, ROUND((prezzos.prezzo_fattura+(prezzos.prezzo_fattura*prezzos.sconto)/100)*(ROUND(SUM( DISTINCT caricos.quantit)-SUM(Distinct prodotto_trattamentos.dose_ha*colturas.estensione_ha),2)),2) as stima FROM trattamentos,colturas,prodotto_trattamentos,prodottos,caricos,prezzos WHERE trattamentos.id_coltura=colturas.id AND prodotto_trattamentos.id_prodotto=prodottos.id AND prodotto_trattamentos.id_trattamento=trattamentos.id AND caricos.id_prodotto=prodottos.id AND prodottos.id=prezzos.id_prodotto AND YEAR(prezzos.data) = YEAR(CURDATE()) GROUP BY prodottos.id, prodottos.nome,prezzos.prezzo_fattura,prezzos.sconto union select prodottos.id,prodottos.nome, prezzos.prezzo_fattura, prezzos.sconto,'0' as Q_consumata , ROUND(SUM(caricos.quantit),2) as Q_caricata,ROUND(SUM(caricos.quantit),2) as Giacenza,ROUND((prezzos.prezzo_fattura+(prezzos.prezzo_fattura*prezzos.sconto)/100)*SUM(caricos.quantit),2) as stima FROM prodottos,`caricos`,prezzos WHERE  prodottos.id NOT IN  (select prodotto_trattamentos.id_prodotto                              from prodotto_trattamentos) AND caricos.id_prodotto=prodottos.id AND prodottos.id=prezzos.id_prodotto  AND  YEAR(prezzos.data) = YEAR(CURDATE()) GROUP BY prodottos.id,prodottos.nome,prezzos.prezzo_fattura, prezzos.sconto";

$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
    <title>Hello, world!</title>
  </head>
  
  <?php include("header.php")?>
  <body>
    <h1>Magazzino </h1>
	<table id="table" class="table">
	<thead>
	<th>ID</th>
	<th>Prodotto</th>
	<th>Prezzo fattura </th>
	<th>Sconto</th>
	<th>Quantità consumata </th>
	<th>Quantità caricata</th>
	<th>Giacenza</th>
	<th>Stima</th>
	
	</thead>
	<tbody>
<?php
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr> <td>" . $row["id"]. "</td><td>" . $row["nome"]. "</td><td>" . $row["prezzo_fattura"]. "</td><td>" . $row["sconto"]. "</td><td>" . $row["Q_consumata"]. "</td><td>" . $row["Q_caricata"]. "</td><td>" . $row["Giacenza"]. "</td><td>" . $row["stima"]. "</td></tr>";
    }
} else {
    echo "0 results";
}
$conn->close();

?>
	</tbody>
</table>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" > </script>  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    $('#table').DataTable({"paging": false});
} );
</script>  
  <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

 </body>
</html>

