const toggle =
document.getElementById("chatbotToggle");

const box =
document.getElementById("chatbotBox");

toggle.onclick = () => {

    if(box.style.display === "flex"){

        box.style.display = "none";

    }else{

        box.style.display = "flex";
    }
};

/* SEND MESSAGE */

function sendMessage(){

    let input =
    document.getElementById("userInput");

    let message =
    input.value.trim();

    if(message === "") return;

    let body =
    document.getElementById("chatbotBody");

    /* USER MESSAGE */

    body.innerHTML +=
    `<div class="user-message">
    ${message}
    </div>`;

    /* AJAX */

    fetch("chatbot.php",{

        method:"POST",

        headers:{
            "Content-Type":
            "application/x-www-form-urlencoded"
        },

        body:
        "message=" +
        encodeURIComponent(message)

    })

    .then(res => res.text())

    .then(data => {

        body.innerHTML +=
        `<div class="bot-message">
        ${data}
        </div>`;

        body.scrollTop =
        body.scrollHeight;
    });

    input.value = "";
}
/* ENTER KEY SUPPORT */

document
.getElementById("userInput")

.addEventListener(
"keypress",

function(event){

    if(event.key === "Enter"){

        event.preventDefault();

        sendMessage();
    }
});