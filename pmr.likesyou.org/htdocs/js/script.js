document.addEventListener('DOMContentLoaded', function() {

    // --- Dark Mode Toggle ---
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
        body.classList.add('dark-mode');
        darkModeToggle.textContent = '☀️';
    }
    darkModeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        const theme = body.classList.contains('dark-mode') ? 'dark' : 'light';
        localStorage.setItem('theme', theme);
        darkModeToggle.textContent = theme === 'dark' ? '☀️' : '🌙';
    });

    // --- Smooth Scrolling ---
    document.querySelectorAll('.main-nav a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // --- Scroll to Top Button ---
    const scrollTopBtn = document.getElementById('scrollTopBtn');
    window.addEventListener('scroll', () => {
        scrollTopBtn.style.display = window.pageYOffset > 300 ? 'block' : 'none';
    });
    scrollTopBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    // --- Search Functionality ---
    const searchInput = document.getElementById('searchInput');
    const guideItems = document.querySelectorAll('.guide-item');
    const noResultsMessage = document.getElementById('noResults');

    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        let hasResults = false;
        guideItems.forEach(item => {
            const isVisible = item.textContent.toLowerCase().includes(searchTerm);
            item.style.display = isVisible ? 'block' : 'none';
            if (isVisible) hasResults = true;
        });
        noResultsMessage.style.display = hasResults ? 'none' : 'block';
    });

    // --- Dynamic Checklist ---
    const checklistData = [
        { title: 'Perban & Balutan', items: ['Kasa Steril (berbagai ukuran)', 'Plester (berbagai ukuran)', 'Perban Elastis', 'Perban Triangular', 'Kapas Steril', 'Tissue Basa Antiseptik'] },
        { title: 'Alat Medis', items: ['Gunting Kecil', 'Pinset', 'Termometer', 'Sarung Tangan Medis', 'Masker Wajah', 'Peniti'] },
        { title: 'Obat-Obatan & Cairan', items: ['Cairan Antiseptik', 'Salep Antibiotik', 'Obat Antihistamin', 'Obat Penurun Demam', 'Oralit'] }
    ];
    
    const checklistContainer = document.getElementById('checklistContainer');
    const progressBar = document.getElementById('checklistProgress');
    const resetBtn = document.getElementById('resetChecklist');

    function renderChecklist() {
        checklistContainer.innerHTML = '';
        checklistData.forEach(column => {
            const colDiv = document.createElement('div');
            colDiv.className = 'checklist-column';
            colDiv.innerHTML = `<h4>${column.title}</h4>`;
            column.items.forEach(itemText => {
                const label = document.createElement('label');
                label.innerHTML = `<input type="checkbox"> ${itemText}`;
                colDiv.appendChild(label);
            });
            checklistContainer.appendChild(colDiv);
        });
        attachCheckboxListeners();
        updateProgress();
    }

    function attachCheckboxListeners() {
        checklistContainer.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateProgress);
        });
    }

    function updateProgress() {
        const checkboxes = checklistContainer.querySelectorAll('input[type="checkbox"]');
        const checked = document.querySelectorAll('input[type="checkbox"]:checked').length;
        const total = checkboxes.length;
        const percentage = total > 0 ? Math.round((checked / total) * 100) : 0;
        progressBar.style.width = `${percentage}%`;
        progressBar.textContent = `${percentage}%`;
    }

    resetBtn.addEventListener('click', () => {
        if (confirm('Apakah Anda yakin ingin mereset checklist?')) {
            checklistContainer.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            updateProgress();
        }
    });

    renderChecklist();

    // --- Dynamic Quiz ---
    const quizData = [
        {
            question: "Saat menemukan korban kecelakaan, hal pertama yang harus dilakukan adalah?",
            options: ["Langsung menolong korban", "Memastikan lokasi aman untuk diri sendiri", "Menelepon keluarga korban"],
            correctIndex: 1,
            feedback: {
                correct: "✅ Benar! Keselamatan penolong adalah prioritas utama. Jika Anda menjadi korban, tidak ada yang bisa menolong.",
                incorrect: "❌ Salah. Selalu periksa keamanan lokasi terlebih dahulu. Jangan tambah jumlah korban."
            }
        },
        {
            question: "Tindakan yang PALING TEPAT untuk menangani luka bakar ringan adalah?",
            options: ["Mengoleskan mentega", "Menyiram dengan air dingin mengalir", "Menutup dengan kapas"],
            correctIndex: 1,
            feedback: {
                correct: "✅ Benar! Air dingin mengalir adalah cara terbaik untuk mendinginkan luka dan mengurangi rasa sakit.",
                incorrect: "❌ Salah. Ini adalah mitos berbahaya yang bisa memperparah luka dan infeksi. Gunakan air dingin."
            }
        },
        {
            question: "Korban mimisan sebaiknya dalam posisi?",
            options: ["Berdiri dengan kepala menengadah ke belakang", "Duduk dengan badan sedikit condong ke depan", "Berbaring telentang"],
            correctIndex: 1,
            feedback: {
                correct: "✅ Benar! Posisi ini mencegah darah masuk ke tenggorokan yang bisa menyebabkan tersedak.",
                incorrect: "❌ Salah. Posisi ini berisiko membuat darah masuk ke saluran pencernaan atau pernapasan."
            }
        }
    ];

    const quizContainer = document.getElementById('quizContainer');

    function renderQuiz() {
        quizContainer.innerHTML = '';
        quizData.forEach((q, index) => {
            const qDiv = document.createElement('div');
            qDiv.className = 'quiz-question';
            qDiv.innerHTML = `
                <h4>Pertanyaan ${index + 1}: ${q.question}</h4>
                <div class="quiz-options">${q.options.map((opt, i) => `<button class="quiz-btn" onclick="checkAnswer(this, ${i}, ${q.correctIndex}, '${q.feedback.correct}', '${q.feedbackIncorrect}')">${opt}</button>`).join('')}</div>
                <p class="quiz-feedback"></p>
            `;
            quizContainer.appendChild(qDiv);
        });
    }
    
    window.checkAnswer = function(button, selectedIndex, correctIndex, feedbackCorrect, feedbackIncorrect) {
        const options = button.parentElement.querySelectorAll('.quiz-btn');
        const feedback = button.nextElementSibling;
        
        if (options[0].disabled) return; // Already answered

        options.forEach(btn => btn.disabled = true);
        
        if (selectedIndex === correctIndex) {
            button.style.backgroundColor = 'var(--success-color)';
            button.style.color = 'white';
            feedback.textContent = feedbackCorrect;
            feedback.style.backgroundColor = '#d4edda';
            feedback.style.color = '#155724';
        } else {
            button.style.backgroundColor = 'var(--error-color)';
            button.style.color = 'white';
            options[correctIndex].style.backgroundColor = 'var(--success-color)';
            options[correctIndex].style.color = 'white';
            feedback.textContent = feedbackIncorrect;
            feedback.style.backgroundColor = '#f8d7da';
            feedback.style.color = '#721c24';
        }
        feedback.style.display = 'block';
        feedback.style.padding = '1rem';
        feedback.style.borderRadius = '5px';
    };

    renderQuiz();
});
