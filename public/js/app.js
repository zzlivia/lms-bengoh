window.downloadLesson = function(url, btn = null) {
  if (btn && btn.classList.contains("downloaded")) return;
  if (btn) btn.innerHTML = "⏳";
  if (navigator.serviceWorker.controller) {
    navigator.serviceWorker.controller.postMessage({
      type: "CACHE_URL",
      url: url
    });
    // simulate completion (temporary)
    setTimeout(() => {
      if (btn) {
        btn.innerHTML = "✔";
        btn.classList.remove("btn-warning");
        btn.classList.add("btn-success");
        btn.classList.add("downloaded");
      }
    }, 1000);
  } else {
    console.log("Service Worker not ready");
  }
};