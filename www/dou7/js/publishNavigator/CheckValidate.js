
		var Pass = new Array();

/**
 Array Argument Pattern for  CheckValidate()
 *      CheckValidate
 		(
 			formId, 
 			numField , 
 			{FieldName_1, ... , FieldName_n} , 
 			{FieldTitle_1 , ... , FieldTitle_n} , ... , 
 			{FieldValue_1 , ... FieldValue_n}
 			[,'preview'	] @ For Preview Only		
 		) 				
*/
function CheckValidate(){
		


		var notSubmit =0;
		var FieldEr= "";
		var num = arguments[1] - 1; // numField -1
		var formElement = document.getElementById('formId' + arguments[0]);		
		var formLength = formElement.elements.length;
		var preview = arguments[arguments.length -1];


		var FieldName=new Array();
		var FieldValue=new Array();
		var FieldTitle=new Array();
		var argId = 2;
		
		for(FNameId = 0 ; FNameId <= num ; FNameId++){
			FieldName[FNameId] = arguments[argId];
			argId ++; 

		}
		
		for(FTitleId = 0 ; FTitleId <= num ; FTitleId++){
			FieldTitle[FTitleId] = arguments[argId];
			argId ++;

		}
		
		for(FValueId = 0 ; FValueId <= num ; FValueId++){
			FieldValue[FValueId] = arguments[argId];
			argId ++;

		}				


		for(i=0;i<=num;i++){
				aName = FieldName[i] ; 
				type = FieldValue[i] ; 
				title = FieldTitle[i] ;
				
				for(j=0;j<=formLength-1;j++){
				
					if(formElement.elements[j].name == aName){

							validateObj = formElement.elements[j]; 	
							objValue = validateObj.value;	

							Pass[0] = CheckNotNull(type,objValue);
							Pass[1] = CheckEmail(type,objValue);
							Pass[2] = CheckNumeric(type,objValue);
							Pass[3] = CheckChar(type,objValue);
							Pass[4] = CheckNumChar(type,objValue);
							SumPass = Pass[0]+Pass[1]+Pass[2]+Pass[3]+Pass[4];

							
							if(SumPass==1){
							//alert(type +" = "+ SumPass);
							//alert(Pass[0]+","+Pass[1]+","+Pass[2]+","+Pass[3]+","+Pass[4]);
								 if(type=="Numeric"){ errTypeText = "numeric"; }
								 else if(type=="NotNull"){ errTypeText = "not null"; }
								 else if(type=="Character"){ errTypeText = "character"; }
								 else if(type=="Email"){ errTypeText = "e-mail"; }
								 else if(type=="NumericCharacter"){ errTypeText = "numeric or character"; }
								 else { errTypeText = type; }								 								 								 
								 								 											 
								 FieldEr = FieldEr + "- " + title + " must be " + errTypeText + ".\n" ;
								 notSubmit=1;
							
							}						
														
					}//  formElement	
			
			}// formLength 
			
		}// num

				if(notSubmit==1){
						alert("Invalid Field Value!\n" + FieldEr);
						return false;
				}
				else if(notSubmit==0 & preview == "preview"){
						alert("Form is submitted.");						
				}


}

function CheckNotNull(type,objValue){
				notPass = 0;
				if(type=="NotNull" & objValue==""){
						notPass = 1;
				}
				return (notPass);
}
function CheckEmail(type,objValue){
				notPass = 0;
				if(type=="Email"& objValue!=""){
						AssPost = objValue.indexOf("@");
						DotText = objValue.substring(AssPost);
						DotPost = DotText.indexOf(".");
						AftDotTxt = DotText.substring(DotPost);
						if(AssPost != -1){
								if(DotPost != -1 & DotPost !=1){
											if(AftDotTxt.length ==1){
													notPass = 1; //alert("Not .com");								
											}
								}
								else {
										notPass = 1; 	//alert("Not Dot Or Domain");											
								}
						}
						else {
										notPass=1;//alert("Not @");													
						}
						
				 		if(notPass==1){
				 				//alert("The " + title + " is must E-mail Address! e.g. uname@email.com");	
								notPass = 1;			
				 		}
						
				}
				return (notPass);
}

function CheckNumeric(type,objValue){				
				notPass = 0;
				if(type=="Numeric"){
						isNum = objValue /1;
						if(isNum != objValue){
									//alert("The " + title + " is must Numeric!");				
									notPass = 1;		
						}
				}
				return (notPass);								
}

function CheckChar(type,objValue){
				notPass = 0;
				if(type=="Character" & objValue!=""){ 
						SpChar = new Array("!","@","#","$","%","^","&","*",")","(","]","[","}","{","+","/","?",">","<","=","|",".",":",";","\,");
						for(m=0;m<=SpChar.length;m++){
							isChar = objValue.indexOf(SpChar[m]);
							if(isChar!=-1){
								notPass=1; 
							}
						}
						
						isNum = objValue /1;
						if(isNum == objValue){
								notPass=1;		
						}						
												
				 		if(notPass==1){
				 				//alert("The " + title + " is must Character");				
								notPass = 1;
				 		}						
						
				}
				return (notPass);							
}

function CheckNumChar(type,objValue){	
				notPass = 0;
				if(type=="NumericCharacter"){
						SpChar = new Array("!","@","#","$","%","^","&","*",")","(","]","[","}","{","+","/","?",">","<","=","|",".",":",";","\,");
						for(k=SpChar.length;k>=0;k--){
							isChar = objValue.indexOf(SpChar[k]);
							if(isChar!=-1){
								notPass=1; 
							}
						}
				 		if(notPass==1){
				 				//alert("The " + title + " is must Numeric or Character");			
								notPass = 1;				 					
				 		}
						
				}
				return (notPass);								
}

function CheckedBox(type,obj){
				notPass = 0;
				validateObj = document.getElementById(obj); 			
				if(type=="Checked"){
						if(validateObj.checked==false){
								notPass =1;						
						}
				}
				return (notPass);												
}	

function Multi(){
var week = new Array()

week[1]= new Array("TUTORIAL 1","TUTORIAL 2" )

alert(week[1]);

}