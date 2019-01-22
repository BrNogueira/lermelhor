//Javascript name: My Date Time Picker
//Date created: 16-Nov-2003 23:19
//Scripter: TengYong Ng
//Website: http://www.rainforestnet.com
//Copyright (c) 2003 TengYong Ng
//FileName: DateTimePicker.js
//Version: 0.8
//Contact: contact@rainforestnet.com
// Note: Permission given to use this script in ANY kind of applications if
//       header lines are left unchanged.

// ------- addition to the original header -------------
// Modified version of TenyYong's My Date Time Picker Script
// Modified by Aytekin Tank<atank@interlogy.com>, Interlogy LLC.
// This modified version is released with same license as above:
    // Note: Permission given to use this script in ANY kind of applications if
    //       header lines are left unchanged.
// Original script is available at www.javascriptkit.com/script/script2/tengcalendar.shtml
// ------- addition to the original header ends -------------



//Global variables
var winCal = null;
var dtToday=new Date();
var Cal = null;
var docCal = null;
var MonthName=["January", "February", "March", "April", "May", "June","July", 
	"August", "September", "October", "November", "December"];
var WeekDayName=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];	
var exDateTime = null;//Existing Date and Time

//Configurable parameters
var cnTop="200";//top coordinate of calendar window.
var cnLeft="500";//left coordinate of calendar window
var WindowTitle ="Pick a Date";//Date Time Picker title.
var WeekChar=2;//number of character for week day. if 2 then Mo,Tu,We. if 3 then Mon,Tue,Wed.
var CellWidth=21;//Width of day cell.
var CellHeight = 100; //Height of the cell if this is a largecalbox
var DateSeparator="-";//Date Separator, you can change it to "/" if you want.
var TimeMode=24;//default TimeMode value. 12 or 24

var ShowLongMonth=true;//Show long month name in Calendar header. example: "January".
var ShowMonthYear=true;//Show Month and Year in Calendar header.
var MonthYearColor="#f9621a";//Font Color of Month and Year in Calendar header.
var WeekHeadColor="#cfcfcf";//Background Color in Week header.
var SundayColor="#b5cfe9";//Background color of Sunday.
var SaturdayColor="#b5cfe9";//Background color of Saturday.
var WeekDayColor="f5f5f5";//Background color of weekdays.
var FontColor="blue";//color of font in Calendar day cell.
var TodayColor="#f9621a";//Background color of today.
var SelDateColor="#f9621a";//Backgrond color of selected date in textbox.
var YrSelColor="#000000";//color of font of Year selector.
var ThemeBg="";//Background image of Calendar window.
//end Configurable parameters
//end Global variable

function NewCal(pCtrl,pFormat,pShowTime,pTimeMode)
{
	Cal=new Calendar(dtToday);
	if ((pShowTime!=null) && (pShowTime))
	{
		Cal.ShowTime=true;
		if ((pTimeMode!=null) &&((pTimeMode=='12')||(pTimeMode=='24')))
		{
			TimeMode=pTimeMode;
		}		
	}	
	if (pCtrl!=null)
		Cal.Ctrl=pCtrl;
	if (pFormat!=null)
		Cal.Format=pFormat.toUpperCase();
	var exDateTime = "";
	if (pCtrl!='inline')
            exDateTime=document.getElementById(pCtrl).value;
	if (exDateTime!="")//Parse Date String
	{
		var Sp1;//Index of Date Separator 1
		var Sp2;//Index of Date Separator 2 
		var tSp1;//Index of Time Separator 1
		var tSp1;//Index of Time Separator 2
		var strMonth;
		var strDate;
		var strYear;
		var intMonth;
		var YearPattern;
		var strHour;
		var strMinute;
		//var strSecond;
		//parse month
		Sp1=exDateTime.indexOf(DateSeparator,0)
		Sp2=exDateTime.indexOf(DateSeparator,(parseInt(Sp1)+1));
		
		if ((Cal.Format.toUpperCase()=="DDMMYYYY") || (Cal.Format.toUpperCase()=="DDMMMYYYY"))
		{
			strMonth=exDateTime.substring(Sp1+1,Sp2);
			strDate=exDateTime.substring(0,Sp1);
		}
		else if ((Cal.Format.toUpperCase()=="MMDDYYYY") || (Cal.Format.toUpperCase()=="MMMDDYYYY"))
		{
			strMonth=exDateTime.substring(0,Sp1);
			strDate=exDateTime.substring(Sp1+1,Sp2);
		}
		if (isNaN(strMonth))
			intMonth=Cal.GetMonthIndex(strMonth);
		else
			intMonth=parseInt(strMonth,10)-1;	
		if ((parseInt(intMonth,10)>=0) && (parseInt(intMonth,10)<12))
			Cal.Month=intMonth;
		//end parse month
		//parse Date
		if ((parseInt(strDate,10)<=Cal.GetMonDays()) && (parseInt(strDate,10)>=1))
			Cal.Date=strDate;
		//end parse Date
		//parse year
		strYear=exDateTime.substring(Sp2+1,Sp2+5);
		YearPattern=/^\d{4}$/;
		if (YearPattern.test(strYear))
			Cal.Year=parseInt(strYear,10);
		//end parse year
		//parse time
		if (Cal.ShowTime==true)
		{
			tSp1=exDateTime.indexOf(":",0)
			tSp2=exDateTime.indexOf(":",(parseInt(tSp1)+1));
			strHour=exDateTime.substring(tSp1,(tSp1)-2);
			Cal.SetHour(strHour);
			strMinute=exDateTime.substring(tSp1+1,tSp2);
			Cal.SetMinute(strMinute);
			//strSecond=exDateTime.substring(tSp2+1,tSp2+3);
			//Cal.SetSecond(strSecond);
		}	
	}
        if( pCtrl =='calbox' ){
            winCal=window.calframe;
            docCal = winCal.document;
        }else if( pCtrl =='largecalbox' ){
            winCal=window.largecalframe;
            docCal = winCal.document;
        } else {
            winCal=window.open("","DateTimePicker","toolbar=0,status=0,menubar=0,fullscreen=no,width=195,height=195,resizable=0,top="+cnTop+",left="+cnLeft);
            docCal = winCal.document;
        }
	RenderCal(pCtrl);
}

