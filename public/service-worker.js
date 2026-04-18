//flow: when user visit a page for first time, it saved to cache - from server
//flow: when user visit next time even during offline, it works without interner - from cache

const CACHE_NAME = "laravel-dynamic-v2";

//install
self.addEventListener("install", event => {
  console.log("Service Worker Installed");
  self.skipWaiting();
});

//activate (clean old caches)
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

//fetch
self.addEventListener("fetch", event => {
  //only handle GET requests
  if (event.request.method !== "GET") return;

  //only handle HTTP/HTTPS (skip chrome-extension)
  if (!event.request.url.startsWith("http")) return;

  event.respondWith(
    caches.match(event.request).then(cachedResponse => {
      //return cache if exists
      if (cachedResponse) {
        return cachedResponse;
      }
      //fetch from network
      return fetch(event.request)
        .then(networkResponse => {
          //avoid caching bad responses
          if (!networkResponse || networkResponse.status !== 200) {
            return networkResponse;
          }
          //clone & store in cache
          const responseClone = networkResponse.clone();
          caches.open(CACHE_NAME).then(cache => {
            cache.put(event.request, responseClone);
          });

          return networkResponse;
        })
        .catch(() => {
          //offline fallback
          if (event.request.headers.get("accept").includes("text/html")) {
            return new Response(
              "<h1>You are offline</h1><p>This page is not cached yet.</p>",{ headers: { "Content-Type": "text/html" } }
            );
          }
        });

    })
  );
});