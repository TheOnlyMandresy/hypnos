export function appendInstitution (datas)
{
    let list = document.querySelector('.list')

    const el = `  
        <div id="institution${datas.id}" class="box">
            <h2>${datas.name}</h2>
            
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

    let order = el + list.innerHTML
    list.innerHTML = order
}

export function addBtn ()
{
    let form = document.querySelector('form .buttons')

    const el = `
        <button type="button" name="submit" class="btn-success add">
            <span><a name="new">ou ajouter</a></span>
        </button>
    `

    if (!document.querySelector('button.add')) form.innerHTML += el
}