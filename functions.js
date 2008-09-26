var showednewticker_state = "0";
function showNewTickerForm()
{
if(showednewticker_state == "0") {
document.getElementById("newtickerform").innerHTML = '<form action="index.php?subtopic=latestnews&action=newticker" method="post" ><table border="0"><tr><td bgcolor="D4C0A1" align="center"><b>Select icon:</b></td><td><table border="0" bgcolor="F1E0C6"><tr><td><img src="images/news/icon_0.gif" width="20"></td><td><img src="images/news/icon_1.gif" width="20"></td><td><img src="images/news/icon_2.gif" width="20"></td><td><img src="images/news/icon_3.gif" width="20"></td><td><img src="images/news/icon_4.gif" width="20"></td></tr><tr><td><input type="radio" name="icon_id" value="0" checked="checked"></td><td><input type="radio" name="icon_id" value="1"></td><td><input type="radio" name="icon_id" value="2"></td><td><input type="radio" name="icon_id" value="3"></td><td><input type="radio" name="icon_id" value="4"></td></tr></table></td></tr><tr><td align="center" bgcolor="D4C0A1"><b>New<br>ticker<br>text:</b></td><td bgcolor="F1E0C6"><textarea name="new_ticker" rows="3" cols="45"></textarea></td></tr><tr><td><div class="BigButton" style="background-image:url(images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url(images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="images/buttons/_sbutton_submit.gif" ></div></div></form><div class="BigButton" style="background-image:url(images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url(images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="AddTicker" src="images/buttons/_sbutton_cancel.gif" onClick="showNewTickerForm()" alt="AddTicker" /></div></div></td></tr></table>';
document.getElementById("jajo").innerHTML = '';
showednewticker_state = "1";
}
else {
document.getElementById("newtickerform").innerHTML = '';
document.getElementById("jajo").innerHTML = '<div class="BigButton" style="background-image:url(images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url(images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="AddTicker" src="images/buttons/addticker.gif" onClick="showNewTickerForm()" alt="AddTicker" /></div></div>';
showednewticker_state = "0";
}
}

var showednewnews_state = "0";
function showNewNewsForm()
{
if(showednewnews_state == "0") {
document.getElementById("newnewsform").innerHTML = '<form action="index.php?subtopic=latestnews&action=newnews" method="post" ><table border="0"><tr><td bgcolor="D4C0A1" align="center"><b>Select icon:</b></td><td><table border="0" bgcolor="F1E0C6"><tr><td><img src="images/news/icon_0.gif" width="20"></td><td><img src="images/news/icon_1.gif" width="20"></td><td><img src="images/news/icon_2.gif" width="20"></td><td><img src="images/news/icon_3.gif" width="20"></td><td><img src="images/news/icon_4.gif" width="20"></td></tr><tr><td><input type="radio" name="icon_id" value="0" checked="checked"></td><td><input type="radio" name="icon_id" value="1"></td><td><input type="radio" name="icon_id" value="2"></td><td><input type="radio" name="icon_id" value="3"></td><td><input type="radio" name="icon_id" value="4"></td></tr></table></td></tr><tr><td align="center" bgcolor="F1E0C6"><b>Topic:</b></td><td><input type="text" name="news_topic" maxlenght="50" style="width: 300px" ></td></tr><tr><td align="center" bgcolor="D4C0A1"><b>News<br>text:</b></td><td bgcolor="F1E0C6"><textarea name="news_text" rows="6" cols="60"></textarea></td></tr><tr><td align="center" bgcolor="F1E0C6"><b>Your nick:</b></td><td><input type="text" name="news_name" maxlenght="40" style="width: 200px" ></td></tr><tr><td><div class="BigButton" style="background-image:url(images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url(images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="images/buttons/_sbutton_submit.gif" ></div></div></form><div class="BigButton" style="background-image:url(images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url(images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="CancelAddNews" src="images/buttons/_sbutton_cancel.gif" onClick="showNewNewsForm()" alt="CancelAddNews" /></div></div></td></tr></table>';
document.getElementById("chicken").innerHTML = '';
showednewnews_state = "1";
}
else {
document.getElementById("newnewsform").innerHTML = '';
document.getElementById("chicken").innerHTML = '<div class="BigButton" style="background-image:url(images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url(images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="AddNews" src="images/buttons/addnews.gif" onClick="showNewNewsForm()" alt="AddNews" /></div></div>';
showednewnews_state = "0";
}
}

state = new Array("0", "0", "0", "0", "0");
function TickerAction(id) {
  var line = id.substr(12, 1);
  if(state[line] == "0") {
    state[line] = "1";
    OpenNews(id);
  }
  else {
    state[line] = "0";
    CloseNews(id);
  }
}

function OpenNews(id)
{
  var div = document.getElementById(id)
  var idShort = id.concat("-ShortText");
  var idMore = id.concat("-FullText");
  document.getElementById(idShort).style.display = "none";
  document.getElementById(idMore).style.display = "block";
}

