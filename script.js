var overlay = jQuery('<div id="overlay"><div id="spinner"></div></div>');
overlay.appendTo(document.body)

var opts = {
  lines: 13, // The number of lines to draw
  length: 20, // The length of each line
  width: 10, // The line thickness
  radius: 30, // The radius of the inner circle
  corners: 1, // Corner roundness (0..1)
  rotate: 0, // The rotation offset
  direction: 1, // 1: clockwise, -1: counterclockwise
  color: '#FFF', // #rgb or #rrggbb or array of colors
  speed: 1, // Rounds per second
  trail: 90, // Afterglow percentage
  shadow: false, // Whether to render a shadow
  hwaccel: false, // Whether to use hardware acceleration
  className: 'spinner', // The CSS class to assign to the spinner
  zIndex: 2e9, // The z-index (defaults to 2000000000)
  top: 'auto', // Top position relative to parent in px
  left: 'auto' // Left position relative to parent in px
};
var target = document.getElementById('spinner');
var spinner = new Spinner(opts).spin(target);

function loadData() {
	
	$.ajax({
  			type: "GET",
  			url: "data.php",
			}).success(function(data) {
				
				//cache variables to speed up.
				var artist = data.artist;
				var title = data.title;
				
				$('.title').text(title);
				$('.artist').text(artist);
				$('#type').text(data.type);
				$('#overlay').fadeOut();
				$('.cover').css('background', 'url(' + data.cover + ')');
				$('#cover').attr('src', data.cover);
				$('.twitter').attr('href', 'https://twitter.com/intent/tweet?hashtags=nowplaying&text=' + encodeURIComponent(artist + ' - ' + title));
					
			});	

}

loadData();

setInterval(function() {
	loadData();
}, 10000);
