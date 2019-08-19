/*
 *  Document   : app.js
 *  Author     : pixelcave
 *  Description: Main entry point
 *
 */

// Import global dependencies
import './bootstrap';

// Import required modules
import Tools from './modules/tools';
import Helpers from './modules/helpers';
import Template from './modules/template';

// App extends Template
export default class App extends Template {
    /*
     * Auto called when creating a new instance
     *
     */
    constructor() {
        super();
        
        this._stateInit();
    }

    /*
     *  Here you can override or extend any function you want from Template class
     *  if you would like to change/extend/remove the default functionality.
     *
     *  This way it will be easier for you to update the module files if a new update
     *  is released since all your changes will be in here overriding the original ones.
     *
     *  Let's have a look at the _uiInit() function, the one that runs the first time
     *  we create an instance of Template class or App class which extends it. This function
     *  inits all vital functionality but you can change it to fit your own needs.
     *
     */

    /*
     * EXAMPLE #1 - Removing default functionality by making it empty
     *
     */

    //  _uiInit() {}


    /*
     * EXAMPLE #2 - Extending default functionality with additional code
     *
     */

    /*
	_uiInit() {
		// Call original function
		super._uiInit();
		
		
	}
    */
    
    /*
     * EXAMPLE #3 - Replacing default functionality by writing your own code
     *
     */

    //  _uiInit() {
    //      // Your own JS code without ever calling the original function's code
    //  }
    
    
    _stateInit() {
    	var app = this;
    	var _lPage = this._lPage;
    	this._lPage.on('classChanged', function(e){
    		
    		// 
    		const state = _lPage.hasClass('sidebar-mini') ? 'on' : 'off';
    		const oldState = app._getDataToStorage('sidebar_mini_state');
    		if (state != oldState) {
    		    jQuery(window).trigger('sidebarMiniStateChanged', state);
    		}
    		app._setDataToStorage('sidebar_mini_state', state);
    		console.log(state);
    	});
    	
    	$('body').addClass('no-transition');
    	
    	
    	this._restoreSidebarMiniState();
    	
    	
    	setTimeout(function(){
    		$('body').removeClass('no-transition');
    	}, 300);
    	
    }
    
    _restoreSidebarMiniState() {
    	if (this._getDataToStorage('sidebar_mini_state') == 'on') {
    		this._lPage.addClass('sidebar-mini');
    	} else {
    		this._lPage.removeClass('sidebar-mini');
    	}
    }
    
    
    _setDataToStorage(key, value) {
    	if (localStorage) {
			return localStorage.setItem(key, JSON.stringify(value))
		}
    }
    
    _getDataToStorage(key) {
    	if (localStorage) {
    		return JSON.parse(localStorage.getItem(key));
    	}
    }
    
}

// Once everything is loaded
jQuery(() => {
	
	var originalAddClassMethod = jQuery.fn.addClass;
    var originalRemoveClassMethod = jQuery.fn.removeClass;
    jQuery.fn.addClass = function(){
        var result = originalAddClassMethod.apply( this, arguments );
        jQuery(this).trigger('classChanged', arguments);
        return result;
    }
    jQuery.fn.removeClass = function(){
        var result = originalRemoveClassMethod.apply( this, arguments );
        jQuery(this).trigger('classChanged', arguments);
        return result;
    }
    
    // Create a new instance of App
	window.One = new App();
});
