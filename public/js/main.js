import { navbar } from './modules/nav.js'
import { route, handleLocation } from './modules/router.js'

// Router
window.onpopstate = handleLocation
window.route = route

handleLocation()


// System
const navBtn = document.querySelector('.logo .img')

navBtn.addEventListener('click', navbar)
