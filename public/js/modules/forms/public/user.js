import { sendDatas } from '../../form.js'

export function userCall (e, main)
{
    let target = e.target.name

    if (target === 'login') login()
    if (target === 'register') register()
}

function login ()
{
    let email = document.querySelector('input[type="email"]'),
        password = document.querySelector('input[type="password"]')

    const send = {
        'to': 'login',
        'post': [
            ['email', email.value],
            ['password', password.value]
        ]
    }

    sendDatas(send)
}

function register ()
{
    let firstname = document.querySelector('input[name="firstname"]'),
        lastname = document.querySelector('input[name="lastname"]'),
        email = document.querySelector('input[type="email"]'),
        password1 = document.querySelector('input[name="password1"]'),
        password2 = document.querySelector('input[name="password2"]')

    const send = {
        'to': 'register',
        'post': [
            ['firstname', firstname.value],
            ['lastname', lastname.value],
            ['email', email.value],
            ['password1', password1.value],
            ['password2', password2.value]
        ]
    }

    sendDatas(send)
}