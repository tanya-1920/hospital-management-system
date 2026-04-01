</div>

<!-- 🎤 Voice Button -->
<div id="voiceAssistant">🎤</div>

<!-- 🤖 Assistant Panel -->
<div id="assistantPanel" class="hidden">

    <div id="assistantHeader">
        <span>HMS Assistant</span>
        <button id="toggleChat">×</button>
    </div>

    <div id="chatBody"></div>

    <div id="listeningIndicator" class="hidden">
        <div class="dot-bubble">
            <span></span><span></span><span></span>
        </div>
    </div>

</div>

<script>
let username = "<?php echo $_SESSION['name'] ?? 'Admin'; ?>";
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
// ================= ELEMENTS
let panel = document.getElementById("assistantPanel");
let chatBody = document.getElementById("chatBody");
let listeningIndicator = document.getElementById("listeningIndicator");

// ================= CHAT
function loadChat(){
    let saved = localStorage.getItem("chatHistory");
    if(saved){
        chatBody.innerHTML = saved;
        setTimeout(()=> chatBody.scrollTop = chatBody.scrollHeight, 50);
    }
}
function saveChat(){
    localStorage.setItem("chatHistory", chatBody.innerHTML);
}
function addMessage(text, type){
    let msg = document.createElement("div");
    msg.className = "message " + type;
    msg.innerText = text;
    chatBody.appendChild(msg);
    setTimeout(()=> chatBody.scrollTop = chatBody.scrollHeight, 10);
    saveChat();
}
function speak(text){
    speechSynthesis.cancel();
    let speech = new SpeechSynthesisUtterance(text);
    speech.rate = 0.9;
    speechSynthesis.speak(speech);
    addMessage(text, "bot");
}

// ================= OPEN / CLOSE
document.getElementById("voiceAssistant").onclick = function(){
    panel.classList.remove("hidden");
    setTimeout(()=> chatBody.scrollTop = chatBody.scrollHeight, 50);
    startListening();
};

document.getElementById("toggleChat").onclick = function(){
    panel.classList.add("hidden");
    listeningIndicator.classList.add("hidden");
};

// ================= LISTEN
function startListening(){
    let recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.start();
    listeningIndicator.classList.remove("hidden");

    recognition.onresult = function(e){
        let command = e.results[0][0].transcript.toLowerCase().trim();
        addMessage(command, "user");
        processCommand(command);
        listeningIndicator.classList.add("hidden");
    };

    recognition.onerror = function(){
        speak("Couldn't hear you");
        listeningIndicator.classList.add("hidden");
    };
}

// ================= HELPERS
function highlightCard(keyword){
    document.querySelectorAll(".dashboard-card").forEach(card=>{
        if(card.innerText.toLowerCase().includes(keyword)){
            card.classList.add("highlight");
            setTimeout(()=>card.classList.remove("highlight"),2000);
        }
    });
}

function clickButton(keyword){
    let elements = document.querySelectorAll("a,button");
    for(let el of elements){
        if(el.innerText.toLowerCase().includes(keyword)){
            el.click();
            return true;
        }
    }
    return false;
}

function searchDashboard(term){
    let input = document.querySelector(".search-box input");
    if(input){
        input.value = term;
        input.dispatchEvent(new Event("keyup"));
        speak("Searching for " + term);
    }
}

