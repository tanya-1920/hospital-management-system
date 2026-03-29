<!-- 🎤 Voice Assistant -->
<div id="voiceAssistant">🎤</div>

<div id="voicePopup">
    <p id="voiceText">Click mic and speak...</p>
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
  max-width: 250px;
  font-size: 14px;
}
</style>

<script>

//  Assistant State
let assistantState = {
    mode: "idle"
};

//  Start on click
document.getElementById("voiceAssistant").onclick = function(){
    startListening();
};

//  Speech Recognition
function startListening(){
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();

    recognition.lang = "en-US";
    recognition.start();

    document.getElementById("voicePopup").style.display = "block";
    document.getElementById("voiceText").innerText = "Listening...";

    recognition.onresult = function(event){
        let command = event.results[0][0].transcript.toLowerCase();
        document.getElementById("voiceText").innerText = command;

        handleCommand(command);
    };
}

//  Voice Response
function speak(text){
    let speech = new SpeechSynthesisUtterance(text);
    speech.rate = 0.9;
    speech.pitch = 1;
    window.speechSynthesis.speak(speech);
}

//  Smart Field Fill
function fillField(label, value){
    let inputs = document.querySelectorAll("input, textarea, select");

    inputs.forEach(input => {
        let placeholder = (input.placeholder || "").toLowerCase();
        let name = (input.name || "").toLowerCase();
        let id = (input.id || "").toLowerCase();

        if(placeholder.includes(label) || name.includes(label) || id.includes(label)){
            if(input.tagName === "SELECT"){
                for(let i=0; i<input.options.length; i++){
                    if(input.options[i].text.toLowerCase().includes(value)){
                        input.selectedIndex = i;
                    }
                }
            } else {
                input.value = value;
            }
        }
    });
}

//  MAIN AI COMMAND HANDLER
function handleCommand(command){

    //  NAVIGATION
    if(command.includes("open dashboard")){
        speak("Opening dashboard");
        window.location.href = "dashboard.php";
    }

    else if(command.includes("open appointments") || command.includes("my appointments")){
        speak("Opening your appointments");
        window.location.href = "appointment-history.php";
    }

    else if(command.includes("book appointment")){
        speak("Opening booking page");
        window.location.href = "book-appointment.php";
    }

    else if(command.includes("edit profile")){
        speak("Opening edit profile");
        window.location.href = "edit-profile.php";
    }

    //  HELP MODE
    else if(command.includes("help")){
        speak("You can say open dashboard, book appointment, or edit profile. You can also say name, email, or submit.");
    }

    //  FORM INPUTS
    else if(command.includes("name")){
        let value = command.replace("name", "").trim();
        fillField("name", value);
        speak("Name added");
    }

    else if(command.includes("email")){
        let value = command.replace("email", "").trim();
        fillField("email", value);
        speak("Email added");
    }

    else if(command.includes("phone")){
        let value = command.replace("phone", "").trim();
        fillField("phone", value);
        speak("Phone number added");
    }

    else if(command.includes("date")){
        let value = command.replace("date", "").trim();
        fillField("date", value);
        speak("Date added");
    }

    else if(command.includes("time")){
        let value = command.replace("time", "").trim();
        fillField("time", value);
        speak("Time added");
    }

    else if(command.includes("doctor")){
        let value = command.replace("doctor", "").trim();
        fillField("doctor", value);
        speak("Doctor selected");
    }

    //  GENERIC WRITE
    else if(command.includes("write")){
        let text = command.replace("write", "").trim();
        let input = document.querySelector("input, textarea");

        if(input){
            input.value = text;
            speak("Added " + text);
        }
    }

    //  SUBMIT FORM
    else if(command.includes("submit") || command.includes("update") || command.includes("save")){
        let form = document.querySelector("form");

        if(form){
            speak("Submitting form");
            form.submit();
        }
    }

    //  READ SCREEN
    else if(command.includes("read screen")){
        speak(document.body.innerText);
    }

    //  UNKNOWN COMMAND 
    else{
        speak("Command not understood");
    }
}

</script>