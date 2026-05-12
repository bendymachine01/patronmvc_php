<?php
// Iniciamos la sesión
session_start();

// Guardamos datos
$_SESSION["usuario"] = "Juan Perez";
$_SESSION["rol"] = "Administrador";

echo "Sesión iniciada. Hemos guardado tu nombre.";
?>
<br>
<a href="pagina2.php">Ir a la siguiente página</a>


<?php
// Recuperar la sesión
session_start();

if (isset($_SESSION["usuario"])) {
    echo "Bienvenido de nuevo, " . $_SESSION["usuario"];
    echo "<br>Tu rango es: " . $_SESSION["rol"];
} else {
    echo "No has iniciado sesión.";
}
?>


<?php
// Cerrar la sesión
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión por completo
session_destroy();

echo "Has cerrado sesión correctamente.";
?>