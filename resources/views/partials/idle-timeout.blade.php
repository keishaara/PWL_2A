@auth
<form id="idle-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="timeout" value="1">
</form>

<script>
    (function() {
        const BATAS_WAKTU_IDLE = 60 * 1000; 
        let timerIdle;

        function resetTimer() {
            clearTimeout(timerIdle);
            timerIdle = setTimeout(() => {
                document.getElementById('idle-logout-form').submit();
            }, BATAS_WAKTU_IDLE);
        }

        ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart'].forEach(eventName => {
            window.addEventListener(eventName, resetTimer, true);
        });

        resetTimer();
    })();
</script>
@endauth