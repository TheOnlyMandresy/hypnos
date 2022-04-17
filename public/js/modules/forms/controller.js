import { userCall } from './public/user.js'
// import { teamClick } from './public/support.js'
// import { teamClick } from './public/reservation.js'
import { adminTeamCall } from './admin/team.js'
import { adminViewsCall } from './admin/views.js'

export function formController (e)
{
    let main = document.querySelector('main'),
        form = main.querySelector('form')

    if (form) {
        let btn = form.querySelector('button[type="button"]')

        form.addEventListener('submit', (e) => {
            e.preventDefault()
        })
        btn.addEventListener('click', (e) => {
            e.preventDefault()
            btn.disabled = true;
        })
    } 


    let call = main.classList

    // Public
    if (call.contains('login') || call.contains('register')) userCall(e)

    // admin
    if (call.contains('admin-team')) adminTeamCall(e)
    if (call.contains('admin-views')) adminViewsCall(e, main.className)
}