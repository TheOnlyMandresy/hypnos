import { route, handleLocation } from './modules/router.js'
import { navbar } from './modules/nav.js'
import { scroll } from './modules/scroll.js'

// Router
window.onpopstate = handleLocation
window.route = route

handleLocation()


// System
const header = document.querySelector('header')

window.addEventListener('scroll', scroll)
header.addEventListener('click', (e) => { navbar(e) })