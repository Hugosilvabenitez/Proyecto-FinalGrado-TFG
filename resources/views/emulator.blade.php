<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $rom->title }} · GameFlux</title>
    <style>
        :root {
            color-scheme: dark;
            font-family: Arial, Helvetica, sans-serif;
            --page-background: {{ $backgroundPresets[$emulatorPreferences['emulator_background']]['css'] ?? $backgroundPresets['nebula']['css'] }};
            --shell-background: {{ $activeTheme['shell_background'] ?? 'linear-gradient(180deg, #020617 0%, #0f172a 100%)' }};
            --panel: {{ $activeTheme['panel_strong'] ?? 'rgba(15, 23, 42, 0.88)' }};
            --panel-soft: {{ $activeTheme['panel'] ?? 'rgba(15, 23, 42, 0.72)' }};
            --input-bg: {{ $activeTheme['input_background'] ?? 'rgba(2, 6, 23, 0.72)' }};
            --line: {{ $activeTheme['line'] ?? 'rgba(255, 255, 255, 0.12)' }};
            --line-strong: {{ $activeTheme['line_strong'] ?? 'rgba(255, 255, 255, 0.18)' }};
            --muted: {{ $activeTheme['subtle'] ?? '#94a3b8' }};
            --text: {{ $activeTheme['text'] ?? '#e2e8f0' }};
            --accent: {{ $activeTheme['accent'] ?? '#67e8f9' }};
            --accent-soft: {{ $activeTheme['accent_soft'] ?? 'rgba(34, 211, 238, 0.12)' }};
            --accent-border: {{ $activeTheme['accent_border'] ?? 'rgba(34, 211, 238, 0.32)' }};
            --secondary: {{ $activeTheme['secondary'] ?? '#f472b6' }};
            --button-gradient: {{ $activeTheme['button_gradient'] ?? 'linear-gradient(90deg, #22d3ee 0%, #3b82f6 52%, #d946ef 100%)' }};
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--page-background);
            color: var(--text);
        }

        .panel {
            width: min(720px, calc(100vw - 32px));
            padding: 32px;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: var(--panel);
            box-shadow: 0 20px 80px rgba(15, 23, 42, 0.45);
        }

        h1 {
            margin: 0 0 12px;
            font-size: 28px;
        }

        p {
            margin: 0 0 14px;
            color: #cbd5e1;
            line-height: 1.6;
        }

        code,
        a {
            color: var(--accent);
        }

        .shell {
            display: flex;
            min-height: 100vh;
            padding: 0;
        }

        .emulator-panel {
            background: var(--panel);
            width: 100%;
        }

        .emulator-panel {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 0;
        }

        .emulator-frame-shell {
            background: var(--page-background);
            flex: 1;
            min-height: 0;
            overflow: hidden;
            padding: 0;
            transition: background 0.2s ease;
        }

        .emulator-frame {
            background: var(--shell-background);
            border: 0;
            display: block;
            height: 100%;
            min-height: 100vh;
            width: 100%;
        }

        @media (max-width: 980px) {
            .shell {
                min-height: 100vh;
            }

            .emulator-panel {
                min-height: 100vh;
            }

            .emulator-frame {
                min-height: 100vh;
            }
        }
    </style>
