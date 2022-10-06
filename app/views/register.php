<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="text-white h-screen flex justify-center items-center">
    <form name="form" class="w-full mx-auto bg-white rounded-lg shadow md:mt-0 sm:max-w-md p-10">
        <h1 class="text-xl font-bold text-gray-900 md:text-2xl flex flex-col justify-center items-center pb-3">
            Registrarse
        </h1>
        <!-- <div class="flex flex-wrap -mx-3 mb-0"> -->
        <label class="text-base font-medium text-gray-800" for="full_name">
          Nombre y Apellido
        </label>
        <div class="mb-3">
          <input class="appearance-none block w-full bg-gray-200 text-gray-800 focus:text-white border-lg rounded-lg py-3 px-4 leading-tight focus:outline-none focus:bg-gray-800" id="full_name" type="text" placeholder="Nombre">
          <p id="full_name_error" class="hidden text-rose-600 text-xs">Los caracteres deben ser alfabéticos</p>
        </div>

        <label class="text-base font-medium text-gray-800" for="birth_date">
          Fecha de Nacimiento
        </label>
        <div class="mb-3">
          <input class="appearance-none block w-full bg-gray-200 text-gray-800 focus:text-white border-lg rounded-lg py-3 px-4 leading-tight focus:outline-none focus:bg-gray-800" id="birth_date" type="date">
          <p id="birth_date_error" class="hidden text-rose-600 text-xs">La fecha de nacimiento no puede ser mayor a la fecha actual</p>
        </div>


        <div class="flex flex-wrap -mx-3 mb-3">
          <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <label class="text-base font-medium text-gray-800" for="name">
              DNI
            </label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-800 focus:text-white border border-gray-200 rounded-lg py-3 px-4 leading-tight focus:outline-none focus:bg-gray-800 focus:border-gray-500" id="dni" type="text" placeholder="DNI">
            <p id="dni_error" class="hidden text-rose-600 text-xs">El formato debe ser del tipo 11111111-Z y la letra debe verificar los números</p>
          </div>
          <div class="w-full md:w-1/2 px-3">
            <label class="text-base font-medium text-gray-800" for="phoneNumber">
              Teléfono
            </label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-800 focus:text-white border border-gray-200 rounded-lg py-3 px-4 leading-tight focus:outline-none focus:bg-gray-800 focus:border-gray-500" id="phone" type="text" placeholder="Teléfono">
            <p id="phone_error" class="hidden text-rose-600 text-xs">El teléfono debe tener 9 digitos</p>
          </div>
        </div>
        <div class="flex flex-wrap -mx-3">
          <div class="w-full px-3">
            <label class="text-base font-medium text-gray-800" for="email">
                Email
            </label>
            <div class="mb-3">
              <input class="appearance-none block w-full bg-gray-200 text-gray-800 focus:text-white border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-gray-800 focus:border-gray-500" id="email" type="email" placeholder="Email">
              <p id="email_error" class="hidden text-rose-600 text-xs">El formato de email debe ser del tipo example@test.com</p>
            </div>
          </div>
        </div>
        <div class="flex flex-wrap -mx-3">
            <div class="w-full px-3">
              <label class="text-base font-medium text-gray-800" for="user_name">
                Nombre de Usuario
              </label>
              <div class="mb-3">
                <input class="appearance-none block w-full bg-gray-200 text-gray-800 focus:text-white border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-gray-800 focus:border-gray-500" id="user_name" type="text" placeholder="Usuario">
                <p id="user_name_error" class="hidden text-rose-600 text-xs">Debe ingresar un nombre de usuario</p>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="text-base font-medium text-gray-800" for="password">
                Contraseña
              </label>
              <input class="appearance-none block w-full bg-gray-200 text-gray-800 focus:text-white border border-gray-200 rounded-lg py-3 px-4 leading-tight focus:outline-none focus:bg-gray-800 focus:border-gray-500" id="password" type="password">
            </div>
            <div class="w-full md:w-1/2 px-3">
              <label class="text-base font-medium text-gray-800" for="confirm_password">
                Repetir contraseña
              </label>
              <input class="appearance-none block w-full bg-gray-200 text-gray-800 focus:text-white border border-gray-200 rounded-lg py-3 px-4 leading-tight focus:outline-none focus:bg-gray-800 focus:border-gray-500" id="confirm_password" type="password">
            </div>
            <p id="password_error" class="hidden px-3 text-rose-600 text-xs">Las contraseñas no coinciden</p>
          </div>
        <div>
            <input type="button" value="Registrarse" onclick="register()" class="cursor-pointer w-full text-white bg-gray-800 hover:bg-primary-700 font-medium rounded-lg text-sm px-5 py-3 text-center"/>
        </div>
      </form>
</body>
</html>

<script>
  function register() {
    if(validateForm()) {
      console.log('register')
      document.form.submit();
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