# Manual de arquitectura

## Propósito

Documentar la estructura lógica y operativa de la plataforma de diagnóstico de automatización.

## Stack

- Laravel 11+
- Filament Admin Panel
- PostgreSQL
- Tailwind CSS
- Docker Compose
- Exportación a Markdown, JSON, Excel, Word y PDF

## Capas

### 1. Capa pública

- Landing comercial.
- Diagnóstico rápido.
- Resultado comercial.
- Captura de contacto.

### 2. Capa de consultoría

- Portal cliente.
- Levantamiento por proceso.
- AS-IS.
- Evidencias.
- Oportunidades.
- Backlog.

### 3. Capa administrativa

- Panel Filament.
- Gestión de clientes.
- Gestión de usuarios.
- Revisión de procesos.
- Exportaciones.

## Entidades principales

- `leads`
- `clients`
- `processes`
- `process_steps`
- `system_integrations`
- `document_evidences`
- `current_problems`
- `automation_opportunities`
- `internal_evaluations`
- `backlog_items`
- `users`

## Seguridad

- Formulario público sin login.
- Panel interno con autenticación.
- Portal cliente con autenticación.
- Validación por rol.
- Acceso a procesos restringido al cliente propietario o usuarios internos.
- Rate limit en formularios.
- Protección CSRF.

## Exportación e IA

La arquitectura deja preparados tres formatos de salida:

- Markdown: lectura humana y LLM.
- JSON: integración con n8n y agentes.
- PDF/Word/Excel: documentos comerciales y de ejecución.

## Automatización

El `LeadAutomationDispatcher` centraliza el envío del payload de diagnóstico a:

- n8n
- CRM
- notificaciones internas
- cualquier webhook configurado

## Operación

### Desarrollo local

- Composer + Node + Laravel.
- Migraciones y seeders.
- Build de assets.

### Contenerización

- App Laravel.
- Nginx.
- PostgreSQL.
- Redis opcional.
- Node para build de frontend.

## Observaciones de diseño

- El portal cliente no debe mostrar accesos internos.
- El diagnóstico rápido debe vender el resultado, no el formulario.
- Cada proceso puede tener su propia ficha y exportables.
- El contenido listo para IA debe ser limpio, estructurado y reutilizable.

