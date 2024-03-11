@extends("moonshine::layouts.app")

@section('title', config("moonshine.title"))

@section("header-inner")
    @parent

    @include('moonshine::layouts.shared.breadcrumbs', [
        'items' => ['#' => __('moonshine::ui.dashboard')]
    ])
@endsection
<script src="/assets/js/html5-qrcode.min.js"></script>

@section('content')
<div id="reader"></div>
<script>
var html5QrcodeScanner = new Html5QrcodeScanner(
  "reader", { fps: 10, qrbox: 250 });

function onScanSuccess(qrCodeMessage) {
    window.location.href = qrCodeMessage;
}

function onScanError(errorMessage) {
    console.log(errorMessage);
}

html5QrcodeScanner.render(onScanSuccess, onScanError, { facingMode: 'environment' }); // Запускаем сканирование с задней камеры
</script>
@endsection

