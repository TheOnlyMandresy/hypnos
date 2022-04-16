import { sendDatas } from '../form.js'

export function viewsClick (e)
{
    let target = e.target.classList

    if (target.contains('edit')) edit(e.target.name)
    if (target.contains('delete')) remove(e.target.name)
}

function edit (id)
{
    let send = {
            'to': 'adminInstitutionGet',
            'post': [
                ['id', id]
            ]
        }

    sendDatas(send).then(response => {
        if (response.state !== true) return
        const datas = response.infos

        let name = document.querySelector('input[name="name"]'),
            city = document.querySelector('input[name="city"]'),
            address = document.querySelector('input[name="address"]'),
            description = document.querySelector('textarea[name="description"]'),
            entertainment = document.querySelector('input[name="entertainment"]')

        name.value = datas.name;
        city.value = datas.city;
        address.value = datas.address;
        description.value = datas.description;
        entertainment.value = datas.entertainment;
    })
}

function remove (id)
{
    let send = {
            'to': 'adminInstitutionDel',
            'post': [
                ['id', id]
            ]
        }
    
    sendDatas(send).then(response => {
        if (response.state !== true) return

        const datas = response.infos
        let box = document.querySelector('#institution' +id)
        
        if (datas === true) box.remove();
    })   
}