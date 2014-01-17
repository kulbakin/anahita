//@depends libs/Request.js
//@depends libs/Validation.js

/**
 * Initialize Global Behavior and Delegator
 */
(function () {
    Browser.Platform.mobile = Browser.Platform.ios || Browser.Platform.android || Browser.Platform.webos || Browser.Platform.name.match(/BlackBerry/i);
    
    //for firefix 15, don't round corder the images
    //caauses issues
    if (Browser.name == 'firefox' && Browser.version >= 15) {
        new Element('style', { 
            'type': 'text/css',
            'text': '.modal img,.popover img {border-radius:0}'
        }).inject(document.getElements('script').getLast(), 'after');
    }
    
    var style = new Element('style', {
        'type': 'text/css',
        'text': '#row-main *[data-behavior] {visibility:hidden}'
    }).inject(document.getElements('script').getLast(), 'after');
    
    window.behavior  = new Behavior({breakOnErrors:true});
    window.delegator = new Delegator({breakOnErrors:true});
    
    window.addEvent('domready', function () {
        window.delegator.attach(document);
        window.behavior.apply(document.body);
        style.dispose();
    });
    
    /**
     * Refactors request to attach all An.Core.Event.Window instances 
     */
    Class.refactor(Request.HTML, {
        onSuccess: function() {
            this.previous.apply(this, arguments);
            window.delegator.attach(document);
            window.behavior.apply(document.body);
        }
    });
})();


//parse language
(function(){
    //set the language
    var lang = document.getElement('html').get('lang') || 'en-GB';
    Locale.define(lang, {});
    Locale.use(lang);
    window.addEvent('domready', function() {
        document.getElements('script[type="text/language"]').each(function (lang) {
            var lang = JSON.decode(lang.get('text'));
            Object.each(lang, function (data, set){
                Locale.define(Locale.getCurrent().name, set, data);
            });
        });
    });
})();

/**
 * Extend Object
 */
Object.extend({
    set: function (original, extension) {
        extension = Object.merge(extension, original);
        Object.each(extension, function (value, key) {
            original[key] = value;
        });
        return Object;
    },
    add: function (original, extension) {
        extension = Object.merge(extension, original);
        Object.each(extension, function (value, key) {
            original[key] = value;
        });
        return Object;
    }
});

/**
 * String Extras
 */
String.implement({
    translate: function () {
        var str = this + "";
        return Locale.get(str) || str;
    },
    parseHTML: function (parent) {
        parent = parent || 'span';
        return new Element('span', {html : this});
    },
    toObject: function() {
        var object = {};
        this.split('&').each(function (part) {
            part = part.split('=');
            object[part[0]] = part[1];
        });
        return object;
    },
    escapeHTML: function () {
        var result = "", i;
        for (i = 0; i < this.length; i += 1) {
            if (this.charAt(i) === "&"  && (this.length - i - 1) >= 4 && this.substr(i, 4) !== "&amp;") {
                result = result + "&amp;";
            } else if (this.charAt(i) === "<") {
                result = result + "&lt;";
            } else if (this.charAt(i) === ">") {
                result = result + "&gt;";
            } else {
                result = result + this.charAt(i);
            }
        }
        return result;
    }
});

(function() {
    var elements  = [];
    var selectors = [];
    Class.refactor(Request.HTML, {
        onSuccess: function () {
            this.previous.apply(this, arguments);
            selectors.each(function (item) {
                selector = item.selector;
                fn = item.fn;
                document.getElements(selector).each(function(el){
                    if ( ! elements.contains(el)) {
                        elements.push(el);
                        fn.apply(el);
                    }
                });
            });
        }
    });
    String.implement({
        addEvent: function (type, fn) {
            if (type == 'domready') {
                var selector = String.from(this);
                selectors.push({selector: selector, fn: fn});
                document.addEvent('domready', function () {
                    document.getElements(selector).each(function (el) {
                        elements.push(el);
                        fn.apply(el);
                    });
                });
            } else {
                type = type + ':relay(' + this + ')';
                document.addEvent(type, fn);
            }
        }
    });
})();

/**
 * Spinner Refactor 
 */
Class.refactor(Spinner, {
    options: {
        'class': 'uiActivityIndicator',
        'onShow': function () { 
            this.target.fade(0.5);
        },
        'onHide': function () {
            this.target.fade(1);
        }
    }
});

