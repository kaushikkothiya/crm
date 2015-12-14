(function(d) {
  "function" === typeof define && define.amd ? define(["jquery"], function(f) {
    d(f, window, document);
  }) : d(jQuery, window, document);
})(function(d, f, p, q) {
  function l(a, b) {
    this.element = a;
    this.options = d.extend({}, r, b);
    this._defaults = r;
    this.ns = ".intlTelInput" + u++;
    this.isGoodBrowser = Boolean(a.setSelectionRange);
    this.hadInitialPlaceholder = Boolean(d(a).attr("placeholder"));
    this._name = "intlTelInput";
    this.init();
  }
  var u = 1, r = {autoFormat:!0, autoHideDialCode:!0, defaultCountry:"", ipinfoToken:"", nationalMode:!1, numberType:"MOBILE", onlyCountries:[], preferredCountries:[], responsiveDropdown:!1, utilsScript:""}, t = !1;
  d(f).load(function() {
    t = !0;
  });
  l.prototype = {init:function() {
    var a = this;
    if ("auto" == this.options.defaultCountry) {
      this.options.defaultCountry = "";
      var b = "//ipinfo.io";
      this.options.ipinfoToken && (b += "?token=" + this.options.ipinfoToken);
      d.get(b, function(b) {
        b && b.country && (a.options.defaultCountry = b.country.toLowerCase());
      }, "jsonp").always(function() {
        a._ready();
      });
    } else {
      this._ready();
    }
  }, _ready:function() {
    this.options.nationalMode && (this.options.autoHideDialCode = !1);
    navigator.userAgent.match(/IEMobile/i) && (this.options.autoFormat = !1);
    500 > f.innerWidth && (this.options.responsiveDropdown = !0);
    this._processCountryData();
    this._generateMarkup();
    this._setInitialState();
    this._initListeners();
  }, _processCountryData:function() {
    this._setInstanceCountryData();
    this._setPreferredCountries();
  }, _addCountryCode:function(a, b, c) {
    b in this.countryCodes || (this.countryCodes[b] = []);
    this.countryCodes[b][c || 0] = a;
  }, _setInstanceCountryData:function() {
    var a;
    if (this.options.onlyCountries.length) {
      for (this.countries = [], a = 0;a < g.length;a++) {
        -1 != d.inArray(g[a].iso2, this.options.onlyCountries) && this.countries.push(g[a]);
      }
    } else {
      this.countries = g;
    }
    this.countryCodes = {};
    for (a = 0;a < this.countries.length;a++) {
      var b = this.countries[a];
      this._addCountryCode(b.iso2, b.dialCode, b.priority);
      if (b.areaCodes) {
        for (var c = 0;c < b.areaCodes.length;c++) {
          this._addCountryCode(b.iso2, b.dialCode + b.areaCodes[c]);
        }
      }
    }
  }, _setPreferredCountries:function() {
    this.preferredCountries = [];
    for (var a = 0;a < this.options.preferredCountries.length;a++) {
      var b = this._getCountryData(this.options.preferredCountries[a], !1, !0);
      b && this.preferredCountries.push(b);
    }
  }, _generateMarkup:function() {
    this.telInput = d(this.element);
    this.telInput.wrap(d("<div>", {"class":"intl-tel-input"}));
    var a = d("<div>", {"class":"flag-dropdown"}).insertAfter(this.telInput), b = d("<div>", {"class":"selected-flag"}).appendTo(a);
    this.selectedFlagInner = d("<div>", {"class":"flag"}).appendTo(b);
    d("<div>", {"class":"arrow"}).appendTo(this.selectedFlagInner);
    this.countryList = d("<ul>", {"class":"country-list v-hide"}).appendTo(a);
    this.preferredCountries.length && (this._appendListItems(this.preferredCountries, "preferred"), d("<li>", {"class":"divider"}).appendTo(this.countryList));
    this._appendListItems(this.countries, "");
    this.dropdownHeight = this.countryList.outerHeight();
    this.countryList.removeClass("v-hide").addClass("hide");
    this.options.responsiveDropdown && this.countryList.outerWidth(this.telInput.outerWidth());
    this.countryListItems = this.countryList.children(".country");
  }, _appendListItems:function(a, b) {
    for (var c = "", e = 0;e < a.length;e++) {
      var d = a[e], c = c + ("<li class='country " + b + "' data-dial-code='" + d.dialCode + "' data-country-code='" + d.iso2 + "'>"), c = c + ("<div class='flag " + d.iso2 + "'></div>"), c = c + ("<span class='country-name'>" + d.name + "</span>"), c = c + ("<span class='dial-code'>+" + d.dialCode + "</span>"), c = c + "</li>"
    }
    this.countryList.append(c);
  }, _setInitialState:function() {
    var a = this.telInput.val();
    if (this._getDialCode(a)) {
      this._updateFlagFromNumber(a);
    } else {
      var b;
      b = this.options.defaultCountry ? this._getCountryData(this.options.defaultCountry, !1, !1) : this.preferredCountries.length ? this.preferredCountries[0] : this.countries[0];
      this._selectFlag(b.iso2);
      a || this._updateDialCode(b.dialCode, !1);
    }
    a && this._updateVal(a, !1);
  }, _initListeners:function() {
    var a = this;
    this._initKeyListeners();
    (this.options.autoHideDialCode || this.options.autoFormat) && this._initFocusListeners();
    var b = this.telInput.closest("label");
    if (b.length) {
      b.on("click" + this.ns, function(b) {
        a.countryList.hasClass("hide") ? a.telInput.focus() : b.preventDefault();
      });
    }
    this.selectedFlagInner.parent().on("click" + this.ns, function(b) {
      a.countryList.hasClass("hide") && !a.telInput.prop("disabled") && a._showDropdown();
    });
    this.options.utilsScript && (t ? this.loadUtils() : d(f).load(function() {
      a.loadUtils();
    }));
  }, _initKeyListeners:function() {
    var a = this;
    if (this.options.autoFormat) {
      this.telInput.on("keypress" + this.ns, function(b) {
        if (32 <= b.which && !b.metaKey && f.intlTelInputUtils) {
          b.preventDefault();
          var c = 48 <= b.which && 57 >= b.which || 43 == b.which, e = a.telInput[0], e = a.isGoodBrowser && e.selectionStart == e.selectionEnd, d = a.telInput.attr("maxlength");
          (d ? a.telInput.val().length < d : 1) && (c || e) && (b = c ? String.fromCharCode(b.which) : null, a._handleInputKey(b, !0));
          c || a.telInput.trigger("invalidkey");
        }
      });
    }
    this.telInput.on("keyup" + this.ns, function(b) {
      if (13 != b.which) {
        if (a.options.autoFormat && f.intlTelInputUtils) {
          var c = 17 == b.which || 91 == b.which || 224 == b.which, e = a.telInput[0], d = a.isGoodBrowser && e.selectionStart == e.selectionEnd, g = a.isGoodBrowser && e.selectionStart == a.telInput.val().length;
          (46 == b.which && !g || 8 == b.which || c && d) && a._handleInputKey(null, c && g);
          a.options.nationalMode || (b = a.telInput.val(), "+" != b.substr(0, 1) && (c = a.isGoodBrowser ? e.selectionStart + 1 : 0, a.telInput.val("+" + b), a.isGoodBrowser && e.setSelectionRange(c, c)));
        } else {
          a._updateFlagFromNumber(a.telInput.val());
        }
      }
    });
  }, _handleInputKey:function(a, b) {
    var c = this.telInput.val(), e = null, d = !1, f = this.telInput[0];
    if (this.isGoodBrowser) {
      var g = f.selectionEnd, k = c.length, d = g == k;
      a ? (c = c.substr(0, f.selectionStart) + a + c.substring(g, k), d || (e = g + (c.length - k))) : e = f.selectionStart;
    } else {
      a && (c += a);
    }
    this.setNumber(c, b);
    this.isGoodBrowser && (d && (e = this.telInput.val().length), f.setSelectionRange(e, e));
  }, _initFocusListeners:function() {
    var a = this;
    if (this.options.autoHideDialCode) {
      this.telInput.on("mousedown" + this.ns, function(b) {
        a.telInput.is(":focus") || a.telInput.val() || (b.preventDefault(), a.telInput.focus());
      });
    }
    this.telInput.on("focus" + this.ns, function() {
      var b = a.telInput.val();
      a.telInput.data("focusVal", b);
      a.options.autoHideDialCode && !b && (a._updateVal("+" + a.selectedCountryData.dialCode, !0), a.telInput.one("keypress.plus" + a.ns, function(b) {
        43 == b.which && a.telInput.val(a.options.autoFormat && f.intlTelInputUtils ? "+" : "");
      }), setTimeout(function() {
        var b = a.telInput[0];
        if (a.isGoodBrowser) {
          var e = a.telInput.val().length;
          b.setSelectionRange(e, e);
        }
      }));
    });
    this.telInput.on("blur" + this.ns, function() {
      if (a.options.autoHideDialCode) {
        var b = a.telInput.val();
        "+" == b.substr(0, 1) && ((b = a._getNumeric(b)) && a.selectedCountryData.dialCode != b || a.telInput.val(""));
        a.telInput.off("keypress.plus" + a.ns);
      }
      a.options.autoFormat && f.intlTelInputUtils && a.telInput.val() != a.telInput.data("focusVal") && a.telInput.trigger("change");
    });
  }, _getNumeric:function(a) {
    return a.replace(/\D/g, "");
  }, _showDropdown:function() {
    this._setDropdownPosition();
    var a = this.countryList.children(".active");
    this._highlightListItem(a);
    this.countryList.removeClass("hide");
    this._scrollTo(a);
    this._bindDropdownListeners();
    this.selectedFlagInner.children(".arrow").addClass("up");
  }, _setDropdownPosition:function() {
    var a = this.telInput.offset().top, b = d(f).scrollTop(), c = a + this.telInput.outerHeight() + this.dropdownHeight < b + d(f).height(), a = a - this.dropdownHeight > b;
    this.countryList.css("top", !c && a ? "-" + (this.dropdownHeight - 1) + "px" : "");
  }, _bindDropdownListeners:function() {
    var a = this;
    this.countryList.on("mouseover" + this.ns, ".country", function(b) {
      a._highlightListItem(d(this));
    });
    this.countryList.on("click" + this.ns, ".country", function(b) {
      a._selectListItem(d(this));
    });
    var b = !0;
    d("html").on("click" + this.ns, function(c) {
      b || a._closeDropdown();
      b = !1;
    });
    var c = "", e = null;
    d(p).on("keydown" + this.ns, function(b) {
      b.preventDefault();
      if (38 == b.which || 40 == b.which) {
        a._handleUpDownKey(b.which);
      } else {
        if (13 == b.which) {
          a._handleEnterKey();
        } else {
          if (27 == b.which) {
            a._closeDropdown();
          } else {
            if (65 <= b.which && 90 >= b.which || 32 == b.which) {
              e && clearTimeout(e), c += String.fromCharCode(b.which), a._searchForCountry(c), e = setTimeout(function() {
                c = "";
              }, 1E3);
            }
          }
        }
      }
    });
  }, _handleUpDownKey:function(a) {
    var b = this.countryList.children(".highlight").first(), b = 38 == a ? b.prev() : b.next();
    b.length && (b.hasClass("divider") && (b = 38 == a ? b.prev() : b.next()), this._highlightListItem(b), this._scrollTo(b));
  }, _handleEnterKey:function() {
    var a = this.countryList.children(".highlight").first();
    a.length && this._selectListItem(a);
  }, _searchForCountry:function(a) {
    for (var b = 0;b < this.countries.length;b++) {
      if (this._startsWith(this.countries[b].name, a)) {
        a = this.countryList.children("[data-country-code=" + this.countries[b].iso2 + "]").not(".preferred");
        this._highlightListItem(a);
        this._scrollTo(a, !0);
        break;
      }
    }
  }, _startsWith:function(a, b) {
    return a.substr(0, b.length).toUpperCase() == b;
  }, _updateVal:function(a, b) {
    var c;
    if (this.options.autoFormat && f.intlTelInputUtils) {
      c = intlTelInputUtils.formatNumber(a, this.selectedCountryData.iso2, b);
      var e = this.telInput.attr("maxlength");
      e && c.length > e && (c = c.substr(0, e));
    } else {
      c = a;
    }
    this.telInput.val(c);
  }, _updateFlagFromNumber:function(a) {
    this.options.nationalMode && this.selectedCountryData && "1" == this.selectedCountryData.dialCode && "+" != a.substr(0, 1) && (a = "+1" + a);
    var b = this._getDialCode(a);
    if (b) {
      var c = this.countryCodes[this._getNumeric(b)], e = !1;
      if (this.selectedCountryData) {
        for (var d = 0;d < c.length;d++) {
          c[d] == this.selectedCountryData.iso2 && (e = !0);
        }
      }
      if (!e || this._isUnknownNanp(a, b)) {
        for (a = 0;a < c.length;a++) {
          if (c[a]) {
            this._selectFlag(c[a]);
            break;
          }
        }
      }
    }
  }, _isUnknownNanp:function(a, b) {
    return "+1" == b && 4 <= this._getNumeric(a).length;
  }, _highlightListItem:function(a) {
    this.countryListItems.removeClass("highlight");
    a.addClass("highlight");
  }, _getCountryData:function(a, b, c) {
    b = b ? g : this.countries;
    for (var d = 0;d < b.length;d++) {
      if (b[d].iso2 == a) {
        return b[d];
      }
    }
    if (c) {
      return null;
    }
    throw Error("No country data for '" + a + "'");
  }, _selectFlag:function(a) {
    this.selectedCountryData = this._getCountryData(a, !1, !1);
    this.selectedFlagInner.attr("class", "flag " + a);
    var b = this.selectedCountryData.name + ": +" + this.selectedCountryData.dialCode;
    this.selectedFlagInner.parent().attr("title", b);
    this._updatePlaceholder();
    a = this.countryListItems.children(".flag." + a).first().parent();
    this.countryListItems.removeClass("active");
    a.addClass("active");
  }, _updatePlaceholder:function() {
    if (f.intlTelInputUtils && !this.hadInitialPlaceholder) {
      var a = intlTelInputUtils.getExampleNumber(this.selectedCountryData.iso2, this.options.nationalMode, intlTelInputUtils.numberType[this.options.numberType || "FIXED_LINE"]);
      this.telInput.attr("placeholder", a);
    }
  }, _selectListItem:function(a) {
    var b = a.attr("data-country-code");
    this._selectFlag(b);
    this._closeDropdown();
    this._updateDialCode(a.attr("data-dial-code"), !0);
    this.telInput.trigger("change");
    this.telInput.focus();
  }, _closeDropdown:function() {
    this.countryList.addClass("hide");
    this.selectedFlagInner.children(".arrow").removeClass("up");
    d(p).off(this.ns);
    d("html").off(this.ns);
    this.countryList.off(this.ns);
  }, _scrollTo:function(a, b) {
    var c = this.countryList, d = c.height(), f = c.offset().top, g = f + d, h = a.outerHeight(), k = a.offset().top, n = k + h, m = k - f + c.scrollTop(), l = d / 2 - h / 2;
    k < f ? (b && (m -= l), c.scrollTop(m)) : n > g && (b && (m += l), c.scrollTop(m - (d - h)));
  }, _updateDialCode:function(a, b) {
    var c = this.telInput.val();
    a = "+" + a;
    if (!this.options.nationalMode || "+" == c.substr(0, 1)) {
      if (c) {
        var e = this._getDialCode(c);
        1 < e.length ? c = c.replace(e, a) : (c = "+" != c.substr(0, 1) ? d.trim(c) : "", c = a + c);
      } else {
        c = !this.options.autoHideDialCode || b ? a : "";
      }
    }
    this._updateVal(c, b);
  }, _getDialCode:function(a) {
    var b = "";
    if ("+" == a.charAt(0)) {
      for (var c = "", e = 0;e < a.length;e++) {
        var f = a.charAt(e);
        if (d.isNumeric(f) && (c += f, this.countryCodes[c] && (b = a.substr(0, e + 1)), 4 == c.length)) {
          break;
        }
      }
    }
    return b;
  }, destroy:function() {
    this._closeDropdown();
    this.telInput.off(this.ns);
    this.selectedFlagInner.parent().off(this.ns);
    this.telInput.closest("label").off(this.ns);
    this.telInput.parent().before(this.telInput).remove();
  }, getCleanNumber:function() {
    return f.intlTelInputUtils ? intlTelInputUtils.formatNumberE164(this.telInput.val(), this.selectedCountryData.iso2) : "";
  }, getNumberType:function() {
    return f.intlTelInputUtils ? intlTelInputUtils.getNumberType(this.telInput.val(), this.selectedCountryData.iso2) : -99;
  }, getSelectedCountryData:function() {
    return this.selectedCountryData || {};
  }, getValidationError:function() {
    return f.intlTelInputUtils ? intlTelInputUtils.getValidationError(this.telInput.val(), this.selectedCountryData.iso2) : -99;
  }, isValidNumber:function() {
    var a = d.trim(this.telInput.val()), b = this.options.nationalMode ? this.selectedCountryData.iso2 : "";
    return !/[a-zA-Z]/.test(a) && f.intlTelInputUtils ? intlTelInputUtils.isValidNumber(a, b) : !1;
  }, loadUtils:function(a) {
    a = a || this.options.utilsScript;
    !d.fn.intlTelInput.loadedUtilsScript && a && (d.fn.intlTelInput.loadedUtilsScript = !0, d.ajax({url:a, success:function() {
      d(".intl-tel-input input").intlTelInput("utilsLoaded");
    }, dataType:"script", cache:!0}));
  }, selectCountry:function(a) {
    this.selectedFlagInner.hasClass(a) || (this._selectFlag(a), this._updateDialCode(this.selectedCountryData.dialCode, !1));
  }, setNumber:function(a, b) {
    this.options.nationalMode || "+" == a.substr(0, 1) || (a = "+" + a);
    this._updateFlagFromNumber(a);
    this._updateVal(a, b);
  }, utilsLoaded:function() {
    this.options.autoFormat && this.telInput.val() && this._updateVal(this.telInput.val());
    this._updatePlaceholder();
  }};
  d.fn.intlTelInput = function(a) {
    var b = arguments;
    if (a === q || "object" === typeof a) {
      return this.each(function() {
        d.data(this, "plugin_intlTelInput") || d.data(this, "plugin_intlTelInput", new l(this, a));
      });
    }
    if ("string" === typeof a && "_" !== a[0] && "init" !== a) {
      var c;
      this.each(function() {
        var e = d.data(this, "plugin_intlTelInput");
        e instanceof l && "function" === typeof e[a] && (c = e[a].apply(e, Array.prototype.slice.call(b, 1)));
        "destroy" === a && d.data(this, "plugin_intlTelInput", null);
      });
      return c !== q ? c : this;
    }
  };
  d.fn.intlTelInput.getCountryData = function() {
    return g;
  };
  d.fn.intlTelInput.setCountryData = function(a) {
    g = a;
  };
  for (var g = [["Afghanistan (\u202b\u0627\u0641\u063a\u0627\u0646\u0633\u062a\u0627\u0646\u202c\u200e)", "af", "93"], ["Albania (Shqip\u00ebri)", "al", "355"], ["Algeria (\u202b\u0627\u0644\u062c\u0632\u0627\u0626\u0631\u202c\u200e)", "dz", "213"], ["American Samoa", "as", "1684"], ["Andorra", "ad", "376"], ["Angola", "ao", "244"], ["Anguilla", "ai", "1264"], ["Antigua and Barbuda", "ag", "1268"], ["Argentina", "ar", "54"], ["Armenia (\u0540\u0561\u0575\u0561\u057d\u057f\u0561\u0576)", "am", "374"], 
  ["Aruba", "aw", "297"], ["Australia", "au", "61"], ["Austria (\u00d6sterreich)", "at", "43"], ["Azerbaijan (Az\u0259rbaycan)", "az", "994"], ["Bahamas", "bs", "1242"], ["Bahrain (\u202b\u0627\u0644\u0628\u062d\u0631\u064a\u0646\u202c\u200e)", "bh", "973"], ["Bangladesh (\u09ac\u09be\u0982\u09b2\u09be\u09a6\u09c7\u09b6)", "bd", "880"], ["Barbados", "bb", "1246"], ["Belarus (\u0411\u0435\u043b\u0430\u0440\u0443\u0441\u044c)", "by", "375"], ["Belgium (Belgi\u00eb)", "be", "32"], ["Belize", "bz", "501"], 
  ["Benin (B\u00e9nin)", "bj", "229"], ["Bermuda", "bm", "1441"], ["Bhutan (\u0f60\u0f56\u0fb2\u0f74\u0f42)", "bt", "975"], ["Bolivia", "bo", "591"], ["Bosnia and Herzegovina (\u0411\u043e\u0441\u043d\u0430 \u0438 \u0425\u0435\u0440\u0446\u0435\u0433\u043e\u0432\u0438\u043d\u0430)", "ba", "387"], ["Botswana", "bw", "267"], ["Brazil (Brasil)", "br", "55"], ["British Indian Ocean Territory", "io", "246"], ["British Virgin Islands", "vg", "1284"], ["Brunei", "bn", "673"], ["Bulgaria (\u0411\u044a\u043b\u0433\u0430\u0440\u0438\u044f)", 
  "bg", "359"], ["Burkina Faso", "bf", "226"], ["Burundi (Uburundi)", "bi", "257"], ["Cambodia (\u1780\u1798\u17d2\u1796\u17bb\u1787\u17b6)", "kh", "855"], ["Cameroon (Cameroun)", "cm", "237"], ["Canada", "ca", "1", 1, "204 236 249 250 289 306 343 365 387 403 416 418 431 437 438 450 506 514 519 548 579 581 587 604 613 639 647 672 705 709 742 778 780 782 807 819 825 867 873 902 905".split(" ")], ["Cape Verde (Kabu Verdi)", "cv", "238"], ["Caribbean Netherlands", "bq", "599", 1], ["Cayman Islands", 
  "ky", "1345"], ["Central African Republic (R\u00e9publique centrafricaine)", "cf", "236"], ["Chad (Tchad)", "td", "235"], ["Chile", "cl", "56"], ["China (\u4e2d\u56fd)", "cn", "86"], ["Colombia", "co", "57"], ["Comoros (\u202b\u062c\u0632\u0631 \u0627\u0644\u0642\u0645\u0631\u202c\u200e)", "km", "269"], ["Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)", "cd", "243"], ["Congo (Republic) (Congo-Brazzaville)", "cg", "242"], ["Cook Islands", "ck", "682"], ["Costa Rica", "cr", "506"], ["C\u00f4te d\u2019Ivoire", 
  "ci", "225"], ["Croatia (Hrvatska)", "hr", "385"], ["Cuba", "cu", "53"], ["Cura\u00e7ao", "cw", "599", 0], ["Cyprus (\u039a\u03cd\u03c0\u03c1\u03bf\u03c2)", "cy", "357"], ["Czech Republic (\u010cesk\u00e1 republika)", "cz", "420"], ["Denmark (Danmark)", "dk", "45"], ["Djibouti", "dj", "253"], ["Dominica", "dm", "1767"], ["Dominican Republic (Rep\u00fablica Dominicana)", "do", "1", 2, ["809", "829", "849"]], ["Ecuador", "ec", "593"], ["Egypt (\u202b\u0645\u0635\u0631\u202c\u200e)", "eg", "20"], 
  ["El Salvador", "sv", "503"], ["Equatorial Guinea (Guinea Ecuatorial)", "gq", "240"], ["Eritrea", "er", "291"], ["Estonia (Eesti)", "ee", "372"], ["Ethiopia", "et", "251"], ["Falkland Islands (Islas Malvinas)", "fk", "500"], ["Faroe Islands (F\u00f8royar)", "fo", "298"], ["Fiji", "fj", "679"], ["Finland (Suomi)", "fi", "358"], ["France", "fr", "33"], ["French Guiana (Guyane fran\u00e7aise)", "gf", "594"], ["French Polynesia (Polyn\u00e9sie fran\u00e7aise)", "pf", "689"], ["Gabon", "ga", "241"], 
  ["Gambia", "gm", "220"], ["Georgia (\u10e1\u10d0\u10e5\u10d0\u10e0\u10d7\u10d5\u10d4\u10da\u10dd)", "ge", "995"], ["Germany (Deutschland)", "de", "49"], ["Ghana (Gaana)", "gh", "233"], ["Gibraltar", "gi", "350"], ["Greece (\u0395\u03bb\u03bb\u03ac\u03b4\u03b1)", "gr", "30"], ["Greenland (Kalaallit Nunaat)", "gl", "299"], ["Grenada", "gd", "1473"], ["Guadeloupe", "gp", "590", 0], ["Guam", "gu", "1671"], ["Guatemala", "gt", "502"], ["Guinea (Guin\u00e9e)", "gn", "224"], ["Guinea-Bissau (Guin\u00e9 Bissau)", 
  "gw", "245"], ["Guyana", "gy", "592"], ["Haiti", "ht", "509"], ["Honduras", "hn", "504"], ["Hong Kong (\u9999\u6e2f)", "hk", "852"], ["Hungary (Magyarorsz\u00e1g)", "hu", "36"], ["Iceland (\u00cdsland)", "is", "354"], ["India (\u092d\u093e\u0930\u0924)", "in", "91"], ["Indonesia", "id", "62"], ["Iran (\u202b\u0627\u06cc\u0631\u0627\u0646\u202c\u200e)", "ir", "98"], ["Iraq (\u202b\u0627\u0644\u0639\u0631\u0627\u0642\u202c\u200e)", "iq", "964"], ["Ireland", "ie", "353"], ["Israel (\u202b\u05d9\u05e9\u05e8\u05d0\u05dc\u202c\u200e)", 
  "il", "972"], ["Italy (Italia)", "it", "39", 0], ["Jamaica", "jm", "1876"], ["Japan (\u65e5\u672c)", "jp", "81"], ["Jordan (\u202b\u0627\u0644\u0623\u0631\u062f\u0646\u202c\u200e)", "jo", "962"], ["Kazakhstan (\u041a\u0430\u0437\u0430\u0445\u0441\u0442\u0430\u043d)", "kz", "7", 1], ["Kenya", "ke", "254"], ["Kiribati", "ki", "686"], ["Kuwait (\u202b\u0627\u0644\u0643\u0648\u064a\u062a\u202c\u200e)", "kw", "965"], ["Kyrgyzstan (\u041a\u044b\u0440\u0433\u044b\u0437\u0441\u0442\u0430\u043d)", "kg", 
  "996"], ["Laos (\u0ea5\u0eb2\u0ea7)", "la", "856"], ["Latvia (Latvija)", "lv", "371"], ["Lebanon (\u202b\u0644\u0628\u0646\u0627\u0646\u202c\u200e)", "lb", "961"], ["Lesotho", "ls", "266"], ["Liberia", "lr", "231"], ["Libya (\u202b\u0644\u064a\u0628\u064a\u0627\u202c\u200e)", "ly", "218"], ["Liechtenstein", "li", "423"], ["Lithuania (Lietuva)", "lt", "370"], ["Luxembourg", "lu", "352"], ["Macau (\u6fb3\u9580)", "mo", "853"], ["Macedonia (FYROM) (\u041c\u0430\u043a\u0435\u0434\u043e\u043d\u0438\u0458\u0430)", 
  "mk", "389"], ["Madagascar (Madagasikara)", "mg", "261"], ["Malawi", "mw", "265"], ["Malaysia", "my", "60"], ["Maldives", "mv", "960"], ["Mali", "ml", "223"], ["Malta", "mt", "356"], ["Marshall Islands", "mh", "692"], ["Martinique", "mq", "596"], ["Mauritania (\u202b\u0645\u0648\u0631\u064a\u062a\u0627\u0646\u064a\u0627\u202c\u200e)", "mr", "222"], ["Mauritius (Moris)", "mu", "230"], ["Mexico (M\u00e9xico)", "mx", "52"], ["Micronesia", "fm", "691"], ["Moldova (Republica Moldova)", "md", "373"], 
  ["Monaco", "mc", "377"], ["Mongolia (\u041c\u043e\u043d\u0433\u043e\u043b)", "mn", "976"], ["Montenegro (Crna Gora)", "me", "382"], ["Montserrat", "ms", "1664"], ["Morocco (\u202b\u0627\u0644\u0645\u063a\u0631\u0628\u202c\u200e)", "ma", "212"], ["Mozambique (Mo\u00e7ambique)", "mz", "258"], ["Myanmar (Burma) (\u1019\u103c\u1014\u103a\u1019\u102c)", "mm", "95"], ["Namibia (Namibi\u00eb)", "na", "264"], ["Nauru", "nr", "674"], ["Nepal (\u0928\u0947\u092a\u093e\u0932)", "np", "977"], ["Netherlands (Nederland)", 
  "nl", "31"], ["New Caledonia (Nouvelle-Cal\u00e9donie)", "nc", "687"], ["New Zealand", "nz", "64"], ["Nicaragua", "ni", "505"], ["Niger (Nijar)", "ne", "227"], ["Nigeria", "ng", "234"], ["Niue", "nu", "683"], ["Norfolk Island", "nf", "672"], ["North Korea (\uc870\uc120 \ubbfc\uc8fc\uc8fc\uc758 \uc778\ubbfc \uacf5\ud654\uad6d)", "kp", "850"], ["Northern Mariana Islands", "mp", "1670"], ["Norway (Norge)", "no", "47"], ["Oman (\u202b\u0639\u064f\u0645\u0627\u0646\u202c\u200e)", "om", "968"], ["Pakistan (\u202b\u067e\u0627\u06a9\u0633\u062a\u0627\u0646\u202c\u200e)", 
  "pk", "92"], ["Palau", "pw", "680"], ["Palestine (\u202b\u0641\u0644\u0633\u0637\u064a\u0646\u202c\u200e)", "ps", "970"], ["Panama (Panam\u00e1)", "pa", "507"], ["Papua New Guinea", "pg", "675"], ["Paraguay", "py", "595"], ["Peru (Per\u00fa)", "pe", "51"], ["Philippines", "ph", "63"], ["Poland (Polska)", "pl", "48"], ["Portugal", "pt", "351"], ["Puerto Rico", "pr", "1", 3, ["787", "939"]], ["Qatar (\u202b\u0642\u0637\u0631\u202c\u200e)", "qa", "974"], ["R\u00e9union (La R\u00e9union)", "re", "262"], 
  ["Romania (Rom\u00e2nia)", "ro", "40"], ["Russia (\u0420\u043e\u0441\u0441\u0438\u044f)", "ru", "7", 0], ["Rwanda", "rw", "250"], ["Saint Barth\u00e9lemy (Saint-Barth\u00e9lemy)", "bl", "590", 1], ["Saint Helena", "sh", "290"], ["Saint Kitts and Nevis", "kn", "1869"], ["Saint Lucia", "lc", "1758"], ["Saint Martin (Saint-Martin (partie fran\u00e7aise))", "mf", "590", 2], ["Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)", "pm", "508"], ["Saint Vincent and the Grenadines", "vc", "1784"], ["Samoa", 
  "ws", "685"], ["San Marino", "sm", "378"], ["S\u00e3o Tom\u00e9 and Pr\u00edncipe (S\u00e3o Tom\u00e9 e Pr\u00edncipe)", "st", "239"], ["Saudi Arabia (\u202b\u0627\u0644\u0645\u0645\u0644\u0643\u0629 \u0627\u0644\u0639\u0631\u0628\u064a\u0629 \u0627\u0644\u0633\u0639\u0648\u062f\u064a\u0629\u202c\u200e)", "sa", "966"], ["Senegal (S\u00e9n\u00e9gal)", "sn", "221"], ["Serbia (\u0421\u0440\u0431\u0438\u0458\u0430)", "rs", "381"], ["Seychelles", "sc", "248"], ["Sierra Leone", "sl", "232"], ["Singapore", 
  "sg", "65"], ["Sint Maarten", "sx", "1721"], ["Slovakia (Slovensko)", "sk", "421"], ["Slovenia (Slovenija)", "si", "386"], ["Solomon Islands", "sb", "677"], ["Somalia (Soomaaliya)", "so", "252"], ["South Africa", "za", "27"], ["South Korea (\ub300\ud55c\ubbfc\uad6d)", "kr", "82"], ["South Sudan (\u202b\u062c\u0646\u0648\u0628 \u0627\u0644\u0633\u0648\u062f\u0627\u0646\u202c\u200e)", "ss", "211"], ["Spain (Espa\u00f1a)", "es", "34"], ["Sri Lanka (\u0dc1\u0dca\u200d\u0dbb\u0dd3 \u0dbd\u0d82\u0d9a\u0dcf\u0dc0)", 
  "lk", "94"], ["Sudan (\u202b\u0627\u0644\u0633\u0648\u062f\u0627\u0646\u202c\u200e)", "sd", "249"], ["Suriname", "sr", "597"], ["Swaziland", "sz", "268"], ["Sweden (Sverige)", "se", "46"], ["Switzerland (Schweiz)", "ch", "41"], ["Syria (\u202b\u0633\u0648\u0631\u064a\u0627\u202c\u200e)", "sy", "963"], ["Taiwan (\u53f0\u7063)", "tw", "886"], ["Tajikistan", "tj", "992"], ["Tanzania", "tz", "255"], ["Thailand (\u0e44\u0e17\u0e22)", "th", "66"], ["Timor-Leste", "tl", "670"], ["Togo", "tg", "228"], 
  ["Tokelau", "tk", "690"], ["Tonga", "to", "676"], ["Trinidad and Tobago", "tt", "1868"], ["Tunisia (\u202b\u062a\u0648\u0646\u0633\u202c\u200e)", "tn", "216"], ["Turkey (T\u00fcrkiye)", "tr", "90"], ["Turkmenistan", "tm", "993"], ["Turks and Caicos Islands", "tc", "1649"], ["Tuvalu", "tv", "688"], ["U.S. Virgin Islands", "vi", "1340"], ["Uganda", "ug", "256"], ["Ukraine (\u0423\u043a\u0440\u0430\u0457\u043d\u0430)", "ua", "380"], ["United Arab Emirates (\u202b\u0627\u0644\u0625\u0645\u0627\u0631\u0627\u062a \u0627\u0644\u0639\u0631\u0628\u064a\u0629 \u0627\u0644\u0645\u062a\u062d\u062f\u0629\u202c\u200e)", 
  "ae", "971"], ["United Kingdom", "gb", "44"], ["United States", "us", "1", 0], ["Uruguay", "uy", "598"], ["Uzbekistan (O\u02bbzbekiston)", "uz", "998"], ["Vanuatu", "vu", "678"], ["Vatican City (Citt\u00e0 del Vaticano)", "va", "39", 1], ["Venezuela", "ve", "58"], ["Vietnam (Vi\u1ec7t Nam)", "vn", "84"], ["Wallis and Futuna", "wf", "681"], ["Yemen (\u202b\u0627\u0644\u064a\u0645\u0646\u202c\u200e)", "ye", "967"], ["Zambia", "zm", "260"], ["Zimbabwe", "zw", "263"]], n = 0;n < g.length;n++) {
    var h = g[n];
    g[n] = {name:h[0], iso2:h[1], dialCode:h[2], priority:h[3] || 0, areaCodes:h[4] || null};
  }
});