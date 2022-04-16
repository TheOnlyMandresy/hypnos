import { reloadApp } from './nav.js'

let btn, post

export let globalData

export function sendDatas (form)
{
    let request = new XMLHttpRequest()

    if (btn) btn.disabled = true

    if (form.constructor.name === 'HTMLFormElement') {
        post = new FormData(form)
        
        post.append('submit', btn.value)
    } else {
        post = new FormData()

        for(let data of form.post) {
            post.append(data[0], data[1])
        }
        post.append('submit', form.submit)
    }
    
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            let datas = JSON.parse(request.responseText)

            globalData = JSON.parse(JSON.parse(request.responseText).infos)

            setTimeout(() => {
                if (btn) btn.disabled = false
            }, 3000)

            appendAlert(datas, form)
        }
    }
    
    request.open("POST", "/datas")
    request.send(post)
}

export function checkForm ()
{
    if (document.querySelector('form.sendData')) {
        let form = document.querySelector('form.sendData')
        btn = form.querySelector('button[type="button"]')

        console.log(btn)
        form.addEventListener('submit', (e) => {
            e.preventDefault()
            sendDatas(form)
        })
        btn.addEventListener('click', (e) => {
            e.preventDefault()
            sendDatas(form)
        })
    }
}

function appendAlert (datas, form)
{
    let main = document.querySelector('main')

    if (document.querySelector('.flash')) document.querySelector('.flash').remove()

    if (datas.state !== true && form.constructor.name === 'HTMLFormElement') {
        let html = document.createElement('div'),
            p = document.createElement('p')

        html.classList.add('flash')
        p.textContent = datas.state
        html.appendChild(p)
        main.classList.add('danger')
        main.appendChild(html)
        return
    }
    
    if (form.constructor.name === 'HTMLFormElement') {
        main.classList.remove('danger')
        main.classList.add('success')
        setTimeout (() => { main.classList.remove('success') }, 1000)
    }

    if (datas.reload && !datas.link) return location.reload()
    if (datas.reload && datas.link === -1) return reloadApp()
    if (!datas.reload && datas.link === -1) return history.back()
    if (!datas.reload && typeof datas.link === 'string') return window.location.href = datas.link
}