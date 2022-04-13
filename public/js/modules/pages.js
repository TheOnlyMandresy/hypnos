export const routes = {
    '/404': ['/page/index/404', 1],
    '/405': ['/page/index/405', 1],
    '/': ['/page/index', 1],

    '/hotels': ['/page/institutions', 1],
    '/hotel-ID': ['/page/institutions/get-ID', 1], // SEE AN INST

    '/rooms': ['/page/rooms', 1],
    '/room-ID': ['/page/rooms/get-ID', 1], // SEE A ROOM,
    '/rooms-ID': ['/page/rooms/filter-ID', 1], // FILTER BY INST

    '/contact': ['/page/users/contact', 1],
    '/support': ['/page/users/tickets', 3],
    '/ticket-ID': ['/page/users/ticket-ID', 3], // SEE A TICKET

    '/booking': ['/page/users/booking', 1],
    '/reservations': ['/page/users/reserved', 3],
    '/booked-ID': ['/page/users/booked-ID', 3], // SEE RESERVATION DETAIL

    '/login': ['/page/users/login', 2],
    '/register': ['/page/users/register', 2],
    '/logout': ['/datas?logout=true', 3]
}