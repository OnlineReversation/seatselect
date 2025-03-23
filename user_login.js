window.onload = function () {
  const user_login = localStorage.getItem("user_login");

  if (user_login) {
    document.getElementById("logged_user").textContent =
      "Logged in: " + user_login;
    document.getElementById("logged_user").href = "user_panel.html"; // замените на актуальный путь
  }
};