// ================= 🧠 SMART READ SCREEN
function readDashboard(){

    let url = window.location.href;
    let text = "";

    if(url.includes("dashboard.php")){
        text += "Hello " + username + ". ";
        text += "You are currently on the admin dashboard. ";

        let data = {};
        document.querySelectorAll(".dashboard-card").forEach(card=>{
            let title = card.querySelector("h4")?.innerText.toLowerCase();
            let value = card.querySelector("p")?.innerText.match(/\d+/);
            if(title){
                data[title] = value ? parseInt(value[0]) : 0;
            }
        });

        text += "In this dashboard, ";

        if(data.doctors !== undefined)
            text += "you have " + data.doctors + " doctors, ";

        if(data.users !== undefined)
            text += data.users + " users, ";

        if(data.patients !== undefined)
            text += data.patients + " patients, ";

        if(data.appointments !== undefined)
            text += "and " + data.appointments + " total appointments. ";

        if(data.queries !== undefined){
            if(data.queries > 0){
                text += "There are " + data.queries + " pending queries that require your attention. ";
            } else {
                text += "There are no pending queries. ";
            }
        }

        let now = new Date();
        text += "Current time is " + now.toLocaleTimeString() + ". ";
        text += "Today is " + now.toLocaleDateString() + ".";
    }

    else if(url.includes("manage-doctors.php")){
        let count = document.querySelectorAll("table tbody tr").length;
        text = "You are on the manage doctors page. There are " + count + " doctors listed.";
    }

    else if(url.includes("manage-patient.php")){
        let count = document.querySelectorAll("table tbody tr").length;
        text = "You are on the patients page. There are " + count + " patients listed.";
    }

    else if(url.includes("manage-users.php")){
        let count = document.querySelectorAll("table tbody tr").length;
        text = "You are on the users page. There are " + count + " users listed.";
    }

    else if(url.includes("appointment-history.php")){
        let count = document.querySelectorAll("table tbody tr").length;
        text = "You are viewing appointment history. There are " + count + " records.";
    }

    else if(url.includes("unread-queries.php")){
        let count = document.querySelectorAll("table tbody tr").length;
        text = "You are viewing unread queries. There are " + count + " pending queries.";
    }

    else if(url.includes("doctor-logs.php")){
        text = "You are viewing doctor logs.";
    }

    else if(url.includes("user-logs.php")){
        text = "You are viewing user logs.";
    }

    else if(url.includes("between-dates-reports.php")){
        text = "You are on the reports page.";
    }

    else {
        text = "You are currently on " + document.title;
    }

    speak(text);
}

// ================= COMMAND ENGINE
function processCommand(cmd){

    cmd = cmd.toLowerCase().trim();

    if(cmd.includes("search")){
        searchDashboard(cmd.replace("search","").trim());
        return;
    }

    if(cmd.includes("highlight")){
        highlightCard(cmd);
        speak("Highlighting");
        return;
    }

    if(cmd.includes("click") || cmd.includes("press")){
        if(clickButton(cmd)){
            speak("Done");
        } else {
            speak("Button not found");
        }
        return;
    }

    if(cmd.includes("fill")){
        let parts = cmd.replace("fill","").trim().split(" ");
        let field = parts[0];
        let value = parts.slice(1).join(" ");

        let input = document.querySelector(`input[name*='${field}'], input[id*='${field}']`);
        if(input){
            input.value = value;
            speak(field + " filled");
        } else {
            speak("Field not found");
        }
        return;
    }

    if(cmd.includes("doctor")){
        if(cmd.includes("add") || cmd.includes("new")) return location.href="add-doctor.php";
        if(cmd.includes("special")) return location.href="doctor-specilization.php";
        return location.href="manage-doctors.php";
    }

    if(cmd.includes("user")) return location.href="manage-users.php";
    if(cmd.includes("patient")) return location.href="manage-patient.php";
    if(cmd.includes("appointment") || cmd.includes("history")) return location.href="appointment-history.php";

    if(cmd.includes("query")){
        if(cmd.includes("unread")) return location.href="unread-queries.php";
        return location.href="read-query.php";
    }

    if(cmd.includes("log")){
        if(cmd.includes("doctor")) return location.href="doctor-logs.php";
        return location.href="user-logs.php";
    }

    if(cmd.includes("report")) return location.href="between-dates-reports.php";
    if(cmd.includes("profile")) return location.href="edit-profile.php";
    if(cmd.includes("dashboard")) return location.href="dashboard.php";

    if(cmd.includes("summary") || cmd.includes("status") || cmd.includes("read")){
        readDashboard();
        return;
    }

    if(cmd.includes("time")){
        speak("Time is " + new Date().toLocaleTimeString());
        return;
    }

    speak("I didn't understand, try again");
}

// ================= INIT
loadChat();
</script>

</body>
</html>