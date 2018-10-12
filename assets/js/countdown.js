/*--------------------------------------------------------------
# Countdown
--------------------------------------------------------------*/
// Set the date we're counting down to
var countDownDate = new Date(cd.date).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in elements
    var daysClass = document.getElementsByClassName("days");
    var hoursClass = document.getElementsByClassName("hours");
    var minutesClass = document.getElementsByClassName("minutes");
    var secondsClass = document.getElementsByClassName("seconds");
    daysClass[0].innerHTML = days;
    hoursClass[0].innerHTML = hours;
    minutesClass[0].innerHTML = minutes;
    secondsClass[0].innerHTML = seconds;
    
    // If the count down is over, write something else instead
    if (distance < 0) {
        clearInterval(x);
        var daysClass = document.getElementsByClassName("days");
        var hoursClass = document.getElementsByClassName("hours");
        var minutesClass = document.getElementsByClassName("minutes");
        var secondsClass = document.getElementsByClassName("seconds");
        daysClass[0].innerHTML = '0';
        hoursClass[0].innerHTML = '0';
        minutesClass[0].innerHTML = '0';
        secondsClass[0].innerHTML = '0';
    }

}, 1000);