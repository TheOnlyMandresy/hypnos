let header = document.querySelector('header'),
    navBtn = document.querySelector('.logo .img')

export function navbar (e)
{
    let isOpen = header.classList.contains('open'),
        tag = e.target.tagName,
        cl = e.target.classList

    if (cl.contains('img') || tag === 'IMG' || tag === 'A') {
        if (isOpen) {
            header.classList.remove('open')
            header.style.animation="closeNavbar .5s ease-out forwards"
            navBtn.style.animation="effacerNavbarOff .5s ease-out forwards"
        }

        if (!isOpen) {
            header.classList.add('open')
            header.style.animation="openNavbar .5s ease-in-out forwards"
            navBtn.style.animation="effacerNavbarOn .5s ease-in-out forwards"
        }
    }
}

export function reloadApp ()
{
    let html = document.createElement('div'),
        img = document.createElement('img'),
        body = document.querySelector('body')

    html.id = 'loading'
    html.classList.add('loading')
    img.src = '/img/logo.png'
    html.appendChild(img)

    setTimeout(() => {
        body.style.overflow = 'hidden'
        body.appendChild(html)
        history.back()
        setTimeout( () => { location.reload() }, 500)
    }, 500)
}