# Plan de ejecución - Plataforma de Diagnóstico

Este plan traduce el checklist de implementación en bloques de trabajo priorizados.

## Objetivo

Evolucionar la plataforma de diagnóstico de Consultores IT sin perder compatibilidad con los datos existentes y manteniendo trazabilidad, seguridad y documentación completa.

## Prioridades

| Prioridad | Bloque | Objetivo | Entregables | Dependencias | Estado |
| --- | --- | --- | --- | --- | --- |
| P1 | Auditoría y línea base | Confirmar qué existe y qué falta | Inventario de rutas, modelos, exportadores y permisos | Ninguna | Pendiente |
| P1 | Seguridad y compatibilidad | Evitar romper datos existentes | Revisión de permisos, validaciones y rutas internas | Auditoría | Pendiente |
| P1 | Modelo de datos | Normalizar cliente, proceso y entidades hijas | Migraciones incrementales y relaciones | Auditoría | Pendiente |
| P2 | Formularios y UX | Capturar el AS-IS por secciones | Formularios guardables, progreso y borradores | Modelo de datos | Pendiente |
| P2 | Exportaciones | Generar Markdown, JSON, Excel y Word consistentes | Exportadores actualizados y permisos por rol | Modelo de datos | Pendiente |
| P2 | ROI y automatización | Calcular valor de negocio de forma trazable | Fórmulas, supuestos y matriz de automatización | Formularios y datos | Pendiente |
| P3 | Evaluación técnica interna | Separar lo visible al cliente de lo interno | Vista técnica protegida y backlog interno | Permisos y modelo | Pendiente |
| P3 | Pruebas y validación | Asegurar estabilidad del sistema | Pruebas de contrato, seguridad y compatibilidad | Implementación previa | Pendiente |
| P3 | Documentación y GitHub | Dejar el proyecto listo para compartir | README actualizado, manuales y commit publicado | Todo lo anterior | Pendiente |

## Secuencia recomendada

1. Validar estado actual del código y del servidor.
2. Ajustar primero la estructura de datos y permisos.
3. Mejorar formularios y captura por proceso.
4. Reescribir exportaciones con criterios de seguridad.
5. Agregar cálculos de ROI y matriz de automatización.
6. Cerrar con pruebas, documentación y publicación a GitHub.

## Reglas de trabajo

- No borrar datos existentes.
- Usar migraciones incrementales y reversibles.
- Mantener exportaciones compatibles con registros previos.
- No guardar secretos ni credenciales.
- Documentar cada bloque antes de pasar al siguiente.
- Publicar a GitHub solo cuando el bloque esté verificado.

## Hecho / pendiente

- Hecho:
  - Checklist operativo creado.
  - README enlazado con el checklist.
- Pendiente:
  - Implementar el bloque P1.
  - Reordenar exportaciones y formularios.
  - Ejecutar pruebas y publicar en GitHub.

