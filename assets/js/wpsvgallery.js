jQuery(document).ready(function($){
	"use strict";
	
	$('.metabox_submit').click(function() {
		e.preventDefault();
		$('#publish').click();
	});
	$('#add-row').on('click', function() {
		var row = $('.empty-row.screen-reader-text').clone(true);
		row.removeClass('empty-row screen-reader-text');
		row.insertBefore('#repeatable-fieldset-one tbody>tr:last');
		return false;
	});
	$('.remove-row').on('click', function() {
		$(this).parents('tr').remove();
		return false;
	});
/* 	$('#repeatable-fieldset-one tbody').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.sort'
	}); */
	
	$( "a.sort, #wpsvgallery_grayscale" ).click(function() {
		$.iaoAlert({

		  // default message
		  msg: "Sorry This Features Only For Premium Version.",

		  // or 'success', 'error', 'warning'
		  type: "error",

		  // or dark
		  mode: "dark",

		  // auto hide
		  autoHide: true,

		  // fade animation speed
		  fadeTime: "500",

		  // shows close button
		  closeButton: true,

		  // close on click
		  closeOnClick: false,

		  // custom position
		  position: 'bottom-right',

		  // fade on hover
		  fadeOnHover: true,

		  // z-index
		  zIndex: '999'

		})
	});
		
});