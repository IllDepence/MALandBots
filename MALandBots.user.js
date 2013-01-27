// ==UserScript==

// @name          MALandBots

// @namespace     MALandBots

// @description   Notifies on newly released episodes based on XDCC-Bot-Packlists

// @include       *myanimelist.net/animelist/*

// ==/UserScript==

var mab_location = 'https://46.223.55.110:3739/srv/malandbots/';
localStorage.setItem('mab_location', mab_location);
var url = mab_location + 'mab.js';
var headID = document.getElementsByTagName("head")[0];
var newScript = document.createElement('script');
newScript.type = 'text/javascript';
newScript.src = url;
headID.appendChild(newScript);
