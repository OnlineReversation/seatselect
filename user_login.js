window.onload = function () {
  const user_login = localStorage.getItem("user_login");

  if (user_login) {
    if (user_login) {
      let loggedUserElements = document.querySelectorAll(".logged_user");
      loggedUserElements.forEach(function (element) {
        element.textContent = "Logged in: " + user_login;
      });
    }
  }
};
