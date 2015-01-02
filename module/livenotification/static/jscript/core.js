var LN = {
    container: null,
    options: {
        started: false
    },
    
    init: function() {
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
        setTimeout('LN.check()', 5000); // recall every 5 seconds
    },
    attach: function(content) {
        if (content === '') return false;
        this.container.append(content);
        this.container.show();
        setTimeout('LN.clean()', 3000); // clean after 3 seconds
    },
    clean: function() {
        this.container.hide();
        this.container.html('');
    }
}; // LN means Live Notification
$Behavior.onLiveNotificationLoaded = function() {
    LN.init();
};