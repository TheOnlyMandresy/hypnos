import { administrator } from './admin.js'

export const routes = {
    '/404': '/page/index/404',
    '/405': '/page/index/405',
    '/': '/page/index',

    '/hotels': '/page/institutions',
    '/hotel-ID': '/page/institutions/get-ID',

    '/rooms': '/page/rooms',
    '/room-ID': '/page/rooms/get-ID',
    '/rooms-ID': '/page/rooms/filter-ID',

    '/contact': '/page/users/contact',
    '/support': '/page/users/tickets',
    '/ticket-ID': '/page/users/ticket-ID',

    '/booking': '/page/users/booking',
    '/reservations': '/page/users/reserved',
    '/booked-ID': '/page/users/booked-ID',

    '/login': '/page/users/login',
    '/register': '/page/users/register',
    '/logout': '/datas?logout=true',

    '/admin/team': '/page/admin/team',             // Team
    '/admin/views': '/page/admin/views',           // Hotels, Rooms, Reservations
    '/admin/support': '/page/admin/support',       // Tickets
    '/admin/ticket-ID': '/page/admin/ticket-ID',
    '/admin/user': '/page/admin/team',  
}

export function admin (path)
{
    let isAdmin = path.split('/')[1] === 'admin',
        body = document.querySelector('body')

        if (isAdmin) body.classList.add('mode-admin')
        if (!isAdmin) body.classList.remove('mode-admin')

        if (isAdmin) body.addEventListener('click', (e) => { administrator(e) })
}