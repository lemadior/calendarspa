import { Link } from '@inertiajs/react';

function Day ({ dayData }) {
    const {
        isEnabled,
        date,
        workDate,
        eventsCount: {
            events,
            meetings
        },
        isCurrent,
    } = dayData;

    const validDay = isEnabled ? 'day_enabled' : 'day_disabled';
    const currentDate = isCurrent ? 'day_current' : validDay;
    const month = ('00' + (workDate.getMonth() + 1)).slice(-2);
    const day = ('00' + date).slice(-2);
    const dayDate = `${workDate.getFullYear()}-${month}-${day}`;

    return (
        <Link
            href={ route('admin.calendar.showday', { date: dayDate }) }
            className={ `calendar ${currentDate}` }
        >
            { date }
            <div className="day" >
                <span className={ `day_meeting ${meetings ? '' : 'hidden'} ` }>{ meetings }</span>
                <span className={ `day_event ${events ? '' : 'hidden'} ` }>{ events }</span>
            </div>
        </Link>
    );
}

export default Day;