function RenderCal(pCtrl)
{
	var vCalHeader;
	var vCalData;
	var vCalTime;
	var i;
	var j;
	var SelectStr;
	var vDayCount=0;
	var vFirstDay;

	docCal.open();
        if(pCtrl != "calbox" && pCtrl != "largecalbox"){
            docCal.writeln("<html><head><title>"+WindowTitle+"</title>");
            docCal.writeln("<style>a {color: #333333; text-decoration: none; font-weight:none; font-family:'Trebuchet MS' }</style>");
            docCal.writeln("<script>var winMain=window.opener;</script>");
            docCal.writeln("</head><body background='"+ThemeBg+"' link="+FontColor+" vlink="+FontColor+">");
        }else{
            docCal.writeln("<html><head>");
            docCal.writeln("<style>a {color: black; text-decoration: none; font-weight:none; font-family:'Trebuchet MS' }</style>");
            docCal.writeln("<script>var winMain=window.parent ;</script>");
            docCal.writeln("</head><body background='"+ThemeBg+"' link="+FontColor+" vlink="+FontColor+">");
        }
        docCal.writeln("<form name='Calendar'>");
	vCalHeader="<table border=0 cellpadding=1 cellspacing=1 width='100%' align=\"center\" valign=\"top\">\n";

	//Calendar header shows Month and Year
	if (ShowMonthYear){
		vCalHeader+="<tr><td colspan='7' align='center'>";
                vCalHeader+="<table border=0 width=100% cellspacing=0 cellpadding=0><tr><td align=left>";
                vCalHeader+="<a href=\"javascript:winMain.Cal.DecYear();winMain.RenderCal('"+pCtrl+"')\"><font color="+MonthYearColor+" size=2><b><<</b></font></a> ";
                vCalHeader+="<a href=\"javascript:winMain.Cal.DecMonth();winMain.RenderCal('"+pCtrl+"')\"><font color="+MonthYearColor+" size=2><b><</b></font></a> ";
                if(pCtrl == "largecalbox") vCalHeader+="&nbsp;";
                vCalHeader+="</td><td align=center> ";
                if(pCtrl == "largecalbox")
                    vCalHeader+="<font face='Verdana' size='2' align='center' color='"+MonthYearColor+"'><b>"+Cal.GetMonthName(ShowLongMonth)+" "+Cal.Year+"</b></font>";
                else
                    vCalHeader+="<font face='Verdana' size='1' align='center' color='"+MonthYearColor+"'><b>"+Cal.GetMonthName(ShowLongMonth)+" "+Cal.Year+"</b></font>";
                vCalHeader+="</td><td align=right>";
                vCalHeader+=" <a href=\"javascript:winMain.Cal.IncMonth();winMain.RenderCal('"+pCtrl+"')\"><font color="+MonthYearColor+" size=2><b>></b></font></a> ";
                if(pCtrl == "largecalbox") vCalHeader+="&nbsp;";
                vCalHeader+=" <a href=\"javascript:winMain.Cal.IncYear();winMain.RenderCal('"+pCtrl+"')\"><font color="+MonthYearColor+" size=2><b>>></b></font></a>";
                vCalHeader+="</td></tr></table>";
                vCalHeader+="</td></tr>\n";
        }

	//Week day header
	vCalHeader+="<tr bgcolor="+WeekHeadColor+">";
	for (i=0;i<7;i++)
	{
		vCalHeader+="<td align='center'><font face='Trebuchet MS' size='2'>"+WeekDayName[i].substr(0,WeekChar)+"</font></td>";
	}
	vCalHeader+="</tr>";	
	docCal.write(vCalHeader);
	
	//Calendar detail
	CalDate=new Date(Cal.Year,Cal.Month);
	CalDate.setDate(1);
	vFirstDay=CalDate.getDay();
	vCalData="<tr>";
	for (i=0;i<vFirstDay;i++)
	{
		vCalData=vCalData+GenCell(pCtrl);
		vDayCount=vDayCount+1;
	}
	for (j=1;j<=Cal.GetMonDays();j++)
	{
		var strCell;
		vDayCount=vDayCount+1;
		if ((j==dtToday.getDate())&&(Cal.Month==dtToday.getMonth())&&(Cal.Year==dtToday.getFullYear()))
			strCell=GenCell(pCtrl, j,true,TodayColor);//Highlight today's date
		else
		{
			if (j==Cal.Date)
			{
				strCell=GenCell(pCtrl, j,true,SelDateColor);
			}
			else
			{	 
				if (vDayCount%7==0)
					strCell=GenCell(pCtrl, j,false,SaturdayColor);
				else if ((vDayCount+6)%7==0)
					strCell=GenCell(pCtrl, j,false,SundayColor);
				else
					strCell=GenCell(pCtrl, j,null,WeekDayColor);
			}		
		}						
		vCalData=vCalData+strCell;

		if((vDayCount%7==0)&&(j<Cal.GetMonDays()))
		{
			vCalData=vCalData+"</tr>\n<tr>";
		}
	}
	docCal.writeln(vCalData);	
	//Time picker
	if (Cal.ShowTime)
	{
		var showHour;
		showHour=Cal.getShowHour();		
		vCalTime="<tr>\n<td colspan='7' align='center'>";
		vCalTime+="<input type='text' name='hour' maxlength=2 size=1 style=\"WIDTH: 22px\" value="+showHour+" onchange=\"javascript:winMain.Cal.SetHour(this.value)\">";
		vCalTime+=" : ";
		vCalTime+="<input type='text' name='minute' maxlength=2 size=1 style=\"WIDTH: 22px\" value="+Cal.Minutes+" onchange=\"javascript:winMain.Cal.SetMinute(this.value)\">";
		if (TimeMode==12)
		{
			var SelectAm =(parseInt(Cal.Hours,10)<12)? "Selected":"";
			var SelectPm =(parseInt(Cal.Hours,10)>=12)? "Selected":"";

			vCalTime+="<select name=\"ampm\" onchange=\"javascript:winMain.Cal.SetAmPm(this.options[this.selectedIndex].value);\">";
			vCalTime+="<option "+SelectAm+" value=\"AM\">AM</option>";
			vCalTime+="<option "+SelectPm+" value=\"PM\">PM<option>";
			vCalTime+="</select>";
		}	
		vCalTime+="\n</td>\n</tr>";
		docCal.write(vCalTime);
	}
	


	//end time picker
	docCal.writeln("\n</table>");
        //if(pCtrl != "inline"){
            docCal.writeln("</form></body></html>");
        //}
	docCal.close();
}

