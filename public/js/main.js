

function deleteSkin(skin_id)
{
	$.ajax({
	  method: "POST",
	  url: base_url + "/delete/weapon",
	  data: { skin: skin_id, player: $("#player_id").val()
	  }
	})
	.done(function( msg ) {
		
		$("#alert").append(msg)
		$(".message-green").show("slow");
		$("#skin-"+skin_id).fadeOut();
		setTimeout(function(){
			$(".message-green").hide("slow");	
			$("#skin-"+skin_id).remove();
		},5000);
		setTimeout(function(){
			$(".message-green").remove();	
		},6000);
		
	});
}

$(function() {
    if($( window ).width() > 600)
	{
		var lastScrollTop = 0;
		$(window).scroll(function(event){
			
		   var st = $(this).scrollTop();
		   if (st > lastScrollTop){
			$("#nav").css("position", "relative");
			$("#nav").stop().animate({"top":  ($(window).scrollTop()) + "px", "marginLeft":($(window).scrollLeft()) + "px"}, {duration: "slow", done: function(){
			$("#nav").css("position", "relative");
			//$("#nav").css("top", "0px");
			$("#nav").css("left", "0px");
				}});
		   } else {
			
		   }
		   // lastScrollTop = st;
		});
	
	}
	setTimeout(function(){
		$(".message-green").hide("slow");
    },5000)
	
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})
		
	 $("img.weapon-delete").click(function(event) {
        deleteSkin(event.target.id);
    });
	
	
	/* mobile menu */
	var mobile = $( window ).width();
	$( window ).resize(function()
	{
		mobile = $( window ).width();
		if( mobile <  600)	{
			$('.nav').fadeOut('fast');
			$(".menu-burger").html('|||');
		}
		else
		{
			$('.nav').fadeIn('fast');			
		}
	}); 
	if( mobile <  600)
	{
		$('.nav').fadeOut('fast');
		
		$(".menu-burger").click(function() {
		  $('.nav').toggle('slow');
		  
		  if ($(".menu-burger").html() == '|||') {
			$(".menu-burger").fadeOut('fast');
			setTimeout(function() {
			  $(".menu-burger").html('X');
			  $(".menu-burger").fadeIn('fast');
			}, 500);

		  } else {
			$(".menu-burger").fadeOut('fast');
			setTimeout(function() {
			  $(".menu-burger").html('|||');
			  $(".menu-burger").fadeIn('fast');
			}, 500);
		  }
		});
	}
	else{ 
		$('.nav').fadeIn('fast');
		$(".menu-burger").html('|||');
	}
}); 
