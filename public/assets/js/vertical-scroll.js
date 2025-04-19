$(function () {
	$(".vertical-scroll").bootstrapNews({
		newsPerPage: 6,
		autoplay: true,
		pauseOnHover: true,
		navigation: false,
		direction: 'down',
		newsTickerInterval: 2500,
		onToDo: function () {
			//console.log(this);
		}
	});
	$(".vertical-scroll1").bootstrapNews({
		newsPerPage: 2,
		autoplay: true,
		pauseOnHover: true,
		navigation: false,
		direction: 'down',
		newsTickerInterval: 2500,
		onToDo: function () {
			//console.log(this);
		}
	});
});