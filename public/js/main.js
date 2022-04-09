import { route, handleLocation } from './modules/router.js'
import { navbar } from './modules/nav.js'

// Router
window.onpopstate = handleLocation
window.route = route

handleLocation()


// System
const header = document.querySelector('header')

header.addEventListener('click', (e) => {navbar(e)})