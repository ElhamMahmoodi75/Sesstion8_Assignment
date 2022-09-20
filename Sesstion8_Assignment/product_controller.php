<?php
// DB Connetion 
$connection = new mysqli('localhost','root','','codeweekend');
if ($connection->connect_error){
    die('No DB Connection');

}


// insert Method

if (isset($_POST['insert_product'])){

$name= $_POST['Name'];
$Price= $_POST['Price'];
$Expariy_Date= $_POST['expiry_date'] ;

$image_File= $_FILES['image'];
$tmp_name=$image_File['tmp_name'];
$image_Name=$image_File['name'];
move_uploaded_file($tmp_name,'Storage/Product/'.$image_Name);
$query = " INSERT INTO products (Name, Price, Expiar_Date, image) VALUES ('$name', $Price, '$Expariy_Date','$image_Name')";
echo $query;
$connection->query($query);
header('location: Home.php');
}
// For Update data
else if (isset($_POST['update_product'])){
    $id=$_POST['id'];
    $name= $_POST['Name'];
    $Price= $_POST['Price'];
    $Expariy_Date= $_POST['expiry_date'] ;
// for upload a image and delete the provice image

    $image_query="SELECT  Image FROM products WHERE id=$id";
    $result=$connection->query($image_query);
    $Product_data=$result->fetch_assoc();
    $image_Name=$Product_data;

  
   if (isset($_FILES['image'])){
    unlink('Storage/Product/' . $image_Name);
    $image_File= $_FILES['image'];
    $tmp_name=$image_File['tmp_name'];
    $image_Name=$image_File['name'];
    move_uploaded_file($tmp_name,'Storage/Product/'.$image_Name);

   }
$query = " UPDATE  products SET Name='$name' , Price=$Price ,Expiar_Date='$Expariy_Date',image='$image_Name' WHERE id=$id";
echo($query);
$connection->query($query);

header('location: Home.php');
}
else if(isset($_GET['delete_id'])){
$id=$_GET['delete_id'];
$image_query="SELECT  Image FROM products WHERE id=$id";
    $result=$connection->query($image_query);
    $Product_data=$result->fetch_assoc();
    unlink('Storage/Product/' . $Product_data['Image']);
    $query="DELETE FROM  products WHERE id=$id";
    $connection->query($query);
    if ($connection->error){
        echo $connection->error;
    }
    header('location: Home.php');
}