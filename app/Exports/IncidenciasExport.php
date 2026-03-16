<?php
namespace App\Exports;

use App\Models\Incidencia;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IncidenciasExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(protected array $filtros = []) {}

    public function query()
    {
        $query = Incidencia::with(['cliente','local','agente','tecnico'])->orderByDesc('created_at');
        if (!empty($this->filtros['cliente_id'])) $query->where('cliente_id', $this->filtros['cliente_id']);
        if (!empty($this->filtros['estado']))      $query->where('estado_mesa', $this->filtros['estado']);
        if (!empty($this->filtros['prioridad']))   $query->where('prioridad', $this->filtros['prioridad']);
        if (!empty($this->filtros['desde']))       $query->whereDate('created_at', '>=', $this->filtros['desde']);
        if (!empty($this->filtros['hasta']))       $query->whereDate('created_at', '<=', $this->filtros['hasta']);
        return $query;
    }

    public function headings(): array
    {
        return [
            'N° Ticket', 'Cliente', 'Local', 'Agente', 'Técnico',
            'Tipo Ticket', 'Categoría', 'Equipo', 'Asunto', 'Prioridad',
            'Estado Mesa', 'Fecha Creación', 'Fecha Asignación',
            'Fecha Límite Respuesta', 'Fecha Primera Atención',
            'Fecha Límite Resolución', 'Fecha Cierre',
            'SLA Respuesta', 'SLA Resolución',
            'Categoría Cierre', 'Subcategoría Cierre',
        ];
    }

    public function map($i): array
    {
        return [
            $i->numero_ticket,
            $i->cliente->nombre ?? '-',
            $i->local->direccion ?? '-',
            $i->agente->name ?? '-',
            $i->tecnico->name ?? 'Sin asignar',
            $i->tipo_ticket,
            $i->categoria_equipo,
            $i->tipo_equipo,
            $i->asunto,
            $i->prioridad,
            $i->estado_mesa,
            $i->created_at?->format('d/m/Y H:i'),
            $i->fecha_asignacion?->format('d/m/Y H:i'),
            $i->fecha_limite_respuesta?->format('d/m/Y H:i'),
            $i->fecha_primera_atencion?->format('d/m/Y H:i'),
            $i->fecha_limite_resolucion?->format('d/m/Y H:i'),
            $i->closed_at?->format('d/m/Y H:i'),
            $i->slaRespuestaCumplido() ? 'Cumplido' : 'Incumplido',
            $i->slaResolucionCumplido() ? 'Cumplido' : 'Incumplido',
            $i->categoria_cierre ?? '-',
            $i->subcategoria_cierre ?? '-',
        ];
    }
}