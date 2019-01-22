/*################################################################*\
       JotForm Forms Framework V1.2.0 | Interlogy LLC.
\*################################################################*/
/////// Defining the source domain of images.
/////// don't change these variables
/////////////////////////////////////////////

if(location.href.match(/https/))
	var url = "https://www.jotform.com";
else
	var url = "http://www.jotform.com";
//////// Prototype's $ function
///////////////////////////////
function $jt(){
  var elements = new Array();
  for (var i = 0; i < arguments.length; i++) { 
    var element = arguments[i];
    if (typeof element == 'string')
	  element = document.getElementById(element);
    if (arguments.length == 1)	
      return element;
    elements.push(element);
  }
  return elements;
}

///////// Birthdate picker 
///////////////////////////////////
function getdate(elem){
	id = elem.id.split("_");
	day = $jt("day_"+id[1]).options[$jt("day_"+id[1]).selectedIndex].value;
	month = $jt("month_"+id[1]).options[$jt("month_"+id[1]).selectedIndex].value;
	year = $jt("year_"+id[1]).options[$jt("year_"+id[1]).selectedIndex].value;
	$jt("date_"+id[1]).value = month+" / "+day+" / "+year;
}

///////// AutoComplete functions
///////////////////////////////////
function Complete(obj, evt) {
  if ((!obj) || (!evt) || (auto.length == 0)){return;}
  if (obj.value.length == 0){ return; }
  var elm = (obj.setSelectionRange) ? evt.which : evt.keyCode;
  if ((elm < 32) || (elm >= 33 && elm <= 46) || (elm >= 112 && elm <= 123)) { return; }
  var txt = obj.value.replace(/;/gi, ",");
  elm = txt.split(",");
  txt = elm.pop();
  txt = txt.replace(/^\s*/, "");

  if (txt.length == 0){return;}
  if (obj.createTextRange) {
   	var rng = document.selection.createRange();
  		if (rng.parentElement() == obj) {
   			elm = rng.text;
  	 		var ini = obj.value.lastIndexOf(elm);
  		}
  } else if (obj.setSelectionRange) {
  		var ini = obj.selectionStart;
  }
  for (var i = 0; i < auto.length; i++) {
   	elm = auto[i].toString();
  		if (elm.toLowerCase().indexOf(txt.toLowerCase()) == 0) {
   			obj.value += elm.substring(txt.length, elm.length);
  	 		break;
  		}
  }
  if (obj.createTextRange) {
  		rng = obj.createTextRange();
  		rng.moveStart("character", ini);
  		rng.moveEnd("character", obj.value.length);
  		rng.select();
  } else if (obj.setSelectionRange) {
  		obj.setSelectionRange(ini, obj.value.length);
  }
}

///////// sum function for payment objects
//////////////////////////////////////////
function sum(radio,t){
    if(!$jt('res')){
        return true;
    }
	var val = new Array();
	if(radio.type!='radio'){
		tot1=parseFloat($jt('hid').value);
		if(t){
			tot2=parseFloat(price[radio.value])+parseFloat(setup[radio.value]);
		}else
			tot2=parseFloat(price[radio.value]);
		if(radio.checked)
			tot1=tot1+tot2;
		else 
			tot1=tot1-tot2;
		tot1 = tot1.toFixed(2);
		$jt('hid').value=tot1;
		$jt('res').innerHTML = tot1;
	}else{
		val = price[radio.value].split(':');
		rval = parseFloat(val[0]);
		rval = rval.toFixed(2);
		$jt('res').innerHTML = rval;
	}
}

