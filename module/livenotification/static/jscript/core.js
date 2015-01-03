var LN = {
    container: null,
    options: {
        started: false,
        delayCheck: 5000,
        delayClean: 3000,
        onCheck: false
    },
    
    init: function() {
        this.options.delayCheck = ln_delay_check * 1000;
        this.options.delayClean = ln_delay_clean * 1000;
        
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
        if (this.options.onCheck) return false;
        
        // call ajax to check if there is new notifications
        this.options.onCheck = true;
        $.ajaxCall('livenotification.check');
        setTimeout('LN.check()', this.options.delayCheck);
    },
    attach: function(content, ids) {
        if (content === '') return false;
        this.options.onCheck = false;
        this.container.append(content);
        this.container.show();
        this.read(ids);
        if (this.options.delayClean) setTimeout('LN.clean()', this.options.delayClean);
    },
    clean: function() {
        this.container.hide();
        this.container.html('');
    },
    read: function(ids) {
        $.ajaxCall('livenotification.read', 'ids=' + ids.join());
    }
}; // LN means Live Notification
$Behavior.onLiveNotificationLoaded = function() {
    LN.init();
};