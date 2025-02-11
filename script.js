document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("infoModal");
    const openModalBtn = document.getElementById("openModalBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");

    if (modal && openModalBtn && closeModalBtn) {
        openModalBtn.addEventListener("click", function () {
            modal.style.display = "flex";
            setTimeout(() => {
                modal.classList.add("show");
            }, 10);
        });

        closeModalBtn.addEventListener("click", function () {
            modal.classList.remove("show");
            setTimeout(() => {
                modal.style.display = "none";
            }, 300);
        });

        window.addEventListener("click", function (event) {
            if (event.target === modal) {
                modal.classList.remove("show");
                setTimeout(() => {
                    modal.style.display = "none";
                }, 300);
            }
        });

        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") {
                modal.classList.remove("show");
                setTimeout(() => {
                    modal.style.display = "none";
                }, 300);
            }
        });
    }



    // Efek transisi antar halaman
    document.querySelectorAll("a").forEach(link => {
        link.addEventListener("click", function (event) {
            if (this.href.startsWith(window.location.origin)) {
                event.preventDefault();
                let targetUrl = this.href;

                document.body.classList.add("fade-out");
                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 500);
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        let index = 0;
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;
        const slider = document.querySelector('.slider');
    
        function nextSlide() {
            index = (index + 1) % totalSlides;
            slider.style.transform = `translateX(-${index * 100}vw)`;
        }
    
        setInterval(nextSlide, 5000); // Ganti gambar setiap 5 detik
    });    
});