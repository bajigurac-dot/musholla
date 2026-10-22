/**
 * JavaScript Admin Panel Musholla Ar-rahman
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Toggle Sidebar di Layar Mobile
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.admin-sidebar');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            sidebar.classList.toggle('show');
        });

        // Tutup sidebar otomatis saat mengetuk area di luar sidebar pada ponsel/tablet
        document.addEventListener('click', function (e) {
            if (window.innerWidth <= 992 && sidebar.classList.contains('show')) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    }

    // 2. Preview Gambar Sebelum Diunggah
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function () {
            const previewId = this.getAttribute('data-preview');
            if (previewId) {
                const previewEl = document.getElementById(previewId);
                if (previewEl && this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewEl.src = e.target.result;
                        previewEl.style.display = 'block';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            }
        });
    });

    // 3. Konfirmasi Hapus Modal / Form Interceptor
    const deleteBtns = document.querySelectorAll('.btn-delete-confirm');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            const itemTitle = this.getAttribute('data-title') || 'data ini';
            if (!confirm(`Apakah Anda yakin ingin menghapus "${itemTitle}"? Tindakan ini tidak dapat dibatalkan.`)) {
                e.preventDefault();
            }
        });
    });

    // 4. Kalkulasi Saldo Otomatis pada Form Laporan Keuangan
    const incomeInput = document.getElementById('input-income');
    const expenseInput = document.getElementById('input-expense');
    const balancePreview = document.getElementById('preview-balance');

    function calculateBalance() {
        if (incomeInput && expenseInput && balancePreview) {
            const inc = parseFloat(incomeInput.value) || 0;
            const exp = parseFloat(expenseInput.value) || 0;
            const bal = inc - exp;
            balancePreview.textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(bal);
            if (bal >= 0) {
                balancePreview.className = 'fw-bold text-success';
            } else {
                balancePreview.className = 'fw-bold text-danger';
            }
        }
    }

    if (incomeInput && expenseInput) {
        incomeInput.addEventListener('input', calculateBalance);
        expenseInput.addEventListener('input', calculateBalance);
        calculateBalance();
    }
});
