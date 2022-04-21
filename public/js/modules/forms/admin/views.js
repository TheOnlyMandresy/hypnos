import * as FORMULAR from '../../form.js'
import * as VIEWS from '../../views/admin/views.js'

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
        if (target === 'deleteImg') roomRemoveImg(e.target.dataset.infos, e.target.dataset.id)
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
        ],
        'institutionName': institutionId.querySelector('[value="' +institutionId.value+ '"]').text
    }

    FORMULAR.sendDatas(send).then(res => {
        if (res.state !== true) return
        const datas = res.infos

        const box = `
            <div id="room${datas.id}" class="box">
                <h2>${send.post[0][1]}</h2>
                <p>${send.institutionName}</p>
                
                <div class="buttons">
                    <button class="btn-success">
                        <span><a name="get" data-infos="${datas.id}" >modifier</a></span>
                    </button>
                    <button class="btn-danger">
                        <span><a name="delete" data-infos="${datas.id}">ou retirer</a></span>
                    </button>
                </div>
            </div>
        `

        let list = document.querySelector('.list'),
            order = box + list.innerHTML
        
        list.innerHTML = order
    })
}

function roomRemove (id)
{
    const send = {
        'to': 'adminRoomDel',
        'post': [
            ['id', id]
        ]
    }
    
    FORMULAR.sendDatas(send).then(res => {
        if (res.state !== true) return

        id = 'room' +id
        document.getElementById(id).remove()
    })
}

function roomEdit (id)
{
    let title = document.querySelector('input[name="title"]'),
        imgFront = document.querySelector('input[name="image"]'),
        description = document.querySelector('textarea'),
        price = document.querySelector('input[name="price"]'),
        images = document.querySelector('input[name="image[]"]'),
        link = document.querySelector('input[name="link"]')
        
    const send = {
        'to': 'adminRoomEdit',
        'post': [
            ['id', id],
            ['title', title.value],
            ['imgFront', imgFront.files],
            ['description', description.value],
            ['price', price.value],
            ['images', images.files],
            ['link', link.value]
        ]
    }

    FORMULAR.sendDatas(send)
}

function roomGet (id)
{
    const send = {
        'to': 'adminRoomGet',
        'post': [
            ['id', id]
        ]
    }

    FORMULAR.sendDatas(send).then(response => {
        if (response.state !== true) return
        const datas = response.infos

        let title = document.querySelector('input[name="title"]'),
            price = document.querySelector('input[name="price"]'),
            description = document.querySelector('textarea[name="description"]'),
            link = document.querySelector('input[name="link"]'),
            btn = document.querySelector('form button a')

        let boxImages = document.querySelector('form .images'),
            select = document.querySelector('select')
        if (boxImages) boxImages.remove()
        if (select) select.remove()
            
        title.value = FORMULAR.htmlDecode(datas.title)
        price.value = FORMULAR.htmlDecode(datas.price)
        description.value = FORMULAR.htmlDecode(datas.description)
        link.value = FORMULAR.htmlDecode(datas.link)

        let images = datas.images.split(','),
            box = document.createElement('div'),
            list = []

        for (let x = 0; x < images.length; x++) {
            const img = `
                <div id="${images[x]}" class="box">
                    <img src="/img/rooms/${images[x]}" />
                    <a class="delete" name="deleteImg" data-infos="${images[x]}" data-id="${id}">supprimer</a>
                </div>
            `
            list.push(img)
        }

        box.classList.add('images')
        for (let el of list) box.innerHTML += el
        document.querySelectorAll('form .img')[1].after(box)

        FORMULAR.btnState('confirmer modifications', 'edit', true)
        btn.dataset.infos = FORMULAR.htmlDecode(datas.id)
        // VIEWS.addBtn()
    })
}

function roomRemoveImg (name, id)
{
    const send = {
        'to': 'adminRoomRemoveImg',
        'post': [
            ['img', name],
            ['id', id]
        ]
    }

    FORMULAR.sendDatas(send).then(res => {
        if (res.state !== true) return
        document.getElementById(name).remove()
    })
}