/////////Prototypes Clipp functions
///////////////////////////////////
function makeClipping(element){ 
	if (element._overflow) return element;
    element._overflow = element.style.overflow || 'auto';
    if ((element.style.overflow || 'visible') != 'hidden')
      element.style.overflow = 'hidden';
    return element;
}
/////////Prototypes Clipp functions
///////////////////////////////////
function undoClipping(element){
	if (!element._overflow) return element;
	element.style.overflow = element._overflow == 'auto' ? '' : element._overflow;
    element._overflow = null;
    return element;
}
/////////Prototypes Dimention functions
///////////////////////////////////////
function getDimentions(e){
	element = e;
	var display = element.style.display;
    if (display != 'none' && display != null) // Safari bug
      return {width: element.offsetWidth, height: element.offsetHeight};
	var els = element.style;
    var originalVisibility = els.visibility;
    var originalPosition = els.position;
    var originalDisplay = els.display;
    els.visibility = 'hidden';
    els.position = 'absolute';
    els.display = 'block';
    var originalWidth = element.clientWidth;
    var originalHeight = element.clientHeight;
    els.display = originalDisplay;
    els.position = originalPosition;
    els.visibility = originalVisibility;
    return {width: originalWidth, height: originalHeight};
}
//////// Effect for sliding down and show
/////////////////////////////////////////
var orgH = new Object();
function blindDown(elem, id, dur){
	if(!dur){
		var dur = 0;
		orgH[elem.id] = getDimentions(elem).height;
		makeClipping(elem);
		elem.style.display = "block";
	}
	elem.style.height = (dur+=25)+"px";
	if(dur <= orgH[elem.id])
		setTimeout(function(){ blindDown(elem, id, dur) },50);
	else{
		undoClipping(elem);
		elem.style.height = orgH[elem.id]+"px";
		elem.style.padding = "2px";
		window.location = "#td_"+id;
	}
}
//////// Effect for sliding up and hide
/////////////////////////////////////////
function blindUp(elem, id, dur){
	if(!dur){
		makeClipping(elem);
		var dur = getDimentions(elem).height;
		orgH[elem.id] = dur;
	}
	dur -= 25;
	if(dur > 0){
		elem.style.height = dur+"px";
		setTimeout(function(){ blindUp(elem, id, dur) },50);
	}else{
		undoClipping(elem);
		elem.style.display = "none";
		elem.style.height = orgH[elem.id]+"px";
		elem.style.padding = "2px";
		window.location = "#td_"+id;
	}
}
//////// Form collapse functions
////////////////////////////////
var tool = "";
function closeDiv(id){
	var id2 = 'div_'+id;
	var currdiv= $jt(id2);
	var the_divs=document.getElementsByTagName('div');
	var re = RegExp(/^div_/i);
	for(var n=0;n<the_divs.length;n++)
		if(the_divs[n].id.match(re))
			if (the_divs[n].id==id2 && the_divs[n].style.display == 'none'){
				blindDown(the_divs[n], id);
			}else if(the_divs[n].style.display == 'block'){
				blindUp(the_divs[n], id);
			}
	var the_tds=document.getElementsByTagName('td');
	var id3 = 'td_'+id;
	var tdElem = $jt(id3);
	var re = RegExp(/^td_/i);
	var show = 'url('+url+'/images/splitter_right_show.gif)';
	var hide = 'url('+url+'/images/splitter_right_hide.gif)';
	if(tdElem.style.backgroundImage == show){
		tdElem.style.backgroundImage = hide;
	}else{
		for(var n=0;n<the_tds.length;n++){
			if(the_tds[n].id.match(re)){
				if (the_tds[n].style.backgroundImage == show){
					the_tds[n].style.backgroundImage = hide;
					}
				}
			}
		tdElem.style.backgroundImage = show;
	}
}

//////// Functions for star rating
//////////////////////////////////
function rate(elem,val,hid){
	$jt(hid).value = val;
}
function resetRate(elem,hid){
	var val = $jt(hid).value;
	if(val == "")
		elem.style.backgroundImage="url("+url+"/images/star0.gif)";
	else
		elem.style.backgroundImage="url("+url+"/images/star"+val+".gif)";
}
function changeColor(val,tab){
	$jt(tab).style.backgroundImage="url("+url+"/images/star"+val+".gif)";
}

//////// Tooltip code
///////////////////////
var offsetfromcursorX=12
var offsetfromcursorY=10
var offsetdivfrompointerX=10
var offsetdivfrompointerY=14
var table  = '<div id="tooltip" style="display:none; position:absolute;z-index: 100;opacity: .9;filter: alpha(opacity=90);">';
    table += '<table border="0" cellpadding="0" cellspacing="0">';
    table += '  <tr><td width="1" height="8" background="'+url+'/images/tooltip_top.gif"></td>';
    table += '    <td align="left" background="'+url+'/images/tooltip_top.gif"><img src="'+url+'/images/tooltip_arrow.gif" width="20" height="8" /></td>';
    table += '    <td width="1" background="'+url+'/images/tooltip_top.gif"></td>';
    table += '  </tr><tr>';
    table += '  <td bgcolor="#b1bfcc"></td>';
    table += '    <td bgcolor="#edf4fa"><div style="padding:10px; font-family:\'Trebuchet MS\'; font-size:12px; color:black" id="tooltipinner"></div></td>';
    table += '    <td bgcolor="#b1bfcc"></td>';
    table += '  </tr><tr>';
    table += '    <td height="1" bgcolor="#b1bfcc"></td>';
    table += '    <td bgcolor="#b1bfcc"></td>';
    table += '    <td bgcolor="#b1bfcc"></td>';
    table += '  </tr>';
    table += '</table>';
    table += '</div>';
