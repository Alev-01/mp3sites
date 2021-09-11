function search_find(){
	
	var word = $('#q').val();
	
	var search_word = "q="+word;
	
	$('#results').html('<center><img src="images/loader.gif" style="padding:10px;" /></center>');
	$.ajax({
		type: "POST",
		url: "search.php",
		data: search_word,
		success: function(result){
			$('#results').html(''+result+'');	
		}
	});
	
}

function play(id){
	
	var veriler = "id="+id;
	
	$('#player').html('<img src="images/loader2.gif" />');
	$.ajax({
		type: "POST",
		url: "play.php",
		data: veriler,
		success: function(msg){
			$('#player').html(''+msg+'');	
		}
	});	
}

function registerUser(){
	
	var users = $('form').serialize();
	
	$('#registerSuccess').html('<img src="images/loader.gif" />');
	$.ajax({
		type: "POST",
		url: "register.php?do=register",
		data: users,
		success: function(msg){
			$('#registerSuccess').html(''+msg+'');	
		}
	});	
}

function loginUser(){
	
	var userVar = $('form').serialize();
	
	$('#loginSuccess').html('<img src="images/loader.gif" />');
	$.ajax({
		type: "POST",
		url: "login.php?do=login",
		data: userVar,
		success: function(userSuccess){
			$('#loginSuccess').html(''+userSuccess+'');	
		}
	});	
}