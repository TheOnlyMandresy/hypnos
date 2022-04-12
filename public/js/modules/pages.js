export const routes = {
    '/404': '/page/index/404',
    '/405': '/page/index/405',
    '/': '/page/index',

    '/hotels': '/page/institutions',
    '/hotel-ID': '/page/institutions/get-ID', // SEE AN INST

    '/rooms': '/page/rooms',
    '/room-ID': '/page/rooms/get-ID', // SEE A ROOM,
    '/rooms-ID': '/page/rooms/filter-ID', // FILTER BY INST

    '/contact': '/page/users/contact',
    '/support': '/page/users/tickets',
    '/ticket-ID': '/page/users/ticket-ID', // SEE A TICKET

    '/booking': '/page/users/booking',
    '/reservations': '/page/users/reserved',
    '/booked-ID': '/page/users/booked-ID', // SEE RESERVATION DETAIL

    '/login': '/page/users/login',
    '/register': '/page/users/register',
    '/logout': '/datas?logout=true'
}