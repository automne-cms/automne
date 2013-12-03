"use strict";

document.addEventListener("DOMContentLoaded", function(event) {
  var editorXml = CodeMirror.fromTextArea(document.getElementById('xml'), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
				tabSize: 2
  });
  var editorJson = CodeMirror.fromTextArea(document.getElementById('json'), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "javascript",
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
				tabSize: 2
  });
});