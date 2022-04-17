import * as FORMULAR from '../../form.js'
import * as VIEWS from '../../views/admin/VIEWS.js'

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
        if (target === 'new') roomNew()
        if (target === 'edit') roomEdit(e.target.dataset.infos)
        if (target === 'get') roomGet(e.target.dataset.infos)
        if (target === 'delete') roomRemove(e.target.dataset.infos)
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

    FORMULAR.sendDatas(send).then(response => {
        if (response.state !== true) return
        const datas = response.infos

        VIEWS.appendInstitution(datas)
        FORMULAR.btnState('ajouter l\institution', 'new', false)
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

    FORMULAR.sendDatas(send).then(response => {
        if (response.state !== true) return

        let institutionId = '#institution' + id
        document.querySelector(institutionId + ' h2').innerHTML = FORMULAR.htmlDecode(send.post[1][1])
        document.querySelector('form .buttons .add').remove()
        FORMULAR.btnState('ajouter l\institution', 'new', false)
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

    FORMULAR.sendDatas(send).then(response => {
        if (response.state !== true) return
        const datas = response.infos

        let name = document.querySelector('input[name="name"]'),
            city = document.querySelector('input[name="city"]'),
            address = document.querySelector('input[name="address"]'),
            description = document.querySelector('textarea[name="description"]'),
            entertainment = document.querySelector('input[name="entertainment"]'),
            btn = document.querySelector('form button a')

        name.value = FORMULAR.htmlDecode(datas.name)
        city.value = FORMULAR.htmlDecode(datas.city)
        address.value = FORMULAR.htmlDecode(datas.address)
        description.value = FORMULAR.htmlDecode(datas.description)
        entertainment.value = FORMULAR.htmlDecode(datas.entertainment)

        FORMULAR.btnState('confirmer modifications', 'edit', true)
        btn.dataset.infos = FORMULAR.htmlDecode(datas.id)
        VIEWS.addBtn()
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
    
    FORMULAR.sendDatas(send).then(response => {
        if (response.state !== true) return

        const datas = response.infos
        let box = document.querySelector('#institution' +id)
        box.remove();
        
        let isAddBtn = document.querySelector('form .buttons .add')
        if (isAddBtn) isAddBtn.remove()
        FORMULAR.btnState('ajouter l\institution', 'new', false)
    })   
}

function roomNew ()
{
    let title = document.querySelector('input[name="title"]'),
        institutionId = document.querySelector('select'),
        imgFront = document.querySelector('input[name="image"]'),
        description = document.querySelector('textarea'),
        price = document.querySelector('input[name="price"]'),
        images = document.querySelector('input[name="image[]"]'),
        link = document.querySelector('input[name="link"]')
        
    const send = {
        'to': 'adminRoomNew',
        'post': [
            ['title', title.value],
            ['institutionId', institutionId.value],
            ['imgFront', imgFront.files],
            ['description', description.value],
            ['price', price.value],
            ['images', images.files],
            ['link', link.value]
        ]
    }

    FORMULAR.sendDatas(send)
}