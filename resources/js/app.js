import './bootstrap';
import Quagga from 'quagga';
function scanQRCode() {
    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#qr-scanner'), // Здесь вы должны создать div-элемент с id "qr-scanner" в вашем представлении
            constraints: {
                width: 640,
                height: 480,
                facingMode: "environment", // Используйте заднюю камеру, если это возможно
            },
        },
        decoder: {
            readers: ["qrcode"],
        },
    }, function (err) {
        if (err) {
            console.error(err);
            return;
        }
        console.log("Initialization finished. Ready to start.");
        Quagga.start();
    });

    Quagga.onDetected(function (result) {
        const code = result.codeResult.code;
        console.log("QR Code detected: " + code);
        // Здесь вы можете отправить код на сервер для дальнейшей обработки
    });
}

scanQRCode();
