Joomla.submitbutton = function(task) {
	if (task == '') {
		return false;
	} else {
		var isValid = true;
		var action = task.split('.');
		if (action[1] != 'cancel' && action[1] != 'close') {
			var forms = $$('form.form-validate');
			for (var i = 0; i < forms.length; i++) {
				if (!document.formvalidator.isValid(forms[i])) {
					isValid = false;
					break;
				}
			}
		}


	}
};
