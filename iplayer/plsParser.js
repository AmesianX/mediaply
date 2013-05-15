/*
.pls parser for HTML5 - Yirb edition by Deminoth Runo
*/
function loadPls(plsUrl,playerWrapper)
{
	var ajaxReq = new Ajax.Request(plsUrl, { method: 'get', onComplete: showResponse, encoding: 'euc-kr' });
	wrapper = playerWrapper;
}

function showResponse(originalRequest)
{
	var files = parsePls(originalRequest.responseText);
	//make innerHTML
	var tagString = "<object id=\"fmp256\" type=\"application/x-shockwave-flash\" data=\"minicaster.swf\" width=\"180\" height=\"70\" style=\"display: block !important; \"><param name=\"movie\" value=\"minicaster.swf\"><param name=\"wmode\" value=\"window\"><p><audio id=\"audio\" src=\""+files+"\" controls></audio></p></object>"	
	
	$('result').value = tagString
	
	document.getElementById(wrapper).innerHTML = tagString;
}

function parsePls(pls)
{
	//get number of entries
	var matched = pls.match(/NumberOfEntries=\d/);
	matched = matched[0].split("=");
	var numberOfEntries = matched[1];
	
	//get location
	matched = pls.match(/File1=\S+/);
	matched = matched[0].split("=");
	var files = matched[1]
	
	//get title
	matched = pls.match(/Title1=\S+/);
	matched = matched[0].split("=");
	var titles = matched[1]
	 
	return files;
}
	