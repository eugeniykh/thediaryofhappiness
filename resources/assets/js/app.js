
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// imports

import Fullcalendar from 'fullcalendar'
import Qtip2 from 'qtip2'
import Waves from 'node-waves'

window.Vue = require('vue');
window.VueResource = require('vue-resource');

require('./apis.js');
require('./services.js');

Vue.directive('diary-day', {
    inserted: (el) => {
        let timezone = new Date().getTimezoneOffset();
        timezone = window.services.getInMinutes(-timezone);
        Vue.http.post(window.apiService.url('getCurrentDay'), {timezone}).then((_response) => {
            let state = _response.body.state;
            if (state) document.getElementById(state).checked = true;
            let emotion = _response.body.emotion;
            if (emotion) document.getElementById('emotion').value = emotion;
            let events = _response.body.states;
            if (events.length) {
                let locales = _response.body.locales;
                let statesData = _response.body.statesData;
                events.forEach((event) => {
                    event.title = locales[event.state];
                    event.start = event.date;
                    event.allDay = true;
                    let stateData = statesData[event.state];
                    for (var key in stateData) {
                        event[key] = stateData[key];
                    }
                });
                $(el).find('.calendar').fullCalendar({
                    events,
                    eventRender: function(event, element) {
                        if (event.emotion) element.qtip({content: {
                                text: event.emotion.replace(/(\r\n|\n\r|\r|\n)/g, '<br>')
                            }
                        });
                    },               
					firstDay: 1
                });
            }
        });
        let timeoutAreaUpdate = null;
        document.getElementById('emotion').addEventListener('keydown', () => {
            if (timeoutAreaUpdate) clearTimeout(timeoutAreaUpdate);
            timeoutAreaUpdate = setTimeout(() => {
                let state = document.querySelectorAll('[name="selector"]:checked');
                (state) ? saveState(state[0].id) : false;
            }, window.timeoutAreaUpdateInterval);
        }, false);
        document.getElementsByName('selector').forEach((selector) =>
            selector.addEventListener('change', function() {
                saveState(this.id);
            })
        );
        let saveState = (state) => {
            Vue.http.post(window.apiService.url('setCurrentDay'), {timezone, state, emotion: document.getElementById('emotion').value});
        };
    }
});

Vue.directive('per-page', {
    inserted: (el) => {
        el.addEventListener('change', function() {
            window.location.href = '/home/flow?perPage=' + el.value;
        });
    }
});

const app = new Vue({
    el: '#app',
    methods: {
        submitStateUpdate: () => {
            document.forms[0].submit();
        }
    },
    mounted: () => {
        Waves.init();
        Waves.attach('.waves-circle', ['waves-circle']);
        Waves.attach('.waves-button', ['waves-button']);
    }
});
