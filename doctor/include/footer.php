<!-- 🎤 Voice Button -->
<div id="voiceAssistant">A</div>

<!-- 🤖 Assistant Panel -->
<div id="assistantPanel" class="hidden">

    <!-- HEADER -->
    <div id="assistantHeader">
        <span>Doctor Assistant</span>
        <button id="toggleChat">×</button>
    </div>

    <!-- CHAT BODY -->
    <div id="chatBody"></div>

    <!-- INPUT -->
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
  bottom: 50px;
  right: 50px;
  width: 60px;
  height: 60px;
  background: #2a19e9;
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
  box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.hidden { display: none; }

#assistantHeader {
  background: #1e293b;
  padding: 10px;
  color: white;
  display: flex;
  justify-content: space-between;
}

#toggleChat {
  background: none;
  border: none;
  color: white;
  font-size: 18px;
  cursor: pointer;
}

#chatBody {
  flex: 1;
  padding: 10px;
  overflow-y: auto;
  font-size: 13px;
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
  text-align: right;
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
  background: transparent;
  color: white;
}

#chatInput::placeholder {
  color: #94a3b8;
}

#sendBtn {
  background: none;
  border: none;
  color: #2563eb;
  font-size: 18px;
  cursor: pointer;
}

#listeningIndicator {
  display: flex;
  justify-content: flex-end;
  padding: 5px;
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
  opacity: 0.3;
  animation: bounce 1s infinite;
}

.dot-bubble span:nth-child(2){animation-delay:0.2s;}
.dot-bubble span:nth-child(3){animation-delay:0.4s;}

@keyframes bounce {
  0%,100%{opacity:0.3;}
  50%{opacity:1;}
}
</style>

<script>
// ELEMENTS
const micBtn = document.getElementById("voiceAssistant");
const panel = document.getElementById("assistantPanel");
const chatBody = document.getElementById("chatBody");
const listeningIndicator = document.getElementById("listeningIndicator");
const input = document.getElementById("chatInput");

let recognition;
let isListening = false;

// INIT VOICE
function initVoice(){
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if(!SpeechRecognition){
        alert("❌ Voice not supported. Use Chrome.");
        return;
    }

    recognition = new SpeechRecognition();
    recognition.lang = "en-US";

    recognition.onstart = ()=>{
        isListening = true;
        listeningIndicator.classList.remove("hidden");
    };

    recognition.onend = ()=>{
        isListening = false;
        listeningIndicator.classList.add("hidden");
    };

    recognition.onerror = (e)=>{
        console.log(e);
        listeningIndicator.classList.add("hidden");
    };

    recognition.onresult = (e)=>{
        let text = e.results[0][0].transcript.toLowerCase();
        addMessage(text,"user");
        processCommand(text);
    };
}

// CHAT
function addMessage(text,type){
    let div=document.createElement("div");
    div.className="message "+type;
    div.innerText=text;
    chatBody.appendChild(div);
    chatBody.scrollTop = chatBody.scrollHeight;
}

// SPEAK
function speak(text){
    let speech = new SpeechSynthesisUtterance(text);
    speechSynthesis.cancel();
    speechSynthesis.speak(speech);
    addMessage(text,"bot");
}

// 🎤 CLICK = OPEN + START LISTENING
micBtn.onclick = ()=>{
    panel.classList.remove("hidden");

    if(!recognition){
        initVoice();
    }

    try {
        recognition.start();
    } catch(e){
        console.log("Already running");
    }
};

// CLOSE
document.getElementById("toggleChat").onclick = ()=>{
    panel.classList.add("hidden");
};

// COMMANDS
function processCommand(cmd){

    if(cmd.includes("appointment")){
        speak("Opening appointments");
        location.href="appointment-history.php";
    }

    else if(cmd.includes("patient")){
        if(cmd.includes("add")){
            speak("Opening add patient");
            location.href="add-patient.php";
        } else {
            speak("Opening manage patients");
            location.href="manage-patient.php";
        }
    }

    else if(cmd.includes("profile")){
        speak("Opening profile");
        location.href="edit-profile.php";
    }

    else if(cmd.includes("search")){
        speak("Opening search");
        location.href="search.php";
    }

    else if(cmd.includes("dashboard")){
        speak("Going to dashboard");
        location.href="dashboard.php";
    }

    else if(cmd.includes("read") || cmd.includes("status")){
        let txt = document.body.innerText;

        let p = txt.match(/Patients:\s*(\d+)/i);
        let a = txt.match(/Appointments:\s*(\d+)/i);
        let pen = txt.match(/Pending:\s*(\d+)/i);

        let msg = "Here is your dashboard status. ";

        if(p) msg += "You have " + p[1] + " patients. ";
        if(a) msg += "You have " + a[1] + " appointments. ";
        if(pen) msg += pen[1] + " are pending.";

        speak(msg);
    }

    else {
        speak("Command not understood");
    }
}

// TEXT INPUT
document.getElementById("sendBtn").onclick = ()=>{
    let cmd = input.value.toLowerCase();
    if(!cmd) return;

    addMessage(cmd,"user");
    processCommand(cmd);
    input.value="";
};

input.addEventListener("keypress",e=>{
    if(e.key==="Enter"){
        document.getElementById("sendBtn").click();
    }
});
</script>