function CloseNews(id)
{
  var div = document.getElementById(id)
  var idShort = id.concat("-ShortText");
  var idMore = id.concat("-FullText");
  document.getElementById(idShort).style.display = "block";
  document.getElementById(idMore).style.display = "none";
}
//sprawdzanie czy ktos online
var statusxmlhttp = createXmlRequestObject();
function createXmlRequestObject()
{
	var xmlHttp;
	if(window.ActiveXObject)
	{
		try
		{
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp = false;
		}
	}
	else
	{
		try
		{
			xmlHttp = new XMLHttpRequest();
		}
		catch (e)
		{
			xmlHttp = false;
		}
	}
		return xmlHttp;
}
function checkStatus()
{
	if (statusxmlhttp.readyState == 4 || statusxmlhttp.readyState == 0)
	{
		statusxmlhttp.open("GET", LAYOUT_PATH + "ajax/server_status.php", true);
		statusxmlhttp.onreadystatechange = handleServerResponse;
		statusxmlhttp.send(null);
	}
	else
		setTimeout('checkStatus()', 1000);
}
function handleServerResponse()
{
	if (statusxmlhttp.readyState == 4)
	{
		if (statusxmlhttp.status == 200)
		{
			xmlResponse = statusxmlhttp.responseXML
			xmlDocumentElement = xmlResponse.documentElement;
			serverStatusText = xmlDocumentElement.firstChild.data;
			if (serverStatusText == "OFF") {
			document.getElementById("divServerStatus").innerHTML = '<b><font color="#FF0000">Server<br />Offline</font></b>';
			}
			else
			{
			document.getElementById("divServerStatus").innerHTML = serverStatusText + '<br />Players Online';
			}
			setTimeout('checkStatus()', 10000)
		}
		else
		{
		//blad transmisji z servera
		document.getElementById("divServerStatus").innerHTML = onlinechecklink;
		}
	}
}
//sprawdza czy dane konto istnieje czy nie
var xmlAccount = createXmlRequestObject();
function checkAccount()
{
	if(document.getElementById("account_number").value=="")
	{
	document.getElementById("acc_number_check").innerHTML = '<b><font color="red">Please enter account number.</font></b>';;
	}
	else
	{
		account = encodeURIComponent(document.getElementById("account_number").value);
		if (xmlAccount.readyState == 4 || xmlAccount.readyState == 0)
		{
			xmlAccount.open("GET", LAYOUT_PATH + "ajax/check_account.php?account=" + account, true);
			xmlAccount.onreadystatechange = checkAccountResponse;
			xmlAccount.send(null);
		}
		else
			setTimeout('checkAccount()', 100);
	}
}
function checkAccountResponse()
{
	if (xmlAccount.readyState == 4)
	{
		if (xmlAccount.status == 200)
		{
			xmlResponse = xmlAccount.responseXML
			xmlDocumentElement = xmlResponse.documentElement;
			serverStatusText = xmlDocumentElement.firstChild.data;
			if (serverStatusText == "bad") {
			document.getElementById("acc_number_check").innerHTML = '<b><font color="red">Select other account number.</font></b>';
			}
			else
			{
			document.getElementById("acc_number_check").innerHTML = '<b><font color="green">Good account number.</font></b>';
			}
		}
		else
		{
		//blad transmisji z servera
		document.getElementById("acc_number_check").innerHTML = 'Transfer<br />error';
		}
	}
}


function InitializePage() {
  LoadLoginBox();
  LoadMenu();
}

// functions for mouse-over and click events of non-content-buttons
function MouseOverBigButton(source)
{
  source.firstChild.style.visibility = "visible";
}
function MouseOutBigButton(source)
{
  source.firstChild.style.visibility = "hidden";
}
function BigButtonAction(path)
{
  window.location = path;
}

// initialisation of the loginbox status by the value of the variable 'loginStatus' which is provided to the HTML-document by PHP in the file 'header.inc'
function LoadLoginBox()
{
  if(loginStatus == "false") {
    document.getElementById('LoginstatusText_1').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-you-are-not-logged-in.gif')";
    document.getElementById('ButtonText').style.backgroundImage = "url('" + IMAGES + "/buttons/_sbutton_login.gif')";
    document.getElementById('LoginstatusText_2').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-create-account.gif')";
    document.getElementById('LoginstatusText_2_1').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-create-account.gif')";
    document.getElementById('LoginstatusText_2_2').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-create-account-over.gif')";
  } else {
    document.getElementById('LoginstatusText_1').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-welcome.gif')";
    document.getElementById('ButtonText').style.backgroundImage = "url('" + IMAGES + "/buttons/_sbutton_myaccount.gif')";
    document.getElementById('LoginstatusText_2').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-logout.gif')";
    document.getElementById('LoginstatusText_2_1').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-logout.gif')";
    document.getElementById('LoginstatusText_2_2').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-logout-over.gif')";
  }
}

