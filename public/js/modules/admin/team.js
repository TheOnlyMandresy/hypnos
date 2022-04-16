import { sendDatas, globalData } from '../form.js'

let input, select, btn

export function teamClick (e)
{
    let target = e.target.classList

    input = document.querySelector('input[name="email"]')
    select = document.querySelector('select optgroup')
    btn = document.querySelector('button[type="button"]')
    
    if (e.target.parentNode.parentNode.value === 'adminTeamNew') add()
    if (e.target.parentNode.parentNode.value === 'adminTeamEdit') edit()
    if (target.contains('edit')) getEdit(e.target.name)
    if (target.contains('delete')) remove(e.target.name)
}

async function add ()
{
    let session = 'adminTeamNew',
        list = document.querySelector('.container > .team'),
        send = {
            'post': [
                ['email', input.value],
                ['institutionId', select.parentNode.value]
            ],
            'submit': session
        }

    await fetch(sendDatas(send))
    const datas = globalData

    const newOption = `
        <div id="member${datas.userId}" class="box">
            <p class="name">${datas.name}</p>
            <p class="email">${datas.email}</p>
            
            <div class="buttons">
                <button class="btn-success">
                    <span><a class="edit" name="${datas.email}" >modifier</a></span>
                </button>
                <button class="btn-danger">
                    <span><a class="delete" name="${datas.email}">ou retirer</a></span>
                </button>
            </div>
        </div>
    `
    list.innerHTML += newOption

    input.value = ''
    select.querySelector('option[value="' +datas.iId+ '"]').remove()
}

async function getEdit (email)
{
    let session = 'adminInstitutionGet',
        send = {
            'post': [
                ['email', email]
            ],
            'submit': session
        }

    await fetch(sendDatas(send))
    const datas = globalData
    if (select.querySelector('option.new')) select.querySelector('option.new').remove()

    input.value = datas.userEmail
    const newOption = `
        <option selected class="new" value=${datas.id}>
        ${datas.name}
        </option>
    `
    btnState('confirmer modifications', 'adminTeamEdit', true)

    select.innerHTML += newOption
    input.addEventListener('change', teamChange)
}

async function remove (email)
{
    let session = 'adminTeamDelete',
        send = {
            'post': [
                ['email', email]
            ],
            'submit': session
        }

    await fetch(sendDatas(send))
    const datas = globalData
    let box = document.querySelector('#member' +datas.userId)
    
    teamChange()
    const newOption = `
        <option value=${datas.iId}>
        ${datas.iName}
        </option>
    `
    select.innerHTML += newOption

    box.remove();
}

async function edit ()
{
    let session = 'adminTeamEdit',
        option = select.querySelector('option:checked'),
        lastOption = select.querySelector('option.new'),
        send = {
            'post': [
                ['email', input.value],
                ['institutionId', select.parentNode.value]
            ],
            'submit': session
        }

    await fetch(sendDatas(send))

    input.value = ''
    option.remove()
    lastOption.classList.remove('new')
    teamChange()
}

function teamChange ()
{
    if (btn.value === 'adminTeamEdit') {
        if (select.querySelector('option.new')) select.querySelector('option.new').remove()
        btnState('attribuer les droits', 'adminTeamNew', false)
        input.removeEventListener('change', teamChange)
    } 
}

function btnState (text, value, editMode)
{
    if (editMode) {
        btn.classList.remove('btn-success')
        btn.classList.add('btn-success2')
    } else {
        btn.classList.add('btn-success')
        btn.classList.remove('btn-success2')
    }

    btn.value = value
    btn.querySelector('a').innerHTML = text
}
