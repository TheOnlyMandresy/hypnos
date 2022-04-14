import { routes, admin } from './pages.js'
import { checkForm } from './form.js'
import { reloadApp } from './nav.js'

// Getting link
export const route = (event) => {
    event = event || window.event
    event.preventDefault()
    if (event.target.href === undefined) event.target.href = '/'
    window.history.pushState({}, "", event.target.href)
    handleLocation()
}

// Loader
export const handleLocation = async () => {
    let path = window.location.pathname,
        route = routes[filterLink(path)] || routes['/404'],
        page = await fetch(dynamicLoad(route, path)).then((data) => data.text())

    if (parseInt(page) === -1) history.back()
    if (parseInt(page) === 405) return window.location.href = '/405'
    if (parseInt(page) === 404) return window.location.href = '/404'

    let html = page.replace(jsonConverter(page, true), '')

    if (path === '/logout') return window.location.href = '/'

    admin(path)
    changeContentSize(path)
    updateHead(page)
    document.getElementById('root').innerHTML = html
    checkForm ()
}

// Convert to JSON or remove JSON (to delete before initializing the html)
function jsonConverter (page, remove = false)
{
    let sub = (remove)? 0 : 1,
        jsonStart = '{"jsonHead":',
        jsonEnd = '}}',
        json = page.substring(
            page.indexOf(jsonStart) + jsonStart.length, 
            page.lastIndexOf(jsonEnd) + sub
        )
    
    if (remove) return jsonStart + json + jsonEnd
    return json
}

// Update Head
function updateHead (page)
{
    let json = JSON.parse(jsonConverter(page)),
        keys = Object.keys(json),
        head = document.querySelector('head'),
        title = head.querySelector('title')

    for (let i = 0; i < keys.length; i++) {
        if (keys[i] === 'title') continue
        let obj = json[keys[i]]
        
        Object.keys(obj).forEach(key => {
            let meta = head.querySelector('[' + keys[i] + '="' + key + '"]')
            
            meta.content = obj[key]
        })
    }

    title.textContent = json.title
}

// Dynamic links
function filterLink (path)
{
    let arr = path.split('/'),
        id = parseInt(arr.pop()),
        parse = ['/404', '/405']

    if (parse.includes(path)) return path

    if (Number.isInteger(id)) {
        arr.shift()
        return '/' + arr[0] + '-ID'
    }
    
    return path
}

// Get special links
function dynamicLoad (route, path)
{
    if (route.includes('-ID')) {
        let id = path.split('/'),
            url = route.split('-')

        id = id.pop()
        url.pop()

        url = url.toString() + '/' + id

        return url
    }

    return route
}

// Change principal content's size
function changeContentSize (path)
{
    let content = document.querySelector('#root').classList

    window.scrollTo({top: 0, behavior: 'smooth'})
    if (path === '/') return content.remove('large')
    content.add('large')
}