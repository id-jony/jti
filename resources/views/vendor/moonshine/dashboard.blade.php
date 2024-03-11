@extends("moonshine::layouts.app")

@section('title', config("moonshine.title"))

@section("header-inner")
    @parent

    @include('moonshine::layouts.shared.breadcrumbs', [
        'items' => ['#' => __('moonshine::ui.dashboard')]
    ])
@endsection
<script src="https://telegram.org/js/telegram-web-app.js"></script>

@section('content')
<div id="reader"></div>
<script>
Telegram.WebApp.showScanQrPopup({
    text: 'Scan QR'
}, function (text) {
    const lowerText = text.toString().toLowerCase();
    if (lowerText.substring(0, 7) === 'http://' ||
        lowerText.substring(0, 8) === 'https://'
    ) {
        window.location.href = text;
    }
    return true;
});
</script>
@endsection

