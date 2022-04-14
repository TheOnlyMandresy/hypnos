import { sendDatas } from '../form.js'

let input = null
let select = null
let btn = null

export function teamClick (e)
{
    let target = e.target.classList

    input = document.querySelector('input[name="email"]')
    select = document.querySelector('select optgroup')
    btn = document.querySelector('button[type="button"]')

    if (target.contains('edit')) edit(e)
    if (target.contains('delete')) remove(e)
}

function edit (e)
{
    let datas = e.target.name.split('/')

    if (select.querySelector('option.new')) select.querySelector('option.new').remove()

    input.value = datas[0]
    const newOption = `
        <option selected class="new" value=${datas[1]}>
        ${datas[2]}
        </option>
    `
    btnState('confirmer modifications', 'adminTeamEdit', true)

    select.innerHTML += newOption
    input.addEventListener('change', teamChange)
}

function remove (e)
{
    let data = e.target.name,
        send = {
        'post': [
            ['email', data]
        ],
        'submit': 'adminTeamDelete'
    }

    sendDatas(send);
}

function teamChange ()
{
    if (btn.classList.contains('btn-success2')) {
        document.querySelector('option.new').remove()
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
