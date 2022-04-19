import * as FORMULAR from '../../form.js'
import * as HTML from '../../views/reservations.js'

export function bookCall (e)
{
    let target = e.target.name

    if (target === 'new') bookingNew()
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