</head>
<body>
    @if ($emulatorReady)
        <div class="shell">
            <section class="emulator-panel">
                <div class="emulator-frame-shell" id="emulator-frame-shell">
                    <iframe
                        id="emulator-frame"
                        class="emulator-frame"
                        src="{{ $emulatorIndexUrl }}"
                        title="Emulador {{ $rom->title }}"
                    ></iframe>
                </div>
            </section>
        </div>

        <script>
            const backgroundPresets = @json($backgroundPresets);
            const currentPreferences = @json($emulatorPreferences);
            const activeTheme = @json($activeTheme);
            const gameSessionUrl = @json(route('game-sessions.store'));
            const romId = @json((string) $rom->id);
            const csrfToken = @json(csrf_token());

            const frame = document.getElementById('emulator-frame');
            const frameShell = document.getElementById('emulator-frame-shell');
            const minimumSessionMs = 60000;

            let accumulatedVisibleMs = 0;
            let lastVisibleAt = document.visibilityState === 'visible' ? Date.now() : null;
            let sessionReported = false;

            function accumulateVisibleTime() {
                if (lastVisibleAt === null) {
                    return;
                }

                accumulatedVisibleMs += Math.max(0, Date.now() - lastVisibleAt);
                lastVisibleAt = null;
            }

            function resumeVisibleTime() {
                if (lastVisibleAt !== null || document.visibilityState !== 'visible') {
                    return;
                }

                lastVisibleAt = Date.now();
            }

            function getPlayedMinutes() {
                const liveVisibleMs = lastVisibleAt === null
                    ? 0
                    : Math.max(0, Date.now() - lastVisibleAt);
                const totalVisibleMs = accumulatedVisibleMs + liveVisibleMs;

                if (totalVisibleMs < minimumSessionMs) {
                    return 0;
                }

                return Math.floor(totalVisibleMs / minimumSessionMs);
            }

            function reportGameSession() {
                if (sessionReported) {
                    return;
                }

                accumulateVisibleTime();

                const minutesPlayed = getPlayedMinutes();

                if (minutesPlayed < 1) {
                    return;
                }

                sessionReported = true;

                if (navigator.sendBeacon) {
                    const payload = new FormData();
                    payload.append('_token', csrfToken);
                    payload.append('rom_id', romId);
                    payload.append('minutes_played', String(minutesPlayed));

                    if (navigator.sendBeacon(gameSessionUrl, payload)) {
                        return;
                    }

                    sessionReported = false;
                }

                fetch(gameSessionUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    keepalive: true,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        rom_id: romId,
                        minutes_played: minutesPlayed,
                    }),
                }).catch(() => {
                    sessionReported = false;
                });
            }

            function normalizeVolume(value) {
                const parsed = Number(value);

                if (Number.isNaN(parsed)) {
                    return 100;
                }

                return Math.max(0, Math.min(100, Math.round(parsed)));
            }

            function getActiveBackground() {
                return backgroundPresets[currentPreferences.emulator_background] || backgroundPresets.nebula;
            }

            function applyBackground(backgroundKey) {
                if (!backgroundPresets[backgroundKey]) {
                    return;
                }

                currentPreferences.emulator_background = backgroundKey;
                const preset = getActiveBackground();

                document.documentElement.style.setProperty('--page-background', preset.css);
                frameShell.style.background = preset.css;

                try {
                    const childBody = frame.contentDocument?.body;

                    if (childBody) {
                        childBody.style.background = preset.css;
                    }
                } catch (error) {
                    console.warn('No se pudo aplicar el fondo al emulador embebido.', error);
                }
            }

            function applyThemeToFrame() {
                try {
                    const childDocument = frame.contentDocument;

                    if (!childDocument) {
                        return;
                    }

                    const childRoot = childDocument.documentElement;
                    const childBody = childDocument.body;
                    const themeVariables = {
                        '--panel': activeTheme.panel_strong,
                        '--panel-soft': activeTheme.panel,
                        '--line': activeTheme.line,
                        '--text': activeTheme.text,
                        '--muted': activeTheme.subtle,
                        '--accent': activeTheme.accent,
                        '--gf-shell-bg': activeTheme.shell_background,
                        '--gf-input-bg': activeTheme.input_background,
                        '--gf-accent-soft': activeTheme.accent_soft,
                        '--gf-accent-border': activeTheme.accent_border,
                        '--gf-secondary': activeTheme.secondary,
                        '--gf-button-gradient': activeTheme.button_gradient,
                    };

                    Object.entries(themeVariables).forEach(([property, value]) => {
                        if (value) {
                            childRoot.style.setProperty(property, value);
                        }
                    });

                    if (childBody) {
                        childBody.style.background = activeTheme.shell_background;
                        childBody.style.color = activeTheme.text;
                    }

                    let overrideStyle = childDocument.getElementById('gameflux-theme-overrides');

                    if (!overrideStyle) {
                        overrideStyle = childDocument.createElement('style');
                        overrideStyle.id = 'gameflux-theme-overrides';
                        childDocument.head.appendChild(overrideStyle);
                    }

                    overrideStyle.textContent = `
                        body {
                            background: var(--gf-shell-bg) !important;
                            color: var(--text) !important;
                        }

                        .emulator-header,
                        .panel,
                        #controls,
                        #gameinfo,
                        #instructions {
                            background: var(--panel) !important;
                            border-color: var(--line) !important;
                            color: var(--text) !important;
                        }

                        .screen-panel {
                            background: linear-gradient(180deg, var(--panel), var(--gf-input-bg)) !important;
                        }

                        .screen-frame {
                            border-color: var(--line) !important;
                            box-shadow: inset 0 0 0 5px var(--gf-input-bg), 0 24px 70px rgba(0, 0, 0, 0.42) !important;
                        }

                        #controls button,
                        #controls label,
                        #sound,
                        #mapping td {
                            background: var(--panel-soft) !important;
                            border-color: var(--line) !important;
                            color: var(--text) !important;
                        }

                        #controls button:hover,
                        #controls label:hover,
                        #sound:hover {
                            border-color: var(--gf-accent-border) !important;
                            color: var(--accent) !important;
                        }

                        #controls .bigbutton {
                            background: var(--gf-accent-soft) !important;
                            border-color: var(--gf-accent-border) !important;
                            color: var(--accent) !important;
                        }

                        #mapping td:first-child,
                        #openDebug,
                        a:link,
                        a:visited {
                            color: var(--accent) !important;
                        }

                        #gameinfo p,
                        #instructions p,
                        .emulator-status,
                        footer {
                            color: var(--muted) !important;
                        }

                        input[type="range"] {
                            accent-color: var(--gf-secondary);
                        }
                    `;
                } catch (error) {
                    console.warn('No se pudo aplicar la paleta al emulador embebido.', error);
                }
            }

            function applyVolume(volume) {
                const normalized = normalizeVolume(volume);

                try {
                    const childWindow = frame.contentWindow;
                    const childDocument = frame.contentDocument;

                    if (typeof childWindow?.setVolume === 'function') {
                        childWindow.setVolume(normalized / 100);
                    }

                    if (childWindow?.gba?.audio) {
                        childWindow.gba.audio.masterEnable = normalized > 0;

                        if (normalized > 0 && childWindow.gba.audio.context?.state !== 'running') {
                            childWindow.gba.audio.context.resume().catch(() => {});
                        }
                    }

                    const soundInputs = childDocument?.querySelectorAll('#sound input');

                    if (soundInputs?.length === 2) {
                        soundInputs[0].checked = normalized > 0;
                        soundInputs[1].value = normalized / 100;
                    }
                } catch (error) {
                    console.warn('No se pudo aplicar el volumen al emulador embebido.', error);
                }
            }

            function syncPreferencesToFrame() {
                applyBackground(currentPreferences.emulator_background);
                applyThemeToFrame();
                applyVolume(currentPreferences.audio_volume);
            }

            frame.addEventListener('load', () => {
                window.setTimeout(syncPreferencesToFrame, 150);
            });

            document.addEventListener('visibilitychange', () => {
                if (document.visibilityState === 'hidden') {
                    accumulateVisibleTime();
                    return;
                }

                resumeVisibleTime();
            });

            window.addEventListener('pagehide', reportGameSession);
            window.addEventListener('beforeunload', reportGameSession);
            window.addEventListener('pageshow', (event) => {
                if (!event.persisted) {
                    return;
                }

                accumulatedVisibleMs = 0;
                lastVisibleAt = document.visibilityState === 'visible' ? Date.now() : null;
                sessionReported = false;
            });

            syncPreferencesToFrame();
        </script>
    @else
        <div class="panel">
            <h1>Faltan los archivos del emulador</h1>
            <p>El catalogo ya esta listo, pero en este repositorio no existe <code>public/emulator/gbajs2/index.html</code>, asi que todavia no puedo arrancar la ROM seleccionada.</p>
            <p>Juego seleccionado: <strong>{{ $rom->title }}</strong></p>
            <p>La ruta segura de la ROM ya funciona y queda preparada para cuando copies el emulador completo:</p>
            <p><a href="{{ $romUrl }}">{{ $romUrl }}</a></p>
        </div>
    @endif
</body>
</html>