/**
 * Injects an ajax request result into dom element. To use pass the dom element to inject
 * the result into as Ajax Options 
 * 
 * @example
 * 
 * new Request.HTML({
 *         inject : 'some-element';
 * });
 * 
 * new Request.HTML({
 *     inject : {
 *         where : 'top',
 *         duration : 2,
 *         transition Fx.Transitions.Bounce.easeOut
 *     }
 * });
 * 
 */
(function () {
    Class.refactor(Request, {
        submit: function () {
            var form = Element.Form({
                method: this.options.method,
                action: this.options.url,
                data: this.options.data
            });
            form.submit();
        },
        onFailure: function (xhr) {
            this.previous.apply(this, arguments);
            var method = 'on' + this.status;
            if (this.options[method]) {
                this.options[method].apply(this, [this]);
            }
        }
    });
    
    /**
     * Refactors the request to include the current document media in each
     * ajax request
     */
    Class.refactor(Request.HTML, {
        options: {
            noCache : true
        },
        onSuccess: function (tree, elements, html) {
            this._applyEmbedStyleSheetFix(this.response.html || "");
            
            if (this.options.inject) {
                var options = this.options.inject;
                if (instanceOf(options, String) || instanceOf(options, Element)) {
                    options = {
                        element: document.id(options)
                    };
                }
                
                Object.add(options, {
                    where: 'top',
                    fx: {
                        duration: 'long'
                    },
                    showFx: function(element, container, options) {
                        element.fade('in');
                    }
                });
                var container   = options.element;
                var element     = new Element('div', {html: html}).getElement('*');
                element.fade('hide');
                element.inject(container, options.where);
                options.showFx(element, container, options);
            }
            
            if (this.options.remove) {
                document.id(this.options.remove).fade('out').get('tween').chain(function () {
                    this.element.dispose();
                });
            }
            
            if (this.options.replace) {
                var els = html.stripTags('script').stripTags('style').parseHTML().getElement('*');
                if (els) {
                    els.replaces(this.options.replace).show();
                }
            }
            
            return this.previous.apply(this, arguments);
        },
        _applyEmbedStyleSheetFix: function (rawHTML) {
            if (!Browser.ie) return;
            var headEl = null; // lazy-load
            // find all styles in the string
            var styleFragRegex = '<style[^>]*>([\u0001-\uFFFF]*?)</style>';
            var matchAll = new RegExp(styleFragRegex, 'img');
            var matchOne = new RegExp(styleFragRegex, 'im');
            var styles = (rawHTML.match(matchAll) || []).map(function(tagMatch) {
                return (tagMatch.match(matchOne) || ['', ''])[1];
            });
            
            // add all found style blocks to the HEAD element.
            for (i = 0; i < styles.length; i++) {
                if ( ! headEl) {
                    headEl = document.getElementsByTagName('head')[0];
                    if ( ! headEl) {
                        return;
                    }
                }
                var newStyleEl = new Element('style');
                newStyleEl.type = 'text/css';
                newStyleEl.styleSheet.cssText = styles[i];
                headEl.adopt(newStyleEl);
            }
        }
    });
})();

/**
 * Creates a form element using the passed option
 */
Element.Form = function (options) {
    Object.add(options, {
        method: 'post',
        data: {}
    });
    
    var data = options.data;
    if (instanceOf(data, Element)) {
        data = data.toQueryString();
    }
    
    if (instanceOf(data, String)) {
        data = data.parseQueryString();
    }
    
    delete options.data;
    
    var form = new Element('form', options);
    var lambda = function (key, value) {
        form.adopt(new Element('input',{name:key,value:value,type:'hidden'}));
    };
    Object.each(data, function (value, key) {
        if (instanceOf(value, Object)) {
            Object.each(value, function (v, k) {
                lambda(key + '[' + k + ']', v);
            });
        } else if (instanceOf(value, Array)) {
            Object.each(value, function (v) {
                lambda(key + '[]',v);
            });
        } else {
            lambda(key, value);
        }
    });
    
    form.set('target', '_self');
    form.hide();
    form.inject(document.body);
    return form;
};

/**
 * Content Property
 */
Element.Properties.content = {
   set: function (content) {
       if (instanceOf(content, Element) || instanceOf(content, Elements)) {
           this.empty().adopt(content);
       } else {
           this.set('html', content);
       }
   }
};

