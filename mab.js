function seriesNrs(title, haystack) {
	var length = haystack.length;
	for(var i = 0; i < length; i++) {
		//console.log(haystack[i].mal_title + ' == ' + title + ' >' + (haystack[i].mal_title == title) + '<');
		if(haystack[i].mal_title == title) {
			console.log('match: ' + title);
			return Array(haystack[i].ep, haystack[i].nr);
			}
		}
	return -1;
}

function getJSONP(oldID) {
	if(oldID > -1) {
		var oldTag = document.getElementById('mab_' + oldID);
		oldTag.parentNode.removeChild(oldTag);
		}
	var newID = oldID+1;
	var url = localStorage.getItem('mab_location') + 'jsonp.php';
	var headID = document.getElementsByTagName("head")[0];
	var newScript = document.createElement('script');
	newScript.type = 'text/javascript';
	newScript.src = url;
	newScript.id = 'mab_' + newID;
	headID.appendChild(newScript);
	t=setTimeout('getJSONP(' + newID + ')', 300000);
}

function processJSONP(seriesArr) {
	var listDiv = document.getElementById('list_surround');
	var unseen = 0;
	for(i=6;; i++) {
		var elem = listDiv.children[i];
		if(elem.tagName == 'DIV') continue;
		if(elem.tagName == 'BR') break;
		try {
			var title = elem.children[0].children[0].children[1].children[1].children[0].innerHTML;
			}
		catch(err) {
			continue;
			}
		var ep = elem.children[0].children[0].children[3].children[0].children[0].children[0].innerHTML;
		var snrs= seriesNrs(title, seriesArr);
		var epnr = snrs[0];
		var pkgnr = snrs[1];
		if(epnr > -1) {
			console.log(title + ', ep on mal: ' + ep + ', ep on packlist: ' + epnr);
			var note = elem.children[0].children[0].children[1].children[2];
			if(typeof(note) == 'undefined') {
				var note = document.createElement('small');
				elem.children[0].children[0].children[1].appendChild(note);
				}
			if(parseInt(ep) < parseInt(epnr)) {
				var patt = /^Airing/;
				note.innerHTML = (patt.test(note.innerHTML) ? 'Airing' : '') +
					' <span style="font-weight:bold;color:#ff0000;" onMouseOver="this.style.cursor=\'pointer\'"' + 
					((epnr-ep)>1 ? 'onClick="window.location=\'' + localStorage.getItem('mab_location') + '\'"' : 'onClick="alert(\'' + pkgnr + '\')"') + '>' +
					'New Episode' + ((epnr-ep)>1 ? 's ('+(epnr-ep)+')' : '') + '</span>';
				unseen += (epnr-ep);
				}
			else {
				s = ' <span style="color: #999999;">(' + epnr + ')</span>';
				note.innerHTML = note.innerHTML.replace(/<span.*?New Episode.*?<\/span> ?/, '') + (note.innerHTML.substring(note.innerHTML.length-s.length) == s ?  '' : s);
				}
			}
		}
	document.title = (unseen > 0 ? '(' + unseen + ') ' : '') + 'MALandBots running';
	}

getJSONP(-1);
