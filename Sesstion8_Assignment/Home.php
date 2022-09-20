<?php
$connection = new mysqli('localhost','root','','codeweekend');
$query= " SELECT * FROM products ";
$result = $connection->query($query);
$Products =$result->fetch_all(MYSQLI_ASSOC);
// var_dump($date);
// exit; 
?>
<style> 

td img{
	width: 100px;
}
</style>


<table border="1">
<thead>
	<tr>
<th>id</th>
<th>Name</th>
<th>Price</th>
<th>Expiar_Date</th>
<th>Image</th>
<th>CRUD</th>
</tr>
</thead>

<tbody>
   
	<?php
	  $i = 1;
	foreach ($Products as $product) {
		

		//Name, Price, Expiar_Date, Image
echo "<tr>
<td>". $i++ ."</td>
<td>". $product['Name']."</td>
<td>". $product['Price']."</td>
<td>". $product['Expiar_Date']."</td>
<td>

<img src='Storage/Product/{$product['image']}'/>
</td>
<td><a href='Home.php?edit_id={$product['id']}'>Edit</a>
<a href='product_controller.php ?delete_id={$product['id']}'>Delet </a>


</td>

</tr>";


	 }?>
</tbody>

</table>
</br>
</br>

<?php
$edit_product=null;
if(isset($_GET['edit_id'])){

	$id=$_GET['edit_id'];
	// GET ID Dymicly
	$select_Product_query="SELECT * FROM products WHERE ID=${id}";
	//die($select_Product_query);
	$Products_Result=$connection->query($select_Product_query);
	// Fetch_assoc in fetch a single record
	$edit_product=$Products_Result->fetch_assoc();

}

?>

<form action="product_controller.php" method="post" enctype="multipart/form-data">

	<input type="hidden" name="id" value="<?php echo( $edit_product) ? $edit_product['id']:' '?>">
	<table>
		<tr>
			<td>Name</td>
			<td>
				<!-- to Show data in from from database when we want to edit -->
				<input type="text" name="Name" value="<?php echo ($edit_product)? $edit_product['Name']:' '?>" >
			</td>
		</tr>

		<tr>
			<td>Price</td>
			<td>
				<input type="number" name="Price" value="<?php echo($edit_product)? $edit_product['Price']:'' ?>" >
			</td>
		</tr>

		<tr>
			<td>Expiry Date</td>
			<td>
				<input type="date" name="expiry_date" value="<?php echo($edit_product)? $edit_product['Expiar_Date']:'' ?>" >
			</td>
		</tr>

		<tr>
			<td>Image</td>
			<td>
				<input type="file" name="image" >
				<?php if ($edit_product){  ?>
				<br>
				
				<img src="Storage/Product/<?php echo $edit_product['image'] ?>" alt="">
				<?php } ?>
			</td>
		</tr>

		<tr>
			<td>
				<!-- Controll the Sumit button to whene it shold be save and when it shold be update -->
			
				<button type="submit" name="<?php if(isset($edit_product))echo'update_product';else echo 'insert_product';?>">Save</button>

				<a href="Home.php"> Cancel</a>
			</td>
		</tr>
	</table>

</form>