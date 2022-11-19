<?php
include '../index.php';

$lastUpdate = $user['password_update'];
$dateNow = date("Y-m-d H:i:s");
$dateDifference = abs(strtotime($dateNow) - strtotime($lastUpdate));
$years  = floor($dateDifference / (365 * 60 * 60 * 24));
$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
if($years >=1 or $months>=1){
    header("Location: /views/reset-password.php");
}

if(isset($_GET['id'])) {
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, "SELECT * FROM products WHERE id=?");
  mysqli_stmt_bind_param($stmt, "i", $id);

  $id = $_GET["id"];

  $result = mysqli_stmt_execute($stmt);
  
  if ($result) {
    $stmtResult = $stmt->get_result();
    $product = $stmtResult->fetch_array();
  }


  if ($product['user_id'] != $user_id)
  {
    header("Location: /views/access-denied.php");
  }
  
  // UPDATE PRODUCT
  if(isset($_POST) && !empty($_POST))
  {    
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "UPDATE products
    SET name=?, brand=? , size=?, color=?, category_id=?
    WHERE id=?
    ");
    mysqli_stmt_bind_param($stmt, "ssssii", $name, $brand, $size, $color, $category_id, $id);
   
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $category_id = $_POST['category_id'];
  
    $result = mysqli_stmt_execute($stmt);
  
    if ($result) {
      // Redirect after successful update
      header("Location: /views/armario.php");
    } else {
      // Set error
      $_SESSION["createOrUpdateProduct.Error"] = 'Hubo un inconveniente al procesar sus cambios, inténtalo nuevamente';
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  } 
} else {
// ADD NEW PRODUCT
if(isset($_POST) && !empty($_POST))
{    
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, "INSERT INTO products (name, brand, size, category_id, color, user_id) 
  VALUES (?, ?, ?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt, "sssisi", $name, $brand, $size, $category_id, $color, $user_id);
 
  $name = $_POST['name'];
  $brand = $_POST['brand'];
  $size = $_POST['size'];
  $color = $_POST['color'];
  $category_id = $_POST['category_id'];
  $user_id = $user['id'];

  $result = mysqli_stmt_execute($stmt);

  if ($result) {
    // Redirect after successful insert
    header("Location: /views/armario.php");
  } else {
    // Set error
    $_SESSION["createOrUpdateProduct.Error"] = 'Hubo un inconveniente al guardar sus cambios, inténtalo nuevamente';
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}

}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link  href="/tailwind.css" rel="stylesheet" >
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="text-white">
  <div class="bg-gray-800 p-8 flex justify-between items-start">
    <div> 
      <i class="fa fa-chevron-left fa-lg cursor-pointer mb-4" aria-hidden="true" onClick="back()"></i>
      <div class="text-5xl font-bold"><?php if($product) echo "Editar {$product['name']}"; else echo "Nueva Prenda"; ?></div>
      <div class="text-gray-400"><?php if($product) echo "Editar tu y guarda los cambios en tu armario"; else echo "Agrega una nueva prenda a tu armario"; ?></div>
    </div>
    <div class="flex items-center space-x-4">
        <div class="cursor-pointer" onclick="editUser()"><?php echo"{$user['full_name']}"?></div>
        <a href="/views/logout.php" class='fa fa-sign-out fa-lg cursor-pointer' aria-hidden='true'></a>
    </div>
  </div>
  <div class="bg-gray-900 min-h-screen p-8">
  <!-- ../insert-product.php -->
      <form action="" method="POST" class="w-1/2" id="form" name="form">
        <div class="mb-4">
          <label class="block text-gray-400 mb-2" for="name">
            Nombre
          </label>
          <input required class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="<?php if($product) echo "{$product['name']}";?>" id="name" name="name" type="text" placeholder="Escriba el nombre de su prenda">
        </div>
        <div class="mb-4">
          <label class="block text-gray-400 mb-2" for="brand">
            Marca
          </label>
          <input required class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="<?php if($product) echo "{$product['brand']}";?>" id="brand" name="brand" type="text" placeholder="Cuál es su marca?">
        </div>
        <div class="mb-4">
          <label class="block text-gray-400 mb-2" for="size">
            Talle
          </label>
          <input required class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="<?php if($product) echo "{$product['size']}";?>" id="size" name="size" type="text" placeholder="Cuál es su talle?">
        </div>
        <div class="mb-4">
          <label class="block text-gray-400 mb-2" for="color">
            Color
          </label>
          <input required class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="<?php if($product) echo "{$product['color']}";?>" id="color" name="color" type="text" placeholder="Cuál es su color?">
        </div>
        <div class="mb-4">
          <label class="block text-gray-400 mb-2" for="category">
            Categoría
          </label>
          <select required id="categories" name='category_id' class="bg-gray-700 text-sm rounded-lg block w-full py-2 px-3 focus:outline-none">
            <option disabled selected value>Seleccione una categoría</option>
            <?php 
              $query = mysqli_query($conn, "SELECT * FROM categories")
              or die;

              while ($row = mysqli_fetch_array($query)) {
                  if($product['category_id']==htmlspecialchars($row['id']))
                  $selected=' selected';
                  else
                  $selected='';
                  
                  echo "
                  <option $selected value='{$row['id']}'>{$row['name']}</option>
                  ";
              }
            ?>
          </select>
        </div>
        <input required type='submit' class='bg-rose-600 px-3 py-2 rounded mt-4' value='Guardar' />
        <p class="mt-2 text-rose-600 text-xs"><?php if($_SESSION["createOrUpdateProduct.Error"]) echo "{$_SESSION['createOrUpdateProduct.Error']}"?></p>      
      </form>

  </div>
</body>
</html>

<script>
  function back() {
    document.location = '/views/armario.php';
  }
  function editUser() {
    document.location = '/views/update-user.php'
  }
</script>