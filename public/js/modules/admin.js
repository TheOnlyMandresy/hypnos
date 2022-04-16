import { teamClick } from './admin/team.js'
import { viewsClick } from './admin/views.js'

export function administrator (e)
{
    let main = document.querySelector('main').classList

    if (main.contains('admin-team')) teamClick(e)
    if (main.contains('admin-views')) viewsClick(e)
}