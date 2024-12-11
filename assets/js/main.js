// Input Date Custom
// Get all date inputs with the "custom-date-input" class
var dateInputs = document.querySelectorAll(".custom-date-input");

dateInputs.forEach(function (input) {
    // Add an event listener for the "change" event
    input.addEventListener("change", function () {
        var dateValue = input.value;
        if (dateValue) {
            // Parse the date in the current format (yyyy-mm-dd)
            var dateParts = dateValue.split("-");
            var year = dateParts[0];
            var month = dateParts[1];
            var day = dateParts[2];

            // Format the date as "dd mm yyyy"
            var formattedDate = day + " " + month + " " + year;

            // Set the input value to the formatted date
            input.value = formattedDate;
        }
    });
});

// Call Button
const ticketNumbers = [];
let currentTicketIndex = 0;

document.getElementById('call-button').addEventListener('click', function () {
    if (currentTicketIndex < ticketNumbers.length) {
        const currentNumber = ticketNumbers[currentTicketIndex];
        displayTicketNumber(currentNumber);
        currentTicketIndex++;
    } else {
        displayTicketNumber('No more tickets.');
    }
});

function generateTicketNumber() {
    const newTicketNumber = Math.floor(Math.random() * 1000) + 1; // Generate a random number
    ticketNumbers.push(newTicketNumber);
    return newTicketNumber;
}

function displayTicketNumber(number) {
    document.getElementById('current-number').textContent = number;
}

// Initial ticket generation
generateTicketNumber();

