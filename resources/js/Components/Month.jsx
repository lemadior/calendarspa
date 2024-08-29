import Week from './Week';
import { DAYS_IN_WEEK } from '../Utils/Utils';
// function getEventsByWeek (events, week) {
//     const weekEvents = [];

//     week.forEach((weekday) => {
//         const month;
//     });
// }

function Month ({ data }) {
    const {
        // events,
        // types,
        monthData,
        workDate
    } = data;

    const dayOfWorkDate = workDate?.getDay();

    console.log(dayOfWorkDate);

    return (
        <div className='calendar_month'>
            <div className="calendar_month_header">
                {
                    DAYS_IN_WEEK.map((day, index) => {
                        const isCurrent = dayOfWorkDate ? day === DAYS_IN_WEEK[ dayOfWorkDate ] : false;
                        const dayHeaderType = isCurrent ? 'current' : 'common';

                        return <div key={ index } className={ `calendar__month_header-${dayHeaderType}` }>{ day }</div>;
                    })
                }
            </div>

            {
                monthData.map((week, index) => {
                    return <Week key={ index } weekData={ week } workDate={ workDate } />;
                })
            }
        </div>
    );
}

export default Month;
