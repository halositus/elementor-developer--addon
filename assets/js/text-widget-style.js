jQuery(document).ready(function ($) {
  setInterval(function () {
    $(".current-time").html(new Date().toLocaleTimeString());
  }, 1000);
});
