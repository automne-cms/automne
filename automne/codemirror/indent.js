// ============== Indentation extensions ============================
// Applies automatic mode-aware indentation to all document
CodeMirror.defineExtension("reindent", function () {
  var cmInstance = this;
  this.operation(function () {
    var lines = cmInstance.lineCount();
	for (var i = 0; i <= lines; i++) {
      cmInstance.indentLine(i);
    }
  });
});