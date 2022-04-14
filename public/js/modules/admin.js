import { teamClick } from './admin/team.js'

export function administrator (e)
{
    let main = document.querySelector('main').classList

    if (main.contains('admin-team')) teamClick(e)
}