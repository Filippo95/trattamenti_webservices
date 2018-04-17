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

$sql = "SELECT prodottos.id as id,prodottos.nome as nome, prodottos.avversit as avversit, cat_prodottos.nome as cat_name, prodottos.principio_attivo FROM prodottos, cat_prodottos WHERE prodottos.id_cat=cat_prodottos.id;";
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
  <body>
        
  <?php include("header.php")?>
    <h1>Prodotti </h1>
	<table id="table" class="table-responsive">
	<thead>
	<th><ID</th>
	<th>Nome</th>
	<th>Avversità </th>

	<th>Categoria </th>
	
	<th>Principio Attivo </th>
	</thead>
	<tbody>
<?php
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr> <td>" . $row["id"]. "</td><td>". $row["nome"]." </td><td>". $row["avversit"]."</td><td>". $row["cat_name"]."</td><td>". $row["principio_attivo"]."</td></tr>";
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