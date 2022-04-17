import * as FORMULAR from '../../form.js'
import * as TEAM from '../../views/admin/team.js'

let input, select, btn

export function adminTeamCall (e)
{
    let target = e.target.name

    input = document.querySelector('input[name="email"]')
    select = document.querySelector('select optgroup')
    btn = document.querySelector('button[type="button"]')
    
    if (target === 'new') add()
    if (target === 'edit') edit()
    if (target === 'get') get(e.target.dataset.infos)
    if (target === 'delete') remove(e.target.dataset.infos)
}

function add ()
{
    const send = {
        'to': 'adminTeamNew',
        'post': [
            ['email', input.value],
            ['institutionId', select.parentNode.value]
        ]
    }

    FORMULAR.sendDatas(send).then(response => {
        if (response.state !== true) return
        return TEAM.addHTML(response.infos)
    })
}

function get (email)
{
    const send = {
            'to': 'adminInstitutionGet',
            'post': [
                ['email', email]
            ]
        }

    FORMULAR.sendDatas(send).then(response => {
        if (response.state !== true) return
        return TEAM.editHTML(response.infos)
    })
}

function remove (email)
{
    const send = {
            'to': 'adminTeamDelete',
            'post': [
                ['email', email]
            ]
        }

    FORMULAR.sendDatas(send).then(response => {
        if (response.state !== true) return
        return TEAM.delHTML(response.infos)
    })
}

function edit ()
{
    let option = select.querySelector('option:checked'),
        lastOption = select.querySelector('option.new')
        
    const send = {
        'to': 'adminTeamEdit',
        'post': [
            ['email', input.value],
            ['institutionId', select.parentNode.value]
        ]
    }

    FORMULAR.sendDatas(send).then(response => {
        if (response.state !== true) return
        const datas = response.infos
    
        option.remove()
        lastOption.classList.remove('new')
        TEAM.changes()
    })
}