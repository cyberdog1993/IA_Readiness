# IA-readiness

Plataforma interna/comercial para Consultores IT orientada a diagnóstico, preventa y ejecución de proyectos de automatización.

## Resumen

La aplicación combina tres capas:

1. Landing pública y diagnóstico rápido.
2. Portal cliente para continuar el levantamiento por proceso.
3. Panel interno Filament para administrar clientes, procesos, exportaciones y propuestas.

## Funcionalidades

- Landing pública enfocada en conversión comercial.
- Pre-formulario público con cálculo de madurez sobre 100.
- Resultado inmediato con puntaje, nivel, fortalezas, riesgos, ROI estimado y siguiente paso.
- Captura de datos por cliente y por proceso.
- Portal cliente con vista propia de procesos.
- Exportación a Markdown, JSON, Excel, Word y PDF.
- Prompts listos para ChatGPT, Claude y agentes internos.
- Payload estructurado para n8n, CRM y webhooks.
- Panel interno con Filament.
- Página de privacidad y tratamiento de datos.
- Tracking opcional para Google Analytics, Plausible, Meta Pixel y LinkedIn Insight Tag.
- Datos demo de NUVO.

## Roles

- `admin`: administra todo el sistema, usuarios, procesos, exportaciones y configuraciones.
- `internal`: consultor interno que levanta información, revisa diagnósticos y genera propuestas.
- `client`: cliente final que entra a su portal, ve sus procesos y descarga sus exportables permitidos.

## Rutas principales

- Landing pública: `/`
- Diagnóstico público: `/diagnostico`
- Resultado comercial: `/diagnostico/{lead}`
- Acceso cliente: `/acceso-cliente`
- Portal cliente: `/portal`
- Proceso del cliente: `/portal/procesos/{process}`
- Panel interno: `/admin`
- Privacidad: `/privacidad`
- Tratamiento de datos: `/tratamiento-datos`

## Exportaciones

Para diagnósticos públicos:

- Markdown: `/exports/lead/{lead}/markdown`
- JSON: `/exports/lead/{lead}/json`
- Excel: `/exports/lead/{lead}/excel`
- Word: `/exports/lead/{lead}/word`
- PDF cliente: `/exports/lead/{lead}/cliente-pdf`
- PDF interno: `/exports/lead/{lead}/interno-pdf`
- Payload para IA/n8n: `/integraciones/lead/{lead}/payload`

Para procesos del cliente:

- PDF: `/levantamiento/ficha/{process}/pdf`
- Markdown: `/levantamiento/ficha/{process}/markdown`
- JSON: `/levantamiento/ficha/{process}/json`

## Flujo funcional

1. El cliente completa el diagnóstico público.
2. El sistema calcula la madurez y muestra un resultado comercial.
3. El usuario puede dejar sus datos para descargar el informe completo.
4. El consultor o el cliente inician el levantamiento por proceso.
5. Cada proceso se documenta por secciones para guardar avance parcial.
6. El cliente accede a su portal y revisa sus procesos.
7. Desde el portal o el panel interno se exporta la información para IA o para propuestas.

## Instalación local

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --seed
php artisan filament:assets
npm run build
php artisan serve
```

## Instalación con Docker

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan filament:assets
docker compose --profile tools run --rm node npm install
docker compose --profile tools run --rm node npm run build
```

## Accesos iniciales

- Email admin: `admin@consultores-it.pe`
- Password inicial: definida en el despliegue del servidor

## Variables opcionales

Para activar analítica y automatización, define en `.env`:

- `GOOGLE_ANALYTICS_ID`
- `PLAUSIBLE_DOMAIN`
- `META_PIXEL_ID`
- `LINKEDIN_INSIGHT_TAG`
- `LANDING_VIDEO_URL`
- `LANDING_VIDEO_MP4`
- `LEAD_CREATED_WEBHOOK_URL`
- `N8N_WEBHOOK_URL`
- `CRM_WEBHOOK_URL`
- `INTERNAL_NOTIFY_WEBHOOK_URL`

## Automatizaciones

El sistema envía el payload estructurado de cada lead a los webhooks configurados al momento de crear el registro.

También puedes re-disparar manualmente el envío desde:

- `POST /integraciones/lead/{lead}/dispatch`

## Estructura de datos

- `leads`: captura del formulario público.
- `clients`: clientes internos.
- `processes`: procesos de negocio.
- `process_steps`: pasos AS-IS.
- `system_integrations`: sistemas involucrados.
- `document_evidences`: documentos y evidencias.
- `current_problems`: problemas actuales.
- `automation_opportunities`: oportunidades de automatización.
- `internal_evaluations`: evaluación técnica interna.
- `backlog_items`: backlog sugerido.

## Documentación adicional

- [Manual de usuario en Markdown](docs/manual-usuario.md)
- [Manual de arquitectura en Markdown](docs/manual-arquitectura.md)
- [Auditoría inicial](docs/auditoria-inicial-plataforma.md)
- [Checklist de implementación](docs/checklist-plataforma-diagnostico.md)
- [Plan de ejecución](docs/plan-ejecucion-plataforma-diagnostico.md)
- [Manual de usuario en Word](docs/manual-usuario.docx)
- [Manual de arquitectura en Word](docs/manual-arquitectura.docx)

## Nota de alcance

La primera versión deja preparada la arquitectura, el dominio, el formulario público, el portal cliente, el panel Filament, el cálculo de madurez, la salida comercial inmediata y los exportadores Markdown/JSON/Excel/Word/PDF.
También incluye estructura para automatizaciones posteriores con n8n y agentes de IA.
