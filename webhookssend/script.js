document.getElementById('submited').addEventListener('click', function() {
    const url = document.getElementById('url').value
    const text = document.getElementById('text')
    if(text.value.includes('\\') || text.value.includes('/')){
        alert('text shall not contain "\\" or "/"')
    }else if(url.includes("https://discord.com/")) {
        
        var splited = url.split('/')
        var token = splited.at(6)
        console.log(token)
        var urlReplaced = url.replace(token, '').replaceAll('/', '-')
        fetch('http://127.0.0.1:8000/api/post/' + urlReplaced + "/" + text.value + "/" + token, {
        })
        .then(response => response.text())
        .then((data) => {
            const responseHeader = document.getElementById('response');
            responseHeader.innerText = data;
        })
        .catch(error => console.error('Error:', error));

    }
    
});
