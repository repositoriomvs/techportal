<?php

namespace App\Http\Controllers;

use App\Models\ActividadUsuario;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $hoy = now()->startOfDay();
        $inicioSemana = now()->startOfWeek();
        $inicioMes = now()->startOfMonth();

        // Ingresos hoy
        $ingresosHoy = ActividadUsuario::whereDate('login_at', today())->count();

        // Ingresos esta semana
        $ingresosSemana = ActividadUsuario::where('login_at', '>=', $inicioSemana)->count();

        // Ingresos este mes
        $ingresosMes = ActividadUsuario::where('login_at', '>=', $inicioMes)->count();

        // Horas activas hoy (suma de duraciones)
        $minutosHoy = ActividadUsuario::whereDate('login_at', today())
            ->whereNotNull('duracion_minutos')
            ->sum('duracion_minutos');

        // Horas activas esta semana
        $minutosSemana = ActividadUsuario::where('login_at', '>=', $inicioSemana)
            ->whereNotNull('duracion_minutos')
            ->sum('duracion_minutos');

        // Horas activas este mes
        $minutosMes = ActividadUsuario::where('login_at', '>=', $inicioMes)
            ->whereNotNull('duracion_minutos')
            ->sum('duracion_minutos');

        // Media diaria de ingresos (mes actual)
        $diasTranscurridos = max(now()->day, 1);
        $mediaIngresosDiaria = round($ingresosMes / $diasTranscurridos, 1);
        $mediaHorasDiaria = round(($minutosMes / 60) / $diasTranscurridos, 1);

        // Media semanal de ingresos (mes actual)
        $semanasTranscurridas = max(ceil($diasTranscurridos / 7), 1);
        $mediaIngresosSemanal = round($ingresosMes / $semanasTranscurridas, 1);
        $mediaHorasSemanal = round(($minutosMes / 60) / $semanasTranscurridas, 1);

        // Actividad por usuario hoy
        $actividadPorUsuario = ActividadUsuario::with('user')
            ->whereDate('login_at', today())
            ->get()
            ->groupBy('user_id')
            ->map(function ($sesiones) {
                return [
                    'usuario'   => $sesiones->first()->user->name ?? 'Desconocido',
                    'ingresos'  => $sesiones->count(),
                    'minutos'   => $sesiones->whereNotNull('duracion_minutos')->sum('duracion_minutos'),
                ];
            })->values();

        // Últimas 10 sesiones
        $ultimasSesiones = ActividadUsuario::with('user')
            ->latest('login_at')
            ->take(10)
            ->get();

        // Ingresos por día esta semana (para gráfico)
        $ingresosPorDia = ActividadUsuario::where('login_at', '>=', $inicioSemana)
            ->select(DB::raw('DATE(login_at) as dia'), DB::raw('COUNT(*) as total'))
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();
// Ranking de usuarios por ingresos este mes
$rankingUsuarios = ActividadUsuario::with('user')
    ->where('login_at', '>=', $inicioMes)
    ->select('user_id', DB::raw('COUNT(*) as total_ingresos'), DB::raw('SUM(duracion_minutos) as total_minutos'))
    ->groupBy('user_id')
    ->orderBy('total_ingresos', 'desc')
    ->get()
    ->map(function ($item) {
        return [
            'usuario'         => $item->user->name ?? 'Desconocido',
            'total_ingresos'  => $item->total_ingresos,
            'total_minutos'   => $item->total_minutos ?? 0,
        ];
    });
        return view('admin.dashboard', compact(
    'ingresosHoy', 'ingresosSemana', 'ingresosMes',
    'minutosHoy', 'minutosSemana', 'minutosMes',
    'mediaIngresosDiaria', 'mediaHorasDiaria',
    'mediaIngresosSemanal', 'mediaHorasSemanal',
    'actividadPorUsuario', 'ultimasSesiones', 'ingresosPorDia',
    'rankingUsuarios'
));
    }

    private function formatMinutos($minutos)
    {
        $horas = floor($minutos / 60);
        $mins  = $minutos % 60;
        return $horas > 0 ? "{$horas}h {$mins}m" : "{$mins}m";
    }
}