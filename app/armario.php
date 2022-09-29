<?php 
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname,$username,$password,$db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
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
  <div class="bg-gray-800 p-8">
    <div class="text-5xl font-bold">Tu armario</div>
    <div class="text-gray-400">Toda tus prendas en un mismo sitio</div>
  </div>
<div class="bg-gray-900 min-h-screen p-8">
    <div class="text-2xl mb-4">Zapatos</div>
    <div class="flex flex-wrap mb-4">
    <?php 
    $query = mysqli_query($conn, "SELECT * FROM products WHERE user_id = 1")
    or die (mysqli_error($conn));
    while ($row = mysqli_fetch_array($query)) {
            echo
            "<div class='overflow-hidden w-64 mr-4 mb-4'>
                <img class='object-cover rounded-xl h-48 w-96 mb-2' src='https://static.nike.com/a/images/t_PDP_1280_v1/f_auto,q_auto:eco/nqawpuyunirt3l50lgc8/air-force-1-shadow-zapatillas-X47QLb.png' alt=''>
                <div class='flex justify-between items-center text-gray-300 px-1'>
                    <div>
                        <div>{$row['brand']}</div>
                        <div class='text-xs'>Talle {$row['size']}</div>
                    </div>
                    <div class='flex space-x-4'>
                        <i class='fa fa-pencil fa-lg cursor-pointer' aria-hidden='true'></i>
                        <i class='fa fa-trash fa-lg cursor-pointer' onclick='myFunction()' aria-hidden='true'></i>
                    </div>
                </div>
            </div>
            ";
        }
    ?>
    </div>
    <div class="text-xl mb-4">Camisetas</div>
    <div class="flex flex-wrap mb-4">
        <div class="overflow-hidden w-64 mr-4 mb-4">
            <img class="object-cover rounded-xl h-48 w-96 mb-2" src="https://image.goxip.com/NEmIM8B71maPCXX3rN23qeXTNeg=/fit-in/500x500/filters:format(jpg):quality(80):fill(white)/https:%2F%2Fassetsprx.matchesfashion.com%2Fimg%2Fproduct%2F500%2F1420251_1.jpg" alt="">
            <div class="flex justify-between items-center text-gray-300 px-1">
                <div>
                    <div>Balenciaga</div>
                    <div class="text-xs">Talle M</div>
                </div>
                <div class="flex space-x-4">
                    <i class="fa fa-pencil fa-lg cursor-pointer" aria-hidden="true"></i>
                    <i class="fa fa-trash fa-lg cursor-pointer" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-rose-600 rounded-full p-6 h-6 w-6 flex items-center justify-center cursor-pointer fixed right-10 bottom-10">
        <i class="fa fa-plus fa-lg cursor-pointer" aria-hidden="true"></i>
    </div>
</div>
</body>
</html>

<script>
function myFunction() {
  window.confirm('seguro quieres eliminar este elemento?');
}
</script>
