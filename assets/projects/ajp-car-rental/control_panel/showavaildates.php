<?php
// Assuming you have already established a database connection
require_once('dbconn.php');
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the list of cars from the database
$query = "SELECT DISTINCT car FROM booking_data WHERE status = 3";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}

$cars = array();
while ($row = mysqli_fetch_assoc($result)) {
    $cars[] = $row['car'];
}

// Check if a car is selected
$selectedCar = isset($_GET['car']) ? $_GET['car'] : '';

// Fetch the calendar data for the selected car
$calendarData = '';
if (!empty($selectedCar)) {
    $query = "SELECT DISTINCT start_date, end_date FROM booking_data WHERE car = '$selectedCar' AND status = 3";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Query Error: ' . mysqli_error($conn));
    }

    $bookedDates = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $startDate = date('Y-m-d', strtotime($row['start_date']));
        $endDate = date('Y-m-d', strtotime($row['end_date']));

        $bookedDates[] = array(
            'start_date' => $startDate,
            'end_date' => $endDate
        );
    }

    // Generate the calendar HTML based on the booked dates
    $calendarData = generateCalendar($bookedDates);
}

// Close the database connection
mysqli_close($conn);


// Function to generate the calendar HTML based on the booked dates
function generateCalendar($bookedDates)
{
    // Get the current month and year
    $currentMonth = date('n');
    $currentYear = date('Y');

    // Check if a month and year are provided in the query string
    if (isset($_GET['month']) && isset($_GET['year'])) {
        $currentMonth = $_GET['month'];
        $currentYear = $_GET['year'];
    }

    // Get the start and end dates of the current month
    $startDate = date('Y-m-d', strtotime("$currentYear-$currentMonth-01"));
    $endDate = date('Y-m-t', strtotime("$currentYear-$currentMonth-01"));

    // Get the previous month and year
    $prevMonth = date('n', strtotime("-1 month", strtotime($startDate)));
    $prevYear = date('Y', strtotime("-1 month", strtotime($startDate)));

    // Get the next month and year
    $nextMonth = date('n', strtotime("+1 month", strtotime($endDate)));
    $nextYear = date('Y', strtotime("+1 month", strtotime($endDate)));

    // Get the number of days in the previous month
    $prevMonthDays = date('t', strtotime("-1 month", strtotime($startDate)));

    // Render the calendar
    $calendarHTML = '<div class="calendar">';
    $calendarHTML .= '<div class="month">' . date('F Y', strtotime("$currentYear-$currentMonth-01")) . '</div>';

    // Render the navigation
    $calendarHTML .= '<div class="navigation">';
    $calendarHTML .= '<a href="?car=' . urlencode($_GET['car']) . '&month=' . $prevMonth . '&year=' . $prevYear . '"><</a>';
    $calendarHTML .= '<a href="?car=' . urlencode($_GET['car']) . '&month=' . $nextMonth . '&year=' . $nextYear . '">></a>';
    $calendarHTML .= '</div>';

    // Render the weekdays
    $calendarHTML .= '<div class="weekdays">';
    $calendarHTML .= '<div class="weekday">Sun</div>';
    $calendarHTML .= '<div class="weekday">Mon</div>';
    $calendarHTML .= '<div class="weekday">Tue</div>';
    $calendarHTML .= '<div class="weekday">Wed</div>';
    $calendarHTML .= '<div class="weekday">Thu</div>';
    $calendarHTML .= '<div class="weekday">Fri</div>';
    $calendarHTML .= '<div class="weekday">Sat</div>';
    $calendarHTML .= '</div>';

    // Render the days
    $calendarHTML .= '<div class="days">';

    // Render the previous month's days
    for ($i = $prevMonthDays - date('w', strtotime($startDate)) + 1; $i <= $prevMonthDays; $i++) {
        $calendarHTML .= '<div class="day prev-month">' . $i . '</div>';
    }

    // Render the current month's days
    $currentDate = $startDate;
    while ($currentDate <= $endDate) {
        $day = date('j', strtotime($currentDate));
        $isBooked = false;
        $isLate = false;

        // Check if the current day is booked and/or late
        foreach ($bookedDates as $booking) {
            $bookingStartDate = date('Y-m-d', strtotime($booking['start_date']));
            $bookingEndDate = date('Y-m-d', strtotime($booking['end_date']));
            if ($currentDate >= $bookingStartDate && $currentDate <= $bookingEndDate) {
                $isBooked = true;

                // Check if the current day is late
                if ($currentDate > $bookingEndDate) {
                    $isLate = true;
                }

                break;
            }
        }

        // Add the booked and late classes if applicable
        $bookedClass = $isBooked ? ' booked' : '';
        $lateClass = $isLate ? ' late' : '';

        $calendarHTML .= '<div class="day' . $bookedClass . $lateClass . '">' . $day . '</div>';

        $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
    }

    // Render the remaining days from the next month
    for ($i = 1; $i <= 6 - date('w', strtotime($endDate)); $i++) {
        $calendarHTML .= '<div class="day next-month">' . $i . '</div>';
    }

    $calendarHTML .= '</div>'; // Close the days container
    $calendarHTML .= '</div>'; // Close the calendar container

    return $calendarHTML;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Car Booking Calendar</title>
    <style>
        body {
            background: linear-gradient(90deg, rgba(11, 20, 31, 1) 50%, rgba(0, 4, 68, 1) 100%);
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 0;
            margin: 0;
        }

        .container {
            max-width: 625px;
            padding: 50px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 3px 3px 9px rgba(0, 0, 0, 0.2);
        }

        @media screen and (max-width: 600px) {
            .container {
                padding: 30px;
            }
        }

        h2 {
            font-size: 1.375rem;
            text-align: center;
            margin-bottom: 30px;
            max-width: 600px;
            padding: 20px;
            background-color: rgba(0, 4, 68, 1);
            border-radius: 10px;
            box-shadow: 3px 3px 9px rgba(0, 0, 0, 0.2);

        }

        ul {
            align-items: center;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .horizontal-list {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .horizontal-list li {
            margin: 0 10px;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            text-align: center;
            display: block;
            padding: 10px;
            background-color: rgba(11, 20, 31, 1);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            transition: background-color 0.5s ease;
        }

        a:hover {
            background-color: rgba(0, 4, 68, 1);
        }

        .calendar {

            margin-top: 30px;
            background-color: rgba(255, 255, 255, 0.92);
            border-radius: 10px;
            box-shadow: 3px 3px 9px rgba(0, 0, 0, 0.2);
        }

        .month {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.95);
            color: #0B141F;
            font-size: 1.5rem;
            padding: 15px;
            height: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .navigation {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px;
        }

        .navigation a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 10px;
            height: 10px;
            background-color: rgba(11, 20, 31, 1);
            color: #fff;
            text-decoration: none;
            border-radius: 50%;
            transition: background-color 0.5s ease;
        }

        .navigation a:hover {
            background-color: rgba(0, 4, 68, 1);
        }

        .weekdays {
            display: flex;
            justify-content: space-between;
            background-color: #000444;
            color: #fff;
            padding: 10px;
            font-weight: bold;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .weekday {
            text-align: center;
            width: 14.2857%;
        }

        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-gap: 5px;
            padding: 10px;
        }

        .day {
            text-align: center;
            padding: 10px;
            border: 1px solid #0B1446;
            background-color: #fff;
            color: black;
            border-radius: 10px;
        }

        .booked {
            background-color: #004044;
            color: #fff;
        }

        .late {
            background-color: #800000;
            color: #fff;
        }

        .backmain {
            background-color: #fff;
            width: 20%;
            border-radius: 4px;
        }

        .container {
            opacity: 0;
            animation: revealContainer 1s ease forwards;

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
    </style>
</head>

<body>
    <div class="container">
        <div class="backmain">
            <a href="../index.html">Go Back Main</a>
        </div>
        <h2>
            <?php
            $selectedCar = isset($_GET['car']) ? $_GET['car'] : '';
            if ($selectedCar !== '') {
                echo "Selected Car: " . $selectedCar;
            } else {
                echo "Select a Car:";
            }
            ?>
        </h2>
        <ul id="car-list" class="horizontal-list">
            <?php foreach ($cars as $car) {
                $imageSrc = '';

                if ($car === 'Mitsubishi_Infrared') {
                    $imageSrc = 'images/mitsubishi-mirage-g4-infrared.jpg';
                } elseif ($car === 'Mitsubishi_gray') {
                    $imageSrc = 'images/mitsubishi-mirage-g4-mercury-gray.jpg';
                } elseif ($car === 'Hyundai_white') {
                    $imageSrc = 'images/hyundai-accent-crystal-white.jpg';
                }
            ?>
                <li>
                    <a href="?car=<?php echo urlencode($car); ?>">
                        <img src="<?php echo $imageSrc; ?>" alt="<?php echo $car; ?>" style="width: 200px; height: 150px;">
                        <?php echo $car; ?>
                    </a>
                </li>
            <?php }
            ?>
        </ul>
        <?php echo $calendarData; ?>
    </div>
</body>

</html>