# consultores-it-automation-platform

Plataforma interna/comercial para Consultores IT orientada a diagnóstico, preventa y ejecución de proyectos de automatización.

## Incluye

- Landing pública con pre-formulario.
- Cálculo de nota de madurez sobre 100.
- Registro de clientes, procesos, pasos AS-IS, sistemas, documentos, problemas, oportunidades, evaluación interna y backlog.
- Panel interno con Filament.
- Exportación a Markdown, JSON, Excel y Word.
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
docker compose --profile tools run --rm node npm install
docker compose --profile tools run --rm node npm run build
```

## Accesos iniciales

- Email: `admin@consultores-it.pe`
- Password: `cambiar123`

## Rutas principales

- Landing pública: `/`
- Resultado del diagnóstico: `/diagnostico/{lead}`
- Panel interno: `/admin`

## Exportaciones

Las exportaciones están disponibles solo para usuarios autenticados:

- Markdown: `/exports/lead/{lead}/markdown`
- JSON: `/exports/lead/{lead}/json`
- Excel: `/exports/lead/{lead}/excel`
- Word: `/exports/lead/{lead}/word`

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

La primera versión deja preparada la arquitectura, el dominio, el formulario público, el panel Filament, el cálculo de madurez y el exportador Markdown/JSON/Excel/Word.
Cuando instales dependencias reales podrás ejecutar el proyecto completo y ampliar el panel con relaciones y acciones avanzadas.