function GenCell(pCtrl, pValue,pHighLight,pColor)//Generate table cell with value
{
	var PValue;
	var PCellStr;
	var vColor;
	var vHLstr1;//HighLight string
	var vHlstr2;
	var vTimeStr;
	
	if (pValue==null)
		PValue="";
	else
		PValue=pValue;
	
	if (pColor!=null)
		vColor="bgcolor=\""+pColor+"\"";
	else
		vColor="";	
	if ((pHighLight!=null)&&(pHighLight))
		{vHLstr1="color='red'><b>";vHLstr2="</b>";}
	else
		{vHLstr1=">";vHLstr2="";}	
	
	if (Cal.ShowTime)
	{
		vTimeStr="winMain.document.getElementById('"+Cal.Ctrl+"').value+=' '+"+"winMain.Cal.getShowHour()"+"+':'+"+"winMain.Cal.Minutes";  //+"+':'+"+"winMain.Cal.Seconds";
		if (TimeMode==12)
			vTimeStr+="+' '+winMain.Cal.AMorPM";
	}	
	else
		vTimeStr="";		
	PCellStr="\n <td width=14% ";  //+CellWidth;
        if( pCtrl == "largecalbox"){
            PCellStr+=" height="+CellHeight;
        }
        if( pCtrl == "largecalbox" ){
            if( window.parent.Events[ Cal.FormatDate(PValue) ] != null ){
                PCellStr+=" "+vColor+" align='center'>";
                PCellStr+="<font color=navy face='verdana' size='2'"+vHLstr1;
                PCellStr+= PValue + vHLstr2;
                desc = window.parent.Events[ Cal.FormatDate(PValue) ];
                if(desc.length>200){
                    desc = desc.substr(0, 200) + "...";
                } 
                PCellStr+= "<br><font size=1 face=arial>" + desc + "</font></a>";
            }else{
                PCellStr+= " "+vColor+" align='center'><font face='verdana' size='2'"+vHLstr1+PValue+vHLstr2+"</font></td>";
            }
            PCellStr+="</font></td>";
        } else if( pCtrl == "calbox" ){
            if( window.parent.Events[ Cal.FormatDate(PValue) ] != null ){
                PCellStr+= " bgcolor=gray align='center'>";
                PCellStr+="<a target=_parent href="+window.parent.pmdir+"pm.cgi?action=app_search&app="+ window.parent.app_name;
                PCellStr+="&bydate="+window.parent.app_field+"&fromdate=";
                PCellStr+=Cal.FormatDate(PValue)+"&todate="+Cal.FormatDate(PValue);
                PCellStr+="&sortby="+window.parent.app_field+">";
                PCellStr+="<font color=navy face='verdana' size='2'"+vHLstr1;
                PCellStr+= PValue + vHLstr2;
                PCellStr+= "</font>";
                PCellStr+= "</a>";
            } else {
                PCellStr+= " "+vColor+" align='center'><font face='verdana' size='2'"+vHLstr1+PValue+vHLstr2+"</font></td>";
            }
        }else{
            PCellStr+=" "+vColor+" align='center'><font face='verdana' size='2'"+vHLstr1+"<a href=\"javascript:winMain.document.getElementById('"+Cal.Ctrl+"').value='"+Cal.FormatDate(PValue)+"';"+vTimeStr+";window.close();\">"+PValue+"</a>"+vHLstr2+"</font></td>";
        }
	return PCellStr;
}

