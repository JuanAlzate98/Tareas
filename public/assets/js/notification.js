Push.Permission.DEFAULT; // 'default'
Push.Permission.GRANTED; // 'granted'
Push.Permission.DENIED; // 'denied'

Push.config({
    serviceWorker: './customServiceWorker.js', // Sets a custom service worker script
    fallback: function(payload) {
        // Code that executes on browsers with no notification support
        // "payload" is an object containing the 
        // title, body, tag, and icon of the notification 
    }
});


$('#btnHola').click(() => {
    Push.create('Hello World!')
});