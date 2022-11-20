<?php
    include '../index.php';

    if(isset($_POST['submit']))
    {   
        $_SESSION["Reset-Password.Error"] = "";
        $_SESSION["Different-Password.Error"] = '';
        
        $oldPw = $_POST['actual-password'];
        $pw = $_POST['newPassword'];
        $repeatPW = $_POST['repeat-password'];
        $equalPassword = password_verify($oldPw, $user['password']);
        $equalNewPassword = password_verify($pw, $user['password']);
        
        if($equalPassword){
            if($pw == $repeatPW or $repeatPW == ''){
                if($equalNewPassword){
                    $_SESSION["Different-Password.Error"] = 'La contrasena debe ser distinta a la anterior';
                }else{
                    $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt, "UPDATE users
                    SET full_name=?, dni=?, birth_date=?, phone=?, email=?, user_name=?, password_update = ?, password=?
                    WHERE id =?
                    ");
                    mysqli_stmt_bind_param($stmt, "sssissssi", $full_name, $dni, $birth_date, $phone, $email, $user_name, $date, $password,$id);
                    
                    $full_name = $user['full_name'];
                    $user_name = $user['user_name'];
                    $email = $user['email'];
                    $phone = $user['phone'];
                    $birth_date = $user['birth_date'];
                    $password = $user['password'];
                    $dni = $user['dni'];
                    $date = date("Y-m-d H:i:s");
                    $password = password_hash($pw, PASSWORD_BCRYPT);
                    $id = $user['id'];

                    $result = mysqli_stmt_execute($stmt);

                    if ($result) {
                    // Redirect after successful update
                        header("Location: /views/armario.php");
                    } else {
                    // Set error
                        $_SESSION["Reset-Password.Error"] = 'Hubo un inconveniente al procesar sus cambios, inténtalo nuevamente';
                    }
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                }
            }else{
                $_SESSION["Different-Password.Error"] = 'Las contrasenas no coinciden';
            }
        }else{
            $_SESSION["Reset-Password.Error"] = 'Contrasena incorrecta';
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
                Resetear Contraseña
            </h1>
            <form action="" method="POST" id="form" class="w-3/4">
                <div>
                    <label for="actual-password" class="text-lg font-medium">Contraseña actual</label>
                    <input type="password" name="actual-password" id="actual-password" placeholder="Ingrese su contraseña actual" class="rounded-lg w-full mt-2 p-2.5 bg-gray-700 text-sm appearance-none focus:outline-none focus:shadow-outline" required="">
                </div>
                <div>
                    <p id="password_incorrect" class="px-3 text-rose-600 text-xs"><?php if($_SESSION["Reset-Password.Error"]) echo "{$_SESSION['Reset-Password.Error']}"?></p>
                </div>
                <div>
                    <label for="password" class="text-lg font-medium">Nueva contraseña</label>
                    <input onkeyup="checkPasswordStrength()" type="password" name="newPassword" id="newPassword" placeholder="Ingrese su nueva contraseña" class="rounded-lg w-full mt-2 p-2.5 bg-gray-700 text-sm appearance-none focus:outline-none focus:shadow-outline" required="">
                </div>
                <div>
                    <label for="repeat-password" class="text-lg font-medium">Repetir Contraseña</label>
                    <input type="password" name="repeat-password" id="repeat-password" placeholder="Vuelva a escribir su contraseña" class="rounded-lg w-full mt-2 p-2.5 bg-gray-700 text-sm appearance-none focus:outline-none focus:shadow-outline" required="">
                </div>
                <div>
                    <p id="StrengthDisp" class="hidden px-3 text-xs text-gray-400 mt-2">Seguridad de la contraseña: <span id="StrengthDispValue">Weak</span></p>
                    <p id="password_error" class="px-3 text-rose-600 text-xs"><?php if($_SESSION["Different-Password.Error"]) echo "{$_SESSION['Different-Password.Error']}"?></p>
                </div>
                <br>
                <input type="submit" onclick="resetPassword()"name="submit" value="Guardar" class="cursor-pointer bg-rose-600 px-3 py-2 rounded my-4"/>
            </form>
        </div>
    </div>
</body>
<script>
    
    var weakPassword = true;
    function checkPasswordStrength() {
        let password = document.getElementById("newPassword").value;
        let strengthBadge = document.getElementById('StrengthDispValue');
        document.getElementById('StrengthDisp').style.display = 'block';
        let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})')
        let mediumPassword = new RegExp('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))')
        if(strongPassword.test(password)) {
        strengthBadge.style.color = "green";
        strengthBadge.textContent = 'Alta';
        weakPassword = false;
        } else if(mediumPassword.test(password)) {
        strengthBadge.style.color = 'yellow';
        strengthBadge.textContent = 'Media';
        weakPassword = false;
        } else {
        strengthBadge.style.color = 'red';
        strengthBadge.textContent = 'Baja';
        weakPassword = true;
        }
    }
    function resetPassword(){
        let passwordError = document.getElementById("password_error");
        if (weakPassword) {
            passwordError.classList.add('block');
            passwordError.classList.remove('hidden');
            passwordError.textContent = 'La contraseña es demasiado insegura. Asegúrate de que el largo de la misma sea mayor a 8 y que incluya una minúscula, una mayúscula, un dígito y un caracter especial'
            return false;
        }else{
            passwordError.classList.add('hidden');
            passwordError.classList.remove('block');
            return true;
        }
    }
</script>