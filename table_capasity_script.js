/* Author: Ganna Karpycheva
 Date: 2025-03-03 11:56
 manual from here https://learn.javascript.ru/fetch
*/
const API_URL_SAVE_TABLES = "http://coursework.local/api/save_tables.php";

function submitTables() {
  let tables = document.querySelectorAll(".restaurant_table");
  let formData = new URLSearchParams();

  // Collect data from all selects
  for (let select of tables) {
    formData.append(select.id, select.value);
  }

  console.log(formData.toString()); // Для проверки перед отправкой

  // Sending data to the server
  fetch(API_URL_SAVE_TABLES, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: formData.toString(),
  })
    .then((response) => {
      if (response.status !== 200) {
        throw new Error("Something wrong with the server response");
      }
      return response.formData(); // Получаем ответ от сервера как текст
    })
    .then((result) => {
      alert("Data saved successfully!");
      console.log(result); // Можете вывести результат для отладки
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("An error occurred while saving data.");
    });
}
