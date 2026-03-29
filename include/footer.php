</div>

<!--  Voice Button -->
<div id="voiceAssistant">🎤</div>

<!--  Assistant Panel (Hidden initially) -->
<div id="assistantPanel" class="hidden">

    <!-- HEADER -->
    <div id="assistantHeader">
        <span>HMS Assistant</span>
        <button id="toggleChat">×</button>
    </div>

    <!-- CHAT BODY -->
    <div id="chatBody"></div>

    <!-- LISTENING INDICATOR -->
    <div id="listeningIndicator" class="hidden">
        <div class="dot-bubble">
            <span></span><span></span><span></span>
        </div>
    </div>

</div>

<script>
let username = "<?php echo $_SESSION['name'] ?? 'User'; ?>";
</script>

<style>
/* 🎤 Voice Button */
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
  font-size: 24px;
}

/* PANEL */
#assistantPanel {
  position: fixed;
  bottom: 100px;
  right: 25px;
  width: 350px;
  height: 450px;
  background: #0f172a;
  border-radius: 15px;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  z-index: 9999;
  box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

/* HIDDEN STATE */
.hidden {
  display: none;
}

/* HEADER */
#assistantHeader {
  background: #1e293b;
  padding: 10px 12px;
  font-weight: 600;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: white;
}

/* CLOSE BUTTON */
#toggleChat {
  background: none;
  border: none;
  color: white;
  font-size: 18px;
  cursor: pointer;
}

/* BODY */
#chatBody {
  flex: 1;
  padding: 10px;
  overflow-y: auto;
  font-size: 13px;
}

/* MESSAGES */
.message {
  margin: 6px 0;
  padding: 8px 10px;
  border-radius: 10px;
  max-width: 80%;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

/* USER MESSAGE */
.user {
  background: #2563eb;
  color: #ffffff;
  margin-left: auto;
  text-align: right;
}

/* BOT MESSAGE */
.bot {
  background: #1e293b;
  color: #e5e7eb;
}

/* HIGHLIGHT ROW */
.highlight {
  outline: 3px solid red;
  transition: outline 0.3s ease-in-out;
}

/* LISTENING INDICATOR (aligned right) */
#listeningIndicator {
  display: flex;
  justify-content: flex-end; /* right aligned */
  padding: 5px 10px;
}

.dot-bubble {
  background: #2563eb;
  border-radius: 20px;
  padding: 6px 10px;
  display: flex;
  gap: 4px;
  align-items: center;
}

.dot-bubble span {
  width: 6px; height: 6px;
  background: white;
  border-radius: 50%;
  opacity: 0.2;
  animation: bounce 1.2s infinite;
}

.dot-bubble span:nth-child(1){ animation-delay: 0s; }
.dot-bubble span:nth-child(2){ animation-delay: 0.2s; }
.dot-bubble span:nth-child(3){ animation-delay: 0.4s; }

@keyframes bounce {
  0%, 80%, 100% { transform: scale(0.6); opacity: 0.2; }
  40% { transform: scale(1); opacity: 1; }
}
</style>

<script>
// ====================== STATE
let state = {
    currentField: null,
    pendingCancel: null,
    lastDeletedRow: null,
    firstOpen: true
};

let panel = document.getElementById("assistantPanel");
let chatBody = document.getElementById("chatBody");
let listeningIndicator = document.getElementById("listeningIndicator");

// ====================== LOAD CHAT HISTORY
function loadChat(){
    let saved = localStorage.getItem("chatHistory");
    if(saved){
        chatBody.innerHTML = saved;
        chatBody.scrollTop = chatBody.scrollHeight;
        state.firstOpen = false;
    }
}

// ====================== SAVE CHAT
function saveChat(){
    localStorage.setItem("chatHistory", chatBody.innerHTML);
}

// ====================== ADD MESSAGE
function addMessage(text, type){
    let msg = document.createElement("div");
    msg.className = "message " + type;
    msg.innerText = text;
    chatBody.appendChild(msg);
    chatBody.scrollTop = chatBody.scrollHeight;
    saveChat();
}

// ====================== SPEAK
function speak(text){
    speechSynthesis.cancel();
    let speech = new SpeechSynthesisUtterance(text);
    speech.rate = 0.9;
    speechSynthesis.speak(speech);
    addMessage(text, "bot");
}

// ====================== MIC CLICK
document.getElementById("voiceAssistant").onclick = function(){
    panel.classList.remove("hidden");

    if(state.firstOpen){
        addMessage("Hello " + username + ", click the mic and speak a command.", "bot");
        state.firstOpen = false;
    }

    startListening();
};

// ====================== CLOSE CHAT
document.getElementById("toggleChat").onclick = function(){
    panel.classList.add("hidden");
    listeningIndicator.classList.add("hidden");
};

