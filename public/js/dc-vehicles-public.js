jQuery(document).ready(function ( $ ) {

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$('#tax-locations').on('change', function () {
		let location = $(this).find('option:selected').val();
		setGetParameter('location', location);
	});

	function setGetParameter(paramName, paramValue)
	{
		let url = window.location.href;
		let hash = location.hash;
		url = url.replace(hash, '');

		if (url.indexOf(paramName + "=") >= 0)
		{
			var prefix = url.substring(0, url.indexOf(paramName + "="));
			var suffix = url.substring(url.indexOf(paramName + "="));
			suffix = suffix.substring(suffix.indexOf("=") + 1);
			suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
			url = prefix + paramName + "=" + paramValue + suffix;
		}
		else
		{
			if (url.indexOf("?") < 0)
				url += "?" + paramName + "=" + paramValue;
			else
				url += "&" + paramName + "=" + paramValue;
		}

		window.location.href = url + hash;
	}

});
