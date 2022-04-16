import { sendDatas, globalData } from '../form.js'

export function viewsClick (e)
{
    let target = e.target.classList

    if (target.contains('edit')) edit(e.target.name)
    if (target.contains('delete')) remove(e.target.name)
}

async function edit (id)
{
    let session = 'adminInstitutionGet',
        send = {
            'post': [
                ['id', id]
            ],
            'submit': session
        }

    await fetch(sendDatas(send))
    
    const datas = globalData
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
}

async function remove (id)
{
    let session = 'adminInstitutionDel',
        send = {
            'post': [
                ['id', id]
            ],
            'submit': session
        }

    await fetch(sendDatas(send))
    
    const datas = globalData
    let box = document.querySelector('#institution' +id)
    
    if (datas === true) box.remove();
}