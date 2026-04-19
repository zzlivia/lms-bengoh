function downloadLesson(url) {
  if (navigator.serviceWorker.controller) {
    navigator.serviceWorker.controller.postMessage({
      type: "CACHE_URL",
      url: url
    });
  } else {
    console.log("Service Worker not ready");
  }
}