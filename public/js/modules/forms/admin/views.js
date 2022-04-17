import * as formular from '../../form.js'
import * as views from '../../views/admin/views.js'

export function adminViewsCall (e, main)
{
    let target = e.target.name

    if (main.includes('admin-institutions')) {
        if (target === 'new') institutionNew()
        if (target === 'edit') institutionEdit(e.target.dataset.infos)
        if (target === 'get') institutionGet(e.target.dataset.infos)
        if (target === 'delete') institutionRemove(e.target.dataset.infos)
    }

    if (main.includes('admin-rooms')) {
        
    }

    if (main.includes('admin-reservations')) {
        
    }
}

function institutionNew ()
{
    let name = document.querySelector('input[name="name"]'),
        city = document.querySelector('input[name="city"]'),
        address = document.querySelector('input[name="address"]'),
        description = document.querySelector('textarea'),
        entertainment = document.querySelector('input[name="entertainment"]'),
        isAddBtn = document.querySelector('form .buttons .add')

    if (isAddBtn) isAddBtn.remove()
        
    const send = {
        'to': 'adminInstitutionNew',
        'post': [
            ['name', name.value],
            ['city', city.value],
            ['address', address.value],
            ['description', description.value],
            ['entertainment', entertainment.value],
        ]
    }

    formular.sendDatas(send).then(response => {
        if (response.state !== true) return
        const datas = response.infos

        views.appendInstitution(datas)
        formular.btnState('ajouter l\institution', 'new', false)
    })
}

function institutionEdit (id)
{
    let name = document.querySelector('input[name="name"]'),
        city = document.querySelector('input[name="city"]'),
        address = document.querySelector('input[name="address"]'),
        description = document.querySelector('textarea'),
        entertainment = document.querySelector('input[name="entertainment"]')

        console.log(name)
        
    const send = {
        'to': 'adminInstitutionEdit',
        'post': [
            ['id', id],
            ['name', name.value],
            ['city', city.value],
            ['address', address.value],
            ['description', description.value],
            ['entertainment', entertainment.value],
        ]
    }

    formular.sendDatas(send).then(response => {
        if (response.state !== true) return

        let institutionId = '#institution' + id
        document.querySelector(institutionId + ' h2').innerHTML = formular.htmlDecode(send.post[1][1])
        document.querySelector('form .buttons .add').remove()
        formular.btnState('ajouter l\institution', 'new', false)
    })
}

function institutionGet (id)
{
    const send = {
        'to': 'adminInstitutionGet',
        'post': [
            ['id', id]
        ]
    }

    formular.sendDatas(send).then(response => {
        if (response.state !== true) return
        const datas = response.infos

        let name = document.querySelector('input[name="name"]'),
            city = document.querySelector('input[name="city"]'),
            address = document.querySelector('input[name="address"]'),
            description = document.querySelector('textarea[name="description"]'),
            entertainment = document.querySelector('input[name="entertainment"]'),
            btn = document.querySelector('form button a')

        name.value = formular.htmlDecode(datas.name)
        city.value = formular.htmlDecode(datas.city)
        address.value = formular.htmlDecode(datas.address)
        description.value = formular.htmlDecode(datas.description)
        entertainment.value = formular.htmlDecode(datas.entertainment)

        formular.btnState('confirmer modifications', 'edit', true)
        btn.dataset.infos = formular.htmlDecode(datas.id)
        views.addBtn()
    })
}

function institutionRemove (id)
{
    const send = {
        'to': 'adminInstitutionDel',
        'post': [
            ['id', id]
        ]
    }
    
    formular.sendDatas(send).then(response => {
        if (response.state !== true) return

        const datas = response.infos
        let box = document.querySelector('#institution' +id)
        box.remove();
        
        let isAddBtn = document.querySelector('form .buttons .add')
        if (isAddBtn) isAddBtn.remove()
        formular.btnState('ajouter l\institution', 'new', false)
    })   
}