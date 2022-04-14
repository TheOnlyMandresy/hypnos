export function administrator (e)
{
    let main = document.querySelector('main').classList

    if (main.contains('admin-team')) {
        teamClick(e)
        document.querySelector('input[name="email"]').addEventListener('change', teamChange)
    }
}

function teamChange ()
{
    let btn = document.querySelector('button[type="button"]')

    if (btn.classList.contains('btn-success2')) editBtn('attribuer les droits', false)
    if (document.querySelector('option.new')) document.querySelector('option.new').remove()
}

function teamClick (e)
{
    if (e.target.textContent === 'modifier') {
        let datas = e.target.name.split('/'),
            input = document.querySelector('input[name="email"]'),
            select = document.querySelector('select optgroup'),
            btn = document.querySelector('button[type="button"]'),
            option = document.createElement('option')
    
        if (select.querySelector('option.new')) select.querySelector('option.new').remove()
    
        input.value = datas[0]
        option.value = datas[1]
        option.innerHTML = datas[2]
        option.selected = true
        option.classList.add('new')
        editBtn('confirmer modifications', true)
    
        select.appendChild(option)
    }
}

function editBtn (text, editMode)
{
    let btn = document.querySelector('button[type="button"]')

    if (editMode) {
        btn.classList.remove('btn-success')
        btn.classList.add('btn-success2')
    } else {
        btn.classList.add('btn-success')
        btn.classList.remove('btn-success2')
    }

    btn.querySelector('a').innerHTML = text
}