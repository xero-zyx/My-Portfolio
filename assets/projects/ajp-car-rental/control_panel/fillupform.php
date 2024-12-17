<!DOCTYPE html>
<html>

<head>
  <title>Booking Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <style>
    body {
      background: linear-gradient(90deg, rgba(11, 20, 31, 1) 50%, rgba(0, 4, 68, 1) 100%);
    }

    .title h1 {
      color: #000000;
      font-family: sans-serif;
      font-weight: 700;
      text-align: center;
      padding: 20px;
      margin: 2px;
    }

    .container {
      color: #000000;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 900px;
      padding: 0;
      margin: 0;
    }

    .container-formbox {
      background-color: hsl(0, 0%, 100%);
      padding-left: 100px;
      padding-right: 100px;
      padding-bottom: 30px;
      border-radius: 10px;
      height: 770px;
      width: auto;
    }

    .container {
      opacity: 0;
      animation: reveal 1s forwards;
    }

    @keyframes reveal {
      0% {
        opacity: 0;
        transform: translateY(20px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .select-container {
      text-align: center;
    }

    #cars {
      width: 100%;
      padding: 7px;
      font-size: 16px;
      border-color: rgb(0, 0, 0);
      border-radius: 14px;
      background-color: hsl(204, 91%, 53%);
    }

    #cars option {
      background-color: hsl(204, 91%, 53%);
      color: #333;
      font-size: 16px;
    }

    .formbox input {
      width: 250px;
      padding: 5px;
      height: 20px;
      font-size: 16px;
      border-color: rgb(0, 0, 0);
      border-radius: 4px;
    }

    .formbox label {
      font-family: sans-serif;
      font-weight: 550;
      float: left;
      width: 100px;
      height: 20px;
      padding-top: 7px;
      font-size: 16px;
      border-radius: 4px;
    }

    .formbox button {
      width: 200px;
      padding: 20px;
      font-size: 16px;
      border-color: rgb(0, 0, 0);
      border-radius: 14px;
    }

    #submit {
      background-color: hsl(204, 91%, 53%);
      color: rgb(0, 0, 0);
    }

    .button-container {
      text-align: center;
    }

    .note-container {
      padding-bottom: 5px;
    }

    .note-containe label {
      display: block;
    }

    #note {
      width: 100%;
      height: 125px;
      border-color: rgb(0, 0, 0);
    }

    .notepad,
    textarea {
      width: auto;
      height: auto;
      font-family: Arial, sans-serif;
      font-size: 16px;
      line-height: 1.5;
      border-color: 2px rgb(0, 0, 0);
      border-radius: 4px;
      resize: none;
    }

    .formbox select {
      text-align: center;
      display: flex;
    }

    /* Media Queries */
    @media (max-width: 768px) {
      .container-formbox {
        padding: 20px;
        height: auto;
      }

      .formbox input,
      .formbox textarea {
        width: 100%;
      }

      .formbox label {
        width: 100%;
      }

      .formbox button {
        width: 100%;
      }
    }
  </style>
</head>


<body class="container">
  <div class="container-formbox">
    <div class="title">
      <h1>Booking Form
        <hr>
      </h1>
    </div>
    <form method="POST" action="insertbooking.php" id="bookingForm" class="formbox">
      <label for="firstname">First Name:</label>
      <input type="text" id="firstname" name="firstname" placeholder="Paolo Gabriel" required><br><br>

      <label for="lastname">Last Name:</label>
      <input type="text" id="lastname" name="lastname" placeholder="Cardeño" required><br><br>

      <label for="email">Email:</label>
      <input type="text" id="email" name="email" placeholder="PaoloCardeño@gmail.com" required><br><br>

      <label for="number">Phone No.:</label>
      <input type="tel" id="number" name="number" inputmode="numeric" pattern="[0-9]*" placeholder="09*********" required><br><br>

      <div class="select-container">
        <select id="cars" name="cars" required>
          <option value="">--Select a car--</option>
          <?php
          require_once('dbconn.php');
          $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

          if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
          }

          $sql = "SELECT DISTINCT car FROM booking_data WHERE status = 3";
          $result = mysqli_query($conn, $sql);

          while ($row = mysqli_fetch_assoc($result)) {
            $car = $row['car'];
            echo "<option value='" . $car . "'>" . $car . "</option>";
          }
          ?>
        </select><br><br>
      </div>

      <label for="startdate">Start Date:</label>
      <input type="text" id="startdate" name="startdate" placeholder="Choose a car first" readonly><br><br>

      <label for="enddate">End Date:</label>
      <input type="text" id="enddate" name="enddate" placeholder="Choose a car first" readonly><br><br>

      <label for="miles">How far:</label>
      <input type="text" id="miles" name="miles" placeholder="Miles/Kilo Meter?" required><br><br>
      <div class="note-container">
        <label for="note">Note:</label>
        <br>
        <textarea id="note" name="note" placeholder="Start typing..." class="notepad" required></textarea>
      </div>
      <div class="button-container">
        <button type="submit" id="submit" value="Submit">Submit</button>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Function to fetch booked dates from the server
      function fetchBookedDates(selectedCar) {
        return new Promise((resolve, reject) => {
          var xhr = new XMLHttpRequest();
          xhr.open("GET", "fetch_booked_dates.php?car=" + selectedCar, true);
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              var response = JSON.parse(xhr.responseText);
              resolve(response.bookedDates);
            }
          };
          xhr.onerror = function() {
            reject(xhr.statusText);
          };
          xhr.send();
        });
      }

      // Function to disable dates
      function disableDates(selectedCar) {
        var startDateInput = document.getElementById("startdate");
        var endDateInput = document.getElementById("enddate");

        fetchBookedDates(selectedCar)
          .then(function(bookedDates) {
            // Initialize flatpickr datepickers
            flatpickr(startDateInput, {
              minDate: "today",
              dateFormat: "Y-m-d",
              disable: bookedDates,
              onChange: function(selectedDates, dateStr, instance) {
                endDateInput._flatpickr.set("minDate", dateStr);
              }
            });

            flatpickr(endDateInput, {
              minDate: "today",
              dateFormat: "Y-m-d",
              disable: bookedDates,
              onChange: function(selectedDates, dateStr, instance) {
                startDateInput._flatpickr.set("maxDate", dateStr);
              }
            });
          })
          .catch(function(error) {
            console.error("Error fetching booked dates:", error);
          });
      }

      var carSelect = document.getElementById("cars");
      carSelect.addEventListener("change", function() {
        var selectedCar = carSelect.value;
        disableDates(selectedCar);
      });

      // Handle form submission
      var form = document.getElementById("bookingForm");
      form.addEventListener("submit", function(event) {
        var startDateInput = document.getElementById("startdate");
        var endDateInput = document.getElementById("enddate");

        if (!startDateInput.value || !endDateInput.value) {
          event.preventDefault();
          alert("Please select start and end dates.");
        }
      });
    });
  </script>
</body>

</html>