<?php 
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname,$username,$password,$db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$id = $_GET["id"];

if($id) {
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn -> query($sql);

    $product = $result -> fetch_assoc();
    
    // $result -> free_result();

    // $conn -> close();
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
    <i class='fa fa-sign-out fa-lg cursor-pointer' onclick='logout()' aria-hidden='true'></i>
  </div>
<div class="bg-gray-900 min-h-screen p-8">
    <form action="" class="w-1/2">
      <div class="mb-4">
        <label class="block text-gray-400 mb-2" for="name">
          Nombre
        </label>
        <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="<?php if($product) echo "{$product['name']}";?>" id="name" type="text" placeholder="Escriba el nombre de su prenda">
      </div>
      <div class="mb-4">
        <label class="block text-gray-400 mb-2" for="brand">
          Marca
        </label>
        <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="<?php if($product) echo "{$product['brand']}";?>" id="brand" type="text" placeholder="Cuál es su marca?">
      </div>
      <div class="mb-4">
        <label class="block text-gray-400 mb-2" for="size">
          Talle
        </label>
        <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="<?php if($product) echo "{$product['size']}";?>" id="size" type="text" placeholder="Cuál es su talle?">
      </div>
      <div class="mb-4">
        <label class="block text-gray-400 mb-2" for="color">
          Color
        </label>
        <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="<?php if($product) echo "{$product['color']}";?>" id="color" type="text" placeholder="Cuál es su color?">
      </div>
      <div class="mb-4">
        <label class="block text-gray-400 mb-2" for="category">
          Categoría
        </label>
        <select id="categories" class="bg-gray-700 text-sm rounded-lg block w-full py-2 px-3 focus:outline-none">
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
    </form>
    <?php
    echo "
     <button class='bg-rose-600 px-3 py-2 rounded mt-4' onClick='save({$product})'>Guardar</button>
    ";
    ?>
</div>
</body>
</html>

<script>
  function back() {
    document.location = '/views/armario.php';
  }
  function save($isUpdate) {
    if($isUpdate) {
      console.log('update');
      document.location = '/views/armario.php'
    } else {
    $product = document.getElementById('name').value;
    window.alert('El producto '+ $product +' se ha agregado correctamente')
    document.location = '/views/armario.php'
    }
  }
</script>