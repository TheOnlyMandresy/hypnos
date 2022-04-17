import { reloadApp } from './nav.js'

let globalData

export function htmlDecode(input) {
    var doc = new DOMParser().parseFromString(input, "text/html");
    return doc.documentElement.textContent;
}

export function btnState (text, value, editMode)
{
    let btn = document.querySelector('button[type="button"]'),
        a = btn.querySelector('a')

    if (editMode) {
        btn.classList.remove('btn-success')
        btn.classList.add('btn-success2')
    } else {
        btn.classList.add('btn-success')
        btn.classList.remove('btn-success2')
    }

    a.name = value
    a.innerHTML = text
}

export async function sendDatas (infos)
{
    let btn = document.querySelector('form button[type="button"]')

    await fetch(datasTreatment(infos))

    if (globalData.state === true) document.querySelector('form').reset()
    appendAlert(globalData)
    btn.disabled = false
    return globalData
}

function datasTreatment (form)
{
    let request = new XMLHttpRequest(),
        post = new FormData()

    post.append('submit', form.to)

    if (form.post) {
        for(let data of form.post) {
            post.append(data[0], data[1])
        }
    }
    
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            let jsonObj = JSON.parse(request.responseText),
                infos = jsonObj.infos
                
            infos = JSON.parse(infos)
            jsonObj.infos = infos

            globalData = jsonObj
        }
    }
    
    request.open("POST", "/datas")
    request.send(post)
}

function appendAlert (datas)
{
    let main = document.querySelector('main')
    
    if (datas.state !== true) return flash(main, datas.state)
    
    if (datas.isForm) {
        main.classList.add('success')
        setTimeout (() => { main.classList.remove('success') }, 1000)
    }

    if (datas.reload && !datas.link) return location.reload()
    if (datas.reload && datas.link === -1) return reloadApp()
    if (!datas.reload && datas.link === -1) return history.back()
    if (!datas.reload && typeof datas.link === 'string') return window.location.href = datas.link
}

function flash (main, message)
{
    let html = document.createElement('div'),
        p = document.createElement('p')

    html.classList.add('flash')
    p.textContent = message
    html.appendChild(p)
    main.appendChild(html)

    main.classList.add('danger')

    setTimeout (() => {
        main.classList.remove('danger')
        document.querySelector('.flash').remove()
    }, 3000)
}