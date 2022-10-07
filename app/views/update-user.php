<?php 
include '../index.php';

if(isset($_POST))
{    
     $full_name = $_POST['full_name'];
     $user_name = $_POST['user_name'];
     $email = $_POST['email'];
     $phone = $_POST['phone'];
     $birth_date = $_POST['birth_date'];
     $password = $_POST['password'];
     $dni = $_POST['dni'];
     $sql = "UPDATE users
     SET full_name = '$full_name', dni = '$dni', birth_date = '$birth_date', phone = $phone, email = '$email', password = '$password', user_name = '$user_name'
     WHERE id = {$user['id']}
     ";
     if (mysqli_query($conn, $sql)) {
        // se podria tirar una alerta o algo
        require __DIR__ . '/armario.php';
     } else {
        // Mostrar error en pantalla
        // echo "Error: " . $sql . ":-" . mysqli_error($conn);
     }
     mysqli_close($conn);
}


?>
<!doctype html>
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
      <div class="text-5xl font-bold"><?php if($user) echo "Modificar datos del usuario"; else echo "Registrarse"; ?></div>
    </div>
    <?php if($user) echo "
        <div class='flex items-center space-x-4'>
          <div class='cursor-pointer'>{$user['full_name']}</div>
          <a href='/views/logout.php' class='fa fa-sign-out fa-lg cursor-pointer' aria-hidden='true'></a>
        </div>
    "; ?>
  </div>
  <div class="bg-gray-900 min-h-screen p-10 ">
    <form action="" method="POST" id="form" class="w-3/4">
      <label class="block text-gray-400 mb-2" for="full_name">
        Nombre y Apellido
      </label>
      <div class="mb-3">
        <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="full_name" name="full_name" type="text" placeholder="Nombre" value="<?php if($user) echo "{$user['full_name']}";?>" >
        <p id="full_name_error" class="hidden text-rose-600 text-xs">Los caracteres deben ser alfabéticos</p>
      </div>

      <label class="block text-gray-400 mb-2" for="birth_date">
        Fecha de Nacimiento
      </label>
      <div class="mb-3">
        <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="birth_date" name="birth_date" type="date" value="<?php if($user) echo "{$user['birth_date']}";?>" >
        <p id="birth_date_error" class="hidden text-rose-600 text-xs">La fecha de nacimiento no puede ser mayor a la fecha actual</p>
      </div>


      <div class="flex flex-wrap -mx-3 mb-3">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <label class="block text-gray-400 mb-2" for="name">
            DNI
          </label>
          <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="dni" name="dni" type="text" placeholder="DNI" value="<?php if($user) echo "{$user['dni']}";?>" >
          <p id="dni_error" class="hidden text-rose-600 text-xs">El formato debe ser del tipo 11111111-Z y la letra debe verificar los números</p>
        </div>
        <div class="w-full md:w-1/2 px-3">
          <label class="block text-gray-400 mb-2" for="phoneNumber">
            Teléfono
          </label>
          <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="phone" name="phone" type="text" placeholder="Teléfono" value="<?php if($user) echo "{$user['phone']}";?>" >
          <p id="phone_error" class="hidden text-rose-600 text-xs">El teléfono debe tener 9 digitos</p>
        </div>
      </div>
      <div class="flex flex-wrap -mx-3">
        <div class="w-full px-3">
          <label class="block text-gray-400 mb-2" for="email">
              Email
          </label>
          <div class="mb-3">
            <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" placeholder="Email" value="<?php if($user) echo "{$user['email']}";?>" >
            <p id="email_error" class="hidden text-rose-600 text-xs">El formato de email debe ser del tipo example@test.com</p>
          </div>
        </div>
      </div>
      <div class="flex flex-wrap -mx-3">
        <div class="w-full px-3">
          <label class="block text-gray-400 mb-2" for="user_name">
            Nombre de Usuario
          </label>
          <div class="mb-3">
            <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="user_name" name="user_name" type="text" placeholder="Usuario" value="<?php if($user) echo "{$user['user_name']}";?>" >
            <p id="user_name_error" class="hidden text-rose-600 text-xs">Debe ingresar un nombre de usuario</p>
          </div>
        </div>
      </div>
      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <label class="block text-gray-400 mb-2" for="password">
            Contraseña
          </label>
          <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" value="<?php if($user) echo "{$user['password']}";?>" >
        </div>
        <div class="w-full md:w-1/2 px-3">
          <label class="block text-gray-400 mb-2" for="confirm_password">
            Repetir contraseña
          </label>
          <input class="bg-gray-700 text-sm appearance-none rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="confirm_password" type="password" value="<?php if($user) echo "{$user['password']}";?>">
        </div>
        <p id="password_error" class="hidden px-3 text-rose-600 text-xs">Las contraseñas no coinciden</p>
      </div>
      <div>
        <input type="button" onclick="update()" name="btnSubmit" value="Guardar" class="cursor-pointer bg-rose-600 px-3 py-2 rounded mt-4"/>
      </div>
    </form>
    </div>
  </body>