document.write(table)
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj     = document.all? document.all["tooltipinner"] : document.getElementById? $jt("tooltipinner") : ""
var pointerobj = document.all? document.all["tooltip"]      : document.getElementById? $jt("tooltip") : ""
function ietruebody(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}
function ddrivetip(thetext, thewidth, thecolor){
	if(thetext != ""){
		if (ns6||ie){
		 	if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px";
			if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor;
			tipobj.innerHTML=thetext;
			enabletip=true;
			return false;
		}		
	}
}
function positiontip(e){
	if (enabletip){
		var nondefaultpos=false
		var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
		var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
		var winwidth=ie&&!window.opera? ietruebody().clientWidth : window.innerWidth-20
		var winheight=ie&&!window.opera? ietruebody().clientHeight : window.innerHeight-20
		var rightedge=ie&&!window.opera? winwidth-event.clientX-offsetfromcursorX : winwidth-e.clientX-offsetfromcursorX
		var bottomedge=ie&&!window.opera? winheight-event.clientY-offsetfromcursorY : winheight-e.clientY-offsetfromcursorY
		var leftedge=(offsetfromcursorX<0)? offsetfromcursorX*(-1) : -1000
		if (rightedge<tipobj.offsetWidth){
			tipobj.style.left=curX-tipobj.offsetWidth+"px"
		nondefaultpos=true
	}
	else if (curX<leftedge)
		tipobj.style.left="5px"
	else{
		tipobj.style.left=(curX+offsetfromcursorX-offsetdivfrompointerX-25)+"px" //position the horizontal position of the menu where the mouse is positioned
		pointerobj.style.left=(curX+offsetfromcursorX-25)+"px"
	}
	if (bottomedge<tipobj.offsetHeight){
		tipobj.style.top=(curY-tipobj.offsetHeight-offsetfromcursorY+15)+"px"
		nondefaultpos=true
	}
	else{
		tipobj.style.top=curY+offsetfromcursorY+offsetdivfrompointerY+"px"
		pointerobj.style.top=curY+offsetfromcursorY+"px"
	}
	//tipobj.style.visibility="visible"
	tipobj.style.display = "block"
	pointerobj.style.display = "block"
	}
}
function hideddrivetip(){
	if (ns6||ie){
		enabletip=false
		//tipobj.style.visibility="hidden"
		tipobj.style.display = "none"
		pointerobj.style.display = "none"
		tipobj.style.left="-1000px"
		tipobj.style.backgroundColor=''
		tipobj.style.width=''
	}
}
document.onmousemove=positiontip
//////// Validation library V2
//////////////////////////////
var errored = false;            // Global for validate function
var exClassName = new Object(); // Global for Changed classnames
var styleAdded = false;         // Global for checking sytle status

// page break object
var pageBreak = new pageBreak();

