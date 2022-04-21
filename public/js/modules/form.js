import { handleLocation } from './router.js'
import { reloadApp } from './nav.js'
import { formController } from './forms/controller.js'

let globalData

export function htmlDecode(input) {
    var doc = new DOMParser().parseFromString(input, "text/html");
    return doc.documentElement.textContent;
}

export function shorten(str, n){
    return (str.length > n) ? str.substr(0, n-1) + '&hellip;' : str;
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
    const main = document.querySelector('main')
    main.removeEventListener('click', formController)

    let btn = document.querySelector('form button[type="button"]')

    await datasTreatment(infos)
    
    main.addEventListener('click', formController)
    if (globalData.state === true && globalData.isForm === true) document.querySelector('form').reset()
    if (globalData.isForm === true) btn.disabled = false
    appendAlert(globalData)
    return globalData
}

function datasTreatment (form)
{
    return new Promise(function (resolve, reject) {
        let request = new XMLHttpRequest(),
            post = new FormData()

        post.append('submit', form.to)

        if (form.post) {
            for(let data of form.post) {
                if (typeof data[1] === 'object' && data[1].length > 0) {
                    for(let x = 0; x < data[1].length; x++) {
                        post.append(data[0] + '[]', data[1][x])
                    }
                } else {
                    post.append(data[0], data[1])
                }
            }
        }
        
        request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status === 200) {
                let jsonObj = JSON.parse(request.responseText),
                    infos = jsonObj.infos
                    
                infos = JSON.parse(infos)
                jsonObj.infos = infos

                globalData = jsonObj
                resolve(request.response)
            }
        }
        
        request.open("POST", "/datas")
        request.send(post)
    })
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
    if (!datas.reload && typeof datas.link === 'string') {
        window.history.pushState({}, "", datas.link)
        setTimeout (() => { handleLocation() }, 1000)
    }
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
        if (document.querySelector('.flash')) document.querySelector('.flash').remove()
    }, 3000)
}