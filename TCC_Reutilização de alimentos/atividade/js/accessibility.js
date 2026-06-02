/* Sistema de Acessibilidade - JavaScript */
(function() {
    'use strict';

    const STORAGE_KEY = 'accessibility-preferences';

    class AccessibilityManager {
        constructor() {
            this.loadPreferences();
            this.initializeUI();
            this.attachEventListeners();
        }

        loadPreferences() {
            const stored = localStorage.getItem(STORAGE_KEY);
            this.preferences = stored ? JSON.parse(stored) : {
                darkMode: false,
                fontSize: 'normal', // small, normal, medium, large
                highContrast: false,
                highSpacing: false,
                readableFont: false,
                reduceMotion: false,
                largeButtons: false,
                largeInputs: false,
                highlightLinks: false,
                visibleFocus: false,
                colorblindMode: 'none', // none, deuteranopia, protanopia, tritanopia
                largeIndicator: false
            };
            this.applyPreferences();
        }

        savePreferences() {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(this.preferences));
            // Salvar também no servidor se necessário
            this.syncWithServer();
        }

        syncWithServer() {
            // Enviar para o servidor via AJAX
            if (document.body.dataset.userId) {
                fetch('salvarAcessibilidade.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.preferences)
                }).catch(() => {
                    // Falha silenciosa - as preferências continuam localmente
                });
            }
        }

        applyPreferences() {
            const body = document.body;

            // Limpar classes anteriores
            body.classList.remove(
                'dark-mode', 'font-small', 'font-medium', 'font-large',
                'high-contrast', 'high-spacing', 'readable-font',
                'reduce-motion', 'large-buttons', 'large-inputs',
                'highlight-links', 'visible-focus', 'colorblind-deuteranopia',
                'colorblind-protanopia', 'colorblind-tritanopia', 'large-cursor'
            );

            // Aplicar classes baseado nas preferências
            if (this.preferences.darkMode) body.classList.add('dark-mode');
            if (this.preferences.fontSize === 'small') body.classList.add('font-small');
            if (this.preferences.fontSize === 'medium') body.classList.add('font-medium');
            if (this.preferences.fontSize === 'large') body.classList.add('font-large');
            if (this.preferences.highContrast) body.classList.add('high-contrast');
            if (this.preferences.highSpacing) body.classList.add('high-spacing');
            if (this.preferences.readableFont) body.classList.add('readable-font');
            if (this.preferences.reduceMotion) body.classList.add('reduce-motion');
            if (this.preferences.largeButtons) body.classList.add('large-buttons');
            if (this.preferences.largeInputs) body.classList.add('large-inputs');
            if (this.preferences.highlightLinks) body.classList.add('highlight-links');
            if (this.preferences.visibleFocus) body.classList.add('visible-focus');
            if (this.preferences.largeIndicator) body.classList.add('large-cursor');

            if (this.preferences.colorblindMode !== 'none') {
                body.classList.add('colorblind-' + this.preferences.colorblindMode);
            }

            // Aplicar configurações de página
            this.applyPageSettings();
        }

        applyPageSettings() {
            const html = document.documentElement;
            if (this.preferences.darkMode) {
                html.style.colorScheme = 'dark';
            } else {
                html.style.colorScheme = 'light';
            }
        }

        initializeUI() {
            this.createAccessibilityPanel();
            this.updateUIState();
        }

        createAccessibilityPanel() {
            // Overlay transparente — fechar ao clicar fora
            const overlay = document.createElement('div');
            overlay.className = 'accessibility-overlay';
            overlay.addEventListener('click', () => this.closePanel());
            document.body.appendChild(overlay);
            this.overlay = overlay;

            // Sincronizar posição do overlay com o nav
            const positionOverlay = () => {
                const nav = document.querySelector('.navbar');
                const offset = nav ? nav.offsetHeight : 0;
                overlay.style.top = offset + 'px';
            };
            positionOverlay();
            window.addEventListener('resize', positionOverlay);

            // Criar botão flutuante
            const indicator = document.createElement('div');
            indicator.className = 'accessibility-indicator';
            indicator.innerHTML = '♿';
            indicator.title = 'Abrir configurações de acessibilidade';
            indicator.onclick = () => this.togglePanel();
            document.body.appendChild(indicator);

            // Criar painel
            const panel = document.createElement('div');
            panel.id = 'accessibility-panel';
            panel.className = 'accessibility-panel';

            // Posicionar abaixo do navbar
            const positionBelowNav = () => {
                const nav = document.querySelector('.navbar');
                const offset = nav ? nav.offsetHeight : 0;
                panel.style.top    = offset + 'px';
                panel.style.height = `calc(100vh - ${offset}px)`;
            };
            positionBelowNav();
            window.addEventListener('resize', positionBelowNav);
            panel.innerHTML = `
                <div class="accessibility-panel-content">
                    <div class="accessibility-panel-header">
                        <h3><i class="bi bi-universal-access"></i> Acessibilidade</h3>
                        <button class="close-btn" onclick="accessibilityManager.closePanel()" title="Fechar">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <div class="accessibility-settings">
                        <!-- Modo Escuro -->
                        <label class="accessibility-option">
                            <input type="checkbox" id="dark-mode-toggle">
                            <span>🌙 Modo Escuro</span>
                        </label>

                        <!-- Tamanho da Fonte -->
                        <fieldset class="accessibility-option-group">
                            <legend>📝 Tamanho da Fonte</legend>
                            <label>
                                <input type="radio" name="font-size" value="small">
                                Pequeno
                            </label>
                            <label>
                                <input type="radio" name="font-size" value="normal">
                                Normal
                            </label>
                            <label>
                                <input type="radio" name="font-size" value="medium">
                                Médio
                            </label>
                            <label>
                                <input type="radio" name="font-size" value="large">
                                Grande
                            </label>
                        </fieldset>

                        <!-- Alto Contraste -->
                        <label class="accessibility-option">
                            <input type="checkbox" id="high-contrast-toggle">
                            <span>⚪ Alto Contraste</span>
                        </label>

                        <!-- Espaçamento Aumentado -->
                        <label class="accessibility-option">
                            <input type="checkbox" id="high-spacing-toggle">
                            <span>📏 Espaçamento Aumentado</span>
                        </label>

                        <!-- Fonte Legível -->
                        <label class="accessibility-option">
                            <input type="checkbox" id="readable-font-toggle">
                            <span>🔤 Fonte Legível</span>
                        </label>

                        <!-- Reduzir Animações -->
                        <label class="accessibility-option">
                            <input type="checkbox" id="reduce-motion-toggle">
                            <span>⏸️ Reduzir Animações</span>
                        </label>

                        <!-- Botões Maiores -->
                        <label class="accessibility-option">
                            <input type="checkbox" id="large-buttons-toggle">
                            <span>🔘 Botões Maiores</span>
                        </label>

                        <!-- Campos Maiores -->
                        <label class="accessibility-option">
                            <input type="checkbox" id="large-inputs-toggle">
                            <span>📦 Campos de Entrada Maiores</span>
                        </label>

                        <!-- Destacar Links -->
                        <label class="accessibility-option">
                            <input type="checkbox" id="highlight-links-toggle">
                            <span>🔗 Destacar Links</span>
                        </label>

                        <!-- Foco Visível -->
                        <label class="accessibility-option">
                            <input type="checkbox" id="visible-focus-toggle">
                            <span>👁️ Foco Visível</span>
                        </label>

                        <!-- Modo Daltônico -->
                        <fieldset class="accessibility-option-group">
                            <legend>🎨 Modo de Cor (Daltonismo)</legend>
                            <label>
                                <input type="radio" name="colorblind-mode" value="none">
                                Padrão
                            </label>
                            <label>
                                <input type="radio" name="colorblind-mode" value="deuteranopia">
                                Deuteranopia (Verde-Vermelho)
                            </label>
                            <label>
                                <input type="radio" name="colorblind-mode" value="protanopia">
                                Protanopia (Vermelho-Verde)
                            </label>
                            <label>
                                <input type="radio" name="colorblind-mode" value="tritanopia">
                                Tritanopia (Azul-Amarelo)
                            </label>
                        </fieldset>

                        <!-- Botões de Ação -->
                        <div class="accessibility-actions">
                            <button class="accessibility-btn reset" onclick="accessibilityManager.resetPreferences()">
                                🔄 Restaurar Padrão
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(panel);
        }

        togglePanel() {
            const panel = document.getElementById('accessibility-panel');
            const isOpen = panel.classList.toggle('open');
            if (this.overlay) this.overlay.classList.toggle('active', isOpen);
        }

        closePanel() {
            const panel = document.getElementById('accessibility-panel');
            panel.classList.remove('open');
            if (this.overlay) this.overlay.classList.remove('active');
        }

        attachEventListeners() {
            // Fechar com tecla Escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') this.closePanel();
            });
            // Modo Escuro
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            if (darkModeToggle) {
                darkModeToggle.addEventListener('change', () => {
                    this.preferences.darkMode = darkModeToggle.checked;
                    this.applyPreferences();
                    this.savePreferences();
                });
            }

            // Tamanho da Fonte
            document.querySelectorAll('input[name="font-size"]').forEach(input => {
                input.addEventListener('change', () => {
                    this.preferences.fontSize = input.value;
                    this.applyPreferences();
                    this.savePreferences();
                });
            });

            // Alto Contraste
            const highContrastToggle = document.getElementById('high-contrast-toggle');
            if (highContrastToggle) {
                highContrastToggle.addEventListener('change', () => {
                    this.preferences.highContrast = highContrastToggle.checked;
                    this.applyPreferences();
                    this.savePreferences();
                });
            }

            // Espaçamento Aumentado
            const highSpacingToggle = document.getElementById('high-spacing-toggle');
            if (highSpacingToggle) {
                highSpacingToggle.addEventListener('change', () => {
                    this.preferences.highSpacing = highSpacingToggle.checked;
                    this.applyPreferences();
                    this.savePreferences();
                });
            }

            // Fonte Legível
            const readableFontToggle = document.getElementById('readable-font-toggle');
            if (readableFontToggle) {
                readableFontToggle.addEventListener('change', () => {
                    this.preferences.readableFont = readableFontToggle.checked;
                    this.applyPreferences();
                    this.savePreferences();
                });
            }

            // Reduzir Animações
            const reduceMotionToggle = document.getElementById('reduce-motion-toggle');
            if (reduceMotionToggle) {
                reduceMotionToggle.addEventListener('change', () => {
                    this.preferences.reduceMotion = reduceMotionToggle.checked;
                    this.applyPreferences();
                    this.savePreferences();
                });
            }

            // Botões Maiores
            const largeButtonsToggle = document.getElementById('large-buttons-toggle');
            if (largeButtonsToggle) {
                largeButtonsToggle.addEventListener('change', () => {
                    this.preferences.largeButtons = largeButtonsToggle.checked;
                    this.applyPreferences();
                    this.savePreferences();
                });
            }

            // Campos Maiores
            const largeInputsToggle = document.getElementById('large-inputs-toggle');
            if (largeInputsToggle) {
                largeInputsToggle.addEventListener('change', () => {
                    this.preferences.largeInputs = largeInputsToggle.checked;
                    this.applyPreferences();
                    this.savePreferences();
                });
            }

            // Destacar Links
            const highlightLinksToggle = document.getElementById('highlight-links-toggle');
            if (highlightLinksToggle) {
                highlightLinksToggle.addEventListener('change', () => {
                    this.preferences.highlightLinks = highlightLinksToggle.checked;
                    this.applyPreferences();
                    this.savePreferences();
                });
            }

            // Foco Visível
            const visibleFocusToggle = document.getElementById('visible-focus-toggle');
            if (visibleFocusToggle) {
                visibleFocusToggle.addEventListener('change', () => {
                    this.preferences.visibleFocus = visibleFocusToggle.checked;
                    this.applyPreferences();
                    this.savePreferences();
                });
            }

            // Modo de Cor
            document.querySelectorAll('input[name="colorblind-mode"]').forEach(input => {
                input.addEventListener('change', () => {
                    this.preferences.colorblindMode = input.value;
                    this.applyPreferences();
                    this.savePreferences();
                });
            });
        }

        updateUIState() {
            // Atualizar checkboxes e radio buttons
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            if (darkModeToggle) darkModeToggle.checked = this.preferences.darkMode;

            const highContrastToggle = document.getElementById('high-contrast-toggle');
            if (highContrastToggle) highContrastToggle.checked = this.preferences.highContrast;

            const highSpacingToggle = document.getElementById('high-spacing-toggle');
            if (highSpacingToggle) highSpacingToggle.checked = this.preferences.highSpacing;

            const readableFontToggle = document.getElementById('readable-font-toggle');
            if (readableFontToggle) readableFontToggle.checked = this.preferences.readableFont;

            const reduceMotionToggle = document.getElementById('reduce-motion-toggle');
            if (reduceMotionToggle) reduceMotionToggle.checked = this.preferences.reduceMotion;

            const largeButtonsToggle = document.getElementById('large-buttons-toggle');
            if (largeButtonsToggle) largeButtonsToggle.checked = this.preferences.largeButtons;

            const largeInputsToggle = document.getElementById('large-inputs-toggle');
            if (largeInputsToggle) largeInputsToggle.checked = this.preferences.largeInputs;

            const highlightLinksToggle = document.getElementById('highlight-links-toggle');
            if (highlightLinksToggle) highlightLinksToggle.checked = this.preferences.highlightLinks;

            const visibleFocusToggle = document.getElementById('visible-focus-toggle');
            if (visibleFocusToggle) visibleFocusToggle.checked = this.preferences.visibleFocus;

            const fontSizeRadios = document.querySelectorAll('input[name="font-size"]');
            fontSizeRadios.forEach(radio => {
                radio.checked = radio.value === this.preferences.fontSize;
            });

            const colorblindRadios = document.querySelectorAll('input[name="colorblind-mode"]');
            colorblindRadios.forEach(radio => {
                radio.checked = radio.value === this.preferences.colorblindMode;
            });
        }

        resetPreferences() {
            this.preferences = {
                darkMode: false,
                fontSize: 'normal',
                highContrast: false,
                highSpacing: false,
                readableFont: false,
                reduceMotion: false,
                largeButtons: false,
                largeInputs: false,
                highlightLinks: false,
                visibleFocus: false,
                colorblindMode: 'none',
                largeIndicator: false
            };
            this.applyPreferences();
            this.updateUIState();
            this.savePreferences();
            alert('Configurações de acessibilidade restauradas para o padrão!');
        }
    }

    // Inicializar quando o DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            window.accessibilityManager = new AccessibilityManager();
        });
    } else {
        window.accessibilityManager = new AccessibilityManager();
    }
})();
