import * as FORMULAR from '../../form.js'

export function addHTML (datas)
{
    let list = document.querySelector('.container > .team'),
        select = document.querySelector('select optgroup')
        
    const el = `
        <div id="member${datas.userId}" class="box">
            <p class="name">${datas.name}</p>
            <p class="email">${datas.email}</p>
            
            <div class="buttons">
                <button class="btn-success">
                    <span><a name="get" data-infos="${datas.email}" >modifier</a></span>
                </button>
                <button class="btn-danger">
                    <span><a name="delete" data-infos="${datas.email}">ou retirer</a></span>
                </button>
            </div>
        </div>
    `
    
    let order = el + list.innerHTML
    list.innerHTML = order

    select.querySelector('option[value="' +datas.iId+ '"]').remove()
}

export function editHTML (datas)
{
    let input = document.querySelector('input[name="email"]'),
        select = document.querySelector('select optgroup')

    if (select.querySelector('option.new')) select.querySelector('option.new').remove()

    input.value = FORMULAR.htmlDecode(datas.userEmail)
    const el = `
        <option selected class="new" value=${FORMULAR.htmlDecode(datas.id)}>
        ${FORMULAR.htmlDecode(datas.name)}
        </option>
    `
    FORMULAR.btnState('confirmer modifications', 'edit', true)

    select.innerHTML += el
    input.addEventListener('input', changes)
}

export function delHTML (datas)
{
    let box = document.querySelector('#member' +datas.userId),
        select = document.querySelector('select optgroup')
        
    changes()
    const el = `
        <option value=${datas.iId}>
        ${datas.iName}
        </option>
    `
    select.innerHTML += el

    box.remove();
}

export function changes ()
{
    let select = document.querySelector('select optgroup')
    
    if (select.querySelector('option.new')) select.querySelector('option.new').remove()
    FORMULAR.btnState('attribuer les droits', 'new', false)
    input.removeEventListener('change', teamChange)
}