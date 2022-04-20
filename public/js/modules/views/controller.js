import { roomController } from './rooms.js'

export function pageController ()
{
    const main = document.querySelector('main').classList[0]

    if (main.includes('room-')) roomController()
}