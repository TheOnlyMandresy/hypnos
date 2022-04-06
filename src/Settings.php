<?php

namespace System;

class Settings
{
    // Database
    protected const DB_NAME = 'hypnos';
    protected const DB_HOST = 'localhost';
    protected const DB_USER = 'root';
    protected const DB_PASS = '';

    // Website
    protected const WEBSITE = 'Hypnos';
    protected const CATCHWORD = 'Groupe Hôtelier';
        // About Website
    protected const CMS_VERSION = 'v1';
    protected const CMS_AUTHOR = 'Mandresy';
    protected const CMS_AUTHOR_URL = 'https://www.instagram.com/monsieur.rvy/';

    // URLS
    protected const URL_HOTEL = '/hotel';
    protected const URL_ROOM = '/room';
        // IMAGES
    protected const IMG_HOTEL = '/img/hotels';
    protected const IMG_ROOM = '/rooms';
}