// JavaScript Document
$(document).ready(function(e) {
    $(".mainmu").mouseover(
		function()
		{
			$(this).children(".mw").stop().show()
		}
	)
	$(".mainmu").mouseout(
		function ()
		{
			$(this).children(".mw").hide()
		}
	)
});
function lo(x)
{
	location.replace(x)
}
function op(x,y,url)
{
	$(x).fadeIn()  //淡入
	if(y)		//如果有y，淡入
	$(y).fadeIn()
	if(y&&url)  //如果有y和url，載入url
	$(y).load(url)
}
function cl(x)
{
	$(x).fadeOut(); //淡出
}