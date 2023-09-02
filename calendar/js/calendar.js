const StopEventPropagation = (e)=> {
    if (!e) return;
    e.cancelBubble = true;
    if (e.stopPropagation) e.stopPropagation();
};
export const Calendar = (id) => ({ 
    id: id,
    data: [],
    el: undefined,
    y: undefined,
    m: undefined,
    onDateClick(e) {
        StopEventPropagation(e);
        const el = e.srcElement;
        console.log('click'); 
        console.log(el);
    },
    onEventClick(e) {
        StopEventPropagation(e);
        const appointment = $(e.currentTarget);
        let time = appointment.attr('time');
        var evTime = moment(time);
        evTime.subtract(2,'hours');
        
        
        // added 15 julio 2023
        // Si esta libre se puede reservar
        if(appointment.hasClass("available")){
            $('#bookappointment_step2').find('input[name="appointment"]').attr('placeholder',evTime.format('YY-MM-DD HH:mm'));
            $('#bookappointment_step2').find('input[name="appointment"]').val(evTime.format('YY-MM-DD HH:mm'));
            $('#calendar').find('.reserved').removeClass('reserved');
            $(e.currentTarget).addClass('reserved');
        }


        //fin 
    },
    bindData(events) {
        this.data = events.sort((a,b) => {
            if ( a.time < b.time ) return -1;
            if ( a.time > b.time ) return 1;
            return 0;
        });
    },
    renderEvents() {    
        if (!this.data || this.data.length<=0) return;
        const lis = this.el.querySelectorAll(`.${this.id} .days .inside`);
        let y = this.el.querySelector('.month-year .year').innerText;
        let m = parseInt(lis[0].querySelector('.date').getAttribute('month'));
        lis.forEach((li,index)=>{
            try {
                let d = li.innerText;
                let divEvents = li.querySelector('.events');
                li.onclick = this.onDateClick;
                this.data.forEach((ev)=>{
                    try {
                        let evTime = moment(ev.time);
                        /*if(ev.turn==1){
                            evTime.add(10,'hour');
                        }else{
                            evTime.add(16,'hour');
                        }*/
                        //evTime.add(1,'month');
                        if ((evTime.year() == y && evTime.month() == m && evTime.date() == d) ) {
                            let frgEvent = document.createRange().createContextualFragment(`
                                <div time="${ev.time}" class="event unavailable ${ev.cls}">${evTime.format('HH:mm')} ${ev.desc}</div>
                            `);
                            if(evTime.hour()<12){
                                divEvents.querySelector('.morning').appendChild(frgEvent);
                            }else{
                                divEvents.querySelector('.afternoom').appendChild(frgEvent);
                            }
                            
                            let divEvent = divEvents.querySelector(`.event[time='${ev.time}']`);
                            divEvent.onclick = this.onEventClick;
                        }
                    } catch (err2) {
                        console.log(err2);
                    }
                });
            } catch (err1) {
                console.log(err1);
            }
            /// ADDED To fullfill days with free to book
            try {
                let divEvents = li.querySelector('.events');
                let d = li.querySelector('.date').innerText;
                let ev = {
                    time1: moment(y+'-'+(m+1)+'-'+d).add(10,'hour'),
                    time2: moment(y+'-'+(m+1)+'-'+d).add(16,'hour'),
                }
                let available1 = "unavailable";
                let available2 = "unavailable";
                if(ev.time1.diff(moment(),'days')>0){

                    if(ev.time1.weekday()!=0 && ev.time1.weekday()!=6){
                        available1 = "available";
                        available2 = "available";
                        
                        
                    }else{
                        if(ev.time1.weekday()==6){
                            available1 = "available";
                            available2 = "unavailable";
                        }
                    }
                }
                if(divEvents.querySelector('.morning').innerHTML==""){
                    let frgEventMorning = document.createRange().createContextualFragment(`
                        <div time="${ev.time1}" class="${available1} event">10:00</div>
                    `);
                    divEvents.querySelector('.morning').appendChild(frgEventMorning);
                    let divEvent1 = divEvents.querySelector(`.event[time='${ev.time1}']`);
                    divEvent1.onclick = this.onEventClick;
                }
                if(divEvents.querySelector('.afternoom').innerHTML==""){
                    let frgEventAfternoom = document.createRange().createContextualFragment(`
                        <div time="${ev.time2}" class="${available2} event ">16:00</div>
                    `);
                    divEvents.querySelector('.afternoom').appendChild(frgEventAfternoom);
                    let divEvent2 = divEvents.querySelector(`.event[time='${ev.time2}']`);
                    divEvent2.onclick = this.onEventClick;
                }
            } catch (erro3) {
                console.log(erro3);
            }

            /// FIN
        });
    },
    render(y, m) {
        //-------------------------------------------------------------------------------------------
        //first time when you call render() without params, it is going to default to current date.
        //this logic here is to make sure if you re-render by calling render() without any param again,
        //if the calendar is already looking at some other month, then it will get the updated data, but
        //the calendar will not jump back to current month and stay at the previous month you are looking at.
        //this is useful when server side has updated events, calendar can re-bindData() and re-render() 
        //itself correctly to reflect any changes.
        try {
            if (isNaN(y) && isNaN(this.y)) {
                this.y = moment().year();
            } else if ((!isNaN(y) && isNaN(this.y)) || (!isNaN(y) && !isNaN(this.y))) {
                this.y = y>1600 ? y : moment().year(); //calendar doesn't exist before 1600! :)
            }
            if (isNaN(m) && isNaN(this.m)) {
                this.m = moment().month();
            } else if ((!isNaN(m) && isNaN(this.m)) || (!isNaN(m) && !isNaN(this.m))) {
                this.m = m>=0 ? m : moment().month(); //momentjs month starts from 0-11
            }
            //------------------------------------------------------------------------------------------

            const d = moment().year(this.y).month(this.m).date(0); 
            const now = moment();
            const frgCal = document.createRange().createContextualFragment(`
            <div class="calendar noselect p-5">
                <div class="month-year-btn d-flex justify-content-center align-items-center mb-2">
                    <a class="prev-month"><i class="fas fa-caret-left fa-lg m-3"></i></a>
                    <div class="month-year d-flex justify-content-center align-items-center">
                        <div class="month mb-2 mr-2">${moment().month(this.m).format('MMMM')}</div>
                        <div class="year mb-2">${this.y}</div>
                    </div>
                    <a class="next-month"><i class="fas fa-caret-right fa-lg m-3" aria-hidden="true"></i></a>
                </div>
                <ol class="day-names list-unstyled border-gradient-gold">
                    <li><h6 class="initials">Mon</h6></li>
                    <li><h6 class="initials">Tue</h6></li>
                    <li><h6 class="initials">Wed</h6></li>
                    <li><h6 class="initials">Thu</h6></li>
                    <li><h6 class="initials">Fri</h6></li>
                    <li><h6 class="initials">Sat</h6></li>
                    <li><h6 class="initials">Sun</h6></li>
                </ol>
            </div>
            `);
            const isSameDate = (d1, d2) => d1.format('YYYY-MM-DD') == d2.format('YYYY-MM-DD');
            let frgWeek;
            d.day(0); //move date to the oldest Sunday, so that it lines up with the calendar layout
            for(let i=0; i<6; i++){ //loop thru 35 boxes on the calendar month
                frgWeek = document.createRange().createContextualFragment(`
                <ol class="days list-unstyled border-gradient-gold" week="${d.week()}">
                    <li class="${d.add(1,'d'),this.m != d.month()?' outside':'inside'}${isSameDate(d,now)?' today':''}"><div month="${d.month()}" class="date">${d.format('D')}</div><div class="events"><div class="morning"></div><div class="afternoom"></div></div></li>
                    <li class="${d.add(1,'d'),this.m != d.month()?' outside':'inside'}${isSameDate(d,now)?' today':''}"><div month="${d.month()}" class="date">${d.format('D')}</div><div class="events"><div class="morning"></div><div class="afternoom"></div></div></li>
                    <li class="${d.add(1,'d'),this.m != d.month()?' outside':'inside'}${isSameDate(d,now)?' today':''}"><div month="${d.month()}" class="date">${d.format('D')}</div><div class="events"><div class="morning"></div><div class="afternoom"></div></div></li>
                    <li class="${d.add(1,'d'),this.m != d.month()?' outside':'inside'}${isSameDate(d,now)?' today':''}"><div month="${d.month()}" class="date">${d.format('D')}</div><div class="events"><div class="morning"></div><div class="afternoom"></div></div></li>
                    <li class="${d.add(1,'d'),this.m != d.month()?' outside':'inside'}${isSameDate(d,now)?' today':''}"><div month="${d.month()}" class="date">${d.format('D')}</div><div class="events"><div class="morning"></div><div class="afternoom"></div></div></li>
                    <li class="${d.add(1,'d'),this.m != d.month()?' outside':'inside'}${isSameDate(d,now)?' today':''}"><div month="${d.month()}" class="date">${d.format('D')}</div><div class="events"><div class="morning"></div><div class="afternoom"></div></div></li>
                    <li class="${d.add(1,'d'),this.m != d.month()?' outside':'inside'}${isSameDate(d,now)?' today':''}"><div month="${d.month()}" class="date">${d.format('D')}</div><div class="events"><div class="morning"></div><div class="afternoom"></div></div></li>
                </ol>
                `);
                frgCal.querySelector('.calendar').appendChild(frgWeek);
            }
            
            frgCal.querySelector('.prev-month').onclick = ()=>{
                const dp = moment().year(this.y).month(this.m).date(1).subtract(1, 'month');
                this.render(dp.year(), dp.month());
            };
            frgCal.querySelector('.next-month').onclick = ()=>{
                const dn = moment().year(this.y).month(this.m).date(1).add(1, 'month');
                this.render(dn.year(), dn.month());
            };
            this.el = document.getElementById(this.id);
            this.el.innerHTML = ''; //replacing
            this.el.appendChild(frgCal);
            this.renderEvents();
        } catch (error) {
            console.error(error);
        }
    }
});