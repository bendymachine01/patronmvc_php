<?php
// ─── MODELO ───────────────────────────────────────────────
$model = ['temperatura' => 20, 'observers' => []];
 
function model_set_temp(array &$model, int $temp): void {
    $model['temperatura'] = $temp;
    observers_notify($model, 'temp_changed', $temp);
}
 
// ─── OBSERVERS ────────────────────────────────────────────
function observers_register(array &$model, string $event, callable $cb): void {
    $model['observers'][$event][] = $cb;
}
 
function observers_notify(array $model, string $event, mixed $payload): void {
    foreach ($model['observers'][$event] ?? [] as $cb) {
        $cb($payload);
    }
}
 
// ─── VISTAS ───────────────────────────────────────────────
function view_temperatura(int $temp): string {
    return "🌡️  Temperatura actual: {$temp}°C\n";
}
 
function view_alerta(int $temp): string {
    return $temp >= 35 ? "🔥 ¡ALERTA! Temperatura peligrosa.\n" : "";
}
 
// ─── REGISTRAR OBSERVERS ──────────────────────────────────
observers_register($model, 'temp_changed', fn($t) => print view_temperatura($t));
observers_register($model, 'temp_changed', fn($t) => print view_alerta($t));
 
// ─── DEMO ─────────────────────────────────────────────────
echo "--- Subiendo temperatura ---\n";
model_set_temp($model, 28);
 
echo "\n--- Subiendo más ---\n";
model_set_temp($model, 38);