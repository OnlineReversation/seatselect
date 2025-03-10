function refresh_users() {
  $.ajax({
    url: "/api/get_users.php", 
    method: "GET",
    dataType: "json",
    success: function (response) {
      var tableBody = document.querySelector("#users_table tbody");
      tableBody.innerHTML = ""; // Clear the table

      response.forEach(function (user) {
        var row = `<tr>
                    <td>${user.id}</td>
                    <td>${user.user_login}</td>
                    <td>${user.user_email}</td>
                    <td>
                        <button onclick="changePassword(${user.id})">Change password</button>
                    </td>
                </tr>`;
        tableBody.innerHTML += row;
      });
    },
    error: function (xhr, status, error) {
      console.error("Ошибка загрузки данных:", error);
    },
  });
}

function changePassword(userId) {
  const newPassword = prompt("Enter the new password:");

  if (newPassword && newPassword.length >= 3) {
    // Минимальная длина пароля - 3 символов
    fetch("api/change_password.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `user_id=${encodeURIComponent(
        userId
      )}&new_password=${encodeURIComponent(newPassword)}`,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          alert("Password successfully changed!");
        } else {
          alert("Error changing password: " + data.message);
        }
      })
      .catch((error) => console.error("Error:", error));
  } else {
    alert("Password should be at least 3 characters long.");
  }
}


document.addEventListener("DOMContentLoaded", function () {
  refresh_users();
});

