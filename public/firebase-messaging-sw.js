// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyBtODAlj6JjbwkD4XgAg5oheQfK3cCD4mA",
    authDomain: "laravel-fcm-6a950.firebaseapp.com",
    databaseURL: "https://laravel-fcm-6a950-default-rtdb.firebaseio.com",
    projectId: "laravel-fcm-6a950",
    storageBucket: "laravel-fcm-6a950.firebasestorage.app",
    messagingSenderId: "640135034919",
    appId: "1:640135034919:web:91c73d06fe00ba3d9c7602",
    measurementId: "G-GV6WJXMCS5"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});
