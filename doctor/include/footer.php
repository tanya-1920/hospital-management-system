</div>

<!-- 🎤 Voice Button -->
<div id="voiceAssistant">🎤</div>

<!-- 🤖 Assistant Panel -->
<div id="assistantPanel" class="hidden">

    <div id="assistantHeader">
        <span>Doctor Assistant</span>
        <button id="toggleChat">×</button>
    </div>

    <div id="chatBody"></div>

    <!-- ✍️ INPUT -->
    <div id="chatInputArea">
        <input type="text" id="chatInput" placeholder="Type a command...">
        <button id="sendBtn">➤</button>
    </div>

    <!-- LISTENING -->
    <div id="listeningIndicator" class="hidden">
        <div class="dot-bubble">
            <span></span><span></span><span></span>
        </div>
    </div>

</div>

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
  font-size: 24px;
}

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
}

.hidden { display: none; }

#assistantHeader {
  background: #1e293b;
  padding: 10px;
  color: white;
  display: flex;
  justify-content: space-between;
}

#chatBody {
  flex: 1;
  padding: 10px;
  overflow-y: auto;
}

.message {
  margin: 6px 0;
  padding: 8px;
  border-radius: 10px;
  max-width: 80%;
}

.user {
  background: #2563eb;
  color: white;
  margin-left: auto;
}

.bot {
  background: #1e293b;
  color: #e5e7eb;
}

#chatInputArea {
  display: flex;
  border-top: 1px solid #1e293b;
}

#chatInput {
  flex: 1;
  padding: 10px;
  border: none;
  outline: none;
  background: #0f172a;
  color: white;
}

#sendBtn {
  background: #2563eb;
  border: none;
  color: white;
  padding: 0 15px;
  cursor: pointer;
}

#listeningIndicator {
  display: flex;
  justify-content: flex-end;
  padding: 5px;
}

.dot-bubble {
  background: #2563eb;
  padding: 6px;
  border-radius: 20px;
  display: flex;
  gap: 4px;
}

.dot-bubble span {
  width: 6px;
  height: 6px;
  background: white;
  border-radius: 50%;
  animation: bounce 1.2s infinite;
}

@keyframes bounce {
  0%,80%,100% { transform: scale(0.6); }
  40% { transform: scale(1); }
}

.highlight {
  outline: 3px solid red;
}
</style>

<script>
// ELEMENTS
let panel = document.getElementById("assistantPanel");
let chatBody = document.getElementById("chatBody");
let listeningIndicator = document.getElementById("listeningIndicator");

// ================= CHAT
function addMessage(text, type){
    let msg = document.createElement("div");
    msg.className = "message " + type;
    msg.innerText = text;
    chatBody.appendChild(msg);
    setTimeout(()=> chatBody.scrollTop = chatBody.scrollHeight, 10);
}

function speak(text){
    speechSynthesis.cancel();
    let s = new SpeechSynthesisUtterance(text);
    s.rate = 0.9;
    speechSynthesis.speak(s);
    addMessage(text, "bot");
}

// ================= OPEN/CLOSE
document.getElementById("voiceAssistant").onclick = function(){
    panel.classList.remove("hidden");
    setTimeout(()=> chatBody.scrollTop = chatBody.scrollHeight, 50);
    startListening();
};

document.getElementById("toggleChat").onclick = function(){
    panel.classList.add("hidden");
};

// ================= VOICE
function startListening(){
    let r = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    r.start();
    listeningIndicator.classList.remove("hidden");

    r.onresult = function(e){
        let cmd = e.results[0][0].transcript.toLowerCase().trim();
        addMessage(cmd, "user");
        processCommand(cmd);
        listeningIndicator.classList.add("hidden");
    };

    r.onerror = function(){
        speak("Couldn't hear you");
        listeningIndicator.classList.add("hidden");
    };
}

// ================= 🧠 READ SCREEN
function readDashboard(){
    let text = "Hello Doctor. You are on your dashboard. ";

    let stats = document.body.innerText;

    let patients = stats.match(/Patients:\s*(\d+)/i);
    let appointments = stats.match(/Appointments:\s*(\d+)/i);
    let pending = stats.match(/Pending:\s*(\d+)/i);
    let completed = stats.match(/Completed:\s*(\d+)/i);

    if(patients) text += "You have " + patients[1] + " patients. ";
    if(appointments) text += "You have " + appointments[1] + " appointments. ";
    if(completed) text += completed[1] + " completed appointments. ";

    if(pending){
        if(parseInt(pending[1]) > 0){
            text += "There are " + pending[1] + " pending requests. ";
        } else {
            text += "No pending requests. ";
        }
    }

    text += "Current time is " + new Date().toLocaleTimeString();
    speak(text);
}

// ================= COMMANDS
function processCommand(cmd){

    if(cmd.includes("appointment")){
        speak("Opening appointments");
        location.href = "appointment-history.php";
    }

    else if(cmd.includes("patient")){
        if(cmd.includes("add")){
            speak("Opening add patient");
            location.href = "add-patient.php";
        } else {
            speak("Opening patients");
            location.href = "manage-patient.php";
        }
    }

    else if(cmd.includes("pending")){
        speak("Opening pending");
        location.href = "appointment-history.php";
    }

    else if(cmd.includes("profile")){
        speak("Opening profile");
        location.href = "edit-profile.php";
    }

    else if(cmd.includes("search")){
        speak("Opening search");
        location.href = "search.php";
    }

    else if(cmd.includes("dashboard")){
        speak("Opening dashboard");
        location.href = "dashboard.php";
    }

    else if(cmd.includes("read") || cmd.includes("status") || cmd.includes("summary")){
        readDashboard();
    }

    else if(cmd.includes("time")){
        speak("Time is " + new Date().toLocaleTimeString());
    }

    else{
        speak("Command not understood");
    }
}

// ================= TEXT INPUT
let input = document.getElementById("chatInput");
let sendBtn = document.getElementById("sendBtn");

function handleTextCommand(){
    let cmd = input.value.trim().toLowerCase();
    if(cmd === "") return;

    addMessage(cmd, "user");
    processCommand(cmd);
    input.value = "";
}

sendBtn.onclick = handleTextCommand;

input.addEventListener("keypress", function(e){
    if(e.key === "Enter"){
        handleTextCommand();
    }
});
</script>

</body>
</html>