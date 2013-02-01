MALandBots
==========
Making use of XDCC packlists by integrating them on [MyAnimeList.net](http://myanimelist.net/)


What it does
------------
MALandBots — MyAnimeList and [XDCC] Bots — is a user script (plus a JSONP "proxy") that informs you about available anime episodes by specific sub groups that you haven't yet watched.

You define what series you want to follow, the sub group whose releases you want to have and a url to the packlist of an XDCC bot that offers those releases. From there on MALandBots parsers your *Watching* list, the XDCC packlists you linked to and lets the magic happen.

The script automatically updates every five minutes as long as you have a tab in your browser displaying your anime list. The number of unwatched, available episodes is indicated on the title of the page, so you won't even have to open the tab to check if there's new stuff to watch.


JSONP "proxy"
-------------
The problem with a user script accessing remote resources (the packlists) is, that it's a violation of the [same origin policy](https://en.wikipedia.org/wiki/Same_origin_policy). So your browser won't let the script do it. There are, however, ways to circumvent the SOP. One of them is the use of JSONP, a technique where you embed a script tag in your document whose src attribute points to a resource that prints a JavaScript function call with a bunch of data as its parameter.

Since XDCC packlists are not formatted as JSONP we need someone to pre-process their data. That's our JSON "proxy" — which simply is a PHP script that retrieves the packlists, filters out the relevant information and prints out the JS function call we need.


Setup
-----
1. Place all the files on a webserver accessible from the internet.
    * If you don't have a server, a free webhosting that allows PHP to open sockets (like [Square7](http://www.square7.ch/)) will suffice.
2. In the file MALandBots.user.js, edit the value of `mab_location` to point to your own MALandBots instace.
3. Edit the file entries.json to your likes. 
4. Open the file MALandBots.user.js with your browser to install it as a user script
    * If you're using Firefox you will need an addon like [Greasemonkey](https://addons.mozilla.org/en-US/firefox/addon/greasemonkey/)
5. Done. :3


Known Problems
--------------
The code in mab.js will only work with specific layout settings on MAL. If your number of columns differs from the one the script is written for, it won't work.

For the script to work the column *Anime Title* has to be the first on your list and the column *Progress* has to be the third. If you want to customize the script to fit your MAL layout you have to edit the lines:
`var title = elem.children[0].children[0].children[1].children[1].children[0].innerHTML;`  
`var ep = elem.children[0].children[0].children[3].children[0].children[0].children[0].innerHTML;`


Todo
----
* Automatically detect the position of the title and progress column.
* Provide a JSONP proxy where people can register a handle and manage their entries.txt so that you only have to install the user script and register for the service instead of hosting the proxy on your own.