// mouse-over and click events of the loginbox
function MouseOverLoginBoxText(source)
{
  source.lastChild.style.visibility = "visible";
  source.firstChild.style.visibility = "hidden";
}
function MouseOutLoginBoxText(source)
{
  source.firstChild.style.visibility = "visible";
  source.lastChild.style.visibility = "hidden";
}
function LoginButtonAction()
{
  if(loginStatus == "false") {
    window.location = LINK_ACCOUNT + "/?subtopic=accountmanagement";
  } else {
    window.location = LINK_ACCOUNT + "/?subtopic=accountmanagement";
  }
}
function LoginstatusTextAction(source) {
  if(loginStatus == "false") {
    window.location = LINK_ACCOUNT + "/?subtopic=createaccount";
  } else {
    window.location = LINK_ACCOUNT + "/?subtopic=accountmanagement&action=logout";
  }
}
var menu = new Array();
menu[0] = new Object();
var unloadhelper = false;

// load the menu and set the active submenu item by using the variable 'activeSubmenuItem' (provided to HTML-document by PHP in the file 'header.inc'
function LoadMenu()
{
  document.getElementById("submenu_"+activeSubmenuItem).style.color = "white";
  document.getElementById("ActiveSubmenuItemIcon_"+activeSubmenuItem).style.visibility = "visible";
  if(self.name.lastIndexOf("&") == -1) {
    self.name = "news=1&library=0&community=0&account=0&";
  }
  FillMenuArray();
  InitializeMenu();
}

function SaveMenu()
{
  if(unloadhelper == false) {
    SaveMenuArray();
    unloadhelper = true;
  }
}

// store the values of the variable 'self.name' in the array menu
function FillMenuArray()
{
  while(self.name.length > 0 ){
    var mark1 = self.name.indexOf("=");
    var mark2 = self.name.indexOf("&");
    var menuItemName = self.name.substr(0, mark1);
    menu[0][menuItemName] = self.name.substring(mark1 + 1, mark2);
    self.name = self.name.substr(mark2 + 1, self.name.length);
  }
}

// hide or show the corresponding submenus
function InitializeMenu()
{
  for(menuItemName in menu[0]) {
    if(menu[0][menuItemName] == "0") {
      document.getElementById(menuItemName+"_Submenu").style.visibility = "hidden";
      document.getElementById(menuItemName+"_Submenu").style.display = "none";
      document.getElementById(menuItemName+"_Lights").style.visibility = "visible";
      document.getElementById(menuItemName+"_Extend").style.backgroundImage = "url(" + IMAGES + "/general/plus.gif)";
    }
    else {
      document.getElementById(menuItemName+"_Submenu").style.visibility = "visible";
      document.getElementById(menuItemName+"_Submenu").style.display = "block";
      document.getElementById(menuItemName+"_Lights").style.visibility = "hidden";
      document.getElementById(menuItemName+"_Extend").style.backgroundImage = "url(" + IMAGES + "/general/minus.gif)";
    }
  }
}

// reconstruct the variable "self.name" out of the array menu
function SaveMenuArray()
{
  var stringSlices = "";
  var temp = "";
  for(menuItemName in menu[0]) {
    stringSlices = menuItemName + "=" + menu[0][menuItemName] + "&";
    temp = temp + stringSlices;
  }
  self.name = temp;
}

// onClick open or close submenus
function MenuItemAction(sourceId)
{
  if(menu[0][sourceId] == 1) {
    CloseMenuItem(sourceId);
  }
  else {
    OpenMenuItem(sourceId);
  }
}
function OpenMenuItem(sourceId)
{
  menu[0][sourceId] = 1;
  document.getElementById(sourceId+"_Submenu").style.visibility = "visible";
  document.getElementById(sourceId+"_Submenu").style.display = "block";
  document.getElementById(sourceId+"_Lights").style.visibility = "hidden";
  document.getElementById(sourceId+"_Extend").style.backgroundImage = "url(" + IMAGES + "/general/minus.gif)";
}
function CloseMenuItem(sourceId)
{
  menu[0][sourceId] = 0;
  document.getElementById(sourceId+"_Submenu").style.visibility = "hidden";
  document.getElementById(sourceId+"_Submenu").style.display = "none";
  document.getElementById(sourceId+"_Lights").style.visibility = "visible";
  document.getElementById(sourceId+"_Extend").style.backgroundImage = "url(" + IMAGES + "/general/plus.gif)";
}

// mouse-over effects of menubuttons and submenuitems
function MouseOverMenuItem(source)
{
  source.firstChild.style.visibility = "visible";
}
function MouseOutMenuItem(source)
{
  source.firstChild.style.visibility = "hidden";
}
function MouseOverSubmenuItem(source)
{
  source.style.backgroundColor = "#14433F";
}
function MouseOutSubmenuItem(source)
{
  source.style.backgroundColor = "#0D2E2B";
}