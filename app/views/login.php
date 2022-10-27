<?php
include '../config.php';
session_start();

// If user is already logged he cannot access login page
if(isset($_SESSION['user'])){
    header("Location: /views/armario.php");
}

// Submit login form
if(isset($_POST['submit']))
{    

    $username = $_POST['user_name'];
    $pw = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE user_name = '$username'";
    $result = $conn -> query($sql);
    $user = $result -> fetch_assoc();

    if($pw == $user['password'])
    {    
        session_start();
        $_SESSION['user'] = $user['id'];
        header("Location: /views/armario.php");
    } else {
        // Set error
        $_SESSION["Login.Error"] = "Nombre de usuario o contraseña incorrectos";
    }
}

?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/tailwind.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="text-white h-screen flex justify-center items-center bg-gray-900 min-h-screen">
    <div class="w-full mx-auto bg-gray-800 rounded-lg shadow-xl md:mt-0 sm:max-w-md xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold md:text-2xl flex flex-col justify-center items-center">
                Iniciar sesión
            </h1>
            <form class="space-y-4 md:space-y-6" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                <div>
                    <label for="userName" class="text-lg font-medium">Usuario</label>
                    <input type="text" name="user_name" id="userNameLogIn" class="rounded-lg w-full mt-2 p-2.5 bg-gray-700 text-sm appearance-none focus:outline-none focus:shadow-outline" placeholder="Ingrese su nombre de usuario" required="">
                </div>
                <div>
                    <label for="password" class="text-lg font-medium">Contraseña</label>
                    <input type="password" name="password" id="passwordLogIn" placeholder="Ingrese su contraseña" class="rounded-lg w-full mt-2 p-2.5 bg-gray-700 text-sm appearance-none focus:outline-none focus:shadow-outline" required="">
                </div>
                <p class="text-rose-600 text-xs"><?php if($_SESSION["Login.Error"]) echo "{$_SESSION['Login.Error']}"?></p>
                <input type="submit" name="submit" class="w-full text-white bg-gray-900 hover:bg-rose-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center" value="Sign in"/>
                <p class="text-sm font-light">
                    No tienes una cuenta? <a href="/views/register.php" class="font-medium text-rose-600 hover:underline">Registrate</a>
                </p>
            </form>
        </div>
    </div>
</body>

</html>