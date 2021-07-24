var duration = 600;
var scriptRun = false;

setInterval(updateTimer, 1000);

function updateTimer() {
    duration--;
    if (scriptRun == false) {
        if (duration == 0)
        {
            alert("You\'ve been inactive! You will be logged out.")
            scriptRun = true;   
            window.location = "./PHP/logout.php";
        }   
    }
}

window.addEventListener("mousemove", resetTimer);
window.addEventListener("keydown", resetTimer);

function resetTimer() {
    duration = 600;
}