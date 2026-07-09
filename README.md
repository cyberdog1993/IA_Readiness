# consultores-it-automation-platform

Plataforma interna/comercial para Consultores IT orientada a diagnóstico, preventa y ejecución de proyectos de automatización.

## Incluye

- Landing comercial pública separada del formulario.
- Cálculo de madurez sobre 100 y salida comercial inmediata.
- Registro de clientes, procesos, pasos AS-IS, sistemas, documentos, problemas, oportunidades, evaluación interna y backlog.
- Panel interno con Filament.
- Exportación a Markdown, JSON, Excel, Word y PDF.
- Payload estructurado para n8n, agentes y automatizaciones.
- Página de privacidad y aviso de tratamiento de datos.
- Tracking opcional para Google Analytics, Plausible, Meta Pixel y LinkedIn Insight Tag.
- Datos demo de NUVO.
- Preparado para Docker, PostgreSQL y Redis opcional.

## Requisitos

- PHP 8.2 o superior.
- Composer.
- Node.js 18 o superior.
- PostgreSQL.
- Opcional: Docker y Docker Compose.

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

- Email: `admin@consultores-it.pe`
- Password inicial: configurada en el despliegue del servidor

## Rutas principales

- Landing pública: `/`
- Diagnóstico público: `/diagnostico`
- Resultado del diagnóstico: `/diagnostico/{lead}`
- Portal cliente: `/cliente`
- Panel interno: `/admin`
- Privacidad: `/privacidad`
- Tratamiento de datos: `/tratamiento-datos`

## Exportaciones

Las exportaciones están disponibles solo para usuarios autenticados:

- Markdown: `/exports/lead/{lead}/markdown`
- JSON: `/exports/lead/{lead}/json`
- Excel: `/exports/lead/{lead}/excel`
- Word: `/exports/lead/{lead}/word`
- PDF cliente: `/exports/lead/{lead}/cliente-pdf`
- PDF interno: `/exports/lead/{lead}/interno-pdf`
- Payload para IA/n8n: `/integraciones/lead/{lead}/payload`

## Variables opcionales

Para activar analítica agregada, define estas variables en `.env`:

- `GOOGLE_ANALYTICS_ID`
- `PLAUSIBLE_DOMAIN`
- `META_PIXEL_ID`
- `LINKEDIN_INSIGHT_TAG`

## Documentación del proyecto

- [Manual de usuario](docs/manual-usuario.docx)
- [Manual de arquitectura](docs/manual-arquitectura.docx)

## Estructura funcional

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

## Nota sobre el primer entregable

La primera versión deja preparada la arquitectura, el dominio, el formulario público, el panel Filament, el cálculo de madurez, la salida comercial inmediata y los exportadores Markdown/JSON/Excel/Word/PDF.
También incluye estructura para automatizaciones posteriores con n8n y agentes de IA.
