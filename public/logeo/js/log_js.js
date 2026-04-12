document.addEventListener("DOMContentLoaded", () => {
  const togglePassword = document.getElementById("togglePassword");
  const password = document.getElementById("password");
  const username = document.getElementById("username");
  const form = document.getElementById("loginForm");

  // Mostrar u ocultar contraseña
  togglePassword.addEventListener("click", () => {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    
    // Cambiar ícono
    togglePassword.classList.toggle("fa-eye");
    togglePassword.classList.toggle("fa-eye-slash");
  });

  // Regex más flexibles y realistas
  const emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
  // Formato más específico pero no tan restrictivo:
  // const emailRegex = /^[A-Z]\d{8}@[\w]+\.[\w.]+$/;
  
  const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

  // Funciones para mostrar error o éxito
  function setError(input, message) {
    const container = input.parentElement;
    const errorMessage = container.querySelector('.error-message');
    
    input.classList.add("error");
    input.classList.remove("success");
    errorMessage.textContent = message;
  }

  function setSuccess(input) {
    const container = input.parentElement;
    const errorMessage = container.querySelector('.error-message');
    
    input.classList.add("success");
    input.classList.remove("error");
    errorMessage.textContent = "";
  }

  // Validación en tiempo real
  username.addEventListener('input', validateEmail);
  password.addEventListener('input', validatePassword);

  function validateEmail() {
    const value = username.value.trim();
    
    if (value === '') {
      setError(username, "El correo es requerido");
      return false;
    }
    
    if (!emailRegex.test(value)) {
      setError(username, "Formato de correo inválido");
      return false;
    }
    
    setSuccess(username);
    return true;
  }

  function validatePassword() {
    const value = password.value;
    
    if (value === '') {
      setError(password, "La contraseña es requerida");
      return false;
    }
    
    if (!passwordRegex.test(value)) {
      setError(password, "Mínimo 8 caracteres");
      return false;
    }
    
    setSuccess(password);
    return true;
  }

  // Validación al enviar
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const isEmailValid = validateEmail();
    const isPasswordValid = validatePassword();

    if (isEmailValid && isPasswordValid) {
      // Aquí puedes enviar el formulario
      console.log("Formulario válido, enviando...");
      alert("Inicio de sesión exitoso!");
      
      // Para enviar realmente el formulario:
      // form.submit();
    }
  });
});