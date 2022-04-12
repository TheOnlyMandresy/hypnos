let btn = null,
    form = null

export function sendDatas (e)
{
    let post = new FormData(form),
        request = new XMLHttpRequest()
        post.append('submit', btn.value)

    btn.disabled = true
    e.preventDefault()
    
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
            appendAlert(request.response)

            setTimeout(() => {
                btn.disabled = false
            }, 3000)
        }
    }
    request.open("POST", "/datas")
    request.send(post)
}

export function checkForm ()
{
    if (document.querySelector('form')) {
        form = document.querySelector('form')
        btn = document.querySelector('form button[type="button"]')
        btn.addEventListener('click', (e) => { sendDatas(e) }) // To remove when finish
    }
}

function appendAlert (message)
{
    let mess = (Array.isArray(message)) ? message : JSON.parse(message)
    console.log(message)
}