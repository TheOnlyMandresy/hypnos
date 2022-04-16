import { teamClick } from './admin/team.js'
import { viewsClick } from './admin/views.js'
import { adminMain } from '../modules/pages.js'

export function administrator (e)
{
    let btn = document.querySelector('form button[type="button"]'),
        form = document.querySelector('form'),
        main = adminMain.classList

    form.addEventListener('submit', function form(e) {
        e.preventDefault()
    })
    btn.addEventListener('click', function form(e) {
        e.preventDefault()
        btn.disabled = true;
    })

    if (main.contains('admin-team')) teamClick(e)
    if (main.contains('admin-views')) viewsClick(e)
}