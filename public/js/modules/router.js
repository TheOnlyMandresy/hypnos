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
        route = routes[filterLink(path)] || routes[404],
        page = await fetch(dynamicLoad(route, path)).then((data) => data.text()),
        html = page.replace(jsonConverter(page, true), '');

    updateHead(page)
    document.getElementById('root').innerHTML = html
}

// Pages
const routes = {
    404: '/page/index/404',
    405: '/page/index/405',
    '/': '/page/index',

    '/institutions': '/page/institutions',
    '/institution/ID': '/page/institutions/get-ID', // SEE AN INST

    '/rooms': '/page/rooms',
    '/room/ID': '/page/rooms/get-ID', // SEE A ROOM,
    '/rooms/ID': '/page/rooms/filter-ID', // FILTER BY INST

    '/contact': '/page/users/contact',
    '/support': '/page/users/tickets',
    '/ticket/ID': '/page/users/ticket-ID', // SEE A TICKET

    '/booking': '/page/users/booking',
    '/reservations': '/page/users/reserved',
    '/booked/ID': '/page/users/booked-ID', // SEE RESERVATION DETAIL

    '/login': '/page/users/login',
    '/register': '/page/users/register'
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

function filterLink (path)
{
    let arr = path.split('/'),
        id = parseInt(arr.pop())

    if (Number.isInteger(id)) {
        arr.shift()
        return '/' + arr[0] + '/ID'
    }
    
    return path
}

// Get special links
function dynamicLoad (route, path)
{
    console.log(route)
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