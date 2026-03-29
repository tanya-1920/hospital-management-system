<!-- Voice Assistant UI -->
<div id="voiceAssistant">🎤</div>

<div id="voicePopup">
    <p id="voiceText">Click mic and speak...</p>
</div>

<!-- Pass username from session -->
<script>
let username = "<?php echo $_SESSION['name'] ?? 'User'; ?>";
</script>

<style>
#voiceAssistant {
  position: fixed;
  bottom: 25px;
  right: 25px;
  width: 60px;
  height: 60px;
  background: #ef4444;
  color: white;
  border-radius: 50%;
  font-size: 26px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 9999;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  transition: 0.3s;
}

#voiceAssistant:hover {
  transform: scale(1.1);
}

#voicePopup {
  position: fixed;
  bottom: 100px;
  right: 25px;
  background: #0f172a;
  color: white;
  padding: 10px 15px;
  border-radius: 10px;
  display: none;
  max-width: 260px;
  font-size: 14px;
}
</style>

<script>

// ======================
// STATE MANAGEMENT
// ======================
let assistantState = {
    isSpeaking: false,
    currentField: null
};

// ======================
// MIC CLICK HANDLER
// ======================
document.getElementById("voiceAssistant").onclick = function(){

    if (speechSynthesis.speaking) {
        speechSynthesis.cancel();
        document.getElementById("voiceText").innerText = "Stopped";
        return;
    }

    startListening();
};

// ======================
// SPEECH RECOGNITION
// ======================
function startListening(){
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();

    recognition.lang = "en-US";
    recognition.start();

    document.getElementById("voicePopup").style.display = "block";
    document.getElementById("voiceText").innerText = "Listening...";

    recognition.onresult = function(event){
        let command = event.results[0][0].transcript.toLowerCase();
        document.getElementById("voiceText").innerText = command;

        processCommand(command);
    };
}

// ======================
// TEXT TO SPEECH
// ======================
function speak(text){
    speechSynthesis.cancel();

    let speech = new SpeechSynthesisUtterance(text);
    speech.rate = 0.9;

    assistantState.isSpeaking = true;

    speech.onend = function(){
        assistantState.isSpeaking = false;
    };

    speechSynthesis.speak(speech);
}

// ======================
// GREETING + TIME
// ======================
function getGreeting(){
    let hour = new Date().getHours();
    if(hour < 12) return "Good morning";
    if(hour < 17) return "Good afternoon";
    return "Good evening";
}

function tellTime(){
    let time = new Date().toLocaleTimeString();
    speak("The current time is " + time);
}

function tellDate(){
    let date = new Date().toDateString();
    speak("Today is " + date);
}

// ======================
// FIND INPUT FIELD
// ======================
function findField(label){
    let inputs = document.querySelectorAll("input, textarea");

    for(let input of inputs){
        let text = (input.placeholder || input.name || input.id || "").toLowerCase();

        if(text.includes(label)){
            return input;
        }
    }
    return null;
}

// ======================
// SMART SCREEN READING
// ======================
function readSmartScreen(){

    let greeting = getGreeting();
    let title = document.title;

    let message = greeting + " " + username + ". ";
    message += "You are on " + title + ". ";

    let headings = document.querySelectorAll("h1, h2, h3");

    if(headings.length > 0){
        message += "Sections include ";
        headings.forEach((h, i) => {
            if(i < 4){
                message += h.innerText + ", ";
            }
        });
    }

    speak(message);
}

// ======================
// MAIN COMMAND ENGINE
// ======================
function processCommand(command){

    // GENERAL CONVERSATION
    if(command.includes("hi") || command.includes("hello")){
        speak("Hello " + username + ". How can I help you?");
    }

    else if(command.includes("time")){
        tellTime();
    }

    else if(command.includes("today")){
        tellDate();
    }

    // PROFILE INTENT
    else if(command.includes("profile")){

        if(command.includes("help")){
            speak("Opening edit profile. You can update your details and submit.");
        }

        speak("Opening edit profile");
        window.location.href = "edit-profile.php";
    }

    // UPDATE MODE
    else if(command.includes("update") || command.includes("change")){

        if(command.includes("name") || command.includes("username")){
            assistantState.currentField = "name";
            speak("What would you like to change your name to?");
        }

        else if(command.includes("email")){
            assistantState.currentField = "email";
            speak("What is the new email?");
        }

        else if(command.includes("phone")){
            assistantState.currentField = "phone";
            speak("What is the new phone number?");
        }
    }

    // FROM → TO UPDATE
    else if(command.includes("from") && command.includes("to")){

        let parts = command.split("to");
        let newValue = parts[1].trim();

        if(assistantState.currentField){
            let field = findField(assistantState.currentField);

            if(field){
                field.value = newValue;
                speak(assistantState.currentField + " updated");
            } else {
                speak("Field not found");
            }
        }
    }

    // DIRECT FIELD INPUT
    else if(command.includes("name")){
        let value = command.replace("name","").trim();
        let field = findField("name");

        if(field){
            field.value = value;
            speak("Name added");
        }
    }

    else if(command.includes("email")){
        let value = command.replace("email","").trim();
        let field = findField("email");

        if(field){
            field.value = value;
            speak("Email added");
        }
    }

    // APPOINTMENTS
    else if(command.includes("appointment")){

        if(command.includes("book")){
            speak("Opening booking page");
            window.location.href = "book-appointment.php";
        }

        else if(command.includes("show") || command.includes("history")){
            speak("Opening appointment history");
            window.location.href = "appointment-history.php";
        }

        else{
            speak("You can say book appointment or show appointments");
        }
    }

    // DASHBOARD
    else if(command.includes("dashboard")){
        speak("Opening dashboard");
        window.location.href = "dashboard.php";
    }

    // FORM SUBMIT
    else if(command.includes("submit") || command.includes("update profile")){
        let form = document.querySelector("form");

        if(form){
            speak("Submitting form");
            form.submit();
        }
    }

    // SCREEN READ
    else if(command.includes("read screen")){
        readSmartScreen();
    }

    // FALLBACK
    else{
        speak("I did not fully understand. Try asking differently.");
    }
}

</script>