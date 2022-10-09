<?php
include '../index.php';

if(isset($_GET['id'])) {
  $id = $_GET["id"];

  $sql = "SELECT * FROM products WHERE id = $id";
  $result = $conn -> query($sql);
  $product = $result -> fetch_assoc();  
  $result -> free_result();

  // UPDATE PRODUCT
  if(isset($_POST) && !empty($_POST))
  {    
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $category_id = $_POST['category_id'];

    $sql = "UPDATE products
    SET name = '$name', brand = '$brand', size = '$size', color = '$color', category_id = $category_id
    WHERE id = $id
    ";

    if (mysqli_query($conn, $sql)) {
      // se podria tirar una alerta o algo
      header("Location: /views/armario.php");
    } else {
      // Mostrar error en pantalla
      // echo "Error: " . $sql . ":-" . mysqli_error($conn);
    }
  } 
} else {
// ADD NEW PRODUCT
if(isset($_POST) && !empty($_POST))
{    
  $name = $_POST['name'];
  $brand = $_POST['brand'];
  $size = $_POST['size'];
  $color = $_POST['color'];
  $category_id = $_POST['category_id'];

  $sql = "INSERT INTO products (name, brand, size, category_id, color, user_id) 
  VALUES ('$name', '$brand', '$size', $category_id, '$color', {$user['id']})";
  
  if (mysqli_query($conn, $sql)) {
    // se podria tirar una alerta o algo
    header("Location: /views/armario.php");
  } else {
    // Mostrar error en pantalla
    // echo "Error: " . $sql . ":-" . mysqli_error($conn);
  }
}

}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
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
          <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="<?php if($product) echo "{$product['name']}";?>" id="name" name="name" type="text" placeholder="Escriba el nombre de su prenda">
        </div>
        <div class="mb-4">
          <label class="block text-gray-400 mb-2" for="brand">
            Marca
          </label>
          <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="<?php if($product) echo "{$product['brand']}";?>" id="brand" name="brand" type="text" placeholder="Cuál es su marca?">
        </div>
        <div class="mb-4">
          <label class="block text-gray-400 mb-2" for="size">
            Talle
          </label>
          <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="<?php if($product) echo "{$product['size']}";?>" id="size" name="size" type="text" placeholder="Cuál es su talle?">
        </div>
        <div class="mb-4">
          <label class="block text-gray-400 mb-2" for="color">
            Color
          </label>
          <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="<?php if($product) echo "{$product['color']}";?>" id="color" name="color" type="text" placeholder="Cuál es su color?">
        </div>
        <div class="mb-4">
          <label class="block text-gray-400 mb-2" for="category">
            Categoría
          </label>
          <select id="categories" name='category_id' class="bg-gray-700 text-sm rounded-lg block w-full py-2 px-3 focus:outline-none">
            <option disabled selected value>Seleccione una categoría</option>
            <?php 
              $query = mysqli_query($conn, "SELECT * FROM categories")
              or die (mysqli_error($conn));

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
        <input type='submit' class='bg-rose-600 px-3 py-2 rounded mt-4' onclick='save()' value='Guardar' />
      </form>

  </div>
</body>
</html>

<script>
  function back() {
    document.location = '/views/armario.php';
  }
  function save() {
    console.log('save');
    // document.form.submit();
  }
  function editUser() {
    document.location = '/views/update-user.php'
  }
</script>