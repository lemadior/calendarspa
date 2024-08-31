export const MONTHS = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];


export const DAYS_IN_WEEK = [
    'Sun',
    'Mon',
    'Tue',
    'Wed',
    'Thu',
    'Fri',
    'Sat'
];

export const EVENT_TYPES = [
    'General',
    'Event',
    'Meeting',
    'Conference',
    'Reminder'
];

export const EVENT_STATUSES = [
    'Postponed',
    'Pended',
    'Finished',
    'Waiting',
    'Paused'
];

export const EVENT_DURATIONS = {
    "0": 'Unlimited',
    "0:30": "30 min",
    "1:00": "1 hour",
    "1:30": "1 hour 30 min",
    "2:00": "2 hour",
    "2:30": '2 hour 30 min',
    "3:00": '3 hour or more'
};


function getSecondsFromTime (time) {
    const [ hours, minutes ] = time.split(':').map(Number);

    return (hours * 3600) + (minutes * 60);
}

// Compare incoming duration time with predefined ones
export function getDuration (time) {
    const timeInSeconds = getSecondsFromTime(time);

    return Object.keys(EVENT_DURATIONS)
        .find(dtime => timeInSeconds <= getSecondsFromTime(dtime)) ?? '0';
}
