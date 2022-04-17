export function appendMember (datas)
{
    let list = document.querySelector('.container > .team')
        
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