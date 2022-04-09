export const route = (event) => {
    event = event || window.event
    event.preventDefault()
    if (event.target.href === undefined) event.target.href = '/'
    window.history.pushState({}, "", event.target.href)
    handleLocation()
}

export const handleLocation = async () => {
    let path = window.location.pathname,
        route = routes[path] || routes[404],
        page = await fetch(route).then((data) => data.text()),
        html = page.slice(jsonConverter(page, true));

    updateHead(page)
    document.getElementById('root').innerHTML = html
}

// Pages
const routes = {
    404: '/page/404',
    '/': '/page/index',
    '/institutions': '/page/institutions',
    '/rooms': '/page/rooms'
}

// Convert to JSON or get length of JSON (to delete before initializing the html)
function jsonConverter (page, length = false)
{
    let jsonStart = '{"jsonHead":',
        jsonEnd = '}',
        json = page.substring(
            page.indexOf(jsonStart) + jsonStart.length, 
            page.lastIndexOf(jsonEnd)
        )
    
    if (length) return json.length + jsonStart.length + jsonEnd.length
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