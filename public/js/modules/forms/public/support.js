import * as FORMULAR from '../../form.js'

export function supportCall (e)
{
    let target = e.target.name

    if (target === 'new') ticketNew()
    if (target === 'add') ticketAdd(e.target.dataset.infos)
    if (target === 'close') ticketClose(e.target.dataset.infos)
}

function ticketNew ()
{
    let firstname = document.querySelector('input[name="firstname"]'),
        lastname = document.querySelector('input[name="lastname"]'),
        email = document.querySelector('input[name="email"]'),
        title = document.querySelector('input[name="title"]'),
        topic = document.querySelector('select'),
        message = document.querySelector('textarea')

    firstname = (firstname) ? firstname.value : ''
    lastname = (lastname) ? lastname.value : ''
    email = (email) ? email.value : ''

    const send = {
        'to': 'ticketNew',
        'post': [
            ['title', title.value],
            ['firstname', firstname],
            ['lastname', lastname],
            ['email', email],
            ['topic', topic.value],
            ['message', message.value]
        ]
    }

    FORMULAR.sendDatas(send)
}

function ticketAdd (id)
{
    let message = document.querySelector('textarea')

    const send = {
        'to': 'ticketAdd',
        'post': [
            ['message', message.value],
            ['supportId', id],
        ]
    }

    FORMULAR.sendDatas(send).then(res => {
        if (res.state !== true) return
        const datas = res.infos

        const el = `
            <div class="box me">
                <p class="name">${datas.name} - ${datas.date}</p>
                <p class="message">${FORMULAR.htmlDecode(datas.message)}</p>
            </div>
        `

        let list = document.querySelector('.chat'),
            order = el + list.innerHTML

        list.innerHTML = order
    })
}

function ticketClose (id)
{

    const send = {
        'to': 'ticketClose',
        'post': [
            ['supportId', id],
        ]
    }

    FORMULAR.sendDatas(send).then(res => {
        if (res.state !== true) return
        const datas = res.infos

        let list = document.querySelector('[name="close"][data-infos="' +id+ '"]')
        list.parentNode.parentNode.remove()
    })
}