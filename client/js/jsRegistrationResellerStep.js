/*  File Name : jsRegistrationStep.js
 *  Description : Javascript file for registration step file
 *  Author  :Sushil Singh  Date: 26th,Nov,2010  Creation
*/
function buttonLinkAction(regStep)
{
    //alert(regStep);
	if(regStep==1)
    {
        document.getElementById("step1").disabled=true;
        document.getElementById("step1").className='register_inactive';

		document.getElementById("step3").className='register';
		document.getElementById("step6").className='register';

		//document.getElementById("step2").disabled=false;
        //document.getElementById("step6").disabled=false;

		  document.getElementById("step7").style.display='none';
          document.getElementById("step5").style.display='none';
          document.getElementById("step8").style.display='none';
          document.getElementById("offer").style.display='inline';
		
		/*
		document.getElementById("step2").disabled=false;
        document.getElementById("step6").disabled=false;
        document.getElementById("step1").className='register_inactive';
        document.getElementById("step6").className='register_inactive';
        document.getElementById("step2").className='register';
        document.getElementById("step7").style.display='none';
        document.getElementById("step5").style.display='none';
        document.getElementById("step8").style.display='none';
		*/

    // document.getElementById("offer").style.display='inline';
    }
    else
    if(regStep==2)
    {
        document.getElementById("step1").disabled=true;
        document.getElementById("step2").disabled=true;
        document.getElementById("step3").disabled=false;
        document.getElementById("step6").disabled=false;
        document.getElementById("step1").className='register_inactive';
        document.getElementById("step3").className='register'
        document.getElementById("step6").className='register'
        document.getElementById("offer").style.display='inline';
        document.getElementById("thanks").style.display='none';
         document.getElementById("step5").style.display='none';
        document.getElementById("step7").style.display='none';
         document.getElementById("step8").style.display='none';
    }
    else
    if(regStep==3)
    {
        document.getElementById("step1").disabled=true;
        document.getElementById("step2").disabled = true;
        document.getElementById("step5").disabled = false;
        document.getElementById("step3").disabled = false;
        document.getElementById("step4").disabled = false;
        document.getElementById("step6").disabled = false;
        document.getElementById("step7").disabled = false;
        document.getElementById("step1").className='register_inactive';
            
        document.getElementById("step4").className='register_inactive';
        document.getElementById("step6").className='register';
        document.getElementById("step7").className='none';
            
        document.getElementById("step5").className='none';
        document.getElementById("offer").style.display='none';
        document.getElementById("offer1").style.display='inline';
        document.getElementById("thanks").style.display='inline';
        document.getElementById("offer3").style.display='inline';
    }
    else
    if(regStep==4)
    {
        document.getElementById("step1").disabled=true;
        document.getElementById("step2").disabled = true;
        document.getElementById("step5").disabled = false;
        document.getElementById("step3").disabled = false;
        document.getElementById("step4").disabled = false;
        document.getElementById("step6").disabled = false;
        document.getElementById("step7").disabled = false;
        document.getElementById("step1").className='register_inactive';

        document.getElementById("step4").className='register_inactive';
        document.getElementById("step6").className='register';
        document.getElementById("step7").className='none';

        document.getElementById("step5").className='none';
        document.getElementById("offer").style.display='none';
        document.getElementById("offer2").style.display='inline';
        document.getElementById("thanks").style.display='inline';
        document.getElementById("offer3").style.display='inline';
    }else
    if(regStep==5)
    {
        document.getElementById("step1").disabled=true;
        document.getElementById("step2").disabled = true;
        document.getElementById("step3").disabled= true;
        document.getElementById("step5").style.display='none';
        document.getElementById("step6").disabled= false;
        document.getElementById("step8").style.display='none';
        document.getElementById("step1").className='register_inactive';
        document.getElementById("step3").className='register_inactive';
        //document.getElementById("step5").className='register_inactive';
        //document.getElementById("step3").className='register';
        document.getElementById("step4").className='register';
            
        document.getElementById("step6").className='register';
        document.getElementById("offer").style.display='none';
        document.getElementById("offer2").style.display='none';
        document.getElementById("offer3").style.display='none';
        document.getElementById("thanks").style.display='none';
        document.getElementById("store").style.display='inline';
        document.getElementById("step7").style.display='none';
    }
    else if(regStep==6)
    {
        document.getElementById("step1").className='register_inactive';
        document.getElementById("step6").className='register';
    }
	else if(regStep==8)
    {
        document.getElementById("step5").style.display='none';
         document.getElementById("step8").style.display='none';
         document.getElementById("step7").style.display='none';
        document.getElementById("step1").className='register';
        document.getElementById("step6").className='register_inactive';
    }

}