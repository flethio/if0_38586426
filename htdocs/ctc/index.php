<?php
// Menetapkan header untuk memastikan browser merender HTML dengan benar
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Text Cleaner</title>

    <!-- Bootstrap 5 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- CodeMirror CSS (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.15/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.15/theme/monokai.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.15/theme/eclipse.min.css">
    <!-- Diff2Html CSS (CDN) -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/diff2html/bundles/css/diff2html.min.css" />

    <style>
        :root {
            --bg-color: #f8f9fa;
            --sidebar-bg: #ffffff;
            --text-color: #212529;
            --border-color: #dee2e6;
        }

        [data-bs-theme="dark"] {
            --bg-color: #212529;
            --sidebar-bg: #343a40;
            --text-color: #f8f9fa;
            --border-color: #495057;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar {
            height: 100vh;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            overflow-y: auto;
            z-index: 1000;
            transition: background-color 0.3s;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .nav-link {
            color: var(--text-color);
            border-radius: 0;
            transition: background-color 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }

        .tool-panel {
            display: none;
            animation: fadeIn 0.5s;
        }

        .tool-panel.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .editor-container {
            border: 1px solid var(--border-color);
            border-radius: 5px;
            overflow: hidden;
        }

        .CodeMirror {
            height: 500px;
            font-size: 14px;
        }
        
        .stats-bar {
            background-color: var(--sidebar-bg);
            border: 1px solid var(--border-color);
            border-top: none;
            padding: 5px 10px;
            font-size: 12px;
            color: #6c757d;
        }
        
        .preview-frame {
            width: 100%;
            height: 500px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
        }

        .d2h-wrapper {
            background: transparent;
            border: none;
            text-align: left;
        }
        .d2h-file-header {
            background-color: var(--sidebar-bg);
            border-bottom: 1px solid var(--border-color);
        }
        .d2h-code-wrapper {
            border: 1px solid var(--border-color);
            border-radius: 5px;
        }
        .d2h-diff-table {
            background-color: var(--bg-color);
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center mb-4"><i class="bi bi-code-slash"></i> Code Tools</h4>
        <nav class="nav flex-column">
            <a class="nav-link active" href="#" data-tool="text-tools"><i class="bi bi-fonts"></i> Text Tools</a>
            <a class="nav-link" href="#" data-tool="code-cleaner"><i class="bi bi-brush"></i> Code Cleaner</a>
            <a class="nav-link" href="#" data-tool="combine-split"><i class="bi bi-link"></i> Combine & Split</a>
            <a class="nav-link" href="#" data-tool="text-comparison"><i class="bi bi-columns-gap"></i> Text Comparison</a>
            <a class="nav-link" href="#" data-tool="text-analysis"><i class="bi bi-bar-chart"></i> Text Analysis</a>
        </nav>
        <hr>
        <div class="d-flex justify-content-center p-2">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="theme-switch">
                <label class="form-check-label" for="theme-switch">Dark Mode</label>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Code Text Cleaner</h1>
            <div>
                <button class="btn btn-secondary btn-sm" id="word-wrap-toggle"><i class="bi bi-text-paragraph"></i> Word Wrap</button>
                <button class="btn btn-primary btn-sm" id="save-workspace"><i class="bi bi-save"></i> Save Workspace</button>
            </div>
        </div>

        <!-- Text Tools Panel -->
        <div id="text-tools" class="tool-panel active">
            <h2>Text Transformation & Encoding</h2>
            <div class="row">
                <div class="col-md-6">
                    <label for="input-text-tools" class="form-label">Input</label>
                    <div class="editor-container">
                        <textarea id="input-text-tools"></textarea>
                    </div>
                    <div class="stats-bar" id="stats-input-text-tools">Words: 0 | Characters: 0 | Lines: 0</div>
                </div>
                <div class="col-md-6">
                    <label for="output-text-tools" class="form-label">Output</label>
                    <div class="editor-container">
                        <textarea id="output-text-tools"></textarea>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <h5>Transform</h5>
                <button class="btn btn-outline-primary btn-sm" data-action="uppercase">UPPERCASE</button>
                <button class="btn btn-outline-primary btn-sm" data-action="lowercase">lowercase</button>
                <button class="btn btn-outline-primary btn-sm" data-action="capitalize">Capitalize Each Word</button>
                <button class="btn btn-outline-primary btn-sm" data-action="trim">Trim</button>
                <button class="btn btn-outline-primary btn-sm" data-action="reverse">Reverse</button>
                <button class="btn btn-outline-primary btn-sm" data-action="sort-lines">Sort Lines</button>
            </div>
            <div class="mt-3">
                <h5>Encode / Decode</h5>
                <button class="btn btn-outline-success btn-sm" data-action="encode-base64">Encode Base64</button>
                <button class="btn btn-outline-success btn-sm" data-action="decode-base64">Decode Base64</button>
                <button class="btn btn-outline-info btn-sm" data-action="encode-uri">Encode URL</button>
                <button class="btn btn-outline-info btn-sm" data-action="decode-uri">Decode URL</button>
            </div>
            <div class="mt-3">
                <h5>Format</h5>
                <button class="btn btn-outline-warning btn-sm" data-action="format-json">Format JSON</button>
            </div>
        </div>

        <!-- Code Cleaner Panel -->
        <div id="code-cleaner" class="tool-panel">
            <h2>Code Cleaner (Minify & Format)</h2>
            <div class="mb-3">
                <label for="code-lang-select" class="form-label">Select Language</label>
                <select class="form-select" id="code-lang-select">
                    <option value="html">HTML</option>
                    <option value="css">CSS</option>
                    <option value="javascript">JavaScript</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="input-code-cleaner" class="form-label">Input</label>
                    <div class="editor-container">
                        <textarea id="input-code-cleaner"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="output-code-cleaner" class="form-label">Output</label>
                    <div class="editor-container">
                        <textarea id="output-code-cleaner"></textarea>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-success" id="format-code"><i class="bi bi-magic"></i> Format / Prettify</button>
                <button class="btn btn-danger" id="minify-code"><i class="bi bi-compress"></i> Minify</button>
                <button class="btn btn-warning" id="remove-comments"><i class="bi bi-eraser"></i> Remove Comments</button>
                <button class="btn btn-info" id="preview-html" style="display:none;"><i class="bi bi-eye"></i> Preview HTML</button>
            </div>
        </div>

        <!-- Combine & Split Panel -->
        <div id="combine-split" class="tool-panel">
            <h2>Combine & Split</h2>
            <div class="row">
                <div class="col-md-4">
                    <label for="input-html-combine" class="form-label">HTML</label>
                    <div class="editor-container">
                        <textarea id="input-html-combine" placeholder="Paste your HTML here..."></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="input-css-combine" class="form-label">CSS</label>
                    <div class="editor-container">
                        <textarea id="input-css-combine" placeholder="Paste your CSS here..."></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="input-js-combine" class="form-label">JavaScript</label>
                    <div class="editor-container">
                        <textarea id="input-js-combine" placeholder="Paste your JavaScript here..."></textarea>
                    </div>
                </div>
            </div>
            <div class="mt-3 mb-3">
                <button class="btn btn-primary" id="combine-btn"><i class="bi bi-link-45deg"></i> Combine into HTML</button>
                <button class="btn btn-secondary" id="split-btn"><i class="bi bi-scissors"></i> Split HTML</button>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <label for="output-combine-split" class="form-label">Combined / Split Output</label>
                    <div class="editor-container">
                        <textarea id="output-combine-split"></textarea>
                    </div>
                    <button class="btn btn-info mt-2" id="preview-combined" style="display:none;"><i class="bi bi-eye"></i> Preview Combined HTML</button>
                </div>
            </div>
        </div>

        <!-- Text Comparison Panel -->
        <div id="text-comparison" class="tool-panel">
            <h2>Text Comparison (Diff)</h2>
            <div class="row">
                <div class="col-md-6">
                    <label for="input-diff-old" class="form-label">Original Text</label>
                    <div class="editor-container">
                        <textarea id="input-diff-old"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="input-diff-new" class="form-label">Changed Text</label>
                    <div class="editor-container">
                        <textarea id="input-diff-new"></textarea>
                    </div>
                </div>
            </div>
            <div class="mt-3 mb-3">
                <button class="btn btn-primary" id="compare-btn"><i class="bi bi-columns-gap"></i> Compare</button>
            </div>
            <div id="diff-output"></div>
        </div>

        <!-- Text Analysis Panel -->
        <div id="text-analysis" class="tool-panel">
            <h2>Text Analysis</h2>
            <div class="row">
                <div class="col-md-8">
                    <label for="input-text-analysis" class="form-label">Input Text</label>
                    <div class="editor-container">
                        <textarea id="input-text-analysis"></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>Statistics</h5>
                    <ul class="list-group" id="analysis-stats">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Characters (no spaces)
                            <span class="badge bg-primary rounded-pill" id="stat-chars-nospace">0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Characters (with spaces)
                            <span class="badge bg-primary rounded-pill" id="stat-chars-space">0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Words
                            <span class="badge bg-primary rounded-pill" id="stat-words">0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Lines
                            <span class="badge bg-primary rounded-pill" id="stat-lines">0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Sentences
                            <span class="badge bg-primary rounded-pill" id="stat-sentences">0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Paragraphs
                            <span class="badge bg-primary rounded-pill" id="stat-paragraphs">0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Reading Time (est.)
                            <span class="badge bg-primary rounded-pill" id="stat-reading-time">0 min</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <h5>Top 10 Word Frequencies</h5>
                    <div id="word-freq-chart"></div>
                </div>
                <div class="col-md-6">
                    <h5>Top 10 Character Frequencies</h5>
                    <div id="char-freq-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for HTML Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">HTML Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="btn-group mb-2" role="group">
                        <button type="button" class="btn btn-outline-secondary active" data-device="desktop">Desktop</button>
                        <button type="button" class="btn btn-outline-secondary" data-device="tablet">Tablet</button>
                        <button type="button" class="btn btn-outline-secondary" data-device="mobile">Mobile</button>
                    </div>
                    <iframe id="preview-frame" class="preview-frame"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (CDN) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 JS Bundle (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CodeMirror JS (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.15/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.15/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.15/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.15/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.15/mode/htmlmixed/htmlmixed.min.js"></script>
    <!-- Diff2Html JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/diff@5.1.0/dist/diff.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/diff2html/bundles/js/diff2html-ui.min.js"></script>
    <!-- JS Beautify (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.14.11/beautify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.14.11/beautify-css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.14.11/beautify-html.min.js"></script>
    <!-- Chart.js (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Global Variables ---
            const editors = {};
            let wordWrap = false;

            // --- Initialize CodeMirror Editors ---
            function setupEditor(id, mode = 'htmlmixed', theme = 'eclipse') {
                const editor = CodeMirror.fromTextArea(document.getElementById(id), {
                    lineNumbers: true,
                    mode: mode,
                    theme: theme,
                    lineWrapping: wordWrap
                });
                editors[id] = editor;
                return editor;
            }

            // Text Tools Editors
            setupEditor('input-text-tools', 'text/plain');
            setupEditor('output-text-tools', 'text/plain');
            // Code Cleaner Editors
            setupEditor('input-code-cleaner', 'htmlmixed');
            setupEditor('output-code-cleaner', 'htmlmixed');
            // Combine & Split Editors
            setupEditor('input-html-combine', 'htmlmixed');
            setupEditor('input-css-combine', 'css');
            setupEditor('input-js-combine', 'javascript');
            setupEditor('output-combine-split', 'htmlmixed');
            // Text Comparison Editors
            setupEditor('input-diff-old', 'text/plain');
            setupEditor('input-diff-new', 'text/plain');
            // Text Analysis Editor
            setupEditor('input-text-analysis', 'text/plain');

            // --- Theme Switching ---
            const themeSwitch = document.getElementById('theme-switch');
            const htmlElement = document.documentElement;
            
            // Load saved theme
            const currentTheme = localStorage.getItem('theme') || 'light';
            if (currentTheme === 'dark') {
                htmlElement.setAttribute('data-bs-theme', 'dark');
                themeSwitch.checked = true;
                updateEditorTheme('monokai');
            }

            themeSwitch.addEventListener('change', () => {
                if (themeSwitch.checked) {
                    htmlElement.setAttribute('data-bs-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                    updateEditorTheme('monokai');
                } else {
                    htmlElement.removeAttribute('data-bs-theme');
                    localStorage.setItem('theme', 'light');
                    updateEditorTheme('eclipse');
                }
            });

            function updateEditorTheme(theme) {
                for (const id in editors) {
                    editors[id].setOption('theme', theme);
                }
            }

            // --- Sidebar Navigation ---
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            const toolPanels = document.querySelectorAll('.tool-panel');

            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetTool = link.getAttribute('data-tool');

                    navLinks.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');

                    toolPanels.forEach(panel => {
                        if (panel.id === targetTool) {
                            panel.classList.add('active');
                            // Refresh editor to fix display issues
                            for(const id in editors){
                                if(panel.contains(editors[id].getWrapperElement())){
                                    editors[id].refresh();
                                }
                            }
                        } else {
                            panel.classList.remove('active');
                        }
                    });
                });
            });

            // --- Utility Functions ---
            function updateStats(editorId, statsBarId) {
                const text = editors[editorId].getValue();
                const words = text.trim() === '' ? 0 : text.trim().split(/\s+/).length;
                const characters = text.length;
                const lines = text.split('\n').length;
                document.getElementById(statsBarId).textContent = `Words: ${words} | Characters: ${characters} | Lines: ${lines}`;
            }
            
            // --- Text Tools Functionality ---
            const inputTextToolsEditor = editors['input-text-tools'];
            const outputTextToolsEditor = editors['output-text-tools'];
            
            inputTextToolsEditor.on('change', () => updateStats('input-text-tools', 'stats-input-text-tools'));

            document.querySelectorAll('[data-action]').forEach(button => {
                button.addEventListener('click', () => {
                    const action = button.getAttribute('data-action');
                    let text = inputTextToolsEditor.getValue();
                    let result = '';

                    switch (action) {
                        case 'uppercase': result = text.toUpperCase(); break;
                        case 'lowercase': result = text.toLowerCase(); break;
                        case 'capitalize': result = text.replace(/\b\w/g, l => l.toUpperCase()); break;
                        case 'trim': result = text.trim(); break;
                        case 'reverse': result = text.split('').reverse().join(''); break;
                        case 'sort-lines': result = text.split('\n').sort().join('\n'); break;
                        case 'encode-base64': result = btoa(unescape(encodeURIComponent(text))); break;
                        case 'decode-base64': try { result = decodeURIComponent(escape(atob(text))); } catch(e) { result = 'Invalid Base64'; } break;
                        case 'encode-uri': result = encodeURIComponent(text); break;
                        case 'decode-uri': try { result = decodeURIComponent(text); } catch(e) { result = 'Invalid URI'; } break;
                        case 'format-json':
                            try { result = JSON.stringify(JSON.parse(text), null, 2); }
                            catch(e) { result = `Invalid JSON: ${e.message}`; }
                            break;
                    }
                    outputTextToolsEditor.setValue(result);
                });
            });

            // --- Code Cleaner Functionality ---
            const codeLangSelect = document.getElementById('code-lang-select');
            const inputCodeCleanerEditor = editors['input-code-cleaner'];
            const outputCodeCleanerEditor = editors['output-code-cleaner'];
            const previewHtmlBtn = document.getElementById('preview-html');
            
            codeLangSelect.addEventListener('change', () => {
                const mode = codeLangSelect.value;
                const modeMap = { 'html': 'htmlmixed', 'css': 'css', 'javascript': 'javascript' };
                inputCodeCleanerEditor.setOption('mode', modeMap[mode]);
                outputCodeCleanerEditor.setOption('mode', modeMap[mode]);
                previewHtmlBtn.style.display = mode === 'html' ? 'inline-block' : 'none';
            });

            document.getElementById('format-code').addEventListener('click', () => {
                const code = inputCodeCleanerEditor.getValue();
                const lang = codeLangSelect.value;
                let formattedCode = '';
                try {
                    if (lang === 'html') {
                        formattedCode = html_beautify(code, { indent_size: 2 });
                    } else if (lang === 'css') {
                        formattedCode = css_beautify(code, { indent_size: 2 });
                    } else if (lang === 'javascript') {
                        formattedCode = js_beautify(code, { indent_size: 2 });
                    }
                } catch (e) {
                    formattedCode = `Error formatting code: ${e.message}`;
                }
                outputCodeCleanerEditor.setValue(formattedCode);
            });

            document.getElementById('minify-code').addEventListener('click', () => {
                const code = inputCodeCleanerEditor.getValue();
                const lang = codeLangSelect.value;
                let minifiedCode = '';
                
                if (lang === 'html') {
                    // Simple HTML minification
                    minifiedCode = code.replace(/>\s+</g, '><').replace(/\s+/g, ' ').trim();
                } else if (lang === 'css') {
                    // Simple CSS minification
                    minifiedCode = code.replace(/\/\*[\s\S]*?\*\//g, '').replace(/\s+/g, ' ').replace(/;\s*}/g, '}').trim();
                } else if (lang === 'javascript') {
                    // Simple JS minification
                    minifiedCode = code.replace(/\/\*[\s\S]*?\*\//g, '').replace(/\/\/.*$/gm, '').replace(/\s+/g, ' ').trim();
                }
                outputCodeCleanerEditor.setValue(minifiedCode);
            });

            document.getElementById('remove-comments').addEventListener('click', () => {
                const code = inputCodeCleanerEditor.getValue();
                const lang = codeLangSelect.value;
                let codeWithoutComments = '';
                
                if (lang === 'html') {
                    codeWithoutComments = code.replace(/<!--[\s\S]*?-->/g, '');
                } else if (lang === 'css') {
                    codeWithoutComments = code.replace(/\/\*[\s\S]*?\*\//g, '');
                } else if (lang === 'javascript') {
                    codeWithoutComments = code.replace(/\/\*[\s\S]*?\*\//g, '').replace(/\/\/.*$/gm, '');
                }
                outputCodeCleanerEditor.setValue(codeWithoutComments);
            });

            // --- Combine & Split Functionality ---
            const outputCombineEditor = editors['output-combine-split'];
            document.getElementById('combine-btn').addEventListener('click', () => {
                const html = editors['input-html-combine'].getValue();
                const css = editors['input-css-combine'].getValue();
                const js = editors['input-js-combine'].getValue();

                let combinedHtml = html;
                if (css) {
                    combinedHtml = combinedHtml.replace('</head>', `  <style>\n${css}\n  </style>\n</head>`);
                }
                if (js) {
                    combinedHtml = combinedHtml.replace('</body>', `  <script>\n${js}\n  </script>\n</body>`);
                }
                outputCombineEditor.setValue(combinedHtml);
                document.getElementById('preview-combined').style.display = 'inline-block';
            });

            document.getElementById('split-btn').addEventListener('click', () => {
                const combinedHtml = outputCombineEditor.getValue();
                const cssMatch = combinedHtml.match(/<style[^>]*>([\s\S]*?)<\/style>/i);
                const jsMatch = combinedHtml.match(/<script[^>]*>([\s\S]*?)<\/script>/i);

                const css = cssMatch ? cssMatch[1] : '';
                const js = jsMatch ? jsMatch[1] : '';
                
                let htmlWithoutCssJs = combinedHtml.replace(/<style[^>]*>[\s\S]*?<\/style>/gi, '').replace(/<script[^>]*>[\s\S]*?<\/script>/gi, '');
                
                editors['input-html-combine'].setValue(htmlWithoutCssJs.trim());
                editors['input-css-combine'].setValue(css.trim());
                editors['input-js-combine'].setValue(js.trim());
            });
            
            // --- Text Comparison (Diff) Functionality ---
            document.getElementById('compare-btn').addEventListener('click', () => {
                const oldText = editors['input-diff-old'].getValue();
                const newText = editors['input-diff-new'].getValue();
                
                const diffString = Diff.createPatch('file', oldText, newText);
                const targetElement = document.getElementById('diff-output');
                const configuration = { drawFileList: false, matching: 'lines' };
                const diff2htmlUi = new Diff2HtmlUI(targetElement, diffString, configuration);
                diff2htmlUi.draw();
                diff2htmlUi.highlightCode();
            });

            // --- Text Analysis Functionality ---
            const analysisInputEditor = editors['input-text-analysis'];
            analysisInputEditor.on('change', analyzeText);

            function analyzeText() {
                const text = analysisInputEditor.getValue();
                
                // Basic stats
                const charsWithSpace = text.length;
                const charsWithoutSpace = text.replace(/\s/g, '').length;
                const words = text.trim() === '' ? 0 : text.trim().split(/\s+/).length;
                const lines = text.split('\n').length;
                const sentences = text.trim() === '' ? 0 : text.split(/[.!?]+/).filter(s => s.trim().length > 0).length;
                const paragraphs = text.trim() === '' ? 0 : text.split(/\n\n+/).filter(p => p.trim().length > 0).length;
                const readingTime = Math.ceil(words / 200); // Assuming 200 WPM

                document.getElementById('stat-chars-nospace').textContent = charsWithoutSpace;
                document.getElementById('stat-chars-space').textContent = charsWithSpace;
                document.getElementById('stat-words').textContent = words;
                document.getElementById('stat-lines').textContent = lines;
                document.getElementById('stat-sentences').textContent = sentences;
                document.getElementById('stat-paragraphs').textContent = paragraphs;
                document.getElementById('stat-reading-time').textContent = `${readingTime} min`;

                // Frequency analysis
                const wordFreq = {};
                const charFreq = {};
                const cleanWords = text.toLowerCase().replace(/[.,\/#!$%\^&\*;:{}=\-_`~()]/g, "").split(/\s+/);
                cleanWords.forEach(word => {
                    if(word) wordFreq[word] = (wordFreq[word] || 0) + 1;
                });
                text.replace(/\s/g, "").split('').forEach(char => {
                    charFreq[char] = (charFreq[char] || 0) + 1;
                });

                const sortedWordFreq = Object.entries(wordFreq).sort((a, b) => b[1] - a[1]).slice(0, 10);
                const sortedCharFreq = Object.entries(charFreq).sort((a, b) => b[1] - a[1]).slice(0, 10);

                // Update charts
                updateChart('word-freq-chart', sortedWordFreq, 'Word Frequencies');
                updateChart('char-freq-chart', sortedCharFreq, 'Character Frequencies');
            }
            
            function updateChart(elementId, data, label) {
                const ctx = document.getElementById(elementId);
                if (!ctx) return;
                
                if (window[`${elementId}-chart`]) {
                    window[`${elementId}-chart`].destroy();
                }

                window[`${elementId}-chart`] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.map(item => item[0]),
                        datasets: [{
                            label: label,
                            data: data.map(item => item[1]),
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }


            // --- Additional Features ---
            // Word Wrap Toggle
            document.getElementById('word-wrap-toggle').addEventListener('click', () => {
                wordWrap = !wordWrap;
                for (const id in editors) {
                    editors[id].setOption('lineWrapping', wordWrap);
                }
            });

            // HTML Preview
            const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
            const previewFrame = document.getElementById('preview-frame');
            
            function showPreview(content) {
                const blob = new Blob([content], { type: 'text/html' });
                previewFrame.src = URL.createObjectURL(blob);
                previewModal.show();
            }

            document.getElementById('preview-html').addEventListener('click', () => {
                showPreview(outputCodeCleanerEditor.getValue());
            });

            document.getElementById('preview-combined').addEventListener('click', () => {
                showPreview(outputCombineEditor.getValue());
            });
            
            // Preview device buttons
            document.querySelectorAll('[data-device]').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('[data-device]').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    
                    const device = btn.getAttribute('data-device');
                    let width = '100%';
                    if (device === 'tablet') width = '768px';
                    if (device === 'mobile') width = '375px';
                    
                    previewFrame.style.width = width;
                    previewFrame.style.margin = '0 auto';
                    previewFrame.style.display = 'block';
                });
            });

            // Save/Load Workspace (using localStorage)
            document.getElementById('save-workspace').addEventListener('click', () => {
                const workspace = {};
                for (const id in editors) {
                    workspace[id] = editors[id].getValue();
                }
                localStorage.setItem('codeCleanerWorkspace', JSON.stringify(workspace));
                alert('Workspace saved!');
            });

            function loadWorkspace() {
                const savedWorkspace = localStorage.getItem('codeCleanerWorkspace');
                if (savedWorkspace) {
                    const workspace = JSON.parse(savedWorkspace);
                    for (const id in workspace) {
                        if (editors[id]) {
                            editors[id].setValue(workspace[id]);
                        }
                    }
                }
            }
            loadWorkspace();
        });
    </script>
</body>
</html>