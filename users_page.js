function refresh_users() {
  $.ajax({
    url: "/api/get_users.php",
    method: "GET",
    dataType: "json",
    success: function (response) {
      var tableBody = document.querySelector("#users_table tbody");
      tableBody.innerHTML = ""; // Clear the table

      response.forEach(function (user) {
        var row = `
    <tr>
        <td style="width: 50px;">${user.id}</td> <!-- Узкая колонка -->
        <td style="width: 200px;">${user.user_login}</td>
        <td style="width: 200px;">${user.user_email}</td>
        <td style="width: 200px;">
            <button 
                onclick="changePassword(${user.id})"
                class="u-active-grey-70 u-align-center u-border-none u-btn u-button-style u-hover-grey-70 u-palette-1-base u-text-active-white u-text-body-alt-color u-text-hover-white u-btn-2"
                data-animation-name="customAnimationIn" 
                data-animation-duration="1500" 
                data-animation-delay="750" 
                data-animation-direction="">
                <img src="/images/password.png" alt="Password" style="width: 20px; height: 20px; vertical-align: middle; margin-right: 5px;">
                Change password
            </button>
        </td>
        <td style="width: 200px;">
            <button 
                onclick="changeEmail(${user.id})"
                class="u-active-grey-70 u-align-center u-border-none u-btn u-button-style u-hover-grey-70 u-palette-1-base u-text-active-white u-text-body-alt-color u-text-hover-white u-btn-2"
                data-animation-name="customAnimationIn" 
                data-animation-duration="1500" 
                data-animation-delay="750" 
                data-animation-direction="">
                <img src="/images/email.png" alt="Email" style="width: 20px; height: 20px; vertical-align: middle; margin-right: 5px;">
                Change email
            </button>
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

function changeEmail(userId) {
  const newEmail = prompt("Enter the new email:");

  fetch("api/change_email.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `user_id=${encodeURIComponent(userId)}&new_email=${encodeURIComponent(
      newEmail
    )}`,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        alert("Email successfully changed!");

        location.reload();
      } else {
        alert("Error changing email: " + data.message);
      }
    })
    .catch((error) => console.error("Error:", error));
}

document.addEventListener("DOMContentLoaded", function () {
  refresh_users();
});
