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

$sql = "SELECT trattamentos.id,trattamentos.data, colturas.nome AS coltura,attrezzos.nome AS attrezzo FROM Gestione_development.trattamentos,attrezzos,colturas WHERE trattamentos.id=".$_GET['ID']."  AND trattamentos.id_attrezzo=attrezzos.id AND trattamentos.id_coltura=colturas.id";
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

    <title>Hello, world!</title>
  </head>
  <body>
    <h1>Trattamento </h1>

<?php
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. "</br>Data: ". date("d-m-Y",strtotime($row["data"]))." </br>Coltura: ". $row["coltura"]."</br>Attrezzo: ". $row["attrezzo"]."<br>";
    }
} else {
    echo "0 results";
}

$sql = "SELECT operaziones.nome FROM operaziones,operazione_trattamentos WHERE operazione_trattamentos.id_trattamento=".$_GET['ID']." AND operaziones.id=operazione_trattamentos.id_operazione";
$result = $conn->query($sql);
echo "Operazioni: ";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "". $row["nome"].",";
    }
} else {
    echo "0 results";
}


$sql = "SELECT prodottos.nome FROM prodottos,prodotto_trattamentos  WHERE prodotto_trattamentos.id_trattamento=".$_GET['ID']."   AND prodottos.id=prodotto_trattamentos.id_prodotto";
$result = $conn->query($sql);
echo "<br>Prodotti: ";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "". $row["nome"].",";
    }
} else {
    echo "0 results";
}
?>
<br><a href="getTrattamenti.php" class="btn btn-primary" role="button">Indietro</a>








<?php

$conn->close();

?>
       
  <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>


