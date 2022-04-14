import { reloadApp } from './nav.js'

let btn = null,
    form = null

export function sendDatas (e)
{
    let request = new XMLHttpRequest(),
        post = null

    if (e.path) {
        post = new FormData(form)
        
        post.append('submit', btn.value)
        btn.disabled = true
        e.preventDefault()
    } else {
        post = new FormData()

        for(let data of e.post) {
            post.append(data[0], data[1])
        }
        post.append('submit', e.submit)
    }
    
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
            appendAlert(request.response)

            setTimeout(() => {
                if (e.path) btn.disabled = false
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
        btn.addEventListener('click', (e) => { sendDatas(e) })
    }
}

function appendAlert (datas)
{
    let main = document.querySelector('main')
        datas = JSON.parse(datas)

    if (document.querySelector('.flash')) document.querySelector('.flash').remove()

    if (datas.infos !== true && datas.infos !== 'session') {
        let html = document.createElement('div'),
            p = document.createElement('p')

        html.classList.add('flash')
        p.textContent = datas.infos
        html.appendChild(p)
        main.classList.add('danger')
        main.appendChild(html)
        return
    }
    
    main.classList.remove('danger')
    main.classList.add('success')

    if (datas.admin === true) return location.reload()
    if (datas.reload === true) return reloadApp()
    return history.back()
}