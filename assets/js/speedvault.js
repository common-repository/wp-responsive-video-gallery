/*!
 * Speed Vault Video Gallery
 *
 * @author Hélio Chun - https://www.facebook.com/user128
 * JS code bug fix help by SergioCrisostomo - https://github.com/SergioCrisostomo
 * @version 1.1.0 - Square Base
 * @description Lazy load video gallery for Youtube, Vimeo and DailyMotion videos
 *
 * Inspired by a Stack Overflow question
 */

jQuery(document).ready(function($) {
	"use strict";
	var $svThumb = $('.svThumb');

	$('#svList').wrapAll('<div id="svBox"></div>');
	$('#svBox').prepend('<div class="svPlayer">\
	<div class="infoBox">\
	<div class="nowPlaying"></div>\
	</div>\
	</div>');
	// $('.svPlayer').append('<div class="infoBox"></div>');
	//$('.infoBox').prepend('<div class="nowPlaying"><h3 class="svTitle svTitleFix">Select a video from the gallery.</h3></div>');
	$svThumb.wrapInner('<div class="sv-text"></div>');
	$svThumb.prepend('<span class="sv-overlay"></span>');


	// Youtube Video
	$('.ytVideo').each(function() {
		var $videoID = $(this).attr('data-videoID'),
		$txt = $(this).text(),
		$ytVideo = $('<div class="meuVideo"> <iframe width="560" height="315" src="https://www.youtube.com/embed/' + $videoID + '?showinfo=1&autoplay=1" frameborder="0" allowfullscreen></iframe> </div>'),
		$ytThumb = $('<img src="https://img.youtube.com/vi/' + $videoID + '/mqdefault.jpg" data-anchor="svBox"/>');

		$(this).prepend($ytThumb);
		$(this).click(function() {
			$('.meuVideo, .nowPlaying').remove();
			$('.svPlayer').prepend($ytVideo).hide().slideDown("fast");
			$('.infoBox').prepend('<div class="nowPlaying"><h3 class="svTitle">'+ $txt +'</h3></div>');
			return false;
		});
	});

	// Vimeo Video
	jQuery('.vimeoVideo').each(function($) {
		var $videoID = jQuery(this).attr('data-videoID'),
		$txt = jQuery(this).text(),
		$vimeoVideo = jQuery('<div class="meuVideo"> <iframe src="https://player.vimeo.com/video/' + $videoID + '?title=1&byline=1&portrait=1&badge=1&autoplay=1" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> </div>'),
		$thisElHack = this;

		jQuery.getJSON('https://vimeo.com/api/v2/video/' + $videoID + '.json?callback=?', {
			format: "json"
		}, function(data) {
			var $vimeoThumb = data[0].thumbnail_large;
			jQuery($thisElHack).prepend('<img src="' + $vimeoThumb + '" width="268" data-anchor="svBox"/>');
		});

		jQuery(this).click(function($) {
			jQuery('.meuVideo, .nowPlaying').remove();
			jQuery('.svPlayer').prepend($vimeoVideo).hide().slideDown("fast");
			jQuery('.infoBox').prepend('<div class="nowPlaying"><h3 class="svTitle">'+ $txt +'</h3></div>');
			return false;
		});
	});

	// DailyMotion Video
	jQuery('.dailyMVideo').each(function($) {
		var $videoID = jQuery(this).attr('data-videoID'),
		$txt = jQuery(this).text(),
		$dailyMVideo = jQuery('<div class="meuVideo"> <iframe frameborder="0" width="640" height="360" src="//www.dailymotion.com/embed/video/' + $videoID + '?autoplay=1" allowfullscreen></iframe> </div>'),
		$thisElHack = this;

		jQuery.getJSON('https://api.dailymotion.com/video/' + $videoID + '?fields=id,thumbnail_url', function(data) {
			var $dailyMThumb = data.thumbnail_url;
			jQuery($thisElHack).prepend('<img src="' + $dailyMThumb + '" width="268" data-anchor="svBox"/>');
		});

		jQuery(this).click(function($) {
			jQuery('.meuVideo, .nowPlaying').remove();
			jQuery('.svPlayer').prepend($dailyMVideo).hide().slideDown("fast");
			jQuery('.infoBox').prepend('<div class="nowPlaying"><h3 class="svTitle">'+ $txt +'</h3></div>');
			return false;
		});
	});



	jQuery('.svThumb').click(function($) {

		var $thumbPath2 = jQuery('.svThumb img').attr("data-anchor"),
		$thumbAnchor2 = jQuery("#" + $thumbPath2),
		$leftAbsolute2 = jQuery(".html,body");

		jQuery('.closeUiBtn').remove();
		jQuery('#svBox').prepend('<div class="closeUiBtn">&times;</div>');
		return false;
	});
	// Fechar Videos
	jQuery( document ).on( 'click', '.closeUiBtn', function($) {
		jQuery('.meuVideo, .nowPlaying, .closeUiBtn').remove();
		return false;
	});
});

