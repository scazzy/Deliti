// JavaScript Document

//handling popups
		function popbox_show(pb)
		{
			var pBox=document.getElementById(pb);
			pBox.style.display="block";
			var top=(screen.availHeight-pBox.offsetHeight)/2-100;
			var left=(screen.availWidth-pBox.offsetWidth)/2;

			pBox.style.left=left+"px";
			pBox.style.top=top+"px";
			pBox.style.position="absolute";
			document.getElementById(pb).style.display="block";
			pBox.style.display="block";
			pBox.style.zIndex="5000";
			pBox.focus();

		}
		function popbox_close(pb)
		{
			var pBox=document.getElementById(pb);
			pBox.style.zIndex="-1";
			pBox.style.display="none";
		}
		


function toggle_showHide(e)
{
	if(document.getElementById(e).style.display=="none")
		{
			document.getElementById(e).style.display="block";
			document.getElementById(this).alt="Hide";
		}
	else
	{
		document.getElementById(e).style.display="none";
		document.getElementById(this).alt="Show";
	}
}
function toggle_showHide(e,d)
{
	if(document.getElementById(e).style.display=="none")
		{
			document.getElementById(e).style.display="block";
			document.getElementById(d).style.display="none";
			document.getElementById(this).alt="Hide";
		}
	else
	{
		document.getElementById(e).style.display="none";
		document.getElementById(d).style.display="block";
		document.getElementById(this).alt="Show";
	}
}


// Removes leading whitespaces
function LTrim( value ) {
	
	var re = /\s*((\S+\s*)*)/;
	return value.replace(re, "$1");
	
}

// Removes ending whitespaces
function RTrim( value ) {
	
	var re = /((\s*\S+)*)\s*/;
	return value.replace(re, "$1");
	
}

// Removes leading and ending whitespaces
function trim( value ) {
	
	return LTrim(RTrim(value));
	
}

//Anti Spamming
var spamCode="antispa";
function randomString() {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZ";
	var string_length = 6;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
//	document.randform.randomfield.value = randomstring;
}

//print the random code on refresh
function refreshAntiSpamCode(divname) {
	spamCode=randomString();
	document.getElementById(divname).innerHTML=spamCode;
}


//replace character in string
function replaceChar(text,char,byChar)
{
	
	for(var i=0;i<text.length;i++)
	{
		text=text.replace(char,byChar);
	}
	return text;
}
var erremails="";
function check_emails(email_list) {
	var myString = document.getElementById(email_list);
	myString.value=replaceChar(myString.value,';',',');
	myString=document.getElementById(email_list);
	var emails=myString.value.split(",");
	

	for (var i=0;i<emails.length;i++)
	{		
		if(trim(emails[i])!="")
		{	
			if((reg.test(trim(emails[i]))==false))
			{erremails+="- "+emails[i]+"\n";}
		}
		
	}
	if(erremails!="")
	{alert("The following email(s) are invalid:\n"+erremails); myString.focus();}
}

function highlight_inSearch(searchTxtBoxName,searchContainerId){
	var searchTxt=document.getElementsByName(searchTxtBoxName).item(0).value;
	var searchPool=document.getElementById(searchContainerId);
	var searchTerms = searchTxt.split(' ');
	
	for (var i in searchTerms) {
		var regex =  new RegExp(searchTerms[i],"ig");
		searchPool.innerHTML = searchPool.innerHTML.replace(regex,"<span class='highlight_search_term'>"+searchTerms[i]+"</span>");
	}
}

var reg=/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)$/i;