function Calendar(pDate,pCtrl)
{
	//Properties
	this.Date=pDate.getDate();//selected date
	this.Month=pDate.getMonth();//selected month number
	this.Year=pDate.getFullYear();//selected year in 4 digits
	this.Hours=pDate.getHours();	
	
	if (pDate.getMinutes()<10)
		this.Minutes="0"+pDate.getMinutes();
	else
		this.Minutes=pDate.getMinutes();
	
	//if (pDate.getSeconds()<10)
	//	this.Seconds="0"+pDate.getSeconds();
	//else		
	//	this.Seconds=pDate.getSeconds();
		
	this.MyWindow=winCal;
	this.Ctrl=pCtrl;
	this.Format="ddMMyyyy";
	this.Separator=DateSeparator;
	this.ShowTime=false;
	if (pDate.getHours()<12)
		this.AMorPM="AM";
	else
		this.AMorPM="PM";	
}

function GetMonthIndex(shortMonthName)
{
	for (i=0;i<12;i++)
	{
		if (MonthName[i].substring(0,3).toUpperCase()==shortMonthName.toUpperCase())
		{	return i;}
	}
}
Calendar.prototype.GetMonthIndex=GetMonthIndex;

function IncYear()
{	Cal.Year++;}
Calendar.prototype.IncYear=IncYear;

function DecYear()
{	Cal.Year--;}
Calendar.prototype.DecYear=DecYear;

function IncMonth()
{	
    if(Cal.Month==11) {
        Cal.Month=0; 
        Cal.Year++; 
    } else  {
        Cal.Month++;
    }
}
Calendar.prototype.IncMonth=IncMonth;

function DecMonth()
{
    if(Cal.Month==0) {
        Cal.Month=11; 
        Cal.Year--; 
    } else { 
        Cal.Month--;
    }
}
Calendar.prototype.DecMonth=DecMonth;

function SwitchMth(intMth)
{	Cal.Month=intMth;}
Calendar.prototype.SwitchMth=SwitchMth;