Elements.implement({
    replaces : function(elements) {
        Array.each(this, function(element, i){
            element.replaces(elements[i]);
        });
    }
});

/**
 * Load Behavior. Loads a URL through ajax an update an element
 */
(function () {
    var elements = [];
    Object.append(elements, {
        timer: null,
        cycle: function () {
            this.each(function(el){
                if (el.isVisible()) {
                    this.remove(el);
                    el.fireEvent('visible');
                }
            }.bind(this));
        },
        startTimer: function () {
            if (this.length == 0) {
                //stop timer
                clearInterval(this.timer);
                this.timer = null;
            } else if ( ! this.timer) {
                //start timer
                this.timer = this.cycle.bind(this).periodical(100);
            }
        },
        add: function(el) {
            this.include(el);
            this.startTimer();
        },
        remove: function(el) {
            this.erase(el);
            this.startTimer();
        }
    });
    Element.Events.visible = {
        onAdd: function () {
            if ( ! this.isVisible()) {
                elements.add(this);
            }
        },
        onRemove: function () {
            elements.remove(this);
        }
    };
    Behavior.addGlobalFilter('Load',{
        defaults: {
            useSpinner: false
        },
        setup: function (el, api) {
            if ( ! api.get('url')) {
                return;
            }
            var event = api.get('event') ;
            var options = {
                url : api.get('url'),
                useSpinner : api.getAs(Boolean,'useSpinner')
            };
            
            if (api.get('element')) {
                options.update = el.getElement(api.get('element'));
            }
            if (event == 'visible' && el.isVisible()) {
                event = null;
            } else if (event) {
                options.useSpinner = true;
            }
            var request = el.ajaxRequest(options);
            request = request.get.bind(request);
            if (event) {
                el.addEvent(event+':once', request);
            } else {
                request.apply();
            }
        }
    });
})();

/**
 * Hide Behavior. Hides an element 
 */
Behavior.addGlobalFilter('Hide',{
    setup: function(el, api) {
        var hide = el;
        if (api.get('element')) {
            hide = el.getElement(api.get('element'));
        }
        if (hide) {
            el.removeClass('hide');
            hide.hide();
        }
    }
});

/**
 * Countable Behavior for a textarea
 */
Behavior.addGlobalFilter('Countable', {
    defaults : {
        decrement : false
    },
    setup: function(el,api) {
        var counter   = el.getElement(api.get('element'));
        counter.set('html','&nbsp;');
        el.addEvent('focus:once', function () {
            //when an element with count triggered is focus
            //count character in an interval
            var limit = api.getAs(Number, 'limit');
            var decrement  = limit ? api.getAs(Boolean, 'decrement') : false;
            var emptyValue = decrement ? limit : '&nbsp;';
            var getLength  = function (length) {
                return decrement ? limit - length : length;
            };
            if ( ! counter) return;
            (function () {
                var length = el.get('value').length;
                if (length == 0) {
                    counter.set('html', decrement ? limit : '');
                    return;
                }
                if (limit && length > limit) {
                    counter.addClass('label important');
                } else {
                    counter.removeClass('label important');
                }
                counter.set('text', getLength(length));
            }).periodical(100);
        });
    }
});



/**
 * Outside Pseudo
 */

DOMEvent.definePseudo('outside', function(split, fn, args) {
     var event    = args[0];
     var elements = split.value ? document.getElements(split.value) : [];
     if (instanceOf(event, DOMEvent) && elements.length > 0) {
         var outsideEvent = elements.every(function(el){return el != event.target && !el.contains(event.target);});
         if (outsideEvent) {
             fn.apply(this, args);
         }
         elements.fireEvent(event.name + 'Outside', event);
     }
});

Slick.definePseudo('uid', function (value) {
    return Slick.uidOf(this) == value;
});

Element.implement({
    onOutside : function (event, callback) {
        var uid      = Slick.uidOf(this),
            selector = ':uid(' + uid + ')',
            event    = event + ':outside('+selector+')';
        document.addEvent(event, callback.bind(this));
    }
});

var parseLess = function() {
    document.getElements('style[type="text/less"]').each(function (style) {
        (new less.Parser()).parse(style.get('html'), function (e, tree) {
            var css = tree.toCSS();
            style.dispose();
            document.body.adopt(new Element('style', {html: css}));
        });
    });
};
