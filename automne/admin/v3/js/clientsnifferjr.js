// ClientSnifferJr Object Constructor
// Mike Foster, 12/12/01
// cross-browser.com

function ClientSnifferJr()
{
  this.ua = navigator.userAgent.toLowerCase();
  this.major = parseInt(navigator.appVersion);
  this.minor = parseFloat(navigator.appVersion);
  // DOM Support
  if (document.addEventListener && document.removeEventListener) this.dom2events = true;
  if (document.getElementById) this.dom1getbyid = true;
  // Opera
  this.opera = this.ua.indexOf('opera') != -1;
  if (this.opera) {
    this.opera5 = (this.ua.indexOf("opera 5") != -1 || this.ua.indexOf("opera/5") != -1);
    this.opera6 = (this.ua.indexOf("opera 6") != -1 || this.ua.indexOf("opera/6") != -1);
    return;
  }
  // Konqueror
  this.konq = this.ua.indexOf('konqueror') != -1;
  // MSIE
  this.ie = this.ua.indexOf('msie') != -1;
  if (this.ie) {
    this.ie3 = this.major < 4;
    this.ie4 = (this.major == 4 && this.ua.indexOf('msie 5') == -1 && this.ua.indexOf('msie 6') == -1);
    this.ie4up = this.major >= 4;
    this.ie5 = (this.major == 4 && this.ua.indexOf('msie 5.0') != -1);
    this.ie5up = !this.ie3 && !this.ie4;
    this.ie6 = (this.major == 4 && this.ua.indexOf('msie 6.0') != -1);
    this.ie6up = (!this.ie3 && !this.ie4 && !this.ie5 && this.ua.indexOf("msie 5.5") == -1);
    return;
  }
  // Misc.
  this.hotjava = this.ua.indexOf('hotjava') != -1;
  this.webtv = this.ua.indexOf('webtv') != -1;
  this.aol = this.ua.indexOf('aol') != -1;
  if (this.hotjava || this.webtv || this.aol) return;
  // Gecko, NN4+, and NS6
  this.gecko = this.ua.indexOf('gecko') != -1;
  this.nav = (this.ua.indexOf('mozilla') != -1 && this.ua.indexOf('spoofer') == -1 && this.ua.indexOf('compatible') == -1);
  if (this.nav) {
    this.nav4  = this.major == 4;
    this.nav4up= this.major >= 4;
    this.nav5up= this.major >= 5;
    this.nav6  = this.major == 5;
    this.nav6up= this.nav5up;
  }
}

window.is = new ClientSnifferJr();
