let header = document.querySelector('header'),
navBtn = document.querySelector('.logo .img')

export function navbar ()
{
    let isOpen = header.classList.contains('open')
    
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