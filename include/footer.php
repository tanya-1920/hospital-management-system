</div>

<!--  Voice Button -->
<div id="voiceAssistant">🎤</div>

<!--  Chat UI -->
<div id="assistantChat">
    <div id="chatBody"></div>
</div>

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
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 9999;
}

/* Chat UI */
#assistantChat {
  position: fixed;
  bottom: 100px;
  right: 25px;
  width: 300px;
  max-height: 350px;
  background: #0f172a;
  color: white;
  border-radius: 10px;
  overflow-y: auto;
  padding: 10px;
  font-size: 13px;
}

.message {
  margin: 5px 0;
  padding: 8px;
  border-radius: 8px;
}

.user { background: #1d4ed8; text-align: right; }
.bot { background: #1e293b; }

.highlight {
  outline: 3px solid red;
  transition: 0.3s;
}
</style>

<script>

// ======================
// STATE
// ======================
let state = {
    currentField: null,
    pendingCancel: null,
    lastDeletedRow: null
};

// ======================
// CHAT UI
// ======================
function addMessage(text, type){
    let msg = document.createElement("div");
    msg.className = "message " + type;
    msg.innerText = text;
    document.getElementById("chatBody").appendChild(msg);
}

// ======================
// SPEAK
// ======================
function speak(text){
    speechSynthesis.cancel();
    let speech = new SpeechSynthesisUtterance(text);
    speech.rate = 0.9;
    speechSynthesis.speak(speech);
    addMessage(text, "bot");
}

// ======================
// LISTEN
// ======================
document.getElementById("voiceAssistant").onclick = function(){

    if (speechSynthesis.speaking) {
        speechSynthesis.cancel();
        return;
    }

    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.start();

    recognition.onresult = function(e){
        let command = e.results[0][0].transcript.toLowerCase();
        addMessage(command, "user");
        processCommand(command);
    };
};

// ======================
// FIND FIELD
// ======================
function findField(label){
    let inputs = document.querySelectorAll("input, textarea");

    for(let input of inputs){
        let text = (input.placeholder || input.name || input.id || "").toLowerCase();
        if(text.includes(label)) return input;
    }
    return null;
}

// ======================
// HIGHLIGHT ROW
// ======================
function highlightRow(row){
    row.classList.add("highlight");
    setTimeout(()=>row.classList.remove("highlight"), 2000);
}

// ======================
// CANCEL EXECUTION
// ======================
function executeCancel(number){

    let rows = document.querySelectorAll("table tbody tr");

    if(number <= 0 || number > rows.length){
        speak("Invalid appointment number");
        return;
    }

    let row = rows[number - 1];
    highlightRow(row);

    state.lastDeletedRow = row.cloneNode(true);

    let btn = row.querySelector(".btn-danger, .cancel-btn, a[href*='cancel'], button");

    if(btn){
        btn.click();
        speak("Appointment cancelled");
    } else {
        speak("Cancel button not found");
    }
}

// ======================
// MAIN COMMAND ENGINE
// ======================
function processCommand(command){

    // ------------------
    // CONFIRMATION FLOW
    // ------------------
    if(state.pendingCancel){

        if(command.includes("yes")){
            executeCancel(state.pendingCancel);
            state.pendingCancel = null;
        }
        else{
            speak("Cancellation aborted");
            state.pendingCancel = null;
        }
        return;
    }

    // ------------------
    // CANCEL REQUEST
    // ------------------
    if(command.includes("cancel") || command.includes("delete")){

        let match = command.match(/\d+/);

        if(match){
            let num = parseInt(match[0]);

            state.pendingCancel = num;
            speak("Are you sure you want to cancel appointment " + num + "?");
        }
        else{
            speak("Please specify appointment number");
        }
    }

    // ------------------
    // UNDO
    // ------------------
    else if(command.includes("undo")){

        if(state.lastDeletedRow){
            let table = document.querySelector("table tbody");
            table.appendChild(state.lastDeletedRow);
            speak("Last cancellation undone");
        } else {
            speak("Nothing to undo");
        }
    }

    // ------------------
    // SUBMIT
    // ------------------
    else if(command.includes("submit") || command.includes("save")){

        let btn = document.querySelector(
            "button[type='submit'], input[type='submit'], .btn-primary, .btn-success"
        );

        if(btn){
            speak("Submitting form");
            btn.click();
        } else {
            speak("Submit button not found");
        }
    }

    // ------------------
    // UPDATE FIELD
    // ------------------
    else if(command.includes("update") || command.includes("change")){

        if(command.includes("name")){
            state.currentField = "name";
            speak("What should I change your name to?");
        }
        else if(command.includes("email")){
            state.currentField = "email";
            speak("What is the new email?");
        }
    }

    else if(command.includes("from") && command.includes("to")){

        let newVal = command.split("to")[1].trim();

        if(state.currentField){
            let field = findField(state.currentField);

            if(field){
                field.value = newVal;
                speak("Updated successfully");
            }
        }
    }

    // ------------------
    // NAVIGATION
    // ------------------
    else if(command.includes("appointment")){

        if(command.includes("book")){
            speak("Opening booking page");
            window.location.href = "book-appointment.php";
        }

        else{
            speak("Opening appointment history");
            window.location.href = "appointment-history.php";
        }
    }

    else if(command.includes("profile")){
        speak("Opening profile");
        window.location.href = "edit-profile.php";
    }

    else if(command.includes("dashboard")){
        speak("Opening dashboard");
        window.location.href = "dashboard.php";
    }

    else{
        speak("Command not understood");
    }
}

</script>

</body>
</html>