// airlogger.js


function yeargen(json) {
	// body...
	// console.log(json);
	//alert('append');
	var keys = [];
  	for(var k in json) keys.push(k);
  	// console.log("total " + keys.length + " keys: " + keys);

  	// $('#year_gen').append($('<li/>', {text:}));
  	var monthMap = ["January", "Feburary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  	// keys.sort();
  	// keys.sort(function(a,b) { return parseFloat(a.hour) - parseFloat(b.hour) } );
  	for (var i = 0; i < keys.length; i++) {
  		//alert(json[i]);
  		$('#year_nav').append($('<li/>', {class:'dropdown'})
  			.append($('<a/>', {href:'', class:'dropdown-toggle year', id:keys[i], 'data-toggle':'dropdown', text:keys[i]})
  				.append($('<span/>', {class: 'caret'})))
  			.append($('<ul>', {id:keys[i], class:'dropdown-menu', role: 'menu'})));	

  		  	// do the month gen now
  			
  			var months = json[keys[i]];
  			// console.log(months);
  			
  			months.sort(function(a,b) {return a - b} );

  			for (var j = 0; j < months.length; j++) {
  		  		//alert(json[i]);
  		  		$("ul[id*=" + keys[i] + "]").append($('<li/>', {})
  		  			.append($('<a/>', {class:'mon', onclick:'return false', id:months[j] + "#" + keys[i], text:monthMap[months[j] - 1]})));
  		  	}
  	
  	}

}

function calInit(){

	var d = new Date();
	var temp = d.getMonth() + 1;
	var mes = temp + '#' + d.getFullYear();
	// alert(mes);
    $.ajax({
      type: "POST",
      url: "airlogger.php",
      dataType: "json",
      data: {data : mes}, 
      success: function(data) {
        // console.log("message"); 
        // console.log(data);

        getDaysInMonth(data, d.getFullYear(), temp);
      },
      error: function(){
      	alert('fuck');
      } 
    });
}

function getDaysInMonth(data, yr, mn){
	// console.log(data);
	$("#cal").empty();
	// add cal
	$("#cal").append($("<div/>", {id:'my-calendar'}));


	$("#my-calendar").zabuto_calendar({language: "en", year: yr, month: mn, show_previous: false, show_next: false, today:true, 
		action: function () {
			// console.log(data);
			var day = dateParser(this.id)
			mediaGenerator(data, day, mn, yr);
            return 0;
        }});
}

function dateParser (id) {
	// body...
	//console.log(id);
	var date = id.split('_');
	//console.log(date[3]);
	var day = date[3].split('-');
	return parseInt(day[2]);
}

function titleMaker(hr, minute, year, day, month){
	var monthMap = ["January", "Feburary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	var title;
	// alert(hr + '  ' + min);
	if(minute < 10){
		var min = "0" + minute;
	} else{
		var min = minute;
	}if(hr == 0){
		title = monthMap[month - 1];
		title += " ";
		title += day;
		title += ", ";
		title += 12;
		title += ":";
		title += min;
		title += "am";
		title += " ";
		title += year;

	}else if(hr > 12){
		title = monthMap[month - 1];
		title += " ";
		title += day;
		title += ", ";
		title += hr % 12;
		title += ":";
		title += min;
		title += "pm";
		title += " ";
		title += year;
	} else {
		title = monthMap[month - 1];
		title += " ";
		title += day;
		title += ", ";
		title += hr;
		title += ":";
		title += min;
		title += "am";
		title += " ";
		title += year;
	}
	// console.log(title);
	return title;
}



function mediaGenerator(data, day, month, yr){
	$("#shows").empty();
	
	var focus = data[day];
	//console.log(focus);
	
	//console.log(focus);

	if(focus !== undefined){
		focus.sort(function(a,b) { return parseFloat(a.hour) - parseFloat(b.hour) } );

		for (var i = 0; i < focus.length; i++) {
			// alert(titleMaker(focus[i]['hour'],focus[i]['minute'],focus[i]['year'],focus[i]['day'],focus[i]['month']));
			$("#shows")
				// wraps whole thing
				.append($("<div/>", {class:'container'})
					// wraps next layer
					.append($("<div/>", {class:'col-xs-6', id:'results'})
						// need to wrap the form!
						.append($("<form/>", {role:'form', method:'get', action:''})
							// the text of the file
							.append($("<div/>", {class:'form-group'})
								.append($("<h3/>", {text:titleMaker(focus[i]['hour'],focus[i]['minute'],focus[i]['year'],focus[i]['day'],focus[i]['month'])}))
							)
							.append($("<div/>", {class:'form-group play'})
								.append($("<audio preload='none' controls/>", {class:'audio'})
									.append($("<source/>", {id:focus[i]['mp3'],src:'/' + focus[i]['mp3'], type:'audio/mpeg'})))
							)
							
						)
						.append($("<a/>", {class:'down', href:focus[i]['mp3'], download:day +"-" +focus[i]['hour']+"-"+focus[i]['month']+"-"+focus[i]['year']+".mp3", text:'Download'}))
						// .append($("<a/>", {class:'stream', text: 'Listen', onclick:'return false'}))
					)
				);
		};
		// $(".audio").hide();
		// $('.stream').click(function(){

		//   alert('sanity');
		//   //$(this).closest('div.play').find('.audio').show();// .css('background-color', "green");
		//   // console.log($div);
		//   $div.show();
		// });
		
	} else {
		var monthMap = ["January", "Feburary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	
		$("#shows")
			// wraps whole thing
			.append($("<div/>", {class:'container'})
				// wraps next layer
				.append($("<div/>", {class:'col-xs-6', id:'results'})
					// need to wrap the form!
					.append($("<h3/>",{text: 'No shows on ' + monthMap[month - 1] + ' ' + day + ' ' + yr}))

				)
			);

	}



	// console.log(data[day]);
	



}

// when this is clicked, we need to call a function that will make the 
// days of the month appear

$('.month').click(function(){
	var keys = [];
  	for(var k in ar) keys.push(k);
  	console.log("total " + keys.length + " keys: " + keys);
});





