import { Link } from '@inertiajs/react';

function Day ({ dayData }) {
    const {
        isEnabled,
        date,
        events,
        meetings,
        isCurrent
    } = dayData;
    // console.log(dayData);
    const validDay = isEnabled ? 'day_enabled' : 'day_disabled';
    const currentDate = isCurrent ? 'day_current' : validDay;

    return (
        <Link href="#" className={ `calendar ${currentDate}` } > { date }
            <div className="day" >
                <span className={ `day_meeting ${meetings.length ? '' : 'hidden'}` }>{ meetings.length }</span>
                <span className={ `day_event ${events.length ? '' : 'hidden'}` }>{ events.length }</span>
            </div>
        </Link>
    );
}

export default Day;
