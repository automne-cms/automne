"use strict";

document.addEventListener("DOMContentLoaded", function(event) {
  console.log("DOM fully loaded and parsed");
  var editorXml = CodeMirror.fromTextArea(document.getElementById('definitionXml'), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
				tabSize: 2
  });
  var editorJson = CodeMirror.fromTextArea(document.getElementById('definitionJson'), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "javascript",
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
				tabSize: 2
  });
});