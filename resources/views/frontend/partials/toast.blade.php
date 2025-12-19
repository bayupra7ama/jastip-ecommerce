@if (session('success') || session('error') || session('warning') || $errors->any())
    <div id="fruitkha-toast"
        class="fruitkha-toast
        {{ session('success') ? 'success' : '' }}
        {{ session('error') || $errors->any() ? 'error' : '' }}
        {{ session('warning') ? 'warning' : '' }}">

        @if (session('success'))
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        @elseif (session('error'))
            <i class="fas fa-times-circle"></i>
            {{ session('error') }}
        @elseif (session('warning'))
            <i class="fas fa-exclamation-circle"></i>
            {{ session('warning') }}
        @elseif ($errors->any())
            <i class="fas fa-times-circle"></i>
            {{ $errors->first() }}
        @endif
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('fruitkha-toast');
            if (toast) {
                toast.style.animation = 'toastFadeOut 0.4s ease forwards';
                setTimeout(() => toast.remove(), 400);
            }
        }, 3000);
    </script>
@endif
