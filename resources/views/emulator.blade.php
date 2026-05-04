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
            --panel: {{ $activeTheme['panel_strong'] ?? 'rgba(15, 23, 42, 0.88)' }};
            --panel-soft: {{ $activeTheme['panel'] ?? 'rgba(15, 23, 42, 0.72)' }};
            --line: {{ $activeTheme['line'] ?? 'rgba(255, 255, 255, 0.12)' }};
            --muted: {{ $activeTheme['subtle'] ?? '#94a3b8' }};
            --text: {{ $activeTheme['text'] ?? '#e2e8f0' }};
            --accent: {{ $activeTheme['accent'] ?? '#67e8f9' }};
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
            display: grid;
            gap: 16px;
            grid-template-columns: minmax(280px, 340px) minmax(0, 1fr);
            min-height: 100vh;
            padding: 20px;
        }

        .controls-panel,
        .emulator-panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 24px;
            box-shadow: 0 20px 80px rgba(15, 23, 42, 0.32);
        }

        .controls-panel {
            padding: 22px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .eyebrow {
            margin: 0 0 8px;
            color: var(--accent);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.28em;
            text-transform: uppercase;
        }

        .heading {
            margin: 0;
            font-size: 28px;
        }

        .subtle {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
            margin: 10px 0 0;
        }

        .section-title {
            margin: 0 0 10px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .preset-grid {
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .preset-button {
            background: rgba(15, 23, 42, 0.76);
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 18px;
            color: var(--text);
            cursor: pointer;
            overflow: hidden;
            padding: 0;
            text-align: left;
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .preset-button:hover {
            border-color: color-mix(in srgb, var(--accent) 36%, transparent);
            transform: translateY(-1px);
        }

        .preset-button[data-active="true"] {
            border-color: color-mix(in srgb, var(--accent) 56%, transparent);
            box-shadow: 0 0 0 1px color-mix(in srgb, var(--accent) 25%, transparent), 0 18px 42px rgba(8, 47, 73, 0.26);
        }

        .preset-preview {
            aspect-ratio: 16 / 9;
            width: 100%;
        }

        .preset-content {
            padding: 12px;
        }

        .preset-name {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .preset-meta {
            color: var(--muted);
            font-size: 12px;
        }

        .volume-card {
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: 20px;
            background: var(--panel-soft);
            padding: 16px;
        }

        .volume-row {
            align-items: center;
            display: flex;
            gap: 12px;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .volume-value {
            color: var(--accent);
            font-size: 14px;
            font-weight: 700;
        }

        input[type="range"] {
            width: 100%;
        }

        .status {
            color: var(--muted);
            font-size: 12px;
            min-height: 18px;
        }

        .emulator-panel {
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-height: calc(100vh - 40px);
            padding: 16px;
        }

        .emulator-frame-shell {
            background: var(--page-background);
            border: 1px solid rgba(148, 163, 184, 0.14);
            border-radius: 18px;
            flex: 1;
            min-height: 0;
            overflow: hidden;
            padding: 10px;
            transition: background 0.2s ease;
        }

        .emulator-frame {
            background: #020617;
            border: 0;
            border-radius: 14px;
            display: block;
            height: 100%;
            min-height: 560px;
            width: 100%;
        }

        .emulator-header {
            align-items: center;
            display: flex;
            gap: 12px;
            justify-content: space-between;
            padding: 4px 2px 0;
        }

        .emulator-meta {
            color: var(--muted);
            font-size: 13px;
        }

        @media (max-width: 980px) {
            .shell {
                grid-template-columns: 1fr;
            }

            .emulator-panel {
                min-height: 70vh;
            }

            .emulator-frame {
                min-height: 480px;
            }
        }
    </style>
</head>
<body>
    @if ($emulatorReady)
        @php($activePreset = $backgroundPresets[$emulatorPreferences['emulator_background']] ?? $backgroundPresets['nebula'])
        <div class="shell">
            <aside class="controls-panel">
                <section>
                    <p class="eyebrow">Configuración aplicada</p>
                    <h1 class="heading">{{ $rom->title }}</h1>
                    <p class="subtle">
                        El fondo y el volumen se cargan automáticamente desde tu perfil. Cada usuario mantiene su propia configuración sin afectar al resto.
                    </p>
                </section>

                <section class="volume-card">
                    <div class="volume-row">
                        <h2 class="section-title" style="margin:0;">Fondo activo</h2>
                        <span class="volume-value">{{ $activePreset['label'] }}</span>
                    </div>
                    <div class="preset-preview" style="display:block; border-radius:16px; background: {{ $activePreset['css'] }}"></div>
                    <p class="subtle">Esta ambientación se ha cargado desde tu configuración personal.</p>
                </section>

                <section class="volume-card">
                    <div class="volume-row">
                        <h2 class="section-title" style="margin:0;">Volumen</h2>
                        <span class="volume-value">{{ $emulatorPreferences['audio_volume'] }}%</span>
                    </div>
                    <p class="subtle">El valor guardado en tu perfil se aplica al juego cuando termina de cargar.</p>
                </section>

                <a
                    href="{{ $profileUrl }}"
                    style="display:inline-flex; align-items:center; justify-content:center; min-height:48px; border-radius:18px; border:1px solid rgba(103, 232, 249, 0.24); background: rgba(34, 211, 238, 0.12); color:#cffafe; font-weight:700; text-decoration:none;"
                >
                    Abrir Mi perfil
                </a>
            </aside>

            <section class="emulator-panel">
                <div class="emulator-header">
                    <div>
                        <p class="eyebrow" style="margin-bottom:4px;">Emulador</p>
                        <p style="margin:0; font-size:20px; font-weight:700;">Sesión lista</p>
                    </div>
                    <p class="emulator-meta">Preferencias cargadas desde Mi perfil</p>
                </div>

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

            const frame = document.getElementById('emulator-frame');
            const frameShell = document.getElementById('emulator-frame-shell');

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
                applyVolume(currentPreferences.audio_volume);
            }

            frame.addEventListener('load', () => {
                window.setTimeout(syncPreferencesToFrame, 150);
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
