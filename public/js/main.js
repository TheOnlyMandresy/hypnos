import { route, handleLocation } from './modules/router.js'
import { navbar } from './modules/nav.js'
import { scroll } from './modules/scroll.js'

// when DOM loaded
window.addEventListener('DOMContentLoaded', () => {
    // Router
    window.onpopstate = handleLocation
    window.route = route
    
    handleLocation()

    // System
    const header = document.querySelector('header')
    
    window.addEventListener('scroll', scroll)
    header.addEventListener('click', (e) => { navbar(e) })
})

// When everything loaded
window.addEventListener('load', function loaded() {
    const loader = document.getElementById('loading')

    setTimeout(() => {
        loader.classList.add('fade')

        setTimeout(() => {
            document.querySelector('body').style.overflow = 'initial'
            loader.remove()
        }, 1000)
    }, 1000)
    
    window.removeEventListener('load', loaded)
})

