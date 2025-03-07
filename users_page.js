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
                        <button onclick="openForm(${user.id})">Change password</button>
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

function openForm(userId) {
  window.location.href = `form_page.html?user_id=${userId}`;
}

document.addEventListener("DOMContentLoaded", function () {
  refresh_users();
});
