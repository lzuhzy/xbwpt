function changetype(){
	torrenttype = document.upload.type2.value;
	dis(torrenttype);
}
function dis(id){
	$("cat01").style.display="none";
	$("cat02").style.display="none";
	$("cat03").style.display="none";
	$("cat04").style.display="none";
	$("cat05").style.display="none";
	$("cat06").style.display="none";
	$("cat07").style.display="none";
	$("cat08").style.display="none";
	$("cat09").style.display="none";
	$("cat10").style.display="none";
	$("cat11").style.display="none";
	$("cat12").style.display="none";
	$("cat13").style.display="none";
	$("cat0").style.display="none";
	
	if (Math.floor(id/1000)=="1")
	{
		$("cat01").style.display="";
	}
	else if (Math.floor(id/1000)=="2")
	{
		$("cat02").style.display="";
	}
	else if (Math.floor(id/1000)=="3")
	{
		$("cat03").style.display="";

	}
	else if (Math.floor(id/1000)=="4")
	{
		$("cat04").style.display="";
	}
	else if (Math.floor(id/1000)=="5")
	{
		$("cat05").style.display="";
	}
	else if (Math.floor(id/1000)=="6")
	{
		$("cat06").style.display="";
	}
	else if (Math.floor(id/1000)=="7")
	{
		$("cat07").style.display="";
	}
	else if (Math.floor(id/1000)=="8")
	{
		$("cat08").style.display="";
	}
	else if (Math.floor(id/1000)=="9")
	{
		$("cat09").style.display="";
	}
	else if (Math.floor(id/1000)=="10")
	{
		$("cat10").style.display="";
	}
	else if (Math.floor(id/1000)=="11")
	{
		$("cat11").style.display="";
	}
	else if (Math.floor(id/1000)=="12")
	{
		$("cat12").style.display="";
	}
	else if (Math.floor(id/1000)=="13")
	{
		$("cat13").style.display="";
	}
	else 
	{
		$("cat0").style.display="";
	}
}
