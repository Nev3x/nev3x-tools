let logContainer = document.getElementById("log-container");
function getRandomInt(max) {
    return Math.floor(Math.random() * max);
}

var id = getRandomInt(10000000000)

function createBot() {
    const username = document.getElementById("username").value;
    const host = document.getElementById("host").value;
    const port = document.getElementById("port").value;

    if (!username || !host || !port) {
        alert("Please fill in all connection settings");
        return;
    }
    const url = `http://localhost:8000/api/minecraft/createBot/${username}/${host}/${port}/${id}`;
    console.log(url)
    fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => response.text())
    .then(data => {
        logContainer.innerHTML += `<div class="log-entry">${data}</div>`;
    })
    .catch(error => {
        logContainer.innerHTML += `<div class="log-entry">Error creating bot: ${error}</div>`;
    });
}

function sendMessage() {

    const message = document.getElementById("message").value;

    if (!message) {
        alert("Please enter a message");
        return;
    }

    const url = `http://localhost:8000/api/minecraft/${id}`;
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => response.json())
    .then(data => {
        logContainer.innerHTML += `<div class="log-entry">${data}</div>`;
    })
    .catch(error => {
        logContainer.innerHTML += `<div class="log-entry">Error sending message: ${error}</div>`;
    });
}


function attack(){
    const player = document.getElementById('attack').value
    const url = `http://localhost:8000/api/minecraft/attack/${id}`


    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ target: player })
    })
    .then(response => response.json())
    .then(data => {
        logContainer.innerHTML += `<div class="log-entry">${data}</div>`;
    })
    .catch(error => {
        logContainer.innerHTML += `<div class="log-entry">Error sending message: ${error}</div>`;
    });
}

function stopattack(){
    const url = `http://localhost:8000/api/minecraft/stopattack/${id}`
    
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => response.json())
    .then(data => {
        logContainer.innerHTML += `<div class="log-entry">${data}</div>`;
    })
    .catch(error => {
        logContainer.innerHTML += `<div class="log-entry">Error sending message: ${error}</div>`;
    });
}

function equipArmor(){

    const url = `http://localhost:8000/api/minecraft/equip_armor/${id}`
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        }
    }).then(response => response.json())
    .then(data => {
        logContainer.innerHTML += `<div class="log-entry">${data}</div>`;
    })
    .catch(error => {
        logContainer.innerHTML += `<div class="log-entry">Error sending message: ${error}</div>`;
    });
}
function sleep(ms) {
    const start = new Date().getTime();
    while (new Date().getTime() < start + ms) {}
  }
function followPlayer(){
    const url = `http://localhost:8000/api/minecraft/follow/${id}`

    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ player: document.getElementById('follow').value })
    })
    .then(response => response.json())
    .then(data => {
        logContainer.innerHTML += `<div class="log-entry">${data}</div>`;
    })
    .catch(error => {
        logContainer.innerHTML += `<div class="log-entry">Error sending message: ${error}</div>`;
    });

        
}
// add event listeners
function unfollow(){
    const url = `http://localhost:8000/api/minecraft/unfollow/${id}`
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        }
    }).then(response => response.json())
    .then(data => {
        logContainer.innerHTML += `<div class="log-entry">${data}</div>`;
    })
    .catch(error => {
        logContainer.innerHTML += `<div class="log-entry">Error sending message: ${error}</div>`;
    });
}

function disconnect(){
    const url = `http://localhost:8000/api/minecraft/quit/${id}`
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        }
    }).then(response => response.json())
    .then(data => {
        logContainer.innerHTML += `<div class="log-entry">${data}</div>`;
    })
    .catch(error => {
        logContainer.innerHTML += `<div class="log-entry">Error sending message: ${error}</div>`;
    });
    location.reload()
}

document.getElementById('discbtn').addEventListener("click", disconnect)
document.getElementById('unfollowbtn').addEventListener("click", unfollow)
document.getElementById('followbtn').addEventListener("click", followPlayer)
document.getElementById('attackbtn').addEventListener("click", attack)
document.getElementById('stopattackbtn').addEventListener("click", stopattack)
document.getElementById("conbtn").addEventListener("click", createBot);
document.getElementById("sendbtn").addEventListener("click", sendMessage);
document.getElementById("armor").addEventListener("click", equipArmor);







