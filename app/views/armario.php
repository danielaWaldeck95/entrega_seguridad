<?php 
include '../index.php';

if(isset($_GET['del'])) {
    $user_id = $_SESSION['user'];
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "DELETE FROM products WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
   
    $id = $_GET["del"];

    mysqli_stmt_execute($stmt);
   
    mysqli_stmt_close($stmt);
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
  <div class="bg-gray-800 p-8 flex items-start justify-between">
    <div>
        <div class="text-5xl font-bold">Bienvenid@!</div>
        <div class="text-gray-400">Aquí esta tu armario. Todas tus prendas en un mismo sitio</div>
    </div>
    <div class="flex items-center space-x-4">
        <div class="cursor-pointer" onclick="editUser()"><?php echo"{$user['full_name']}"?></div>
        <a href="/views/logout.php" class='fa fa-sign-out fa-lg cursor-pointer' aria-hidden='true'></a>
    </div>

  </div>
<div class="bg-gray-900 min-h-screen p-8">
    <?php
    $query = mysqli_query($conn, "SELECT DISTINCT c.name as 'category_name', c.id as 'category_id' FROM categories c, products p WHERE p.category_id = c.id AND p.user_id = {$user['id']}")
    or die;
    if(mysqli_num_rows($query) <= 0) {
        // Empty State
        echo"
        <div class='text-lg text-center text-gray-400 mt-10 mb-2'>No tienes prendas en tu armario aun.</div>
        <div class='text-lg text-center text-gray-400'>
            Haz click <span class='text-2xl text-rose-600 cursor-pointer hover:opacity-80' onclick='createProduct()'>aquí</span> para añadir una prenda!
        </div>
    ";
    }
    else {
        while ($row = mysqli_fetch_array($query)) {
                echo"
                    <div class='text-2xl mb-4'>{$row['category_name']}</div>
                    <div class='flex flex-wrap mb-4'>
                ";
                $newQuery = mysqli_query($conn, "SELECT * FROM products WHERE user_id = {$user['id']} AND category_id = {$row['category_id']}")
                    or die;
                    while ($row = mysqli_fetch_array($newQuery)) {
                            echo
                            "<div class='overflow-hidden w-64 mr-4 mb-4'>
                                <img class='object-cover rounded-xl h-48 w-96 mb-2' src='/shared/default.png' alt=''>
                                <div class='flex justify-between items-center text-gray-300 px-1'>
                                    <div>
                                        <div>{$row['brand']}</div>
                                        <div class='text-xs'>Talle {$row['size']}</div>
                                    </div>
                                    <div class='flex space-x-4'>
                                        <i class='fa fa-pencil fa-lg cursor-pointer' onclick='updateProduct({$row['id']})' aria-hidden='true'></i>
                                        <i class='fa fa-trash fa-lg cursor-pointer' onclick='deleteProduct({$row['id']})' aria-hidden='true'></i>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                echo "
                    </div>
                ";
        }
    }
    ?>
    <div class="bg-rose-600 rounded-full p-6 h-6 w-6 flex items-center justify-center cursor-pointer fixed right-10 bottom-10 hover:opacity-80" onclick="createProduct()">
        <i class="fa fa-plus fa-lg cursor-pointer" aria-hidden="true"></i>
    </div>
</div>
</body>
</html>

<script>
function deleteProduct($id) {
  if (window.confirm('Seguro quieres eliminar este elemento?')) {
    document.location = '/views/armario.php?del=' + $id
  }
}
function updateProduct($id) {
    document.location = '/views/create-or-update-product.php?id=' + $id;
}
function createProduct() {
    document.location = '/views/create-or-update-product.php';
}
function editUser() {
    document.location = '/views/update-user.php'
}
</script>
