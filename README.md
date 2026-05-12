# Patrón MVO sin POO en PHP

Implementación del patrón **Model-View-Observer** usando únicamente funciones y arreglos en PHP, sin clases ni programación orientada a objetos.

---

## ¿Qué es el patrón MVO?

MVO (Model-View-Observer) es un patrón de arquitectura de software que organiza el código en tres responsabilidades separadas:

| Capa | Responsabilidad |
|------|----------------|
| **Model** (Modelo) | Gestiona el estado y los datos de la aplicación |
| **View** (Vista) | Renderiza los datos para el usuario |
| **Observer** (Observador) | Reacciona automáticamente a los cambios del modelo |

Es una variante del clásico **MVC** (Model-View-Controller), donde el "Observer" reemplaza al Controller. La diferencia clave es que en MVO **el modelo notifica activamente** a sus observadores cuando cambia, en lugar de que un controlador los coordine manualmente.

---

## ¿Para qué sirve?

El patrón MVO resuelve un problema muy común: **mantener sincronizados los datos con su representación visual**, sin que las capas dependan directamente unas de otras.

Casos de uso típicos:

- Dashboards que actualizan múltiples secciones al cambiar un dato
- Formularios reactivos donde un campo afecta a otros
- Sistemas de notificaciones o logs automáticos
- Cualquier interfaz donde un cambio de estado debe reflejarse en varios lugares

---

## ¿Por qué implementarlo sin POO?

La mayoría de tutulares del patrón MVO usan clases. Esta implementación demuestra que los mismos principios funcionan **con funciones puras y arreglos**, lo cual es útil cuando:

- Se trabaja con código PHP legado sin clases
- Se quiere entender el patrón sin la complejidad de la herencia
- El proyecto es pequeño y no justifica una jerarquía de clases
- Se enseña el concepto de forma más directa

---

## Estructura del código

```
mvo_sin_poo.php
│
├── MODELO
│   ├── model_get_data()       → Lee el estado actual
│   ├── model_set_data()       → Reemplaza todos los datos
│   ├── model_add_item()       → Agrega un elemento
│   └── model_remove_item()    → Elimina un elemento por índice
│
├── OBSERVADORES
│   ├── observers_register()   → Registra un callback para un evento
│   └── observers_notify()     → Dispara todos los callbacks de un evento
│
└── VISTAS
    ├── view_render_list()         → Renderiza una lista HTML
    ├── view_render_count()        → Muestra el total de elementos
    └── view_render_notification() → Muestra un mensaje de notificación
```

---

## Flujo de ejecución

```
Acción del usuario
      ↓
  model_*()          ← Modifica el estado ($model['data'])
      ↓
observers_notify()   ← Notifica a todos los callbacks registrados
      ↓
  callbacks[]        ← Cada observer reacciona al evento
      ↓
  view_render_*()    ← Renderiza el nuevo estado al usuario
```

---

## Los tres eventos del modelo

| Evento | Se dispara cuando... |
|--------|----------------------|
| `data_changed` | Se reemplaza todo el arreglo de datos |
| `item_added` | Se agrega un nuevo elemento |
| `item_removed` | Se elimina un elemento existente |

---

## Ejemplo comentado

```php
// 1. Crear el modelo (arreglo con datos y observadores)
$model = [
    'data'      => [],
    'observers' => [],
];

// 2. Registrar observadores ANTES de modificar el modelo
observers_register($model, 'item_added', function(string $item) {
    echo "Se agregó: $item";
});

// 3. Modificar el modelo → el observer se dispara automáticamente
model_add_item($model, 'Manzana');
// → output: "Se agregó: Manzana"

// 4. Renderizar la vista con el estado actual
echo view_render_list(model_get_data($model));
// → output: <ul><li>[0] Manzana</li></ul>
```

---

## Concepto clave: paso por referencia

Las funciones que **modifican** el modelo reciben `&$model` (por referencia), mientras que las que solo **leen** reciben `$model` (por valor). Esto es fundamental para que los cambios persistan fuera de la función.

```php
// Modifica → necesita referencia
function model_add_item(array &$model, string $item): void { ... }

// Solo notifica → no necesita referencia
function observers_notify(array $model, string $event, mixed $payload): void { ... }

// Solo renderiza → tampoco necesita referencia
function view_render_list(array $items): string { ... }
```

---

## Comparación con MVC clásico

| Aspecto | MVC | MVO (este patrón) |
|---------|-----|-------------------|
| Quién coordina la actualización | El Controller | El Observer (automáticamente) |
| Acoplamiento | Controller conoce a View y Model | Modelo no conoce a nadie |
| Reactividad | Manual (el controller llama a la vista) | Automática (via callbacks) |
| Complejidad inicial | Mayor | Menor |

---

## Limitaciones

- No es adecuado para aplicaciones grandes con muchas capas de estado
- En PHP sin estado (HTTP), los observadores se re-registran en cada request
- Para mayor complejidad, considerar usar clases o un framework

---

## Requisitos

- PHP 8.0 o superior (se usan tipos `mixed` y `array`)
- Servidor web o CLI de PHP

```bash
# Ejecutar desde CLI
php mvo_sin_poo.php

# O con servidor local
php -S localhost:8000
```

---

## Licencia

Libre para uso educativo y personal.