<div id="preloader"
    class="fixed inset-0 z-[9999] flex items-center justify-center
           bg-white/70 backdrop-blur-sm transition-opacity duration-300">

    <div class="flex flex-col items-center gap-4">

        <div class="relative w-12 h-12">
            <div class="absolute inset-0 rounded-full border-2 border-slate-200"></div>
            <div class="absolute inset-0 rounded-full border-2 border-transparent border-t-slate-800 animate-spin"></div>
        </div>

        <span class="text-xs text-slate-500 tracking-wider">
            Carregando...
        </span>
    </div>
</div>

<script>
    window.addEventListener('load', () => {
        const el = document.getElementById('preloader');
        if (!el) return;
        el.classList.add('opacity-0');
        setTimeout(() => el.remove(), 300);
    });
</script>
