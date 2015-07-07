// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function f(){ log.history = log.history || []; log.history.push(arguments); if(this.console) { var args = arguments, newarr; args.callee = args.callee.caller; newarr = [].slice.call(args); if (typeof console.log === 'object') log.apply.call(console.log, console, newarr); else console.log.apply(console, newarr);}};

// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());
<!--Read More-->
$(".readmore").hide();
$.each($(".toggle"), function(){
	$(this).on("click", function(e){
		// use the prevent default and stop the propagation of the event // look to api docs for jQuery
		$(this).toggleClass("expanded");
		$(this).closest("div").find(".readmore").slideToggle();// could have hardened the structure with next/prev or other keyword transversal functions
	});
});
<!--End Read More-->
// place any jQuery/helper plugins in here, instead of separate, slower script files.
<!--Accordion Plugin-->
$(function() {
	$( "#accordion" ).accordion({
		collapsible: true,
		active:false,
		heightStyle: "content",
		icons:  {header: 'acc-plus', activeHeader: 'acc-minus', },
		beforeActivate: function( event, newPanel ) {
			$(".readmore").hide();
			$(".toggle").removeClass("expanded");

		}
	});
});

<!--End Accordion Plugin-->
<!--Accordion Plugin Default-->
$(function() {
	$( "#accordion2" ).accordion({
		heightStyle: "content",
		beforeActivate: function( event, newPanel ) {
			$(".readmore").hide();
			$(".toggle").removeClass("expanded");
		}
	});
});
<!--End Accordion Plugin Default-->
<!-- SubMenu-->
$(function() {
	$( "#accordion3" ).accordion({
		active:false,
		animate: false,
		navigation: true,
		collapsible: true,
		heightStyle: "content",
		header:'.accHeader',
		icons:  {header: 'acc-plus', activeHeader: 'acc-minus', },
	});
	$("#accordion3 li a").click(function() {
		window.location = $(this).attr('href');
		return false;

	});
});
$(function() {
	$( "#accordion4" ).accordion({
		active:false,
		animate:false,
		navigation: true,
		collapsible: true,
		heightStyle: "content",
		header:'.accHeader2',
		icons:  {header: 'acc-plus', activeHeader: 'acc-minus' }
	});
	$("#accordion4 li a").click(function() {
		window.location = $(this).attr('href');
		return false;

	});
});
$(function() {
	$( "#accordion5" ).accordion({
		active:false,
		animate:false,
		navigation: true,
		collapsible: true,
		heightStyle: "content",
		header:'.accHeader2',
		icons:  {header: 'acc-plus', activeHeader: 'acc-minus' }
	});
	$("#accordion5 li a").click(function() {
		window.location = $(this).attr('href');
		return false;

	});
});

$(function() {
	$( "#accordion6" ).accordion({
		active:false,
		animate:false,
		navigation: true,
		collapsible: true,
		heightStyle: "content",
		header:'.accHeader3',
		icons:  {header: 'acc-plus', activeHeader: 'acc-minus' }
	});
	$("#accordion6 li a").click(function() {
		window.location = $(this).attr('href');
		return false;

	});
});
$(function() {
	$( "#accordion7" ).accordion({
		active:false,
		animate:false,
		navigation: true,
		collapsible: true,
		heightStyle: "content",
		header:'.accHeader3',
		icons:  {header: 'acc-plus', activeHeader: 'acc-minus' }
	});
	$("#accordion7 li a").click(function() {
		window.location = $(this).attr('href');
		return false;

	});
});
<!--ADD ACTIVE TO LINKS-->
$(".secondaryMenu a").each(function() {
	if (this.href == window.location.href) {
		$(this).addClass("current");
	}
	else{
		$(this).addClass("joe");
	}
});
$(".secondaryMenu a[href]'").each(function() { if (this.href.toString().match(/^#/)) { $(this).removeClass("current"); } });
<!--End Accordion Plugin Submenu-->
(function( $ ){
	$.fn.mailcrypt = function( options ) {
		return this.each(function() {

			at = '@';
			// insert visivle @ sign
			$(':first-child',this).replaceWith(at);

			// get complete mail address
			email = $(this).html();

			// place mailto link in the href
			$(this).attr('href', 'mailto:'+email);
		});
	};
})( jQuery );