import { Spinner } from './spinner.js';
import { Calendar } from './calendar.js';

const ready = callback => {
	if (document.readyState !== 'loading') callback();
	else if (document.addEventListener)
		document.addEventListener('DOMContentLoaded', callback);
	else
		document.attachEvent('onreadystatechange', function () {
			if (document.readyState === 'complete') callback();
		});
};

ready(async () => {
	const cal = Calendar('calendar');
	const spr = Spinner('calendar');
	await spr.renderSpinner().delay(0);
	var data={};
	$.post("./REST/appointment/read",data,function(resp){
		var citas=[];
		for(var i=0;i<resp.appointments.length;i++){
			citas.push({
				"time" : resp.appointments[i].date_upd,
				"cls" : "",
				"turn" : resp.appointments[i].turn,
				"desc" : ""								//resp.appointments[i].firstname 
			})
		}
		cal.bindData(citas);
		cal.render();
	})
});
