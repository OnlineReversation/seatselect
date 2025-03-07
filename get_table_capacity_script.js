/* Author: Ganna Karpycheva
 Date: 2025-03-03 20:19
*/

const API_URL_GET_TABLE_CAPACITY =
  "http://coursework.local/api/get_table_capacity.php";

function getTables() {
  // Отправка запроса на сервер для получения данных о столиках
  fetch(API_URL_GET_TABLE_CAPACITY)
    .then((response) => response.text()) // Ожидаем текстовый ответ
    .then((data) => {
      // После получения данных, обновляем значения столиков
      updateTableCapacity(data);
    })
    .catch((error) => {
      console.error("Ошибка при получении данных:", error);
    });
}

// Функция для обновления вместимости столиков
function updateTableCapacity(data) {
  // Преобразуем строку параметров в объект
  const params = new URLSearchParams(data);

  // Для каждого параметра (параметры вида table_18=4)
  params.forEach(function (value, key) {
    if (key.startsWith("table_")) {
      const tableId = key.split("_")[1]; // Получаем id стола из key
      const tableElement = document.getElementById("table_" + tableId); // Находим элемент по ID
      if (tableElement) {
        // Обновляем значение в select для каждого стола
        const options = tableElement.querySelectorAll("option"); // Находим все option в select
        options.forEach(function (option) {
          if (parseInt(option.value) === parseInt(value)) {
            option.selected = true; // Если значение совпадает, выбираем option
          }
        });
      }
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  getTables();
});
