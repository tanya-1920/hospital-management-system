<!-- 🎤 Voice Assistant -->
<div id="voiceAssistant">🎤</div>

<div id="voicePopup">
    <p id="voiceText">Click mic and speak...</p>
</div>

<!-- 👤 Username -->
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
#voiceAssistant:hover { transform: scale(1.1); }

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
}
</style>

<script>


//  STATE

let isSpeaking = false;


//  MIC CLICK

document.getElementById("voiceAssistant").onclick = function(){

    if (speechSynthesis.speaking) {
        speechSynthesis.cancel();
        isSpeaking = false;
        document.getElementById("voiceText").innerText = "Stopped";
        return;
    }

    startListening();
};


// LISTENING & COMMAND HANDLING

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


//  SPEAK function

function speak(text){
    speechSynthesis.cancel();
    let speech = new SpeechSynthesisUtterance(text);
    speech.rate = 0.9;

    speech.onend = () => { isSpeaking = false; };

    isSpeaking = true;
    speechSynthesis.speak(speech);
}


//  GREETING

function getGreeting(){
    let hour = new Date().getHours();
    if(hour < 12) return "Good morning";
    if(hour < 17) return "Good afternoon";
    return "Good evening";
}

//   SCREEN READ

function readSmartScreen(){

    let greeting = getGreeting();
    let title = document.title;

    let message = `${greeting} ${username}. `;
    message += `You are on the ${title}. `;

    let sections = document.querySelectorAll("h1, h2, h3, h4");

    if(sections.length > 0){
        message += "Sections include ";
        sections.forEach((sec, i) => {
            if(i < 5){
                message += sec.innerText + ", ";
            }
        });
    }

    speak(message);
}


//  FORM FILL

function fillField(label, value){
    let inputs = document.querySelectorAll("input, textarea, select");

    inputs.forEach(input => {
        let text = (input.placeholder || input.name || input.id || "").toLowerCase();

        if(text.includes(label)){
            if(input.tagName === "SELECT"){
                for(let i=0;i<input.options.length;i++){
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

//  MAIN 

function handleCommand(command){

    let wantsHelp = command.includes("help");
    let wantsOpen = command.includes("open") || command.includes("show");
    let wantsAppointments = command.includes("appointment");
    let wantsToday = command.includes("today");
    let wantsTomorrow = command.includes("tomorrow");
    let wantsFees = command.includes("fees");

    //  BOOK APPOINTMENT
    if(wantsAppointments && command.includes("book")){
        if(wantsHelp){
            speak("To book an appointment, select doctor, choose date and time, then submit.");
        }
        speak("Opening booking page");
        window.location.href = "book-appointment.php";
    }

    //  OPEN HISTORY
    else if(wantsAppointments && (wantsOpen || command.includes("history"))){
        speak("Opening appointment history");
        window.location.href = "appointment-history.php";
    }

    //  ANSWER APPOINTMENTS
    else if(wantsAppointments){

        let rows = document.querySelectorAll("table tbody tr");

        if(rows.length === 0){
            speak("No appointment data found here");
            return;
        }

        let today = new Date().toISOString().split("T")[0];
        let tomorrowDate = new Date();
        tomorrowDate.setDate(tomorrowDate.getDate() + 1);
        let tomorrow = tomorrowDate.toISOString().split("T")[0];

        let results = [];

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();

            if(wantsToday && text.includes(today)){
                results.push(row.innerText);
            }
            else if(wantsTomorrow && text.includes(tomorrow)){
                results.push(row.innerText);
            }
            else if(!wantsToday && !wantsTomorrow){
                results.push(row.innerText);
            }
        });

        if(results.length === 0){
            speak("No matching appointments found");
            return;
        }

        speak(`You have ${results.length} appointments`);

        results.slice(0,2).forEach(r => speak(r));
    }

    //  FEES
    else if(wantsFees){
        let text = document.body.innerText.toLowerCase();
        let matches = text.match(/₹?\s?\d+/g);

        if(matches){
            speak("Fees found are " + matches.slice(0,3).join(", "));
        } else {
            speak("No fee data found");
        }
    }

    //  PROFILE
    else if(command.includes("profile")){
        if(wantsHelp){
            speak("To edit profile, update details and click update.");
        }
        speak("Opening profile");
        window.location.href = "edit-profile.php";
    }

    // DASHBOARD
    else if(command.includes("dashboard")){
        speak("Opening dashboard");
        window.location.href = "dashboard.php";
    }

    //  FORM FILL
    else if(command.includes("name")){
        fillField("name", command.replace("name","").trim());
        speak("Name added");
    }

    else if(command.includes("email")){
        fillField("email", command.replace("email","").trim());
        speak("Email added");
    }

    else if(command.includes("phone")){
        fillField("phone", command.replace("phone","").trim());
        speak("Phone added");
    }

    else if(command.includes("date")){
        fillField("date", command.replace("date","").trim());
        speak("Date added");
    }

    else if(command.includes("time")){
        fillField("time", command.replace("time","").trim());
        speak("Time added");
    }

    //  SUBMIT
    else if(command.includes("submit") || command.includes("update")){
        let form = document.querySelector("form");
        if(form){
            speak("Submitting form");
            form.submit();
        }
    }

    //  READ SCREEN
    else if(command.includes("read screen")){
        readSmartScreen();
    }

    //  DEFAULT
    else{
        speak("I understood partially. Try asking about appointments or say help.");
    }
}

</script>