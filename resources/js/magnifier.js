document.addEventListener("DOMContentLoaded", function () {
    const imgContainer = document.querySelector(".preview_img");
    const img = document.getElementById("img__container");
    const magnifier = document.getElementById("img_magnifier");
    const box = document.getElementById('magnifier_box');
    const zoomFactor = 6;
    const magnifierSize = 250;
    const styleTag = document.getElementById("dynamic-styles");

    let animationFrame;

    if (imgContainer && img && magnifier && styleTag) {
        img.addEventListener("mouseenter", function () {
            magnifier.style.opacity = 1;
            box.style.opacity = 0.4;
        });

        img.addEventListener("mousemove", function (e) {
            if (animationFrame) cancelAnimationFrame(animationFrame);

            const { width, height,left,top } = img.getBoundingClientRect();

            const x = e.offsetX; // Cursor X relative to img
            const y = e.offsetY; // Cursor Y relative to img

            if (x >= 0 && x <= width && y >= 0 && y <= height) {
                magnifier.style.opacity = 1;
                magnifier.style.backgroundImage = `url(${img.src})`;
                magnifier.style.backgroundSize = `${width * zoomFactor}px ${height * zoomFactor}px`;

                const bgPosX = -(x * zoomFactor - magnifierSize / 2);
                const bgPosY = -(y * zoomFactor - magnifierSize / 2);
                magnifier.style.backgroundPosition = `${bgPosX}px ${bgPosY}px`;

                animationFrame = requestAnimationFrame(() => {
                    const boxWidth = box.offsetWidth;
                    const boxHeight = box.offsetHeight;
                    const offsetX = e.clientX - boxWidth / 2;
                    const offsetY = e.clientY - boxHeight / 2;

                    box.style.transform = `translate(${offsetX}px, ${offsetY}px)`;
                })
            }
        });

        img.addEventListener("mouseleave", function () {
            magnifier.style.opacity = 0;
            box.style.opacity = 0;
        });
    }
});
