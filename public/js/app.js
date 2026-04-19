window.downloadLesson = function(url, btn = null) {
  if (btn && btn.classList.contains("downloaded")) return;
  if (btn) btn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
  if (navigator.serviceWorker.controller) {
    navigator.serviceWorker.controller.postMessage({
      type: "CACHE_URL",
      url: url
    });
    // simulate completion (temporary)
    setTimeout(() => {
      if (btn) {
        btn.innerHTML = '<i class="bi bi-check-lg"></i>';
        btn.classList.remove("btn-warning");
        btn.classList.add("btn-success");
        btn.classList.add("downloaded");
      }
    }, 1000);
  } else {
    console.log("Service Worker not ready");
  }
};

// on loading page, show if already cached
document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll("button[onclick^='downloadLesson']");
  if (!buttons.length) return;
  caches.open("laravel-dynamic-v2").then(cache => {
    buttons.forEach(btn => {
      const match = btn.getAttribute("onclick")?.match(/'(.*?)'/);
      if (!match) return;
      const url = match[1];
      cache.match(url).then(res => {
        if (res) {
          btn.innerHTML = '<i class="bi bi-check-lg"></i>';
          btn.classList.remove("btn-warning");
          btn.classList.add("btn-success");
          btn.classList.add("downloaded");
        }
      });

    });

  });

});

//save progress offline
function saveProgressOffline(data) {
  let queue = JSON.parse(localStorage.getItem("progressQueue")) || [];
  queue.push({
    ...data,
    synced: false
  });
  localStorage.setItem("progressQueue", JSON.stringify(queue));
}