function SetHour(intHour)
{	
	var MaxHour;
	var MinHour;
	if (TimeMode==24)
	{	MaxHour=23;MinHour=0}
	else if (TimeMode==12)
	{	MaxHour=12;MinHour=1}
	else
		alert("TimeMode can only be 12 or 24");		
	var HourExp=new RegExp("^\\d\\d$");
	if (HourExp.test(intHour) && (parseInt(intHour,10)<=MaxHour) && (parseInt(intHour,10)>=MinHour))
	{	
		if ((TimeMode==12) && (Cal.AMorPM=="PM"))
		{
			if (parseInt(intHour,10)==12)
				Cal.Hours=12;
			else	
				Cal.Hours=parseInt(intHour,10)+12;
		}	
		else if ((TimeMode==12) && (Cal.AMorPM=="AM"))
		{
			if (intHour==12)
				intHour-=12;
			Cal.Hours=parseInt(intHour,10);
		}
		else if (TimeMode==24)
			Cal.Hours=parseInt(intHour,10);	
	}
}
Calendar.prototype.SetHour=SetHour;

function SetMinute(intMin)
{
	var MinExp=new RegExp("^\\d\\d$");
	if (MinExp.test(intMin) && (intMin<60))
		Cal.Minutes=intMin;
}
Calendar.prototype.SetMinute=SetMinute;

function SetSecond(intSec)
{	
	var SecExp=new RegExp("^\\d\\d$");
	if (SecExp.test(intSec) && (intSec<60))
		Cal.Seconds=intSec;
}
//Calendar.prototype.SetSecond=SetSecond;

function SetAmPm(pvalue)
{
	this.AMorPM=pvalue;
	if (pvalue=="PM")
	{
		this.Hours=(parseInt(this.Hours,10))+12;
		if (this.Hours==24)
			this.Hours=12;
	}	
	else if (pvalue=="AM")
		this.Hours-=12;	
}
Calendar.prototype.SetAmPm=SetAmPm;

function getShowHour()
{
	var finalHour;
    if (TimeMode==12)
    {
    	if (parseInt(this.Hours,10)==0)
		{
			this.AMorPM="AM";
			finalHour=parseInt(this.Hours,10)+12;	
		}
		else if (parseInt(this.Hours,10)==12)
		{
			this.AMorPM="PM";
			finalHour=12;
		}		
		else if (this.Hours>12)
		{
			this.AMorPM="PM";
			if ((this.Hours-12)<10)
				finalHour="0"+((parseInt(this.Hours,10))-12);
			else
				finalHour=parseInt(this.Hours,10)-12;	
		}
		else
		{
			this.AMorPM="AM";
			if (this.Hours<10)
				finalHour="0"+parseInt(this.Hours,10);
			else
				finalHour=this.Hours;	
		}
	}
	else if (TimeMode==24)
	{
		if (this.Hours<10)
			finalHour="0"+parseInt(this.Hours,10);
		else	
			finalHour=this.Hours;
	}	
	return finalHour;	
}				
Calendar.prototype.getShowHour=getShowHour;		

function GetMonthName(IsLong)
{
	var Month=MonthName[this.Month];
	if (IsLong)
		return Month;
	else
		return Month.substr(0,3);
}
Calendar.prototype.GetMonthName=GetMonthName;

function GetMonDays()//Get number of days in a month
{
	var DaysInMonth=[31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	if (this.IsLeapYear())
	{
		DaysInMonth[1]=29;
	}	
	return DaysInMonth[this.Month];	
}
Calendar.prototype.GetMonDays=GetMonDays;

function IsLeapYear()
{
	if ((this.Year%4)==0)
	{
		if ((this.Year%100==0) && (this.Year%400)!=0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	else
	{
		return false;
	}
}
Calendar.prototype.IsLeapYear=IsLeapYear;

function FormatDate(pDate)
{
	if (this.Format.toUpperCase()=="DDMMYYYY")
		return (pDate+DateSeparator+(this.Month+1)+DateSeparator+this.Year);
	else if (this.Format.toUpperCase()=="DDMMMYYYY")
		return (pDate+DateSeparator+this.GetMonthName(false)+DateSeparator+this.Year);
	else if (this.Format.toUpperCase()=="MMDDYYYY")
		return ((this.Month+1)+DateSeparator+pDate+DateSeparator+this.Year);
	else if (this.Format.toUpperCase()=="MMMDDYYYY")
		return (this.GetMonthName(false)+DateSeparator+pDate+DateSeparator+this.Year);			
}
Calendar.prototype.FormatDate=FormatDate;	
