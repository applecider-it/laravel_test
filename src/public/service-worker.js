self.addEventListener('push', async (event) => {
  console.log('Service Worker push.', event);

  const data = await event.data.json();

  console.log('Service Worker push data.', data);

  event.waitUntil(self.registration.showNotification(data.title))
});

self.addEventListener('install', function (event) {
  console.log('Service Worker installing.');
});