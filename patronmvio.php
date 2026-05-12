<?php

// =======================
// MODELO
// =======================
function model_get_data($model) {
    return $model['data'];
}

function model_add_item(&$model, $item) {
    $model['data'][] = $item;

    // Notificar a los observers
    observers_notify($model, 'item_added', $item);
}

// =======================
// OBSERVERS
// =======================
function observers_register(&$model, $event, $callback) {
    $model['observers'][$event][] = $callback;
}

function observers_notify($model, $event, $payload) {
    if (!empty($model['observers'][$event])) {
        foreach ($model['observers'][$event] as $callback) {
            $callback($payload);
        }
    }
}

// =======================
// VISTA
// =======================
function view_render_list($items) {
    echo "<ul>";
    foreach ($items as $i => $item) {
        echo "<li>$i: $item</li>";
    }
    echo "</ul>";
}

// =======================
// USO DEL SISTEMA
// =======================

// Crear el modelo
$model = [
    'data' => [],
    'observers' => []
];

// Registrar un observer
observers_register($model, 'item_added', function($item) {
    echo "Se agregó: $item <br>";
});

// Agregar elementos
model_add_item($model, "Manzana");
model_add_item($model, "Banano");
model_add_item($model, "Uva");

// Mostrar la lista
view_render_list(model_get_data($model));

?>