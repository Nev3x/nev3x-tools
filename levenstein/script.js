function clicked(){
    const url = `http://localhost:8000/api/similarity/levenstein/`
    const text1 = document.getElementById('text1').value
    const text2 = document.getElementById('text2').value
    const response = document.getElementById('response')

    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ doc1: text1, doc2:text2})
    })
    .then(response => response.json())
    .then(data => {
        response.innerHTML = data
    })
    .catch(error => {
        response.innerHTML = error
    });
}


document.getElementById('submitbtn').addEventListener('click', clicked)