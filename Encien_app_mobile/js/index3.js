var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) {return typeof obj;} : function (obj) {return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;};var _createClass = function () {function defineProperties(target, props) {for (var i = 0; i < props.length; i++) {var descriptor = props[i];descriptor.enumerable = descriptor.enumerable || false;descriptor.configurable = true;if ("value" in descriptor) descriptor.writable = true;Object.defineProperty(target, descriptor.key, descriptor);}}return function (Constructor, protoProps, staticProps) {if (protoProps) defineProperties(Constructor.prototype, protoProps);if (staticProps) defineProperties(Constructor, staticProps);return Constructor;};}();function _classCallCheck(instance, Constructor) {if (!(instance instanceof Constructor)) {throw new TypeError("Cannot call a class as a function");}}var SELECTORS = {
  form: '.form',
  feedbackArea: '.form__feedback' };var


OfflineForm = function () {
	
 var index_key = 0 ;

  function OfflineForm(element) {var _this = this;_classCallCheck(this, OfflineForm);
    this.form = element;
    this.id = element.id;
    this.action = element.action;
    this.data = {};
    this.feedbackArea = this.form.querySelector(SELECTORS.feedbackArea);

    this.form.addEventListener('submit', function (e) {return _this.handleSubmit(e);});
    window.addEventListener('online', function () {return _this.checkStorage();});
    window.addEventListener('load', function () {return _this.checkStorage();});
  }_createClass(OfflineForm, [{ key: 'handleSubmit', value: function handleSubmit(

    e) {
      // check network status on form submit

      e.preventDefault();
      this.getFormData();

      // if (!navigator.onLine) {
        // user is offline, store data locally
        var stored = this.storeData();
        var message = '<strong>You appear to be offline right now. </strong>';
        if (stored) {
          message += 'Your data was saved and will be submitted once you come back online.';
        }
        this.resetFeedback();
        this.feedbackArea.innerHTML = message;
      // } else {
        // user is online, send data to server
        // this.sendData();
      // }
	  
	  alert("Successfully sent. Thank you!");
	  location.reload();
	  
    } }, { key: 'storeData', value: function storeData()

    {
      // save data in localStorage

      if (typeof Storage !== 'undefined') {
		  

        var entry = {
          time: new Date().getTime(),
          data: this.data };
		  
        localStorage.setItem(index_key, JSON.stringify(entry));
		index_key++;
        return true;
      }
      return false;
    } }, { key: 'sendData', value: function sendData()

    {var _this2 = this;
      // send ajax call to server
		
      axios.post(this.action, this.data, {
				headers: {
					'Content-Type': 'multipart/form-data',
				},
			}).then(function (response) {
        _this2.handleResponse(response);
      }).
      catch(function (error) {
        console.warn(error);
      });
    } }, { key: 'handleResponse', value: function handleResponse(

    response) {
      // handle server response

      this.resetFeedback();

      if (response.status === 200) {
        // on success
		for (i = 0; i < localStorage.length+1; i++) { 
			localStorage.removeItem(i);
			this.form.reset();
			this.feedbackArea.classList.add('success');
			this.feedbackArea.textContent = '👍 Successfully sent. Thank you!';
			// alert("Successfully sent. Thank you!");
		}
      } else {
        // failure
        this.feedbackArea.textContent = '🔥 Invalid form submission. Oh noez!';
      }
    } }, { key: 'checkStorage', value: function checkStorage()

    {
      // check if we have saved data in localStorage

      if (typeof Storage !== 'undefined') {
		
		for (i = 0; i < localStorage.length+1; i++) { 
			var item = localStorage.getItem(i);
			var entry = item && JSON.parse(item);

			if (entry) {
			  // discard submissions older than one day
			  var now = new Date().getTime();
			  var day = 24 * 60 * 60 * 1000;
			  if (now - day > entry.time) {
				localStorage.removeItem(i);
				return;
			  }

			  // we have saved form data, try to submit it 
			  this.data = entry.data;
			  this.sendData();
			}
		}  
		  

      }
    } }, { key: 'getFormData', value: function getFormData()

    {
      // simple parser, get form data as object

      var field = void 0;
      var i = void 0;
      var data = {};

      if (_typeof(this.form) === 'object' && this.form.nodeName === 'FORM') {
        var len = this.form.elements.length;
        for (i = 0; i < len; i += 1) {
          field = this.form.elements[i];
          if (field.name &&
          !field.disabled &&
          field.type !== 'file' &&
          field.type !== 'reset' &&
          field.type !== 'submit')
          {
            data[field.name] = field.value || '';
          }
        }
      }
      this.data = data;
    } }, { key: 'resetFeedback', value: function resetFeedback()

    {
      this.feedbackArea.classList.remove('success');
      this.feedbackArea.innerHTML = '';
    } }]);return OfflineForm;}();


// init
Array.from(document.querySelectorAll(SELECTORS.form)).forEach(function (form) {
  new OfflineForm(form);
});

