/*!
 * webfontloader.js
 *
 * Google Webfont Loader, used for asynchronous loading of webfonts.
 * The classes '.wf-loading', '.wf-active', and '.wf-inactive' can be used to
 * hide/display content to prevent the FOUT.
 */


// Configure the webfonts in this object,
window.WebFontConfig = {
  google: {
    families: ['Open+Sans:400italic,400,300,700:latin']
  },
  // typekit: {
  //   id: 'xxxxxx'
  // }
};


// Google's loading script.
(function() {
  var wf = document.createElement('script');
  wf.src = ('https:' === document.location.protocol ? 'https' : 'http') +
    '://ajax.googleapis.com/ajax/libs/webfont/1.5.3/webfont.js';
  wf.type = 'text/javascript';
  wf.async = 'true';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(wf, s);
})();
