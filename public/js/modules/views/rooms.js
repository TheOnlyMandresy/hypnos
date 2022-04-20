import { htmlDecode, shorten } from "../form.js"

let slideTo = 0,
    px = 0,
    autoSlide = true,
    readyToSlide = 0

const timer = 5 // 5 secondes
const interval = setInterval (() => {
    if (readyToSlide <= timer) readyToSlide++
    if (readyToSlide === timer && autoSlide) {
        move()
        readyToSlide = 0
    }
}, 1000)

export function roomController ()
{
    endListeners()
    const main = document.querySelector('main').classList

    if (main.contains('room-one')) caroussel()
    if (main.contains('room-all')) document.querySelector('select').addEventListener('change', filter)
}

function caroussel ()
{
    slideTo = 0
    px = 0

    const caroussel = document.querySelector('.caroussel'),
        left = document.querySelector('.left'),
        right = document.querySelector('.right')

    interval
    caroussel.addEventListener('mouseover', mouseOver)
    caroussel.addEventListener('mouseleave', mouseLeave)
    right.addEventListener('click', move)
    left.addEventListener('click', move)
}

function move (e)
{
    const box = document.querySelector('.images'),
        images = document.querySelectorAll('.images img'),
        left = (e) ? e.target.classList[0] === 'left' : false;

    let limit

    if (!box) return
    px += (left) ? images[slideTo].offsetWidth + 5 : parseInt('-' + images[slideTo].offsetWidth) - 5

    if (left && slideTo === 0) {
        slideTo = 0
        px = 0
        return
    } 

    slideTo += (left) ? -1 : 1;

    (window.screen.width >= 1500) ? limit = 2 : limit = 0;
    if (window.screen.width <= 1500 && window.screen.width >= 1080) limit = 1;
    if (images.length < 4) limit = 0;
    if (slideTo === (images.length - limit)) {
        slideTo = 0
        px = 0
    }
    
    box.style.transform = 'translateX(' +px+ 'px)'
}

async function filter ()
{
    let select = document.querySelector('select[name="institution"]'),
        list = document.querySelector('.list'),
        filter = [],
        rooms = await fetch('/api/rooms?institution=' +select.value).then(res => res.json())

    for (let x = 0; x < Object.keys(rooms.datas).length; x++) {
        const box = `
            <div class="box">
                <img src="/img/rooms/${rooms.datas[x].imgFront}" />
            
                <div class="texts">
                    <h2>${rooms.datas[x].title}</h2>
                    <p class="description">${shorten(htmlDecode(rooms.datas[x].description), 220)}</p>
                    <p>${rooms.datas[x].address}, ${rooms.datas[x].city}</p>
                
                    <div class="buttons">
                        <button class="btn-success">
                            <span><a onclick="route()" href="/room/${rooms.datas[x].id}">
                                en savoir plus
                            </a></span>
                        </button>
                        <button class="btn-success2">
                            <span><a href="${rooms.datas[x].link}" target="_blank">
                                sur tripadvisor
                            </a></span>
                        </button>
                    </div>
                </div>
            </div>
        `
        filter.push(box)
    }

    list.innerHTML = null
    for (let el of filter) {
        list.innerHTML += el
    }
}

function mouseOver ()
{
    autoSlide = false
}

function mouseLeave ()
{ 
    autoSlide = true
    readyToSlide = 0
}

function endListeners ()
{
    const main = document.querySelector('main').classList

    if (main.contains('room-all')) document.querySelector('select').removeEventListener('change', filter)

    if (main.contains('room-one')) {
        document.querySelector('.caroussel').removeEventListener('mouseover', mouseOver)
        document.querySelector('.caroussel').removeEventListener('mouseleave', mouseLeave)
        document.querySelector('.left').removeEventListener('click', move)
        document.querySelector('.right').removeEventListener('click', move)
    }

    if (!main.contains('room-one')) clearInterval(interval)
}