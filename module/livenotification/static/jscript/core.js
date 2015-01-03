var LN = {
    container: null,
    options: {
        started: false,
        delayCheck: 5000,
        delayClean: 3000
    },
    
    init: function() {
        this.options.delayCheck = ln_delay_check;
        this.options.delayClean = ln_delay_clean;
        
        if (!this.options.started) {
            this.check();
            this.options.started = true;
        }
        
        if (!this.container) {
            this.container = $('<div id="ln-container"></div>');
            $(document.body).append(this.container);
        }
    },
    check: function() {
        // call ajax to check if there is new notifications
        $.ajaxCall('livenotification.check');
        setTimeout('LN.check()', this.options.delayCheck);
    },
    attach: function(content) {
        if (content === '') return false;
        if (!this.options.delayClean) return false;
        this.container.append(content);
        this.container.show();
        setTimeout('LN.clean()', this.options.delayClean);
    },
    clean: function() {
        this.container.hide();
        this.container.html('');
    }
}; // LN means Live Notification
$Behavior.onLiveNotificationLoaded = function() {
    LN.init();
};