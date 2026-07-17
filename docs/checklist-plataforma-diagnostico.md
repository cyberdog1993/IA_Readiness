# Checklist de implementación - Plataforma de Diagnóstico

Este checklist traduce las indicaciones de ChatGPT en una guía ejecutable por fases.

## 1. Auditoría inicial

- [ ] Leer el Markdown fuente del diagnóstico y confirmar que existe en el entorno.
- [ ] Revisar `README.md`, rutas, modelos, migraciones, formularios, recursos Filament y exportadores.
- [ ] Identificar qué campos ya existen y cuáles faltan para el modelo conceptual.
- [ ] Verificar compatibilidad con datos actuales antes de modificar estructuras.
- [ ] Confirmar roles, permisos y alcance de exportaciones por tipo de usuario.

## 2. Modelo de datos y trazabilidad

- [ ] Mantener `Cliente -> Procesos -> entidades hijas` como jerarquía principal.
- [ ] Agregar o validar UUID estable, versión, estado y timestamps en diagnósticos y procesos.
- [ ] Registrar consultor responsable, usuario creador y último editor.
- [ ] Implementar historial o trazabilidad mínima de cambios.
- [ ] Permitir múltiples procesos por cliente sin duplicar información general.

## 3. Procesos AS-IS

- [ ] Ampliar la captura de objetivos, contexto, resultados esperados y criterios de fin.
- [ ] Registrar stakeholders con rol, área y tipo de participación.
- [ ] Expandir pasos AS-IS con tiempos mínimo/promedio/máximo, espera, evidencias y validación humana.
- [ ] Validar que el orden de pasos sea único por proceso.
- [ ] Implementar dependencias entre pasos y evitar ciclos o autorreferencias.

## 4. Decisiones, excepciones y restricciones

- [ ] Agregar decisiones con condición evaluada y resultado.
- [ ] Agregar excepciones con disparador, severidad, escalamiento y reintento.
- [ ] Registrar restricciones técnicas, operativas, comerciales y de cumplimiento.
- [ ] Registrar supuestos pendientes de validación.

## 5. Sistemas, datos y evidencias

- [ ] Ampliar inventario de sistemas con API, autenticación, ambiente y estado de acceso.
- [ ] Prohibir almacenamiento de contraseñas, tokens o secretos.
- [ ] Registrar datos consumidos, generados y evidencias con formato, sensibilidad y retención.
- [ ] Diferenciar capturas, documentos, logs, reportes y correos.

## 6. Volumen, automatización y ROI

- [ ] Permitir métricas de volumen por periodo y por tipo de dato.
- [ ] Crear matriz de automatización con tiempo actual, tiempo esperado, ahorro y prioridad.
- [ ] Calcular ROI con moneda, costo por hora, costos de implementación y horizonte.
- [ ] Mostrar siempre fórmulas y supuestos.
- [ ] Mostrar `No calculable` si faltan datos, sin inventar valores.

## 7. Evaluación técnica interna

- [ ] Mantener la evaluación técnica separada de lo visible al cliente.
- [ ] Incluir complejidad, impacto, riesgo, confianza y dependencias técnicas.
- [ ] Marcar candidatos tecnológicos: MCP, skill, n8n, IA, OCR, RPA, API, scheduler, webhook y contenedores.
- [ ] Restringir la vista y exportación técnica a usuarios autorizados.

## 8. Backlog y roadmap

- [ ] Soportar épica, historia, tarea técnica, integración, prueba, validación y documentación.
- [ ] Agregar fases con objetivo, entregables, dependencias, estado y fechas tentativas.
- [ ] Marcar el origen del backlog como manual o sugerido.
- [ ] No afirmar aprobación automática de arquitectura o backlog.

## 9. Exportaciones

- [ ] Actualizar Markdown maestro con front matter YAML y secciones estables.
- [ ] Incluir identificadores, versión y fecha de generación en todas las exportaciones.
- [ ] Generar JSON canónico equivalente al Markdown.
- [ ] Actualizar Excel por pestañas separadas.
- [ ] Mantener Word legible y orientado a diagnóstico.
- [ ] Omitir campos internos en exportaciones visibles al cliente.
- [ ] Registrar quién exportó, qué versión y cuándo.

## 10. UX y formularios

- [ ] Convertir el formulario en secciones guardables o pasos.
- [ ] Permitir guardar borradores y continuar después.
- [ ] Mostrar progreso y campos pendientes.
- [ ] No obligar al cliente a llenar campos técnicos internos.
- [ ] Añadir ayudas breves en campos complejos.
- [ ] Agregar vista consolidada antes de exportar.

## 11. Seguridad y privacidad

- [ ] Aplicar autorización por rol a campos internos y exportaciones.
- [ ] Validar y sanitizar entradas.
- [ ] Evitar XSS, inyección en Markdown/YAML y fórmulas peligrosas en Excel.
- [ ] No registrar datos sensibles completos en logs.
- [ ] Mantener aislamiento entre clientes.
- [ ] Documentar política de privacidad y tratamiento de datos.

## 12. Pruebas

- [ ] Relación cliente -> múltiples procesos.
- [ ] CRUD y autorización de entidades nuevas.
- [ ] Validación de tiempos y dependencias.
- [ ] Cálculos de ahorro y ROI con datos incompletos.
- [ ] Exportación Markdown con YAML válido.
- [ ] Paridad estructural entre JSON y Markdown.
- [ ] Omisión de secretos en exportaciones.
- [ ] Compatibilidad con registros anteriores.
- [ ] Escape de fórmulas y HTML peligroso.

## 13. Documentación y despliegue

- [ ] Actualizar `README.md` con instalación, migración, seeders, exportaciones y permisos.
- [ ] Mantener manual de usuario y manual de arquitectura actualizados.
- [ ] Documentar cualquier dato que no pueda migrarse automáticamente.
- [ ] Verificar despliegue en servidor y reinicio de contenedores.
- [ ] Confirmar que el checklist y la documentación reflejan el estado real.

## 14. Criterio de cierre

- [ ] Un cliente puede tener varios procesos sin duplicación indebida.
- [ ] El AS-IS ampliado puede capturarse completo.
- [ ] El Markdown y el JSON salen consistentes.
- [ ] La evaluación interna está protegida.
- [ ] Las pruebas pasan.
- [ ] La documentación explica el uso real del sistema.

