<?php
// 1. Leer la cookie actual. Si no existe, empezar en 0.
$visitas = isset($_COOKIE['contador']) ? $_COOKIE['contador'] : 0;

// 2. Sumar 1 a la visita actual.
$visitas++;

// 3. Guardar el nuevo valor en la cookie (dura 1 día).
setcookie("contador", $visitas, time() + 86400);
?>

<h1>Has visitado esta página <?php echo $visitas; ?> veces.</h1>
<p>Refresca la página (F5) para ver cómo aumenta.</p>