<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', 'Diagnóstico de automatización para consultoría comercial, técnica y ejecutiva.')">
    <meta property="og:locale" content="es_PE">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', 'Diagnóstico de automatización para consultoría comercial, técnica y ejecutiva.')">
    <meta property="og:image" content="@yield('og_image', asset('images/consultores-it-logo.jpeg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="icon" href="{{ asset('images/consultores-it-logo.jpeg') }}">
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Consultores IT',
            'url' => 'https://www.consultores-it.pe',
            'logo' => asset('images/consultores-it-logo.jpeg'),
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'contactType' => 'sales',
                    'email' => 'julio.valdez@consultores.it',
                    'telephone' => '+51 941 108 521',
                ],
            ],
            'sameAs' => [
                'https://www.consultores-it.pe',
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Diagnóstico de automatización',
                'itemListElement' => [
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'Diagnóstico de Madurez para Automatización con IA',
                        ],
                    ],
                ],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,.22),_transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(16,185,129,.16),_transparent_35%)]"></div>
    <main class="mx-auto max-w-7xl px-6 py-10 pb-32">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                @if (! request()->routeIs('home'))
                    <img src="{{ asset('images/consultores-it-logo.jpeg') }}" alt="Consultores IT" class="h-14 w-14 rounded-2xl bg-white/90 object-cover p-1 shadow-lg shadow-slate-950/30" loading="eager">
                @endif
                <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-cyan-200">Consultores IT</p>
                    <p class="text-sm text-slate-300">{{ request()->routeIs('home') ? 'Plataforma de Automatización' : 'Plataforma de diagnóstico y consultoría' }}</p>
                </div>
            </div>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                        Salir
                    </button>
                </form>
            @endauth
        </div>
        @yield('content')

        <footer class="fixed inset-x-0 bottom-0 z-40 border-t border-cyan-400/20 bg-slate-950/95 px-4 py-3 shadow-[0_-12px_40px_rgba(2,6,23,0.45)] backdrop-blur">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap items-center gap-3 text-sm">
                    <span class="text-xs uppercase tracking-[0.28em] text-cyan-200">Consultores IT</span>
                    <span class="text-slate-300">Plataforma de diagnóstico, preventa y consultoría</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="https://www.consultores-it.pe" target="_blank" rel="noreferrer" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                        Web principal
                    </a>
                    <a href="mailto:julio.valdez@consultores.it" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                        julio.valdez@consultores.it
                    </a>
                    <a href="https://wa.me/51941108521" target="_blank" rel="noreferrer" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                        WhatsApp +51 941 108 521
                    </a>
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs uppercase tracking-[0.22em] text-slate-300">Formulario v1.0.3</span>
                    <a href="{{ url('/privacidad') }}" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                        Privacidad
                    </a>
                    <a href="{{ url('/tratamiento-datos') }}" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                        Datos personales
                    </a>
                </div>
            </div>
        </footer>
    </main>

    <script>
        (function () {
            const analyticsId = @json(config('services.analytics.google'));
            const plausibleDomain = @json(config('services.analytics.plausible'));
            const metaPixelId = @json(config('services.meta.pixel'));
            const linkedInTag = @json(config('services.linkedin.insight_tag'));

            window.consultoresTrackEvent = function (name, params = {}) {
                if (window.gtag) {
                    window.gtag('event', name, params);
                }

                if (window.fbq) {
                    window.fbq('trackCustom', name, params);
                }

                if (window._linkedin_data_partner_ids && window.lintrk) {
                    window.lintrk('track', { conversion_id: linkedInTag || name });
                }

                if (window.plausible) {
                    window.plausible(name, { props: params });
                }
            };

            if (analyticsId && !document.getElementById('google-analytics-loader')) {
                const script = document.createElement('script');
                script.id = 'google-analytics-loader';
                script.async = true;
                script.src = `https://www.googletagmanager.com/gtag/js?id=${analyticsId}`;
                document.head.appendChild(script);

                window.dataLayer = window.dataLayer || [];
                window.gtag = function () { window.dataLayer.push(arguments); };
                window.gtag('js', new Date());
                window.gtag('config', analyticsId);
            }

            if (plausibleDomain && !document.getElementById('plausible-loader')) {
                const script = document.createElement('script');
                script.id = 'plausible-loader';
                script.defer = true;
                script.setAttribute('data-domain', plausibleDomain);
                script.src = 'https://plausible.io/js/script.js';
                document.head.appendChild(script);
            }

            if (metaPixelId && !document.getElementById('meta-pixel-loader')) {
                !function(f,b,e,v,n,t,s){
                    if(f.fbq)return;
                    n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                    if(!f._fbq)f._fbq=n;
                    n.push=n;
                    n.loaded=!0;
                    n.version='2.0';
                    n.queue=[];
                    t=b.createElement(e);
                    t.async=!0;
                    t.src=v;
                    t.id='meta-pixel-loader';
                    s=b.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t,s);
                }(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');
                window.fbq('init', metaPixelId);
                window.fbq('track', 'PageView');
            }

            if (linkedInTag && !document.getElementById('linkedin-insight-loader')) {
                window._linkedin_partner_id = linkedInTag;
                window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
                window._linkedin_data_partner_ids.push(linkedInTag);
                const script = document.createElement('script');
                script.id = 'linkedin-insight-loader';
                script.type = 'text/javascript';
                script.async = true;
                script.src = 'https://snap.licdn.com/li.lms-analytics/insight.min.js';
                document.head.appendChild(script);
            }

            const bindEventTracking = () => {
                document.querySelectorAll('[data-track-event]').forEach((element) => {
                    element.addEventListener('click', () => {
                        window.consultoresTrackEvent(element.dataset.trackEvent, {
                            label: element.dataset.trackLabel || element.textContent.trim(),
                        });
                    });
                });

                document.querySelectorAll('a[href^="https://wa.me/"], a[href^="mailto:"]').forEach((element) => {
                    element.addEventListener('click', () => {
                        window.consultoresTrackEvent('contact_click', {
                            channel: element.getAttribute('href').startsWith('mailto:') ? 'email' : 'whatsapp',
                            label: element.textContent.trim(),
                        });
                    });
                });

                document.querySelectorAll('form[data-track-form]').forEach((form) => {
                    let started = false;
                    form.addEventListener('focusin', () => {
                        if (started) return;
                        started = true;
                        window.consultoresTrackEvent('form_start', {
                            form: form.dataset.trackForm,
                        });
                    });
                    form.addEventListener('submit', () => {
                        window.consultoresTrackEvent('form_complete', {
                            form: form.dataset.trackForm,
                        });
                    });
                });
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', bindEventTracking);
            } else {
                bindEventTracking();
            }
        })();
    </script>
</body>
</html>
