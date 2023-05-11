document.createElement("light");

// Screen height and width
var h = window.innerHeight;
var w = window.innerWidth;

document.getElementById('table').style.width = w+'px';
document.getElementById('table').style.height = h+'px';

//variabls
var copy = document.registerElement('copyright');
document.body.appendChild(new Copy());

var footert = document.registerElement('footer-title');
document.body.appendChild(new footert);

var footer_sub = document.registerElement('sub-title');
document.body.appendChild(new footer_sub);

var footer_des = document.registerElement('description');
document.body.appendChild(new footer_des);

var white = document.registerElement('white');
document.body.appendChild(new white); 

var thh = document.registerElement('tb-head');
document.body.appendChild(new thh); 

/*function dropdown()
{
	$("#dropdown").addClass("nav-ul");
}
$('#dropdownkey').click(function(){
    $("#dropdown").addClass("nav-ul");
    
});
$('#nav-close').click(function(){
    $("#dropdown").css("visblity","hidden");
    
});
*/
$('#nav-close').click(function(){
    $("#manu").css("visblity","hidden");
    
});
function dropdown(ids)
	{
			var id = '#'+ids;
			$(id).css("display","block");
	}
	function dropdown_close(idss)
	{
		var id2 = '#'+idss;
		$(id2).css("display","none");
	}

function show(show)
	{
			var id = '#'+show;
			$(id).css("display","inline-block");
	}
	function hide(hide)
	{
		var id2 = '#'+hide;
		$(id2).css("display","none");
	}