// ====================== START LISTENING
function startListening(){
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.interimResults = false;

    listeningIndicator.classList.remove("hidden"); // show 3 dots
    recognition.start();

    recognition.onresult = function(e){
        let command = e.results[0][0].transcript.toLowerCase();
        addMessage(command, "user");
        processCommand(command);
        listeningIndicator.classList.add("hidden"); // hide after command received
    };

    recognition.onerror = function(e){
        speak("Sorry, I couldn't hear you. Please try again.");
        listeningIndicator.classList.add("hidden"); // hide on error
    };

    recognition.onend = function(){
        listeningIndicator.classList.add("hidden"); // hide if stopped
    };
}

// ====================== EXECUTE CANCEL
function executeCancel(number){
    let rows = document.querySelectorAll("table tbody tr");
    if(number <= 0 || number > rows.length){
        speak("Invalid appointment number");
        return;
    }
    let row = rows[number - 1];
    row.classList.add("highlight");
    state.lastDeletedRow = row.cloneNode(true);
    let btn = row.querySelector(".btn-danger, .cancel-btn, a[href*='cancel'], button");
    if(btn){ btn.click(); speak("Appointment cancelled"); }
}

// ====================== READ SCREEN
function readScreen() {
    let text = "";

    //  Current page
    let url = window.location.href;
    if (url.includes("dashboard.php")) {
        text += "You are currently on the Dashboard. ";
    } else if (url.includes("appointment-history.php")) {
        text += "You are on the Appointment History page. ";
    } else if (url.includes("book-appointment.php")) {
        text += "You are on the Book Appointment page. ";
    } else if (url.includes("edit-profile.php")) {
        text += "You are on your Profile page. ";
    } else {
        text += "You are on " + document.title + ". ";
    }

    //  Page summary
    if (url.includes("dashboard.php")) {
        let appointments = document.querySelectorAll("table tbody tr");
        text += appointments.length > 0 ? "You have " + appointments.length + " upcoming appointments. " : "You have no upcoming appointments. ";
    }

    if (url.includes("appointment-history.php")) {
        let rows = document.querySelectorAll("table tbody tr");
        text += rows.length > 0 ? "Your appointment history contains " + rows.length + " records. " : "You have no appointment history. ";
    }

    if (url.includes("edit-profile.php")) {
        let nameField = document.querySelector("input[name='name'], input#name");
        if(nameField) text += "Your profile name is " + nameField.value + ". ";
        let emailField = document.querySelector("input[name='email'], input#email");
        if(emailField) text += "Your email is " + emailField.value + ". ";
    }

    //  Read headings and paragraphs
    let elements = document.querySelectorAll("h1,h2,h3,h4,h5,h6,p");
    let count = 0;
    for(let el of elements){
        if(el.offsetParent !== null){
            text += el.innerText + ". ";
            count++;
        }
        if(count >= 20) break;
    }

    // 4️⃣ Fallback
    if(text.trim() === ""){
        speak("No readable content found on this page.");
    } else {
        speak(text);
    }
}

// ====================== MAIN COMMAND ENGINE
function processCommand(command){
    if(state.pendingCancel){
        if(command.includes("yes")){
            executeCancel(state.pendingCancel);
        } else {
            speak("Cancelled action aborted");
        }
        state.pendingCancel = null;
        return;
    }

    if(command.includes("cancel")){
        let match = command.match(/\d+/);
        if(match){
            let num = parseInt(match[0]);
            state.pendingCancel = num;
            speak("Are you sure you want to cancel appointment " + num + "?");
        }
    } else if(command.includes("undo")){
        if(state.lastDeletedRow){
            document.querySelector("table tbody").appendChild(state.lastDeletedRow);
            speak("Undo successful");
        }
    } else if(command.includes("submit") || command.includes("save")){
        let btn = document.querySelector("button[type='submit'], input[type='submit'], .btn-primary, .btn-success");
        if(btn){ speak("Submitting form"); btn.click(); }
    } else if(command.includes("appointment")){
        if(command.includes("book")){
            speak("Opening booking page");
            window.location.href = "book-appointment.php";
        } else {
            speak("Opening appointment history");
            window.location.href = "appointment-history.php";
        }
    } else if(command.includes("profile")){
        speak("Opening profile");
        window.location.href = "edit-profile.php";
    } else if(command.includes("dashboard")){
        speak("Opening dashboard");
        window.location.href = "dashboard.php";
    } else if(command.includes("read screen")){
        readScreen();
    } else if(command.includes("time")){
        let now = new Date();
        speak("Current time is " + now.toLocaleTimeString());
    } else{
        speak("Command not understood");
    }
}

// ====================== INIT
loadChat();
</script>

</body>
</html>