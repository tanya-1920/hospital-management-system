</div>

<!-- 🎤 Voice Button -->
<div id="voiceAssistant">🎤</div>

<!-- 🤖 Assistant Panel -->
<div id="assistantPanel" class="hidden">

    <!-- HEADER -->
    <div id="assistantHeader">
        <span>Doctor Assistant</span>
        <button id="toggleChat">×</button>
    </div>

    <!-- CHAT BODY -->
    <div id="chatBody"></div>

    <!-- ✍️ INPUT AREA -->
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
/* 🎤 Button */
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

.hidden { display: none; }

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

.user {
  background: #2563eb;
  color: #ffffff;
  margin-left: auto;
  text-align: right;
}

.bot {
  background: #1e293b;
  color: #e5e7eb;
}

/* ✍️ INPUT AREA (FIXED BUT SAME STYLE) */
#chatInputArea {
  display: flex;
  border-top: 1px solid #1e293b;
  background: #0f172a;
}

#chatInput {
  flex: 1;
  padding: 10px;
  border: none;
  outline: none;
  background: transparent !important;
  color: #ffffff !important;
  font-size: 13px;
  caret-color: #ffffff;
}

#chatInput::placeholder {
  color: #94a3b8 !important;
}

#sendBtn {
  background: transparent;
  border: none;
  color: #2563eb;
  padding: 0 15px;
  cursor: pointer;
  font-size: 18px;
}

/* LISTENING DOTS */
#listeningIndicator {
  display: flex;
  justify-content: flex-end;
  padding: 5px 10px;
}

.dot-bubble {
  background: #2563eb;
  border-radius: 20px;
  padding: 6px 10px;
  display: flex;
  gap: 4px;
}

.dot-bubble span {
  width: 6px;
  height: 6px;
  background: white;
  border-radius: 50%;
  opacity: 0.2;
  animation: bounce 1.2s infinite;
}

.dot-bubble span:nth-child(2){animation-delay:0.2s;}
.dot-bubble span:nth-child(3){animation-delay:0.4s;}

@keyframes bounce {
  0%,80%,100% { transform: scale(0.6); opacity:0.2; }
  40% { transform: scale(1); opacity:1; }
}
</style>

<script>
// ELEMENTS
let panel = document.getElementById("assistantPanel");
let chatBody = document.getElementById("chatBody");
let listeningIndicator = document.getElementById("listeningIndicator");

// CHAT
function addMessage(text,type){
    let msg=document.createElement("div");
    msg.className="message "+type;
    msg.innerText=text;
    chatBody.appendChild(msg);
    setTimeout(()=>chatBody.scrollTop=chatBody.scrollHeight,10);
}

function speak(text){
    speechSynthesis.cancel();
    let s=new SpeechSynthesisUtterance(text);
    speechSynthesis.speak(s);
    addMessage(text,"bot");
}

// OPEN
document.getElementById("voiceAssistant").onclick=function(){
    panel.classList.remove("hidden");
    setTimeout(()=>chatBody.scrollTop=chatBody.scrollHeight,50);
    startListening();
};

document.getElementById("toggleChat").onclick=function(){
    panel.classList.add("hidden");
};

// VOICE
function startListening(){
    let r=new (window.SpeechRecognition||window.webkitSpeechRecognition)();
    r.start();
    listeningIndicator.classList.remove("hidden");

    r.onresult=function(e){
        let cmd=e.results[0][0].transcript.toLowerCase().trim();
        addMessage(cmd,"user");
        processCommand(cmd);
        listeningIndicator.classList.add("hidden");
    };
}

// READ
function readDashboard(){
    let text="Hello Doctor. You are on your dashboard. ";

    let stats=document.body.innerText;

    let patients=stats.match(/Patients:\s*(\d+)/i);
    let appointments=stats.match(/Appointments:\s*(\d+)/i);
    let pending=stats.match(/Pending:\s*(\d+)/i);

    if(patients) text+="You have "+patients[1]+" patients. ";
    if(appointments) text+="You have "+appointments[1]+" appointments. ";
    if(pending) text+="There are "+pending[1]+" pending requests. ";

    speak(text);
}

// COMMANDS
function processCommand(cmd){

    if(cmd.includes("appointment")) location.href="appointment-history.php";

    else if(cmd.includes("patient")){
        if(cmd.includes("add")) location.href="add-patient.php";
        else location.href="manage-patient.php";
    }

    else if(cmd.includes("profile")) location.href="edit-profile.php";
    else if(cmd.includes("search")) location.href="search.php";
    else if(cmd.includes("dashboard")) location.href="dashboard.php";
    else if(cmd.includes("read")||cmd.includes("status")) readDashboard();
    else speak("Command not understood");
}

// TEXT INPUT
let input=document.getElementById("chatInput");
let sendBtn=document.getElementById("sendBtn");

function handleText(){
    let cmd=input.value.trim().toLowerCase();
    if(!cmd) return;
    addMessage(cmd,"user");
    processCommand(cmd);
    input.value="";
}

sendBtn.onclick=handleText;

input.addEventListener("keypress",function(e){
    if(e.key==="Enter") handleText();
});
</script>

</body>
</html>