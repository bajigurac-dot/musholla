/**
 * JavaScript Utama Website Publik Musholla Ar-rahman
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Salin Nomor Rekening ke Clipboard
    const copyBtns = document.querySelectorAll('.btn-copy-account');
    copyBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const accNum = this.getAttribute('data-account') || '0152632533100';
            navigator.clipboard.writeText(accNum).then(() => {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Tersalin!';
                this.classList.remove('btn-outline-light-custom', 'btn-outline-primary');
                this.classList.add('btn-success');

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-light-custom');
                }, 2500);
            }).catch(err => {
                prompt("Salin nomor rekening:", accNum);
            });
        });
    });

    // 2. Jam Digital Waktu Indonesia Barat (WIB)
    const liveClockEl = document.getElementById('live-clock');
    if (liveClockEl) {
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            liveClockEl.textContent = `${hours}:${minutes}:${seconds} WIB`;
        }
        updateClock();
        setInterval(updateClock, 1000);
    }

    // 3. Highlight Waktu Salat yang Akan Datang
    highlightNextPrayer();

    // 4. Modal Lightbox Galeri Foto
    const galleryItems = document.querySelectorAll('.gallery-item');
    const lightboxModal = document.getElementById('lightboxModal');
    if (lightboxModal && galleryItems.length > 0) {
        const modalImg = document.getElementById('lightboxImage');
        const modalCaption = document.getElementById('lightboxCaption');
        const bsModal = new bootstrap.Modal(lightboxModal);

        galleryItems.forEach(item => {
            item.addEventListener('click', function () {
                const img = this.querySelector('img');
                const title = this.getAttribute('data-title') || img.getAttribute('alt') || '';
                modalImg.src = img.src;
                modalCaption.textContent = title;
                bsModal.show();
            });
        });
    }
});

function highlightNextPrayer() {
    const prayerItems = document.querySelectorAll('.prayer-item');
    if (!prayerItems.length) return;

    const now = new Date();
    const currentMinutes = now.getHours() * 60 + now.getMinutes();

    let nextItem = null;
    let minDiff = Infinity;

    prayerItems.forEach(item => {
        const timeStr = item.getAttribute('data-time');
        if (!timeStr) return;
        const [h, m] = timeStr.split(':').map(Number);
        const prayerMinutes = h * 60 + m;

        let diff = prayerMinutes - currentMinutes;
        if (diff > 0 && diff < minDiff) {
            minDiff = diff;
            nextItem = item;
        }
    });

    // Jika lewat Isya, waktu berikutnya adalah Subuh besok
    if (!nextItem && prayerItems.length > 0) {
        nextItem = prayerItems[0];
    }

    if (nextItem) {
        prayerItems.forEach(i => i.classList.remove('active'));
        nextItem.classList.add('active');
    }
}
