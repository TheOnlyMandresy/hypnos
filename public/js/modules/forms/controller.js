import { userCall } from './public/user.js'
import { supportCall } from './public/support.js'
import { bookCall } from './public/reservation.js'
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


    let call = main.classList[0]

    // Public
    if (call === 'login' || call === 'register') userCall(e)
    if (call.includes('book-')) bookCall(e);
    if (call.includes('contact-')) supportCall(e);

    // admin
    if (call === 'admin-team') adminTeamCall(e)
    if (call === 'admin-views') adminViewsCall(e, main.className)
    if (call === 'admin-support') supportCall(e);
}