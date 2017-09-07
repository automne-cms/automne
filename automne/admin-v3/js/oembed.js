

document.addEventListener("DOMContentLoaded", function(event) {
  "use strict";
  var editor = CodeMirror.fromTextArea(
    document.getElementById('editor'), {
      lineNumbers: true,
      matchBrackets: true,
      mode: "application/x-httpd-php",
      indentWithTabs: true,
      lineWrapping: true,
      enterMode: "keep",
      tabMode: "shift",
			tabSize: 2
  });

  var indentButton = document.getElementById('reindent');
  indentButton.addEventListener('click',function() {
    editor.reindent();
  });

});