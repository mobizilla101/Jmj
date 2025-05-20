<div id="loading-overlay" class="bg-white fixed top-0 left-0 min-h-screen w-full flex flex-col items-center justify-center z-[90]">
    <img src="{{ asset('assets/images/logo.png') }}" class="h-32 w-32 mb-4" alt="Loading Logo"/>

    <!-- Progress Bar Container -->
    <div class="relative w-64 h-2 bg-gray-200 rounded overflow-hidden">
        <div id="progress-bar" class="absolute left-0 top-0 h-full bg-blue-500 w-0"></div>
    </div>
</div>

<script>
    const progressBar = document.getElementById('progress-bar');
    const overlay = document.getElementById('loading-overlay');

    let progress = 0;

    function simulateProgress() {
        if (progress < 100) {
            progress += Math.random() * 10; // simulate random progress
            progressBar.style.width = Math.min(progress, 100) + '%';
            requestAnimationFrame(simulateProgress);
        }
    }

    simulateProgress();

    window.addEventListener('load', function () {
        progressBar.style.width = '100%';
        setTimeout(() => {
            overlay.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => overlay.remove(), 500);
        }, 200);
    });
</script>