</html>

<script>
  function update() {
    if(validateForm()) {
      document.getElementById("form").submit();
    }
  }

  function validateForm() {
    errors = ['full_name_error', 'dni_error', 'phone_error', 'email_error', 'birth_date_error', 'password_error', 'user_name_error'];
    errors.forEach(error => {
      document.getElementById(error).classList.add('hidden');
      document.getElementById(error).classList.remove('block');
    });
    if(!validateFullName() || !validateDNI() || !validatePhone() || !validateEmail() || !validateBirthDate() || !validatePassword() || !validateUserName()) {
      return false
    }
    return true;
  }

  function validateUserName() {
    let userName = document.getElementById("user_name").value;
    if (userName == '') {
      document.getElementById("user_name_error").classList.add('block');
      document.getElementById("user_name_error").classList.remove('hidden');
      return false;
    }
    return true;
  }

  function validatePassword() {
    let password = document.getElementById("password").value;
    let confirmation = document.getElementById("confirm_password").value;
    if (password == '' || password !== confirmation) {
      document.getElementById("password_error").classList.add('block');
      document.getElementById("password_error").classList.remove('hidden');
      return false;
    }
    return true;
  }

  function validateBirthDate() {
    let birthDate = document.getElementById("birth_date").value;
    if (birthDate == '' || !validBirthDate(birthDate)) {
      document.getElementById("birth_date_error").classList.add('block');
      document.getElementById("birth_date_error").classList.remove('hidden');
      return false;
    }
    return true;
  }

  function validateEmail() {
    let email = document.getElementById("email").value;
    if (email == '' || !validEmail(email)) {
      document.getElementById("email_error").classList.add('block');
      document.getElementById("email_error").classList.remove('hidden');
      return false;
    }
    return true;
  }

  function validatePhone() {
    let phone = document.getElementById("phone").value;
    if (phone == '' || !validPhone(phone)) {
      document.getElementById("phone_error").classList.add('block');
      document.getElementById("phone_error").classList.remove('hidden');
      return false;
    }
    return true;
  }

  function validateDNI() {
    let dni = document.getElementById("dni").value;
    if (dni == '' || !validDNI(dni)) {
      document.getElementById("dni_error").classList.add('block');
      document.getElementById("dni_error").classList.remove('hidden');
      return false;
    }
    return true;
  }

  function validateFullName() {
    let fullName = document.getElementById("full_name").value;
    if (fullName == '' || !validFullName(fullName)) {
      document.getElementById("full_name_error").classList.add('block');
      document.getElementById("full_name_error").classList.remove('hidden');
      return false;
    }
    return true;
  }

  function validBirthDate(bday) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    return new Date(bday) < today;
  }

  function validEmail(email) {
    var pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return email.toLowerCase().match(pattern);
  }

  function validPhone(num) {
    var pattern = /^\d{9}$/;
    return num.match(pattern);
  }

  function validDNI(dni) {
    dni = dni.replace("-",'')
    var num, v, letter, regexpresion
    var regexpresion = /^\d{8}[a-zA-Z]$/;
  
    if(!regexpresion.test (dni)) return false;
    num = dni.substr(0,dni.length-1);
    v = dni.substr(dni.length-1,1);
    num = num % 23;
    letter='TRWAGMYFPDXBNJZSQVHLCKET';
    letter=letter.substring(num,num+1);
    return letter==v.toUpperCase();
  }
  
  function validFullName(str)
  {
   var regexpresion =  /^[a-zA-Z\s]*$/;  
   return regexpresion.test(str);
  }
</script>