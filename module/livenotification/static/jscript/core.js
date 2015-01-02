var LN = {
    options: {
        started: false
    },
    init: function() {
        if (!this.options.started) {
            this.check();
            this.options.started = true;
        }
    },
    check: function() {
        // call ajax to check if there is new notifications
        
        setTimeout('LN.check()', 5000); // recall every 5 seconds
    }
}; // LN means Live Notification
$Behavior.onLiveNotificationLoaded = function() {
    LN.init();
};