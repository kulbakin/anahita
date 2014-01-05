var ScrollLoader = new Class({
    
    Implements: [Options, Events],
    
    options: {
        // onScroll: fn,
        mode: 'vertical',
        fixedheight: 0,
        scrollable : window
    },
    initialize: function(options) {
        this.setOptions(options);
        this.scrollable = document.id(this.options.scrollable) || window; 
        this.bounds = {
            scroll: this.scroll.bind(this)
        };
        this.attach();
    },
    attach: function() {
        this.scrollable.addEvent('scroll', this.bounds.scroll);
        return this;
    },
    detach: function() {
        this.scrollable.removeEvent('scroll', this.bounds.scroll);
        return this;
    },
    scroll: function() {
        var orientation = (this.options.mode == 'vertical') ? 'y' : 'x';
        var scroll      = this.scrollable.getScroll()[orientation];
        var scrollSize  = this.scrollable.getScrollSize()[orientation];
        var scrollWin   = this.scrollable.getSize()[orientation];
        
        if ((this.options.fixedheight && scroll < scrollSize)
            || scroll > scrollSize - scrollWin * 2
        ) {
            this.fireEvent('scroll');
        }
    }
});
