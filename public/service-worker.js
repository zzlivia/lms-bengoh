const CACHE_NAME = "laravel-dynamic-v2";

const urlsToCache = [
  '/',
  '/offline.html'
];

// install
self.addEventListener("install", event => {
  console.log("Service Worker Installed");

  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(urlsToCache);
    })
  );

  self.skipWaiting();
});

// activate
self.addEventListener("activate", event => {
  event.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(
        keys
          .filter(key => key !== CACHE_NAME)
          .map(key => caches.delete(key))
      );
    })
  );

  console.log("Service Worker Activated");
});

// fetch
self.addEventListener("fetch", event => {
  if (event.request.method !== "GET") return;
  if (!event.request.url.startsWith("http")) return;

  const acceptHeader = event.request.headers.get("accept");

  //handle HTML (modules, lectures, etc.)
  if (acceptHeader && acceptHeader.includes("text/html")) {
    event.respondWith(
      fetch(event.request)
        .then(response => {
          const responseClone = response.clone();
          caches.open(CACHE_NAME).then(cache => {
            cache.put(event.request, responseClone);
          });
          return response;
        })
        .catch(() => {
          return caches.match(event.request)
            .then(res => res || caches.match('/offline.html'));
        })
    );
    return;
  }

  //handle others (CSS, JS, etc.)
  event.respondWith(
    caches.match(event.request).then(cachedResponse => {
      if (cachedResponse) return cachedResponse;

      return fetch(event.request).then(networkResponse => {
        const responseClone = networkResponse.clone();
        caches.open(CACHE_NAME).then(cache => {
          cache.put(event.request, responseClone);
        });
        return networkResponse;
      });
    })
  );
});