function validate(elem,type,option){	// Main function

	if (typeof(pageBreak.formName) == 'undefined'){
		pageBreak.formName = elem;
		pageBreak.setInitialStatus();
	}

	var option = (option)? option : "";
	if(!styleAdded){			// Add style for Error warnings
		var style = document.createElement('style');
		var sprop  = '.error{ border:2px red solid !important; background:#FCFCFC !important; }';
		    sprop += '.Errortext{ color:#FF0000;font-family:"Trebuchet MS"; font-size:11px; }';
            sprop += '.DivErrortext{ border:1px solid #ccc;margin:4px; padding:5px; background:lightyellow; color:#FF0000;font-family:"Trebuchet MS"; font-size:11px; }';
		style.setAttribute("type", "text/css");
		if (style.styleSheet){   // for IE
			style.styleSheet.cssText = sprop;
		} else {
			var newStyle = document.createTextNode(sprop);
			style.appendChild(newStyle);
		}
		document.getElementsByTagName('head')[0].appendChild(style);
		styleAdded = true; //don't add again.
	}
	///////////
	//Checking for mail validation
	var checkmail = function(email){
        return /^[a-z0-9_\-]+(\.[_a-z0-9\-]+)*@([_a-z0-9\-]+\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)$/i.test(email);
        /*  Deprecated: for stupid behaviour      
		var splitted = email.match("^(.+)@(.+)$");
        if(splitted == null) return false;
		if(splitted[1] != null )   {
			var regexp_user=/^\"?[\w-_\.]*\"?$/;
			if(splitted[1].match(regexp_user) == null) return false;  
		}
		if(splitted[2] != null)  {
			var regexp_domain=/^[\w-\.]*\.[A-Za-z]{2,4}$/;
			if(splitted[2].match(regexp_domain) == null) {
				var regexp_ip =/^\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\]$/;
				if(splitted[2].match(regexp_ip) == null) return false; 
			}
			return true; 
		}
		return false;
		*/
	}
    var warned = false;
	//////////////
	// Function to run onsubmit;
	var onSubmit = function(elem){
		errored = false;
		var form = document.forms[elem];
		for(var node = 0;node < form.length; node++)
			if((""+form[node].onblur).match("validate"))
				form[node].onblur();
		if(errored){
            if(!warned){
                var inputs = form.getElementsByTagName('input');
                for(var x =0; x< inputs.length; x++){
                    if(inputs[x].type == 'submit'){
                        //var errdiv = document.createElement('div');
                        //errdiv.className = 'DivErrortext';
                        //errdiv.innerHTML = 'There are missing fields on your form please correct them.';
                        //inputs[x].parentNode.appendChild(errdiv);
                    	
                        document.getElementById("RVSDivErrortext").style.display = 'block';
                        document.getElementById("RVSDivErrortext").innerHTML = "There are missing fields on your form please correct them.";
                    }
                }
                warned = true;
            }
			pageBreak.goErrorPage();
            return false;
        }	
		else form.submit();
	}
	
	//////////////
	// Function to set error messages
	var getMsg = function(type){
		switch(type){
			case "LessThan":           return "This field's length should be less than (" + option['LessThan'] + ")"
			case "GreaterThan":        return "This field's length should be greater than (" + option['GreaterThan'] + ")"
			case "Alphabetic":         return "Cannot contain non-alphabetic characters."
			case "RequiredAlphabetic": return "This field is required and cannot contain non-alphabetic characters."
			case "Numeric":            return "Cannot contain non-numeric characters."
			case "RequiredNumeric":    return "This field is required and cannot contain non-numeric characters."
			case "Email":              return "Enter a valid email address."
			case "Required":           return "This field is required."
            case "confirm":            return "Values should match each other"
			case "Regex":              return "This entry does not match (" + option + ")."
			default:                   return "Undefined Error Message"
		}
	}
	
	/////////////
	// Function to check is error printed?
	var checkForErrorDiv = function(elem){
		for(var node = 0;node < elem.parentNode.childNodes.length; node++)
			if(elem.parentNode.childNodes[node].className == "Errortext")
				return true;
		return false;
	}
	
	/////////////
	// Function to define errors and print messages
	var error = function(elem, type, message){
		correct(elem);
		if(!checkForErrorDiv(elem)){
			div = document.createElement("div");
			div.innerHTML = (message)? message : getMsg(type);
			div.className = "Errortext";
			elem.parentNode.appendChild(div);
			//elem.parentNode.insertBefore(div, elem.nextSibling);
		}
		if(elem.className != "error")
			exClassName[elem.name] = elem.className;
		if(elem.type != "checkbox" && elem.type != "radio"){
			elem.className = "error";
		}
		errored = true;
		return true;
	}
	
	/////////////
	// Function to revert Errored fields
	var correct = function(elem){
		var parent = elem.parentNode;
		for(x = 0; x < parent.childNodes.length; x++){
			var node = parent.childNodes[x];
			if(node){
				if(node.className == "Errortext")
					node.parentNode.removeChild(node);
				if(node.className == "error")
					node.className = exClassName[node.name];
			}
		}
	}
	
	///////////////
	// Check for optional validations
	if(option['LessThan']){
		if(elem.value.length >= option['LessThan']){
			error(elem,"LessThan",option['message']);
			return false;
		}else
			correct(elem);
	}
	if(option['GreaterThan']){
		if(elem.value.length <= option['GreaterThan']){
			error(elem,"GreaterThan", option['message']);
			return false;
		}else
			correct(elem);
	}
    if(option.confirm){
		if(elem.value.toLowerCase() != $jt(option.confirm).value.toLowerCase()){
			error(elem, "confirm", option['message']);
            error($jt(option.confirm), "confirm", option['message']);
			return false;
		}else{
            correct(elem);
            correct($jt(option.confirm));
        }
			
	}
		
	//////////////
	// Make all the validations
	switch(type){
		case "Alphabetic":
			var charpos = elem.value.search(/[^a-zA-Z\s\-\_\']/);
			if(charpos >= 0) error(elem,type,option['message']); else correct(elem);
			break;
		case "RequiredAlphabetic":
			if(elem.value.length <= 0) error(elem,type,option['message']); 
			else{
				var charpos = elem.value.search(/[^a-zA-Z\s\-\_\']/);
				if(charpos >= 0) error(elem,type,option['message']); else correct(elem);
			}
			break;
		case "Numeric":
			var charpos = elem.value.search(/[^0-9\.\,\s\-\_]/);
			if(charpos >= 0) error(elem,type,option['message']); else correct(elem);
			break;
		case "RequiredNumeric":
			if(elem.value.length <= 0) error(elem,type,option['message']); 
			else{
				var charpos = elem.value.search(/[^0-9\.\,\s\-\_]/);
				if(charpos >= 0) error(elem,type,option['message']); else correct(elem);
			}
			break;
		case "Email":
			if(!checkmail(elem.value)) error(elem,type,option['message']); else correct(elem);
			break;
		case "Required":
			if(elem.type == "checkbox" || elem.type == "radio"){
				var parent = elem.parentNode;
				var ok = false;
				for(x = 0; x < parent.childNodes.length; x++)
					if(parent.childNodes[x].checked == true)
						ok = true;
				if(ok) correct(elem,true); else error(elem,type,option['message']);
			}else{
				if(elem.options)	
					// Here can be edited for checking text to "Please Select one" or similar text
					// in this example it looks for blank <option> to give error
					if(elem.options[elem.selectedIndex].text.length <= 0) error(elem,type,option['message']); else correct(elem);
				else
					if(elem.value.length <= 0) error(elem,type,option['message']); else correct(elem);
			}
			break;
		case "Regex":
			if(elem.value.match(option['expression'])) correct(elem);
			else error(elem,type,option['message']);
			break;
		default:	// Default is for defining the form and setting onsubmit function
			var form = document.forms[elem]
			form.onsubmit = function(){ onSubmit(elem); return false; };
			break;
	}		
}

function pageBreak(){
	// the object properties
	this.form;
	this.pages;
	this.pageIndex;
	this.pageLength;
	
	// The form objects.
	this.setInitialStatus = setInitialStatus;
	this.goErrorPage = goErrorPage;
	this.goPage = goPage;
	this.controlCurrentPage = controlCurrentPage;
	
	// function for getting properties	
	/**
	 * Get the form objects with the
	 * name form name
	 */
	function getForm(formName){
		return document.forms.formName;
	}
	
	/**
	 * Get the divs
	 */
	function getPages(){
		var temp = new Array();
		var mainDiv = document.getElementById("main");
		if (typeof(mainDiv) == null) {
			alert("Cannot find the main div.");
		}
		for (var i = 0; i < mainDiv.childNodes.length; i++) {
			if (mainDiv.childNodes[i].className == "pagebreak") {
				temp.push(mainDiv.childNodes[i]);
			}
		}
		return temp;
	}
	
	// methods..
	/**
	 * Set the initial status of the
	 * divs.
	 */
	function setInitialStatus(){
		this.form = getForm(this.formName);
		this.pages = getPages();
		this.pageIndex = 0;
		this.pageLength = this.pages.length;
		hidePages(this);
		setButtons(this);
	}
	
	function hidePages(pageBreak){
		for (var i = 0; i < pageBreak.pages.length; i++) {
			if (i != 0) {
				pageBreak.pages[i].style.display = "none";
			}
		}
	}
	
	function setButtons(pageBreak){
		for (var i = 0; i < pageBreak.pages.length; i++) {
			for (var j = 0; j < pageBreak.pages[i].childNodes.length; j++) {
				if (pageBreak.pages[i].childNodes[j].nodeName == "TABLE") {
					var table = pageBreak.pages[i].childNodes[j];
					var rows = table.getElementsByTagName('tr');
					if (rows.length<1){
						continue;
					}
					var lastRow = rows[rows.length-1];
					var myCells = lastRow.getElementsByTagName('td');
					var myCell = myCells[0];
					if (!lastRowButton(table) || i != (pageBreak.pageLength - 1)) {
						var myRow = table.insertRow(-1);
						var myCell = myRow.insertCell(-1);
						var myCell2 = myRow.insertCell(-1);
					}
					if (i != 0) {
						var backButton = document.createElement("div");
						backButton.className = "backButton";
						backButton.onclick = function(){
							goBackPage(pageBreak);
						};
						myCell.appendChild(backButton);
					}
					if (i != pageBreak.pageLength - 1) {
						var nextButton = document.createElement("div");
						nextButton.className = "nextButton";
						nextButton.onclick = function(){
							goNextPage(pageBreak);
						};
						myCell2.appendChild(nextButton);
					}
				} // if element is table
			} // look for all elements in page
		} // look for all pages
	} // end of function
	function goNextPage(pageBreak){
		if (pageBreak.controlCurrentPage() == false){
			scrollTo(obtenerPosicionX(document.getElementById('main')), obtenerPosicionY(document.getElementById('main')))
			return;
		}
		scrollTo(obtenerPosicionX(document.getElementById('main')), obtenerPosicionY(document.getElementById('main')))
		pageBreak.pages[pageBreak.pageIndex].style.display = "none";
		pageBreak.pageIndex++;
		pageBreak.pages[pageBreak.pageIndex].style.display = "block";
	}
	
	function goBackPage(pageBreak){
		scrollTo(obtenerPosicionX(document.getElementById('main')), obtenerPosicionY(document.getElementById('main')))
		pageBreak.pages[pageBreak.pageIndex].style.display = "none";
		pageBreak.pageIndex--;
		pageBreak.pages[pageBreak.pageIndex].style.display = "block";
	}
	
	//Get X position
	function obtenerPosicionX(elemento){
		var x = 0;
		while (elemento) {
			x += elemento.offsetLeft;
			elemento = elemento.offsetParent;
		}
		return x;
	}
	
	//Get Y position
	function obtenerPosicionY(elemento){
		var y = 0;
		while (elemento) {
			y += elemento.offsetTop;
			elemento = elemento.offsetParent;
		}
		return y;
	}
	
	function goErrorPage(){
		for (var i = 0; i < this.pageLength; i++) {
			var div = this.pages[i];
			var inputs = div.getElementsByTagName('input');
			for (var j = 0; j < inputs.length; j++) {
				var className = inputs[j].className;
				if (className.search(/error/) != -1) {
					this.goPage(i);
					return;
				}
			}
		}
	}
	
	function goPage(index){
		this.pages[this.pageIndex].style.display = 'none';
		this.pages[index].style.display = 'block';
		this.pageIndex = index;
	}
	
	function lastRowButton(table){
		var inputs = table.getElementsByTagName('input');
		if (inputs.length<1){
			return false;
		}
		var lastRowInput = inputs[inputs.length - 1];
		if (lastRowInput.type == 'submit') {
			return true;
		}
		return false;
	}
	
	function controlCurrentPage(){
		var div = this.pages[this.pageIndex];
		var inputs = div.getElementsByTagName('input');
		// fire all validation events
		for (var i=0; i<inputs.length; i++){
			fireHTMLEvent(inputs[i],"onblur");
			var className = inputs[i].className;
			if (className.search(/error/) != -1) {
				return false;
			}
		}
		return true;
	}
	
    function fireHTMLEvent(obj, eventType){
        if (typeof obj.fireEvent != "undefined") 
            obj.fireEvent(/^on/.test(eventType) ? eventType : "on" + eventType);
        else {
            var evt = document.createEvent("HTMLEvents");
            evt.initEvent(eventType.replace(/^on/, ""), true, true);
            obj.dispatchEvent(evt);
        }
    }
}
