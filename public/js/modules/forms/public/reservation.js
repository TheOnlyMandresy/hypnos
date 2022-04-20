import { handleLocation } from '../../router.js'
import * as FORMULAR from '../../form.js'

export function bookCall (e)
{
    let target = e.target.name

    if (target === 'new') bookingNew()
    if (target === 'del') bookedDel(e.target.dataset.infos)
    if (target === 'quick') bookedQuick(e.target.dataset.infos)

    if (target === 'institutionId') e.target.addEventListener('change', function (e) {selection(e)})
    if (target === 'roomId') e.target.addEventListener('change', function call (e) {selection(e)} )
}

function bookingNew ()
{
    let institutionId = document.querySelector('select[name="institutionId"]'),
        roomId = document.querySelector('select[name="roomId"]'),
        dateStart = document.querySelector('input[name="dateStart"]'),
        dateEnd = document.querySelector('input[name="dateEnd"]')
        
    const send = {
        'to': 'bookingNew',
        'post': [
            ['institutionId', institutionId.value],
            ['roomId', roomId.value],
            ['dateStart', dateStart.value],
            ['dateEnd', dateEnd.value]
        ]
    }

    FORMULAR.sendDatas(send)
}

function bookedDel (id)
{       
    const send = {
        'to': 'bookedDel',
        'post': [
            ['id', id]
        ]
    }

    FORMULAR.sendDatas(send).then(res => {
        if (res.state !== true) return

        id = 'booked' + id
        document.getElementById(id).remove();
    })
}

function bookedQuick (id)
{
    const send = {
        'to': 'bookingQuick',
        'post': [
            ['id', id]
        ]
    }

    FORMULAR.sendDatas(send).then(res => {
        if (res.state !== true) return
        window.history.pushState({}, "", res.link)
        handleLocation()
    })
}
async function selection (e)
{
    const hotels = await fetch('/api/institutions').then(res => res.json())

    let institutionsSelect = document.querySelector('select[name="institutionId"]'),
        roomsSelect = document.querySelector('select[name="roomId"]'),
        newOptions = []
    
    if (e.target.name === 'roomId') {
    let foundId = await fetch('/api/room/' +e.target.value).then(res => res.json())
        institutionsSelect.value = foundId.institutionId
    }

    for (let x = 0; x < Object.keys(hotels.datas).length; x++) {
        if (hotels.datas[x].id !== institutionsSelect.value) continue
        let rooms = await fetch('/api/rooms?institution=' +hotels.datas[x].id).then(res => res.json())

        for (let y = 0; y < Object.keys(rooms.datas).length; y++) {
            let option = document.createElement('option')
            option.value = rooms.datas[y].id
            option.innerHTML = rooms.datas[y].title
            newOptions.push(option)
        }
    }

    roomsSelect.innerHTML = null
    for (let el of newOptions) {
        roomsSelect.appendChild(el)
    }
}
